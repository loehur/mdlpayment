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

   public function reset_pass()
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == TRUE) {
            header('Location: ' . $this->BASE_URL . "Home");
         }
      }
      $this->view('login/forget_pass');
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

      if ($do['errno'] == 0) {
         echo 1;
      } else {
         print_r($do);
      }
   }

   public function tambah_staff()
   {
      if ($this->userData['tipe'] <> 1) {
         echo "Forbidden Access";
         exit();
      }

      //CEK PIN FAILED 3X LOGOUT
      if ($this->userData['pin_failed'] > 2) {
         echo 0;
         exit();
      }

      //CEK PIN BENER ATAU ENGGA
      $pin = $_POST['pin'];
      if ($this->userData['pin'] <> md5($pin)) {
         $where = "id_user = " . $this->userData['id_user'];
         $set = "pin_failed = pin_failed + 1";
         $this->model('M_DB_1')->update("user", $set, $where);
         echo "PIN Salah! 3x akan Logout!";
         exit();
      }

      $table = "user";
      $columns = 'no_user, nama, no_master, user_tipe, en';
      $values = "'" . $_POST["HP"] . "','" . $_POST["nama"] . "','" . $this->userData['no_master'] . "',2,1";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);

      if ($do['errno'] == 0) {
         echo 1;
      } else {
         print_r($do['error']);
      }
   }

   public function ganti_password()
   {
      $nomor = "";
      if (isset($_POST["no_user"])) {
         $nomor = $_POST["no_user"];
      } else {
         $nomor = $this->userData['no_user'];
      }
      $code_reset_pass = md5($_POST["reset_code"]);

      $where = "no_user = '" . $this->userData['no_user'] . "' AND reset_code = '" . $code_reset_pass . "' AND jenis = 1";
      $reset_code = $this->model('M_DB_1')->get_where_row('reset_code', $where);
      if (!isset($reset_code['reset_code'])) {
         echo "Reset Code Salah!";
         exit();
      }

      $where = "no_user = '" . $nomor . "'";
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

   public function ganti_password_1()
   {

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
      $set = "password = '" . md5($pass) . "', pass_reset_code = 'abcd'";
      $this->model('M_DB_1')->update("user", $set, $where);
      $this->dataSynchrone();
      echo 1;
   }

   public function updateCell_Master($col)
   {
      if ($this->userData['tipe'] <> 1) {
         echo "Forbidden Access";
         exit();
      }

      if (isset($_POST["f1"])) {
         $value = $_POST["f1"];
      } else {
         if (isset($_POST[$col])) {
            $value = $_POST[$col];
         } else {
            $value = 0;
         }
      }

      $where = "no_user = '" . $this->userData['no_master'] . "'";
      $set = $col . " = " . $value;
      $update = $this->model('M_DB_1')->update("user", $set, $where);
      if (isset($update['errno'])) {
         if ($update['errno'] == 0) {
            $this->dataSynchrone();
            echo 1;
         }
      } else {
         print_r($update);
      }
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

   public function ganti_pin_1()
   {
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
      $set = "pin = '" . md5($pin) . "', pin_reset_code = '1234'";
      $this->model('M_DB_1')->update("user", $set, $where);
      $this->dataSynchrone();
      echo 1;
   }
}
