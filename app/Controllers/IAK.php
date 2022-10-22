<?php

class IAK extends Controller
{
   public function callBack()
   {
      $rawRequestInput = file_get_contents("php://input");
      $arrRequestInput = json_decode($rawRequestInput, true);
      $d = $arrRequestInput['data'];

      if (isset($d['admin'])) {
      } else {
         $ref_id = $d['ref_id'];
         $tr_status = $d['status'];
         $product_code = $d['product_code'];
         $customer_id = $d['customer_id'];
         $price = $d['price'];
         $message = $d['message'];
         $sn = $d['sn'];
         $balance = $d['balance'];
         $tr_id = $d['tr_id'];
         $rc = $d['rc'];
         $sign = $d['sign'];

         $where = "ref_id = '" . $ref_id . "'";
         $set =  "ref_id = '" . $ref_id . "', tr_status = " . $tr_status . ", product_code = '" . $product_code . "', customer_id = '" . $customer_id . "', price = " . $price . ", message = '" . $message . "', sn = '" . $sn . "', balance = " . $balance . ", tr_id = " . $tr_id . ", rc = '" . $rc . "', sign = '" . $sign . "'";
         $this->model('M_DB_1')->update('callback', $set, $where);
      }
   }

   public function tes()
   {
      $sign = md5("081268098300" . $this->apiKey . "pl");
      $url = 'https://mobilepulsa.net/api/v1/bill/check';
      $data = [
         "commands" => "pricelist-pasca",
         "username" => "081268098300",
         "sign" => $sign,
         "status" => "active"
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
      print_r($result);
   }
}
