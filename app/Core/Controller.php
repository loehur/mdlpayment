<?php

require 'app/Config/Public_Variables.php';

class Controller extends Public_Variables
{

    public $userData;
    public $prepaidList;
    public $postpaidList;
    public $setting;

    public $margin_prepaid;
    public $admin_postpaid;

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
                if ($this->userData['pin_failed'] > 2) {
                    $this->logout();
                }
            }
        } else {
            header("location: " . $this->BASE_URL . "Login");
        }
    }

    public function data()
    {
        if (isset($_SESSION['login_payment'])) {
            if ($_SESSION['login_payment'] == true) {
                $this->userData = $_SESSION['user_data'];
                $this->prepaidList['list'] = $_SESSION['prepaid_list'];
                $this->prepaidList['product_type'] = $this->model('Functions')->array_group_by_col($this->prepaidList['list'], "product_type");
                $this->postpaidList['list'] = $_SESSION['postpaid_list'];
                $this->setting = $_SESSION['setting'];
            }
        }
    }

    public function dataSynchrone()
    {
        unset($_SESSION['user_data']);
        $where = "id_user = " . $this->userData["id_user"];
        $_SESSION['user_data'] = $this->model('M_DB_1')->get_where_row('user', $where);

        unset($_SESSION['setting']);
        $where = "no_user = " . $_SESSION['user_data']['no_master'];
        $_SESSION['setting'] = $this->model('M_DB_1')->get_where_row('user', $where);
    }

    public function cekUser()
    {
        $where = "id_user = " . $this->userData["id_user"] . " AND en = 1";
        $cek = $this->model('M_DB_1')->count_where('user', $where);
        if ($cek <> 1) {
            $this->logout();
        }
    }

    public function saldo()
    {
        $saldo = 0;
        $arr_topup_success = array();
        $total_topup_success = 0;
        $data['topup'] = $this->model('M_DB_1')->get_where('topup', "no_master = " . $this->userData['no_master']);
        foreach ($data['topup'] as $a) {
            switch ($a['topup_status']) {
                case 1:
                    array_push($arr_topup_success, $a['jumlah']);
                    break;
            }
        }
        $total_topup_success = array_sum($arr_topup_success);

        $arr_pre_success_kas = array();
        $arr_pre_success_master = array();
        $total_pre_success = 0;
        $data['prepaid'] = $this->model('M_DB_1')->get_where('prepaid', "no_master = " . $this->userData['no_master'] . " ORDER BY id DESC");
        foreach ($data['prepaid'] as $a) {
            if ($a['rc'] == "00" || $a['rc'] == "39" || $a['rc'] == "201" || $a['rc'] == "") {
                if ($this->userData['no_user'] == $a['no_user']) {
                    array_push($arr_pre_success_kas, $a['price_sell']);
                }
                array_push($arr_pre_success_master, $a['price_master']);
            }
        }

        $total_pre_success_kas = array_sum($arr_pre_success_kas);
        $total_pre_success_master = array_sum($arr_pre_success_master);
        $saldo = $total_topup_success - $total_pre_success_master;

        $return['saldo'] = $saldo;
        $return['kas'] = $total_pre_success_kas;
        $return['data_topup'] = $data['topup'];
        $return['data_pre'] = $data['prepaid'];
        $return['total_pre'] = $total_pre_success;

        if (($saldo + 5000) > $this->setting['min_saldo']) {
            $this->margin_prepaid = $this->margin_prepaid1;
            $this->admin_postpaid = $this->admin_postpaid1;
        } else {
            $this->margin_prepaid = $this->margin_prepaid2;
            $this->admin_postpaid = $this->admin_postpaid2;
        }

        return $return;
    }

    public function topup_data()
    {
        return $this->model('M_DB_1')->get_where('topup', "no_master = " . $this->userData['no_master']);
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . $this->BASE_URL . "Login");
    }
}
