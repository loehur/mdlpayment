<?php

class Manual_Set extends Controller
{
   public function __construct()
   {
      $this->data();
      $this->session_cek();
      $this->CLASS = __CLASS__;
      $this->load = __CLASS__ . "/load";
      $this->view_content = __CLASS__ . "/content";
   }

   public function index()
   {
      $view_load = $this->load;
      $this->view("layouts/layout_main", [
         "view_load" => $view_load,
         "title" => __CLASS__
      ]);
      $this->load();
   }

   public function load()
   {
      $data = $this->model('M_DB_1')->get_where('manual_set', "no_master = '" . $this->userData['no_user'] . "' ORDER BY id_manual_set DESC");
      $this->view($this->view_content, $data);
   }

   public function simpan()
   {
      if ($this->userData['user_tipe'] <> 1) {
         echo "403";
         exit();
      }
      $id_manual_jenis = $_POST['id_manual_jenis'];
      $kelipatan = $_POST['kelipatan'];
      $biaya = $_POST['biaya'];
      $biaya_dasar = $_POST['dasar_biaya'];

      $unic = $this->userData['no_master'] . $id_manual_jenis;
      $table = "manual_set";
      $columns = 'no_master, id_manual_jenis, biaya, kelipatan, biaya_dasar, unic';
      $values = "'" . $this->userData['no_master'] . "'," . $id_manual_jenis . "," . $biaya . "," . $kelipatan . ",'" . $biaya_dasar . "','" . $unic . "'";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);
      if ($do['errno'] == 0) {
         echo $do['errno'];
      } else {
         print_r($do['error']);
      }
   }

   public function del($id)
   {
      $where = "id_manual = '" . $id . "'";
      $del = $this->model('M_DB_1')->delete_where("manual_set", $where);
      if (isset($del['errno'])) {
         if ($del['errno'] == 0) {
            echo 1;
         }
      } else {
         print_r($del);
      }
   }

   public function updateCell()
   {
      $table  = "manual_set";
      $id = $_POST['id'];
      $mode = $_POST['mode'];
      $value = $_POST['value'];
      $where = "id_manual_set = '" . $id . "'";

      switch ($mode) {
         case 1:
            $col = "biaya_dasar";
            break;
         case 2:
            $col = "biaya";
            break;
         case 3:
            $col = "kelipatan";
            break;
      }

      $set = $col . " = " . $value;
      $update = $this->model('M_DB_1')->update($table, $set, $where);
      echo $update['error'];
   }

   public function update_telegram()
   {
      $telegram = $_POST['telegram'];
      $where = "no_user = '" . $this->userData['no_master'] . "'";
      $set = "telegram_id = " . $telegram;
      $update = $this->model('M_DB_1')->update("user", $set, $where);
      if (isset($update['errno'])) {
         $this->dataSynchrone();
         echo $update['errno'];
      } else {
         print_r($update);
      }
   }
}
