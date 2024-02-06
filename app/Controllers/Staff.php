<?php

class Staff extends Controller
{
   public $page = "Staff";

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
      $data = $this->model('M_DB_1')->get_where_order('user', "no_master = '" . $this->userData['no_user'] . "' AND no_user <> '" . $this->userData['no_user'] . "'", "en DESC");
      $this->view($this->view_content, $data);
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

   function updateSeller()
   {
      $no_user = $_POST['user'];
      $value = $_POST['val'];

      $where = "no_user = '" . $no_user . "'";

      if ($value == 0) {
         $val_ = 1;
      } else {
         $val_ = 0;
      }

      $set = "seller = " . $val_;
      $update = $this->model('M_DB_1')->update("user", $set, $where);
      if (isset($update['errno'])) {
         if ($update['errno'] <> 0) {
            echo $update['errno'];
         }
      }
   }
}
