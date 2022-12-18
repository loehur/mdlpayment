<?php

class Usage extends Controller
{
   public $page = __CLASS__;

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
      $data = $this->model('M_DB_1')->get_where('paid_use', "no_master = '" . $this->userData['no_user'] . "' ORDER BY note ASC");
      $this->view($this->view_content, $data);
   }

   public function simpan()
   {
      if ($this->userData['user_tipe'] <> 1) {
         echo "Forbidden Access";
         exit();
      }

      $table = "paid_use";
      $columns = 'no_master, customer_id, limit_bulanan, note';
      $values = "'" . $this->userData['no_master'] . "','" . $_POST['id'] . "'," . $_POST['limit'] . ",'" . $_POST['note'] . "'";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);

      if ($do['errno'] == 0) {
         echo 1;
      } else {
         print_r($do['error']);
      }
   }


   public function updateCell_Staff($col, $value, $no_user)
   {
      $where = "no_user = '" . $no_user . "'";
      $set = $col . " = " . $value;
      $update = $this->model('M_DB_1')->update("user", $set, $where);
      if (isset($update['errno'])) {
         if ($update['errno'] == 0) {
            $this->index();
         }
      } else {
         print_r($update);
      }
   }

   public function del($id)
   {
      $where = "id = '" . $id . "'";
      $del = $this->model('M_DB_1')->delete_where("paid_use", $where);
      if (isset($del['errno'])) {
         if ($del['errno'] == 0) {
            echo 1;
         }
      } else {
         print_r($del);
      }
   }
}
