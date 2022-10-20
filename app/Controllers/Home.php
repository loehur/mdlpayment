<?php

class Home extends Controller
{
   public $page = "Home";

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
         "title" => "Home"
      ]);
   }

   public function load()
   {
      $data['topup'] = $this->model('M_DB_1')->get_where('topup', "id_user = " . $this->userData['id_user']);
      $data['callback'] = $this->model('M_DB_1')->get_where('callback', "id_user = " . $this->userData['id_user']);
      $this->view($this->view_content, $data);
   }
}
