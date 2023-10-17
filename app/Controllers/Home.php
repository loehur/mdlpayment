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
}
