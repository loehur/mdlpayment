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

      //CEK DUPLIKAT GAK



      //CEK SALDO CUKUP GAK
      $harga = array();
      $saldo = $this->saldo();
      foreach ($this->prepaidList['list'] as $a) {
         if ($a['product_code'] == $product_code) {
            if ($jenis == 1) {
               $harga = [
                  "price_master" => $a['product_price'] + $this->margin_prepaid,
                  "price_cell" => $a['product_price'] + $this->margin_prepaid + $this->setting['margin_prepaid'],
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

      if ($jenis == 1) {
         $ref_id = $this->model('IAK')->ref_id();
         $col = "no_user, no_master, ref_id, product_code, customer_id, price_master, price_sell, description";
         $val = "'" . $this->userData['no_user'] . "','" . $this->userData['no_master'] . "','" . $ref_id . "','" . $product_code . "','" . $customer_id . "'," . $harga['price_master'] . "," . $harga['price_cell'] . ",'" . $harga['desc'] . "'";
         $do = $this->model('M_DB_1')->insertCols("prepaid", $col, $val);
         if ($do['errno'] == 0) {
            echo 1;
         } else {
            print_r($do);
         }
      }
   }

   public function product_type($jenis)
   {
      $this->index();
      switch ($jenis) {
         case 1:
            $this->view($this->page . "/product_type", $jenis);
            break;
         case 2:
            break;
      }
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
            break;
      }
   }

   public function product_code($des, $type, $jenis)
   {
      $margin = 0;
      $saldo = $this->saldo()['saldo'];
      $this->index();
      switch ($jenis) {
         case 1:
            $margin = $this->margin_prepaid;
            $array = array();
            $array['data'] = array();
            foreach ($this->prepaidList['list'] as $a) {
               if ($a['product_description'] == $des) {
                  $array['data'][$a['product_code']] = array($a['product_nominal'], $a['product_details'], ($a['product_price'] + $margin + $this->setting['margin_prepaid']));
               }
            };

            $array['jenis'] = $jenis;
            $array['type'] = $type;
            $array['des'] = $des;

            asort($array['data']);
            $this->view($this->page . "/product_code", $array);
            break;
         case 2:
            break;
      }
   }

   public function confirmation($code, $nominal, $des, $type, $jenis, $harga)
   {
      $this->index();
      switch ($jenis) {
         case 1:

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
            break;
         case 2:
            break;
      }
   }
}
