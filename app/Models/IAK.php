<?php

class IAK extends Public_Variables
{
    public function getPrepaidList()
    {
        $sign = md5("081268098300" . $this->apiKey . "pl");
        $url = 'https://prepaid.iak.id/api/pricelist';
        $data = [
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
        $pricelist = $response['data']['pricelist'];
        $_SESSION['prepaid_list'] = $pricelist;
    }

    public function getPostpaidList()
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
        $pricelist = $response['data']['pasca'];
        $_SESSION['postpaid_list'] = $pricelist;
    }

    function check_balance()
    {
        $sign = md5("081268098300" . $this->apiKey . "bl");
        $url = $this->prepaid_url . 'api/check-balance';
        $data = [
            "username" => "081268098300",
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
        return $response;
    }

    function ref_id()
    {
        return "mdl" . "-" . date('Ymdhis') . "-" . rand(1000000000, 9999999999);
    }
}
