<?php

class Blank extends Controller
{
   public $page = "Blank";

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
}
