<?php

class M_IAK extends Public_Variables
{
    public function getPrepaidList()
    {
        $sign = md5($this->username . $this->apiKey_price . "pl");
        $url = $this->prepaid_url_price . 'api/pricelist';
        $data = [
            "username" => $this->username,
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
        $sign = md5($this->username . $this->apiKey_price . "pl");
        $url = $this->postpaid_url_price . 'api/v1/bill/check';
        $data = [
            "commands" => "pricelist-pasca",
            "username" => $this->username,
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
        $sign = md5($this->username . $this->apiKey . "bl");
        $url = $this->prepaid_url . 'api/check-balance';
        $data = [
            "username" => $this->username,
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
        return date('Ymdhis') . "-" . rand(1000000000, 9999999999);
    }

    function pre_cek($ref_id)
    {

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
        return $response;
    }
}
