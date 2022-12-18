<?php

class IAK_Cek extends Controller
{
   public function __construct()
   {
      $this->data();
   }

   function post($ref_id)
   {
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
      echo "<pre>";
      print_r($response);
      echo "</pre>";
   }
}
