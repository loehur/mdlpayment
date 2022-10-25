<?php

class IAK extends Controller
{
   public function __construct()
   {
      $this->data();
   }

   public function callBack()
   {
      $rawRequestInput = file_get_contents("php://input");
      $arrRequestInput = json_decode($rawRequestInput, JSON_PRESERVE_ZERO_FRACTION);
      $d = $arrRequestInput['data'];
      print_r($d);
   }

   function inquiry($type)
   {
      $customer_id = $_POST['customer_id'];
      switch ($type) {
         case "pln":
            $sign = md5($this->username . $this->apiKey . $customer_id);
            $url = $this->prepaid_url . 'api/inquiry-pln';
            $data = [
               "username" => $this->username,
               "customer_id" => $customer_id,
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
               if (isset($response['data']['name'])) {
                  echo strtoupper($response['data']['name']);
               } else {
                  echo $response['data']['message'];
               }
            } else {
               echo "Request Parameter Error, Hubungi Technical Support!";
            }

            break;

         case "post":
            $code = $_POST['code'];
            //CEK DULU UDAH PERNAH CEK BELUM;
            $where = "customer_id = '" . $customer_id . "' AND noref = ''";
            $cek = $this->model("M_DB_1")->get_where_row("postpaid", $where);

            if (is_array($cek)) {
               $d = $cek;
               echo "<b>" . $d['tr_name'] . "</b>";
               echo "<br>--------------------------------------";
               echo "<br>Nominal: Rp" . number_format($d['nominal']);
               echo "<br>Periode: " . $d['period'];
               echo "<br>Admin Server: Rp" . number_format($d['admin']);
               echo "<br>Admin Loket: Rp" . number_format($this->setting['admin_postpaid']);
               echo "<br>-------------------------------------------";
               echo "<br><b>Total Tagihan: Rp" . number_format($d['nominal'] + $d['admin'] + $this->setting['admin_postpaid']) . "</b>";
               exit();
            }

            $ref_id = $this->model('M_IAK')->ref_id();

            $sign = md5($this->username . $this->apiKey . $ref_id);
            $url = $this->postpaid_url . 'api/v1/bill/check';
            $data = [
               "commands" => "inq-pasca",
               "username" => $this->username,
               "code" => $code,
               "hp" => $customer_id,
               "ref_id" => $ref_id,
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
               if (isset($d['response_code'])) {
                  switch ($d['response_code']) {
                     case "00":
                     case "05":
                     case "39":
                     case "201":
                        $col = "rc, message, tr_id, tr_name, period, nominal, admin, no_user, no_master, ref_id, product_code, customer_id, price, selling_price, description, price_sell";
                        $val = "'" . $d['response_code'] . "','" . $d['message'] . "'," . $d['tr_id'] . ",'" . $d['tr_name'] . "','" . $d['period'] . "'," . $d['nominal'] . "," . $d['admin'] . ",'" . $this->userData['no_user'] . "','" . $this->userData['no_master'] . "','" . $ref_id . "','" . $d['code'] . "','" . $d['hp'] . "'," . $d['price'] . "," . $d['selling_price'] . ",'" . serialize($d['desc']) . "'," . ($d['price'] + $this->setting['admin_postpaid']);
                        $do = $this->model('M_DB_1')->insertCols("postpaid", $col, $val);
                        if ($do['errno'] == 0) {
                           echo "<b>" . $d['tr_name'] . "</b>";
                           echo "<br>--------------------------------------";
                           echo "<br>Nominal: Rp" . number_format($d['nominal']);
                           echo "<br>Periode: " . $d['period'];
                           echo "<br>Admin Server: Rp" . number_format($d['admin']);
                           echo "<br>Admin Loket: Rp" . number_format($this->setting['admin_postpaid']);
                           echo "<br>-------------------------------------------";
                           echo "<br><b>Total Tagihan: Rp" . number_format($d['nominal'] + $d['admin'] + $this->setting['admin_postpaid']) . "</b>";
                        } else {
                           echo "Request Parameter Error, Hubungi Technical Support!";
                        }
                        break;
                     default:
                        echo strtoupper($d['message']);
                        break;
                  }
               } else {
                  print_r($response);
               }
            } else {
               echo "Request Parameter Error, Hubungi Technical Support!";
            }
            break;
      }
   }

   function topup()
   {
      $a = $this->model('M_DB_1')->get_where_row("prepaid", "no_user = '" . $this->userData['no_user'] . "' AND rc = '' LIMIT 1");
      $ref_id = $a['ref_id'];

      $sign = md5($this->username . $this->apiKey . $ref_id);
      $url = $this->prepaid_url . 'api/top-up';
      $data = [
         "username" => $this->username,
         "ref_id"     => $a['ref_id'],
         "customer_id" => $a['customer_id'],
         "product_code"  => $a['product_code'],
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

         $tr_status = isset($d['status']) ? $d['status'] : $a['tr_status'];
         $price = isset($d['price']) ? $d['price'] : $a['price'];
         $message = isset($d['message']) ? $d['message'] : $a['message'];
         $balance = isset($d['balance']) ? $d['balance'] : $a['balance'];
         $tr_id = isset($d['tr_id']) ? $d['tr_id'] : $a['tr_id'];
         $rc = isset($d['rc']) ? $d['rc'] : $a['rc'];


         $where = "ref_id = '" . $ref_id . "'";
         $set =  "tr_status = " . $tr_status . ", price = " . $price . ", message = '" . $message . "', balance = " . $balance . ", tr_id = '" . $tr_id . "', rc = '" . $rc . "'";
         $update = $this->model('M_DB_1')->update('prepaid', $set, $where);
         if ($update['errno'] == 0) {
            echo 1;
         } else {
            print_r($update['error']);
         }
      } else {
         echo "Request Parameter Error, Hubungi Technical Support!";
      }
   }

   function topup_cek()
   {
      $a = $this->model('M_DB_1')->get_where_row("prepaid", "no_master = '" . $this->userData['no_master'] . "' AND tr_status = 0 LIMIT 1");
      if (!is_array($a)) {
         $a = $this->model('M_DB_1')->get_where_row("prepaid", "no_master = '" . $this->userData['no_master'] . "' AND tr_status = 1 AND sn = '' LIMIT 1");
         if (!is_array($a)) {
            exit();
         }
      }
      $ref_id = $a['ref_id'];

      $sign = md5($this->username . $this->apiKey . $ref_id);
      $url = $this->prepaid_url . 'api/check-status';
      $data = [
         "username" => $this->username,
         "ref_id"     => $ref_id,
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
         
         //BATALKAN JIKA STATUS SAMA AJA
         if (isset($d['status'])) {
            if ($d['status'] == $a['tr_status']) {
               exit();
            }
         }

         $tr_status = isset($d['status']) ? $d['status'] : $a['tr_status'];
         $price = isset($d['price']) ? $d['price'] : $a['price'];
         $message = isset($d['message']) ? $d['message'] : $a['message'];
         $balance = isset($d['balance']) ? $d['balance'] : $a['balance'];
         $tr_id = isset($d['tr_id']) ? $d['tr_id'] : $a['tr_id'];
         $rc = isset($d['rc']) ? $d['rc'] : $a['rc'];
         $sn = isset($d['sn']) ? $d['sn'] : $a['sn'];

         $where = "ref_id = '" . $ref_id . "'";
         $set =  "sn = '" . $sn . "', tr_status = " . $tr_status . ", price = " . $price . ", message = '" . $message . "', balance = " . $balance . ", tr_id = '" . $tr_id . "', rc = '" . $rc . "'";
         $update = $this->model('M_DB_1')->update('prepaid', $set, $where);
         if ($update['errno'] == 0) {
            echo 1;
         } else {
            print_r($update['error']);
         }
      }
   }

   function post_cek()
   {
      $a = $this->model('M_DB_1')->get_where_row("postpaid", "no_master = '" . $this->userData['no_master'] . "' AND (tr_status = 4 OR tr_status = 3) LIMIT 1");
      $ref_id = $a['ref_id'];

      $sign = md5($this->username . $this->apiKey . "cs");
      $url = $this->postpaid_url . 'api/v1/bill/check';
      $data = [
         "commands" => "checkstatus",
         "username" => $this->username,
         "ref_id"     => $ref_id,
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
         
         //BATALKAN JIKA STATUS SAMA AJA
         if (isset($d['status'])) {
            if ($d['status'] == $a['tr_status']) {
               exit();
            }
         }

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
            echo 1;
         } else {
            print_r($update['error']);
         }
      } else {
         echo "Request Parameter Error, Hubungi Technical Support!";
      }
   }

   public function cek($mode, $ref_id) //mode: 1 pre, 2 post
   {
      if ($mode == 1) {
         print_r($this->model("M_IAK")->pre_cek($ref_id));
      } else {
      }
   }
}
