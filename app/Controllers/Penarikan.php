<?php

class Penarikan extends Controller
{
   public $page = "Penarikan";

   public function __construct()
   {
      $this->data();
      $this->session_cek();
      $this->load = $this->page . "/load";
      $this->view_content = $this->page . "/content";
   }

   public function index()
   {
      $view_load = $this->load;
      $this->view("layouts/layout_main", [
         "view_load" => $view_load,
         "title" => $this->page
      ]);
      $this->load();
   }

   public function load()
   {
      $data['saldo'] = $this->saldo();
      $data['kas'] = $this->kas()['data'];
      $this->view($this->view_content, $data);
   }

   public function insert()
   {
      $jumlah = $_POST["jumlah"];
      $pin = $_POST["pin"];
      $ket = $_POST["ket"];


      $kas_status = 0;
      if ($this->model('validasi')->enc($pin) == $this->setting['pin']) {
         $kas_status = 1;
      } else {
         $this->dataSynchrone();
         $this->data();

         //CEK PIN FAILED 3X LOGOUT
         if ($this->userData['pin_failed'] > 2) {
            echo 0;
            exit();
         }

         if ($this->model('validasi')->enc($pin) <> $this->userData['pin']) {

            //CEK PIN BENER ATAU ENGGA
            if ($this->userData['pin'] <> $this->model('validasi')->enc($pin)) {
               $where = "id_user = " . $this->userData['id_user'];
               $set = "pin_failed = pin_failed + 1";
               $this->model('M_DB_1')->update("user", $set, $where);
               echo "PIN Salah! 3x akan Logout!";
               exit();
            }
            exit();
         }
      }

      //CEK DUPLIKAT

      //EKSEKUSI
      $columns = 'no_user, keterangan, jumlah, kas_mutasi, kas_status, no_master';
      $values = "'" . $this->userData['no_user'] . "','" . $ket . "','" . $jumlah . "',0,'" . $kas_status . "','" . $this->userData['no_master'] . "'";
      $do = $this->model('M_DB_1')->insertCols("kas", $columns, $values);

      if ($do['errno'] == 0) {
         echo 1;
      } else {
         print_r($do['error']);
      }
   }
}
