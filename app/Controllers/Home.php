<?php

class Home extends Controller
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
      $data = $this->saldo();
      $this->view($this->view_content, $data);
   }

   public function load_pre()
   {
      $data = $this->saldo();
      $this->view($this->page . "/pre", $data);
   }

   public function load_post()
   {
      $data = $this->saldo();
      $this->view($this->page . "/post", $data);
   }

   public function load_manual()
   {
      if ($this->userData['no_master'] == $this->userData['no_user']) {
         $where = "no_master = '" . $this->userData['no_master'] . "'";
      } else {
         $where = "no_user = '" . $this->userData['no_user'] . "'";
      }

      $data = $this->model("M_DB_1")->get_where("manual", $where . " ORDER BY id_manual DESC LIMIT 12");
      $this->view($this->page . "/manual", $data);
   }

   function label()
   {
      $table = "label";
      $label_id = $_POST['label_id'];
      $label_mode = $_POST['label_mode'];
      $label_name = $_POST['label_name'];

      $unic = $this->userData['no_master'] . "_" . $this->userData['no_user'] . "_" . $label_mode . "_" . $label_id;
      $columns = 'customer_id, master_no, user_no, label_name, label_mode, unic';
      $values = "'" . $label_id . "','" . $this->userData['no_master'] . "','" . $this->userData['no_user'] . "','" . $label_name . "'," . $label_mode . ",'" . $unic . "'";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);
      if ($do['errno'] == 1062) {
         $where = "customer_id = '" . $label_id . "' AND user_no = '" . $this->userData['no_user'] . "' AND label_mode = " . $label_mode;
         $set = "label_name = '" . $label_name . "'";
         $update = $this->model('M_DB_1')->update($table, $set, $where);
         if (!$update['errno'] == 0) {
            print_r($update);
         }
      } else {
         if ($do['errno'] <> 0) {
            print_r($do);
         }
      }
   }
}
