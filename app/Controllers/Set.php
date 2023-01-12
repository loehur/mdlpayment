<?php
class Set extends Controller
{
   public function __construct()
   {
      $this->data();
      $this->session_cek();
   }

   public function index()
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
            exit();
         }
      } else {
         exit();
      }

      $this->view(__CLASS__ . '/main');
   }
}
