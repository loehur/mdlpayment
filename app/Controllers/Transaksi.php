<?php

class Transaksi extends Controller
{
   public $page = "Transaksi";

   public function __construct()
   {
      $this->session_cek();
      $this->data();

      $this->view_load = $this->page . "/load";
      $this->view_content = $this->page . "/content";
   }

   public function index()
   {
      $this->view("layouts/layout_main", [
         "view_load" => $this->view_load,
         "title" => $this->page
      ]);
      $this->load();
   }

   public function load()
   {

      $this->view($this->view_content);
   }

   public function proses($jenis, $product_code)
   {
      $this->dataSynchrone();
      $this->data();

      $customer_id = $_POST['customer_id'];
      $pin = $_POST['pin'];
      $tr_name = $_POST['tr_name'];

      //PIN DILARANG DEFAULT
      if ($this->userData['pin'] == $this->model('Validasi')->enc("1234")) {
         $this->model('Log')->write($this->userData['no_user'] . " Process Failed! because Default Password!");
         echo "Silahkan mengganti PIN terlebih dahulu!";
         exit();
      }

      //PIN DILARANG SAMA DENGAN PASSWORD
      if ($this->userData['pin'] == $this->userData['password']) {
         $this->model('Log')->write($this->userData['no_user'] . " Process Failed! Password same with PIN!");
         exit();
      }

      //CEK PIN FAILED 3X LOGOUT
      if ($this->userData['pin_failed'] > 2) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "en = 0";
         $do = $this->model('M_DB_1')->update("user", $set, $where);
         if ($do['errno'] == 0) {
            $this->dataSynchrone();
            echo 0;
            exit();
         }
      }

      //CEK PIN BENER ATAU ENGGA
      if ($this->userData['pin'] <> $this->model('Validasi')->enc($pin)) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "pin_failed = pin_failed + 1";
         $do = $this->model('M_DB_1')->update("user", $set, $where);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Wrong PIN");
            echo "PIN Salah! 3x akan Logout!";
            exit();
         } else {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Wrong PIN");
            echo "PIN Salah! 3x akan Logout!";
            exit();
         }
      }

      //CEK USER MASIH AKTIF ATAU TIDAK
      if ($this->userData['en'] <> $this->model('Validasi')->enc($this->userData['password'] . $this->userData['pin'])) {

         $where = "id_user = " . $this->userData['id_user'];
         $set = "pin_failed = pin_failed + 1";
         $do = $this->model('M_DB_1')->update("user", $set, $where);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Account not Verify yet");
            echo "Account Error! 3x akan Logout!";
            exit();
         } else {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Account not Verify yet");
            echo "Account Error! 3x akan Logout!";
            exit();
         }
      }



      //CEK SISA LIMIT PRIBADI
      $used = 0;
      $month = date("Y-m");
      $data_limit = $this->model("M_DB_1")->get_where_row("paid_use", "no_master = '" . $this->userData['no_master'] . "' AND customer_id = '" . $customer_id . "'");
      $sisa_limit = 0;

      if (isset($data_limit['limit_bulanan'])) {
         $used = 1;
         $limit = $data_limit['limit_bulanan'];
         $used_pre = $this->model("M_DB_1")->sum_col_where("prepaid", "price_sell", "customer_id = '" . $customer_id . "' AND insertTime LIKE '%" . $month . "%' AND rc IN (00,39,201)");
         $total_use = $used_pre;

         $sisa_limit = $limit - $total_use;
      } else {
         //CEK USER SELLER ATAU BUKAN
         if ($this->userData['seller'] == 0) {
            echo "ID Pelanggan tidak terdaftar! hubungi Admin";
            exit();
         }
      }

      if ($jenis == 1) {
         //CEK SALDO CUKUP GAK
         $harga = array();
         $saldo = $this->saldo();
         foreach ($this->prepaidList['list'] as $a) {
            if ($a['product_code'] == $product_code) {
               if ($jenis == 1) {
                  $harga = [
                     "price_master" => $a['product_price'] + $this->margin_prepaid,
                     "price_cell" => ceil(($a['product_price'] + $this->margin_prepaid + $this->setting['margin_prepaid']) / 1000) * 1000,
                     "desc" => $a['product_description'] . " " . $a['product_nominal'] . ", " . $a['product_details']
                  ];
               }
            }
         };

         if ($used == 1) {
            if ($harga['price_cell'] > $sisa_limit) {
               $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Monthly Limit Reach");
               echo "Limit Bulanan Sudah Tercapai!";
               exit();
            }
         }

         $limit = $saldo['saldo'] - $harga['price_master'];
         if ($limit < $this->setting['min_saldo']) {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Saldo Not Enough");
            echo "Saldo Tidak Cukup!";
            exit();
         }

         $ref_id = $this->userData['no_user'] . "-" . $this->model('M_IAK')->ref_id() . "-" . $saldo['saldo'];
         $verify = $this->model('Validasi')->enc($ref_id);

         $col = "no_user, no_master, ref_id, product_code, customer_id, price_master, price_sell, description, used, balance_user, verify, tr_name";
         $val = "'" . $this->userData['no_user'] . "','" . $this->userData['no_master'] . "','" . $ref_id . "','" . $product_code . "','" . $customer_id . "'," . $harga['price_master'] . "," . $harga['price_cell'] . ",'" . $harga['desc'] . "'," . $used . "," . $limit . ",'" . $verify . "','" . $tr_name . "'";
         $do = $this->model('M_DB_1')->insertCols("prepaid", $col, $val);
         if ($do['errno'] == 0) {

            //EKSEKUSI TOPUP
            $sign = md5($this->username . $this->apiKey . $ref_id);
            $url = $this->prepaid_url . 'api/top-up';
            $data = [
               "username" => $this->username,
               "ref_id"     => $ref_id,
               "customer_id" => $customer_id,
               "product_code"  => $product_code,
               "sign" => $sign,
            ];

            $postdata = json_encode($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            curl_close($ch);

            $this->model('Log')->write($this->userData['no_user'] . " Proces Success! PREPAID");
            echo 1;
         } else {
            print_r($do['errno']);
         }
      } elseif ($jenis == 2) {
         $where = "no_user = '" . $this->userData['no_user'] . "' AND customer_id = '" . $customer_id . "' AND noref = '' AND rc = '00'";
         $cek = $this->model("M_DB_1")->get_where_row("postpaid", $where);

         if (is_array($cek)) {
            $a = $cek;
            $tr_id = $cek['tr_id'];
            $ref_id = $cek['ref_id'];
            $verify = $this->model('Validasi')->enc($ref_id);

            if ($this->model('Validasi')->enc($ref_id) <> $a['verify']) {
               $where = "ref_id = '" . $ref_id . "'";
               $set =  "tr_status = 2, message = 'HACKER WARNING!', rc = 'XX'";
               $update = $this->model('M_DB_1')->update('postpaid', $set, $where);
               exit();
            }

            //CEK SALDO CUKUP GAK
            $saldo = $this->saldo();
            $harga = $cek['price'];
            $limit = $saldo['saldo'] - $harga;
            if ($limit < $this->setting['min_saldo']) {
               $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Saldo Not Enough");
               echo "Saldo Tidak Cukup!";
               exit();
            } else {

               //AMANKAN DULU STATUS TRANSAKSI
               $where = "ref_id = '" . $ref_id . "'";
               $set =  "tr_status = 4, used = " . $used;
               $update = $this->model('M_DB_1')->update('postpaid', $set, $where);
               if ($update['errno'] <> 0) {
                  print_r($update['errno']);
                  exit();
               }

               $sign = md5($this->username . $this->apiKey . $tr_id);
               $url = $this->postpaid_url . 'api/v1/bill/check';
               $data = [
                  "commands" => "pay-pasca",
                  "username" => $this->username,
                  "tr_id"    => $tr_id,
                  "sign" => $sign,
               ];

               $postdata = json_encode($data);
               $ch = curl_init($url);
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
               $result = curl_exec($ch);
               curl_close($ch);

               $response = json_decode($result, JSON_PRESERVE_ZERO_FRACTION);


               if (isset($response['data'])) {
                  $d = $response['data'];
                  $price = isset($d['price']) ? $d['price'] : $a['price'];
                  $message = isset($d['message']) ? $d['message'] : $a['message'];
                  $balance = isset($d['balance']) ? $d['balance'] : $a['balance'];
                  $tr_id = isset($d['tr_id']) ? $d['tr_id'] : $a['tr_id'];
                  $rc = isset($d['response_code']) ? $d['response_code'] : $a['rc'];
                  $datetime = isset($d['datetime']) ? $d['datetime'] : $a['datetime'];
                  $noref = isset($d['noref']) ? $d['noref'] : $a['noref'];
                  $tr_status = isset($d['status']) ? $d['status'] : $a['tr_status'];

                  $where = "ref_id = '" . $ref_id . "'";
                  $set =  "tr_status = " . $tr_status . ", datetime = '" . $datetime . "', noref = '" . $noref . "', price = " . $price . ", message = '" . $message . "', balance = " . $balance . ", tr_id = '" . $tr_id . "', rc = '" . $rc . "'";
                  $update = $this->model('M_DB_1')->update('postpaid', $set, $where);
                  if ($update['errno'] == 0) {
                     $this->model('Log')->write($this->userData['no_user'] . " Proces Success! POSTPAID");
                     echo 1;
                  } else {
                     print_r($update['errno']);
                  }
               } else {
                  print_r($response);
               }
            }
         } else {
            echo "Cek Tagihan Terlebih Dahulu!";
         }
      }
   }


   public function proses_manual($jenis)
   {
      $this->dataSynchrone();
      $this->data();
      $pin = $_POST['pin'];

      //PIN DILARANG DEFAULT
      if ($this->userData['pin'] == $this->model('Validasi')->enc("1234")) {
         $this->model('Log')->write($this->userData['no_user'] . " Process Failed! because Default Password!");
         echo "Silahkan mengganti PIN terlebih dahulu!";
         exit();
      }

      //PIN DILARANG SAMA DENGAN PASSWORD
      if ($this->userData['pin'] == $this->userData['password']) {
         $this->model('Log')->write($this->userData['no_user'] . " Process Failed! Password same with PIN!");
         exit();
      }

      //CEK PIN FAILED 3X LOGOUT
      if ($this->userData['pin_failed'] > 2) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "en = 0";
         $do = $this->model('M_DB_1')->update("user", $set, $where);
         $this->dataSynchrone();
         echo 0;
         exit();
      }

      //CEK PIN BENER ATAU ENGGA
      if ($this->userData['pin'] <> $this->model('Validasi')->enc($pin)) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "pin_failed = pin_failed + 1";
         $do = $this->model('M_DB_1')->update("user", $set, $where);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Wrong PIN");
            echo "PIN Salah! 3x akan Logout!";
            exit();
         } else {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Wrong PIN");
            echo "PIN Salah! 3x akan Logout!";
            exit();
         }
      }

      //CEK USER MASIH AKTIF ATAU TIDAK
      if ($this->userData['en'] <> $this->model('Validasi')->enc($this->userData['password'] . $this->userData['pin'])) {

         $where = "id_user = " . $this->userData['id_user'];
         $set = "pin_failed = pin_failed + 1";
         $do = $this->model('M_DB_1')->update("user", $set, $where);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Account not Verify yet");
            echo "Account Error! 3x akan Logout!";
            exit();
         } else {
            $this->model('Log')->write($this->userData['no_user'] . " Proces Failed! Account not Verify yet");
            echo "Account Error! 3x akan Logout!";
            exit();
         }
      }

      $target_id = $_POST['target_id'];
      $target = "";
      $data_tujuan = [];
      switch ($jenis) {
         case 1:
         case 3:
         case 5:
            $data_tujuan = $this->model("M_DB_1")->get("_bank");
            break;
         case 2:
         case 4:
            $data_tujuan = $this->model("M_DB_1")->get("_ewallet");
            break;
      }

      foreach ($data_tujuan as $dt) {
         if ($dt['code'] == $target_id) {
            $target = $dt['name'];
         }
      }

      if (strlen($target) == 0) {
         echo "Target Not Found";
         exit();
      }

      $target_number = $_POST['target_number'];
      $target_name = $_POST['target_name'];
      $jumlah = $_POST['jumlah'];
      $note = $_POST['note'];

      $harga = $this->model("M_DB_1")->get_where_row("manual_set", "no_master = '" . $this->userData['no_master'] . "' AND id_manual_jenis = " . $jenis);
      $biaya_dasar = $harga['biaya_dasar'];
      $tarif = $harga['biaya'];

      $kelipatan = $harga['kelipatan'];
      if ($jumlah >= $kelipatan) {
         $pengali = ceil($jumlah / $kelipatan);
         $biaya = $biaya_dasar + ($tarif * $pengali);
      } else {
         $biaya = $biaya_dasar;
      }

      if (isset($_POST['partner'])) {
         $biaya = $biaya - 2000;
      }

      $transaksi = "";
      $id_manual = date("YmdHis") . rand(0, 9) . rand(0, 9);
      $manual = $this->model("M_DB_1")->get("manual_jenis");
      foreach ($manual as $m) {
         if ($m['id_manual_jenis'] == $jenis) {
            $transaksi = substr($id_manual, -2) . " - " . "*" . strtoupper($m['manual_jenis']) . "*\n";
         }
      }

      $head = strtoupper($this->setting['nama'] . "\n");
      $transaksi = $head . $transaksi;
      $id_telegram = $this->setting['telegram_id'];

      $col = "id_manual, no_user, no_master, id_manual_jenis, target_id, target, target_number, target_name, jumlah, note, biaya, telegram_id, wa_token";
      $val = "'" . $id_manual . "','" . $this->userData['no_user'] . "','" . $this->userData['no_master'] . "'," . $jenis . ",'" . $target_id . "','" . $target . "','" . $target_number . "','" . $target_name . "'," . $jumlah . ",'" . $note . "'," . $biaya . ",'" . $id_telegram . "','" . $this->setting['wa_api'] . "'";
      $do = $this->model('M_DB_1')->insertCols("manual", $col, $val);
      if ($do['errno'] == 0) {
         $set = "sort = sort+1";
         $whereSort = "code = " . $target_id;
         switch ($jenis) {
            case 1:
            case 3:
            case 5:
               $this->model('M_DB_1')->update("_bank", $set, $whereSort);
               break;
            case 2:
            case 4:
               $this->model('M_DB_1')->update("_ewallet", $set, $whereSort);
               break;
         }

         if (strlen($note) > 0) {
            $note = "_" . $note . "_\n";
         }
         $text = $target . "\n" . strtoupper($target_name) . "\nRp" . number_format($jumlah) . " Adm. Rp" . number_format($biaya) . "\n" . $note . "payment.mdl.my.id/O/m/" . $id_manual;
         $text_final = $transaksi . $text;

         //SEND WA
         $curl = curl_init();
         curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => $this->setting['telegram_id'], 'message' => $text_final),
            CURLOPT_HTTPHEADER => array(
               'Authorization: ' . $this->setting['wa_api']
            ),
         ));
         $response = curl_exec($curl);
         curl_close($curl);
      } else {
         echo $do['error'];
      }
   }

   public function product_type($jenis)
   {
      $this->index();
      $this->view($this->page . "/product_type", $jenis);
   }

   public function product_des($type, $jenis)
   {
      $this->index();
      switch ($jenis) {
         case 1:
            $array = array();
            $array['data'] = array();
            foreach ($this->prepaidList['list'] as $a) {
               if ($a['product_type'] == $type) {
                  if (!isset($s[$a['product_description']])) {
                     array_push($array['data'], $a['product_description']);
                     $s[$a['product_description']] = true;
                  }
               }
            }
            $array['type'] = $type;
            $array['jenis'] = $jenis;

            $this->view($this->page . "/product_des", $array);
            break;
         case 2:
            $array = array();
            $array['data'] = array();
            foreach ($this->postpaidList['list'] as $a) {
               if ($a['type'] == $type) {
                  $array['data']['product_code'][$a['code']] = $a['name'];
               }
            }
            $array['type'] = $type;
            $array['jenis'] = $jenis;

            $this->view($this->page . "/product_des", $array);
            break;
      }
   }

   public function product_code($de, $type, $jenis)
   {
      $des = str_replace('_SPACE_', ' ', $de);
      $margin = 0;
      $this->index();
      switch ($jenis) {
         case 1:
            $margin = $this->margin_prepaid;
            $array = array();
            $array['data'] = array();
            foreach ($this->prepaidList['list'] as $a) {
               if ($a['product_description'] == $des) {
                  $array['data'][$a['product_code']] = array($a['product_nominal'], $a['product_details'], ceil(($a['product_price'] + $margin + $this->setting['margin_prepaid']) / 1000) * 1000, $a['product_price'] + $margin);
               }
            };

            $array['jenis'] = $jenis;
            $array['type'] = $type;
            $array['des'] = $des;

            asort($array['data']);
            $this->view($this->page . "/product_code", $array);
            break;
         case 2:
            $this->confirmationPOST($des, $jenis);
            break;
      }
   }

   public function confirmation($code, $nominal, $des, $type, $jenis, $harga)
   {
      $this->index();
      $array = array();
      $array['data'] = array();
      $array['detail'] = "";

      foreach ($this->prepaidList['list'] as $a) {
         if ($a['product_code'] == $code) {
            $array = [
               'code' => $code,
               'nominal' => $nominal,
               'des' => $des,
               'type' => $type,
               'jenis' => $jenis,
               'harga' => $harga,
               'detail' => $a['product_details']
            ];
         }
      };

      $array['history'] = [];
      $array['history'] = $this->model('M_DB_1')->get_cols_where('prepaid', "customer_id, tr_name, count(customer_id) as count", "no_user = '" . $this->userData['no_user'] . "' AND UPPER(product_code) LIKE '%" . strtoupper($des) . "%' GROUP BY customer_id, tr_name ORDER BY count(customer_id) DESC LIMIT 20", 1);

      $this->view($this->page . "/confirmation", $array);
   }

   public function confirmation_manual($jenis)
   {
      $this->index();
      $this->view($this->page . "/confirmation_manual", $jenis);
   }

   public function confirmationPOST($code, $jenis)
   {
      $this->index();
      $array = array();
      $array['data'] = array();
      $array['detail'] = "";

      foreach ($this->postpaidList['list'] as $a) {
         if ($a['code'] == $code) {
            $array = [
               'code' => $code,
               'nominal' => "",
               'des' => $a['name'],
               'type' => $a['type'],
               'jenis' => $jenis,
               'harga' => $this->admin_postpaid,
               'detail' => "",
            ];
         }
      }

      $array['history'] = [];
      $array['history'] = $this->model('M_DB_1')->get_cols_where('postpaid', "customer_id, tr_name, count(customer_id) as count", "no_user = '" . $this->userData['no_user'] . "' AND UPPER(product_code) LIKE '%" . strtoupper($code) . "%' GROUP BY customer_id, tr_name ORDER BY count(customer_id) DESC LIMIT 20", 1);

      $this->view($this->page . "/confirmation", $array);
   }
}
