<?php

class Register extends Controller
{
   public function __construct()
   {
      $this->data();
      $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
      $_SESSION['secure']['db_pass'] = $this->model("Validasi")->dec_2($this->db_pass);
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
      $this->model('Log')->write($_POST["HP"] . " " . $_POST["nama"] . " Registration Failed, Closed!");
      echo "Registration Closed!";
      exit();

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

      $pass_save = $this->model('Validasi')->enc($pass);
      $pin_save = $this->model('Validasi')->enc($pin);

      $table = "user";
      $columns = 'no_user, nama, password, pin, no_master';
      $values = "'" . $_POST["HP"] . "','" . $_POST["nama"] . "','" . $pass_save . "','" . $pin_save . "','" . $_POST["HP"] . "'";
      $do = $this->model('M_DB_1')->insertCols($table, $columns, $values);

      if ($do['errno'] == 0) {
         echo 1;
      } else {
         print_r($do);
      }
   }

   public function tambah_staff()
   {
      $this->model('Log')->write($this->userData['no_user'] . " Add Staff Failed! Limit Reach");
      echo "LIMIT STAFF REACH!";
      exit();

      if ($this->userData['user_tipe'] <> 1) {
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
      if ($this->userData['pin'] <> $this->model('Validasi')->enc($pin)) {
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
         echo "error: " . $do['errno'];
      }
   }

   public function ganti_password_99()
   {
      $nomor = $_POST["no_user"];

      if (strlen($_POST["reset_code"]) <> 4) {
         $this->model('Log')->write($nomor . " Change Password Failed! Wrong Reset Code");
         $this->view('login/failed', 'Code Reset Salah');
         exit();
      }

      $code_reset_pass = $this->model('Validasi')->enc($_POST["reset_code"]);

      $where = "no_user = '" . $nomor . "' AND reset_code = '" . $code_reset_pass . "' AND jenis = 1";
      $reset_code = $this->model('M_DB_1')->get_where_row('reset_code', $where);

      if (!isset($reset_code['reset_code'])) {
         $this->model('Log')->write($nomor . " Change Password Failed! Wrong Reset Code");
         $this->view('login/failed', 'Code Reset Salah');
         exit();
      }

      $pass = $_POST["password"];
      $repass = $_POST["repass"];

      if (strlen($pass) < 6) {
         $this->model('Log')->write($nomor . " Change Password Failed! Min. 6 char");
         $this->view('login/failed', 'Password dan PIN minimal 6 karakter!');
         exit();
      }

      if ($pass <> $repass) {
         $this->model('Log')->write($nomor . " Change Password Failed! Confirmation Second Pass Wrong");
         $this->view('login/failed', 'Konfirmasi Password tidak Cocok!');
         exit();
      }

      $where = "no_user = '" . $nomor . "'";
      $reset_code_old = $this->model('M_DB_1')->get_where_row('user', $where)['pass_reset_code'];

      if ($reset_code['reset_code'] == $reset_code_old) {
         $this->model('Log')->write($nomor . " Change Password Failed! Code Reset Expired");
         $this->view('login/failed', 'Reset Code Expired!');
         exit();
      }

      $where = "no_user = '" . $nomor . "'";
      $set = "password = '" . $this->model('Validasi')->enc($pass) . "', pass_reset_code = '" . $reset_code['reset_code'] . "'";
      $do = $this->model('M_DB_1')->update("user", $set, $where);
      if ($do['errno'] == 0) {
         $this->model('Log')->write($nomor . " Change Password Success!");
         $this->view('login/failed', 'Success!');
         exit();
      } else {
         $this->model('Log')->write($nomor . " Change Password Failed! DB Error");
         $this->view('login/failed', "error: " . $do['errno']);
         exit();
      }
   }

   public function updateCell_Master($col)
   {
      if ($this->userData['user_tipe'] <> 1) {
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
         print_r($update['errno']);
      }
   }

   public function ganti_pin()
   {
      if (strlen($_POST["reset_code"]) <> 4) {
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Failed! Wrong Reset Code");
         $this->view('login/failed', 'Code Reset Salah');
         exit();
      }

      $code_reset_pass = $this->model('Validasi')->enc($_POST["reset_code"]);

      $where = "no_user = '" . $this->userData['no_user'] . "' AND reset_code = '" . $code_reset_pass . "' AND jenis = 2";
      $reset_code = $this->model('M_DB_1')->get_where_row('reset_code', $where);
      if (!isset($reset_code['reset_code'])) {
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Failed! Wrong Reset Code");
         $this->view('login/failed', 'Code Reset Salah');
         exit();
      }

      $pin = $_POST["pin"];
      $repin = $_POST["repin"];

      if (strlen($pin) < 6) {
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Failed! Min. 6 char");
         $this->view('login/failed', 'Password dan PIN minimal 6 karakter!');
         exit();
      }

      if ($pin <> $repin) {
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Failed! Confirmation second PIN Wrong");
         $this->view('login/failed', 'Konfirmasi PIN tidak Cocok!');
         exit();
      }

      $where = "no_user = '" . $this->userData['no_user'] . "'";
      $reset_code_old = $this->model('M_DB_1')->get_where_row('user', $where)['pin_reset_code'];

      if ($reset_code['reset_code'] == $reset_code_old) {
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Failed! Reset Code Expired");
         $this->view('login/failed', 'Reset Code Expired!');
         exit();
         exit();
      }

      $where = "no_user = '" . $this->userData['no_user'] . "'";
      $set = "pin = '" . $this->model('Validasi')->enc($pin) . "', pin_reset_code = '" . $reset_code['reset_code'] . "'";
      $do = $this->model('M_DB_1')->update("user", $set, $where);

      if ($do['errno'] == 0) {
         $this->dataSynchrone();
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Success!");
         $this->view('login/failed', 'Success!');
         exit();
      } else {
         $this->model('Log')->write($this->userData['no_user'] . " Change PIN Failed! DB Error");
         $this->view('login/failed', "error: " . $do['errno']);
         exit();
      }
   }
}
