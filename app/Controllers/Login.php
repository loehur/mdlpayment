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

      $pass = $this->model('Validasi')->enc($_POST["PASS"]);
      $where = "no_user = '" . $_POST["HP"] . "' AND password = '" . $pass . "'";
      $userData = $this->model('M_DB_1')->get_where_row('user', $where);

      if (empty($userData)) {
         $where2 = "no_user = '" . $_POST["HP"] . "' AND en = 1";
         $userData = $this->model('M_DB_1')->get_where_row('user', $where2);

         if (!empty($userData)) {
            $where3 = "no_user = '" . $userData["no_master"] . "'";
            $masterPass = $this->model('M_DB_1')->get_where_row('user', $where3);
            if (isset($masterPass['password'])) {
               if ($masterPass['password'] == $pass) {
                  $this->set_login($userData);
               } else {
                  $this->view('login/failed', 'Authentication Error');
                  exit();
               }
            } else {
               $this->view('login/failed', 'Authentication Error');
               exit();
            }
         } else {
            $this->view('login/failed', 'Authentication Error');
            exit();
         }
      } else {
         if ($userData['en'] <> 1) {
            $this->view('login/failed', 'Verification Error');
            exit();
         } else {
            $this->set_login($userData);
         }
      }
   }


   function set_login($userData = [])
   {
      //LOGIN
      $where = "id_user = " . $userData['id_user'];
      $set = "pin_failed = 0";
      $this->model('M_DB_1')->update("user", $set, $where);

      $userData = $this->model('M_DB_1')->get_where_row('user', $where);

      $_SESSION['login_payment'] = TRUE;
      $_SESSION['user_data'] = $userData;

      $_SESSION['iak']['user'] = $this->model("Validasi")->dec_2("QTBc9AMLsNbRuyZH");
      $_SESSION['iak']['key'] = $this->model("Validasi")->dec_2("RjBY81EE5NfZvy5HYgvhSluatw==");
      $_SESSION['iak']['url_pre'] = "https://" . $this->model("Validasi")->dec_2("AXoItlRa5MGA6X1ZO18=") . "/";
      $_SESSION['iak']['url_post'] = "https://" . $this->model("Validasi")->dec_2("HGcPr1lW8JqF+3dZPF6i") . "/";

      $where = "no_user = " . $userData['no_master'];
      $_SESSION['setting'] = $this->model('M_DB_1')->get_where_row('user', $where);

      $this->model('M_IAK')->getPrepaidList();
      $this->model('M_IAK')->getPostpaidList();
      $this->index();
   }

   public function logout()
   {
      session_start();
      session_unset();
      session_destroy();
      header('Location: ' . $this->BASE_URL . "Home");
   }
}
