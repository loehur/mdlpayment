<?php

class Register extends Controller
{
   public function __construct()
   {
      $this->data();
   }

   public function index()
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }
      $this->view('login/register');
   }

   public function insert()
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }

      $pass = $_POST["password"];
      $repass = $_POST["repass"];
      $pin = $_POST["pin"];
      $repin = $_POST["repin"];

      if (strlen($pass) < 6 || strlen($pin) < 6) {
         echo "Password dan PIN minimal 6 karakter!";
      }

      if ($pass == $pin) {
         echo "Password tidak boleh sama dengan PIN Transaksi!";
         exit();
      }

      if ($pass <> $repass) {
         echo "Password tidak Cocok!";
         exit();
      }
      if ($pin <> $repin) {
         echo "PIN tidak Cocok!";
         exit();
      }

      $table = "user";
      $columns = 'no_user, nama, password, pin, no_master';
      $values = "'" . $_POST["HP"] . "','" . $_POST["nama"] . "','" . md5($pass) . "','" . md5($pin) . "','" . $_POST["HP"] . "'";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);

      if ($do == TRUE) {
         if ($do == 1) {
            echo $do;
         } else {
            print_r($do['info']);
         }
      } else {
         print_r($do);
      }
   }

   public function tambah_staff()
   {
      if ($this->userData['no_master'] <> $this->userData['no_user']) {
         echo "Forbidden Access";
         exit();
      }

      $pass = $_POST["password"];
      $repass = $_POST["repass"];
      $pin = $_POST["pin"];
      $repin = $_POST["repin"];

      if (strlen($pass) < 6 || strlen($pin) < 6) {
         echo "Password dan PIN minimal 6 karakter!";
      }

      if ($pass == $pin) {
         echo "Password tidak boleh sama dengan PIN Transaksi!";
         exit();
      }

      if ($pass <> $repass) {
         echo "Password tidak Cocok!";
         exit();
      }
      if ($pin <> $repin) {
         echo "PIN tidak Cocok!";
         exit();
      }

      $table = "user";
      $columns = 'no_user, nama, password, pin, no_master, user_tipe, en';
      $values = "'" . $_POST["HP"] . "','" . $_POST["nama"] . "','" . md5($pass) . "','" . md5($pin) . "','" . $this->userData['no_master'] . "',2,1";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);

      if ($do == TRUE) {
         if ($do == 1) {
            echo $do;
         } else {
            print_r($do['info']);
         }
      } else {
         print_r($do);
      }
   }

   public function ganti_password()
   {
      $code_reset_pass = md5($_POST["reset_code"]);

      $where = "no_user = '" . $this->userData['no_user'] . "' AND reset_code = '" . $code_reset_pass . "' AND jenis = 1";
      $reset_code = $this->model('M_DB_1')->get_where_row('reset_code', $where);
      if (!isset($reset_code['reset_code'])) {
         echo "Reset Code Salah!";
         exit();
      }

      $where = "no_user = '" . $this->userData['no_user'] . "'";
      $reset_code_old = $this->model('M_DB_1')->get_where_row('user', $where)['pass_reset_code'];

      if ($reset_code['reset_code'] == $reset_code_old) {
         echo "Reset Code Expired!";
         exit();
      }

      $pass = $_POST["password"];
      $repass = $_POST["repass"];

      if (strlen($pass) < 6) {
         echo "Password dan PIN minimal 6 karakter!";
         exit();
      }


      if ($pass <> $repass) {
         echo "Konfirmasi Password tidak Cocok!";
         exit();
      }

      $where = "id_user = " . $this->userData['id_user'];
      $set = "password = '" . md5($pass) . "', pass_reset_code = '" . $reset_code['reset_code'] . "'";
      $this->model('M_DB_1')->update("user", $set, $where);
      $this->dataSynchrone();
      echo 1;
   }

   public function ganti_pin()
   {
      $code_reset_pass = md5($_POST["reset_code"]);

      $where = "no_user = '" . $this->userData['no_user'] . "' AND reset_code = '" . $code_reset_pass . "' AND jenis = 2";
      $reset_code = $this->model('M_DB_1')->get_where_row('reset_code', $where);
      if (!isset($reset_code['reset_code'])) {
         echo "Reset Code Salah!";
         exit();
      }

      $where = "no_user = '" . $this->userData['no_user'] . "'";
      $reset_code_old = $this->model('M_DB_1')->get_where_row('user', $where)['pin_reset_code'];

      if ($reset_code['reset_code'] == $reset_code_old) {
         echo "Reset Code Expired!";
         exit();
      }

      $pin = $_POST["pin"];
      $repin = $_POST["repin"];

      if (strlen($pin) < 6) {
         echo "Password dan PIN minimal 6 karakter!";
         exit();
      }

      if ($pin <> $repin) {
         echo "Konfirmasi PIN tidak Cocok!";
         exit();
      }

      $where = "id_user = " . $this->userData['id_user'];
      $set = "pin = '" . md5($pin) . "', pin_reset_code = '" . $reset_code['reset_code'] . "'";
      $this->model('M_DB_1')->update("user", $set, $where);
      $this->dataSynchrone();
      echo 1;
   }
}
