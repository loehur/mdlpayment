<?php
class O extends Controller
{
   public function __construct()
   {
      $this->CLASS = __CLASS__;

      $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
      if (strlen($this->db_pass) == 0) {
         $_SESSION['secure']['db_pass'] = "";
      } else {
         $_SESSION['secure']['db_pass'] = $this->model("Validasi")->dec_2($this->db_pass);
      }
   }

   public function m($id = "", $action = null)
   {
      $parse[0] = $id;
      $parse[1] = $action;
      $this->view(__CLASS__ . "/viewer", $parse);
   }

   public function content($id = "", $action = null)
   {
      $where = "id_manual = '" . $id . "'";
      if ($action <> null) {
         $set = "tr_status = " . $action;
         $this->model("M_DB_1")->update("manual", $set, $where);
      }

      $data = $this->model("M_DB_1")->get_where_row("manual", $where);
      $this->view("layouts_o/layout_main", [
         "title" => "Operator"
      ]);

      $this->view(__CLASS__ . "/content", $data);
   }

   function action($id, $action, $id_telegram)
   {
      switch ($action) {
         case 1:
            $status = "Dalam Proses";
            break;
         case 2:
            $status = "Transaksi Sukses";
            break;
         case 3:
            $status = "Transaksi Ditolak";
            break;
         default:
            $status = "No Status";
            break;
      }

      $where = "id_manual = '" . $id . "'";
      if ($action <> null) {
         $set = "tr_status = " . $action;
         $up = $this->model("M_DB_1")->update("manual", $set, $where);
         print_r($up);
         if ($up['errno'] == 0) {
            $text = substr($id, -2) . " - " . $status;
            $url = "https://api.telegram.org/bot898378947:AAFSNdF0452DsRfTCKC9d9xp39hisvhCle8/sendMessage?chat_id=" . $id_telegram . "&parse_mode=markdown&text=" . $text;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            curl_close($ch);
         }
      }
   }
}
