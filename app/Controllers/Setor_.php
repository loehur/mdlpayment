<?php

class Setor_ extends Controller
{
   public function __construct()
   {
      $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
      if (strlen($this->db_pass) == 0) {
         $_SESSION['secure']['db_pass'] = "";
      } else {
         $_SESSION['secure']['db_pass'] = $this->model("Validasi")->dec_2($this->db_pass);
      }
   }

   function cp($id)
   {
      $where = "id_topup = " . $id;
      $data['data'] = $this->model('M_DB_1')->get_where_row('topup', $where);
      $data['_c'] = __CLASS__;
      $this->view("Setor/cp", $data);
   }

   function confirm($id, $c)
   {
      $set = "topup_status = " . $c;
      $where = "id_topup = " . $id;
      echo "<pre>";
      print_r($this->model("M_DB_1")->update("topup", $set, $where));
      echo "<br>Confirm: " . $c;
      echo "</pre>";
   }
}
