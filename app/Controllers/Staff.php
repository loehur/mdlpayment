<?php

class Staff extends Controller
{
   public $page = "Staff";

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
         "title" => $this->page
      ]);
      $this->load();
   }

   public function load()
   {
      $data = $this->model('M_DB_1')->get_where('user', "no_master = " . $this->userData['no_user'] . " AND no_user <> " . $this->userData['no_user']);
      $this->view($this->view_content, $data);
   }
}
