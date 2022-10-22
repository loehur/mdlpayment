<?php

class Transaksi extends Controller
{
   public $page = "Transaksi";

   public function __construct()
   {
      $this->session_cek();
      $this->data();

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

   public function product_type($jenis)
   {
      $this->index();
      switch ($jenis) {
         case 1:
            $this->view($this->page . "/product_type", $jenis);
            break;
         case 2:
            break;
      }
   }

   public function product_des($type, $jenis)
   {
      $this->index();
      switch ($jenis) {
         case 1:
            $array = array();
            $array['data'] = array();
            foreach ($this->prepaidList['list'] as $a) {
               if ($a['product_type'] == $type) {
                  if (!isset($s[$a['product_description']])) {
                     array_push($array['data'], $a['product_description']);
                     $s[$a['product_description']] = true;
                  }
               }
            }
            $array['type'] = $type;
            $array['jenis'] = $jenis;

            $this->view($this->page . "/product_des", $array);
            break;
         case 2:
            break;
      }
   }

   public function product_code($des, $type, $jenis)
   {
      $this->index();
      switch ($jenis) {
         case 1:
            $array = array();
            $array['data'] = array();
            foreach ($this->prepaidList['list'] as $a) {
               if ($a['product_description'] == $des) {
                  $array['data'][$a['product_code']] = $a['product_nominal'] . ", " . $a['product_details'] . "<br>Rp" . number_format($a['product_price']);
               }
            };

            $array['jenis'] = $jenis;
            $array['type'] = $type;
            $array['des'] = $des;

            asort($array['data']);
            $this->view($this->page . "/product_code", $array);
            break;
         case 2:
            break;
      }
   }

   public function confirmation($code, $nominal, $des, $type, $jenis)
   {
      $this->index();
      switch ($jenis) {
         case 1:

            $array = array();
            $array['data'] = array();
            $array['detail'] = "";

            foreach ($this->prepaidList['list'] as $a) {
               if ($a['product_code'] == $code) {
                  $array['detail'] = $a['product_details'];
               }
            };

            $array['par'] = [
               'code' => $code,
               'nominal' => $nominal,
               'des' => $des,
               'type' => $type,
               'jenis' => $jenis
            ];

            $this->view($this->page . "/confirmation", $array);
            break;
         case 2:
            break;
      }
   }
}
