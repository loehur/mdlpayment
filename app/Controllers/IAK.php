<?php

class IAK extends Controller
{
   public function __construct()
   {
      $this->data();
      $this->session_cek();
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
               if (isset($response['response_code'])) {
                  switch ($response['response_code']) {
                     case "01":
                     case "102":
                        echo strtoupper($response['message']);
                        break;
                  }
               } else {
                  echo $response['data']['message'];
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
            print_r($update);
         }
      }
   }

   function topup_cek()
   {
      $a = $this->model('M_DB_1')->get_where_row("prepaid", "no_user = '" . $this->userData['no_user'] . "' AND tr_status = 0 LIMIT 1");
      $ref_id = $a['ref_id'];

      $sign = md5($this->username . $this->apiKey . $ref_id);
      $url = $this->prepaid_url . 'api/check-status';
      $data = [
         "username" => $this->username,
         "ref_id"     => $a['ref_id'],
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
         $sn = isset($d['sn']) ? $d['sn'] : $a['sn'];

         $where = "ref_id = '" . $ref_id . "'";
         $set =  "sn = '" . $sn . "', tr_status = " . $tr_status . ", price = " . $price . ", message = '" . $message . "', balance = " . $balance . ", tr_id = '" . $tr_id . "', rc = '" . $rc . "'";
         $update = $this->model('M_DB_1')->update('prepaid', $set, $where);
         if ($update['errno'] == 0) {
            echo 1;
         } else {
            print_r($update);
         }
      }
   }
}
