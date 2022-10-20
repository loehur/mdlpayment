<?php

class Setor extends Controller
{
   public $page = "Setor";

   public function __construct()
   {
      $this->session_cek();
      $this->load = $this->page . "/load";
      $this->view_content = $this->page . "/content";
   }

   public function index()
   {
      $view_load = $this->load;
      $this->view("layouts/layout_main", [
         "view_load" => $view_load,
         "title" => "Home"
      ]);
   }

   public function load()
   {
      $data['topup'] = $this->model('M_DB_1')->get_where('topup', "id_user = " . $this->userData['id_user']);
      $data['callback'] = $this->model('M_DB_1')->get_where('callback', "id_user = " . $this->userData['id_user']);
      $data['bank'] = $this->model('M_DB_1')->get('bank');
      $this->view($this->view_content, $data);
   }

   public function insert()
   {
      $jumlah = $_POST['f1'];
      $id_bank = $_POST['f2'];
      $data_bank = $this->model('M_DB_1')->get('bank');

      foreach ($data_bank as $b) {
         if ($b['id_bank'] == $id_bank) {
            $bank = $b['bank'];
            $narek = $b['nama'];
            $norek = $b['norek'];
            $kode_bank = $b['kode_bank'];
         }
      }

      $cols = 'id_user, jumlah, bank, rek, nama, kode_bank';
      $vals = $this->userData['id_user'] . "," . $jumlah . ",'" . $bank . "','" . $norek . "','" . $narek . "','" . $kode_bank . "'";


      $whereCount = "id_user = " . $this->userData['id_user'] . " AND topup_status = 1";
      $dataCount = $this->model('M_DB_1')->count_where('topup', $whereCount);
      if ($dataCount == 0) {
         $this->model('M_DB_1')->insertCols('topup', $cols, $vals);
      }
   }
}
