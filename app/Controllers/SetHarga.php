<?php

class SetHarga extends Controller
{
   public $page = "SetHarga";

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
}
