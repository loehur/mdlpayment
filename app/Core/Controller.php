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
                $this->postpaidList['product_type'] = $this->model('Functions')->array_group_by_col($this->postpaidList['list'], "type");

                $this->setting = $_SESSION['setting'];
                if ($this->userData['user_tipe'] == 1) {
                    $this->setting['v_price'] = $this->userData['price_view'];
                } else {
                    $this->setting['v_price'] = 0;
                }
            }
        }
    }

    public function dataSynchrone()
    {
        unset($_SESSION['user_data']);
        $where = "no_user = " . $this->userData["no_user"];
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

        $arr_success_kas = array();
        $arr_success_master = array();

        $data['prepaid'] = $this->model('M_DB_1')->get_where('prepaid', "no_master = " . $this->userData['no_master'] . " ORDER BY id DESC");
        foreach ($data['prepaid'] as $a) {
            if ($a['rc'] == "00" || $a['rc'] == "39" || $a['rc'] == "201" || $a['rc'] == "" || strlen($a['sn']) > 0) {
                if ($this->userData['no_user'] == $a['no_user']) {
                    array_push($arr_success_kas, $a['price_sell']);
                }
                array_push($arr_success_master, $a['price_master']);
            }
        }

        $data['postpaid'] = $this->model('M_DB_1')->get_where('postpaid', "no_master = " . $this->userData['no_master'] . " ORDER BY id DESC");
        foreach ($data['postpaid'] as $a) {
            if (strlen($a['noref'] > 0) || strlen($a['datetime']) > 0 || $a['tr_status'] == 1 || $a['tr_status'] == 3 || $a['tr_status'] == 4) {
                if ($this->userData['no_user'] == $a['no_user']) {
                    array_push($arr_success_kas, $a['price_sell']);
                }
                array_push($arr_success_master, $a['price']);
            }
        }

        $total_success_kas = array_sum($arr_success_kas);

        $total_success_master = array_sum($arr_success_master);
        $saldo = $total_topup_success - $total_success_master;

        $total_kas = $total_success_kas - $this->kas()['total_tarik'];

        $return['saldo'] = $saldo;
        $return['kas'] = $total_kas;
        $return['data_topup'] = $data['topup'];
        $return['data_pre'] = $data['prepaid'];
        $return['data_post'] = $data['postpaid'];

        if ($saldo >= 0) {
            $this->margin_prepaid = $this->margin_prepaid1;
            $this->admin_postpaid = $this->admin_postpaid1;
        } else {
            $this->margin_prepaid = $this->margin_prepaid2;
            $this->admin_postpaid = $this->admin_postpaid2;
        }

        return $return;
    }

    public function kas()
    {
        $total_penarikan_success = 0;

        $arr_success_tarik = array();
        $data = $this->model('M_DB_1')->get_where('kas', "no_user = '" . $this->userData['no_user'] . "' ORDER BY id DESC");
        foreach ($data as $a) {
            if ($a['kas_mutasi'] == 0 && $a['kas_status'] == 1) {
                array_push($arr_success_tarik, $a['jumlah']);
            }
        }

        $total_penarikan_success = array_sum($arr_success_tarik);

        $return['data'] = $data;
        $return['total_tarik'] = $total_penarikan_success;

        return $return;
    }

    public function kas_staff()
    {
        $total_penarikan_success = 0;

        $arr_success_tarik = array();
        $data = $this->model('M_DB_1')->get_where('kas', "no_master = '" . $this->userData['no_master'] . "' AND no_user <> '" . $this->userData['no_user'] . "' ORDER BY id DESC");
        foreach ($data as $a) {
            if ($a['kas_mutasi'] == 0 && $a['kas_status'] == 1) {
                array_push($arr_success_tarik, $a['jumlah']);
            }
        }

        $total_penarikan_success = array_sum($arr_success_tarik);

        $return['data'] = $data;
        $return['total_tarik'] = $total_penarikan_success;

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
