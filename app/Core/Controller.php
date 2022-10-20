<?php

require 'app/Config/URL.php';

class Controller extends URL
{

    public $userData;
    public $prepaidList;
    public $postpaidList;
    public function view($file, $data = [])
    {
        require_once "app/Views/" . $file . ".php";
    }

    public function model($file)
    {
        require_once "app/Models/" . $file . ".php";
        return new $file();
    }

    public function session_cek()
    {
        if (isset($_SESSION['login_payment'])) {
            if ($_SESSION['login_payment'] == False) {
                $this->logout();
            } else {
                $this->userData = $_SESSION['user_data'];
            }
        } else {
            header("location: " . $this->BASE_URL . "Login");
        }
    }

    public function data()
    {
        $this->userData = $_SESSION['user_data'];
        $this->prepaidList = $_SESSION['prepaid_list'];
        $this->postpaidList = $_SESSION['postpaid_list'];
    }

    public function dataSynchrone()
    {
        unset($_SESSION['user_data']);
        $where = "id_user = " . $this->userData["id_user"];
        $_SESSION['user_data'] = $this->model('M_DB_1')->get_where_row('user', $where);
    }

    public function cekUser()
    {
        $where = "id_user = " . $this->userData["id_user"] . " AND en = 1";
        $cek = $this->model('M_DB_1')->count_where('user', $where);
        if ($cek <> 1) {
            $this->logout();
        }
    }

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
        $this->prepaidList = $pricelist;
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
        $this->postpaidList = $pricelist;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . $this->BASE_URL . "Login");
    }
}
