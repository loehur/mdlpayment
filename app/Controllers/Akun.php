<?php

class Akun extends Controller
{
   public $page = "Akun";

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
   }

   public function load()
   {
      $this->view($this->view_content);
   }
}
