<?php
class O extends Controller
{
   public function __construct()
   {
      $this->CLASS = __CLASS__;
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

   function action($id, $action)
   {
      $where = "id_manual = '" . $id . "'";
      if ($action <> null) {
         $set = "tr_status = " . $action;
         $this->model("M_DB_1")->update("manual", $set, $where);
      }
   }
}
