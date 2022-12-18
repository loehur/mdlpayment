<?php

class Rekap extends Controller
{
   public $page = "Rekap";

   public function __construct()
   {
      $this->data();
      $this->session_cek();
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
      $this->view($this->view_content);
   }

   public function profit()
   {
      if ($this->userData['user_tipe'] <> 1) {
         exit();
      }

      $month = $_POST['y'] . "-" . $_POST['m'];

      //PRE
      $where = "insertTime like '%" . $month . "%' AND tr_status = 1 AND no_master = '" . $this->userData['no_user'] . "'";
      $data['pre'] = $this->model('M_DB_1')->get_where('prepaid', $where);

      //POST
      $where = "insertTime like '%" . $month . "%' AND tr_status = 1 AND no_master = '" . $this->userData['no_user'] . "'";
      $data['post'] = $this->model('M_DB_1')->get_where('postpaid', $where);

      $data['mon'] = array($_POST['y'], $_POST['m']);

      $this->index();
      $this->view($this->page . "/data", $data);
      print_r($data['post']);
   }
}
