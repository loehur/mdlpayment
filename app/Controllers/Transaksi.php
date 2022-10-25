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
      $data = $this->saldo();
      $this->view($this->view_content, $data);
   }

   public function proses($jenis, $product_code)
   {
      $this->dataSynchrone();
      $this->data();

      $customer_id = $_POST['customer_id'];
      $pin = $_POST['pin'];

      //PIN DILARANG DEFAULT
      if ($this->userData['pin'] == md5("123456")) {
         echo "Silahkan mengganti PIN terlebih dahulu!";
         exit();
      }

      //CEK USER MASIH AKTIF ATAU TIDAK
      if ($this->userData['en'] <> 1) {
         echo "Access Forbiden";
         exit();
      }

      //CEK PIN FAILED 3X LOGOUT
      if ($this->userData['pin_failed'] > 2) {
         echo 0;
         exit();
      }

      //CEK PIN BENER ATAU ENGGA
      if ($this->userData['pin'] <> md5($pin)) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "pin_failed = pin_failed + 1";
         $this->model('M_DB_1')->update("user", $set, $where);
         echo "PIN Salah! 3x akan Logout!";
         exit();
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
                     "desc" => $a['product_description'] . " " . $a['product_nominal'] . " " . $a['product_details']
                  ];
               }
            }
         };

         $limit = $saldo['saldo'] - $harga['price_master'];
         if ($limit < $this->setting['min_saldo']) {
            echo "Saldo Tidak Cukup!";
            exit();
         }

         $ref_id = $this->model('M_IAK')->ref_id();
         $col = "no_user, no_master, ref_id, product_code, customer_id, price_master, price_sell, description";
         $val = "'" . $this->userData['no_user'] . "','" . $this->userData['no_master'] . "','" . $ref_id . "','" . $product_code . "','" . $customer_id . "'," . $harga['price_master'] . "," . $harga['price_cell'] . ",'" . $harga['desc'] . "'";
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

            echo 1;
         } else {
            print_r($do['error']);
         }
      } elseif ($jenis == 2) {

         $where = "customer_id = '" . $customer_id . "' AND product_code = '" . $product_code . "' AND noref = ''";
         $cek = $this->model("M_DB_1")->get_where_row("postpaid", $where);
         if (is_array($cek)) {
            $a = $cek;
            $tr_id = $cek['tr_id'];
            $ref_id = $cek['ref_id'];

            //AMANKAN DULU STATUS TRANSAKSI
            $where = "ref_id = '" . $ref_id . "'";
            $set =  "tr_status = 4";
            $update = $this->model('M_DB_1')->update('postpaid', $set, $where);
            if ($update['errno'] <> 0) {
               print_r($update['error']);
               exit();
            }

            //CEK SALDO CUKUP GAK
            $saldo = $this->saldo();
            $harga = $cek['price'];
            $limit = $saldo['saldo'] - $harga;
            if ($limit < $this->setting['min_saldo']) {
               echo "Saldo Tidak Cukup!";
               exit();
            } else {
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

                  $where = "ref_id = '" . $ref_id . "'";
                  $set =  "datetime = '" . $datetime . "', noref = '" . $noref . "', price = " . $price . ", message = '" . $message . "', balance = " . $balance . ", tr_id = '" . $tr_id . "', rc = '" . $rc . "'";
                  $update = $this->model('M_DB_1')->update('postpaid', $set, $where);
                  if ($update['errno'] == 0) {
                     echo 1;
                  } else {
                     print_r($update['error']);
                  }
               } else {
                  echo "Request Parameter Error, Hubungi Technical Support!";
               }
            }
         } else {
            echo "Silahkan Tagihan Terlebih Dahulu!";
         }
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
      $this->view($this->page . "/confirmation", $array);
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
               'harga' => $a['fee'] + $a['komisi'] + $this->admin_postpaid,
               'detail' => "",
            ];
         }
      }

      $this->view($this->page . "/confirmation", $array);
   }
}
