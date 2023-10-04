<?php

class Reset extends Controller
{
   public $enc = "7ckqRbk9seKXA35dcd899fa8b07537f12b8dc97d8a00869XTSFx8PS1xk";

   public function pass($id, $code, $lock)
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
            exit();
         }
      } else {
         exit();
      }

      if ($this->model('Validasi')->enc($lock) <> $this->enc) {
         $this->model('Log')->write($id . strtoupper(__FUNCTION__) . " [Generate] Reset Code FAILED! TOKEN INVALID");
         $this->view("Set/main", "FAILED!");
         exit();
      }

      $where = "no_user = '" . $id . "' AND jenis = 1";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . $this->model('Validasi')->enc($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            $this->model('Log')->write($id . " PASSWORD [Generate] Reset Code Success");
            $this->view("Set/main", "SUKSES! " . $code);
         } else {
            $this->view("Set/main", "DB Error");
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . $this->model('Validasi')->enc($code) . "',1";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            $this->model('Log')->write($id . " PASSWORD [Generate] Reset Code Success");
            $this->view("Set/main", "SUKSES! " . $code);
         } else {
            $this->view("Set/main", "DB Error");
         }
      }
   }

   public function pin($id, $code, $lock)
   {
      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
            exit();
         }
      } else {
         exit();
      }

      if ($this->model('Validasi')->enc($lock) <> $this->enc) {
         $this->model('Log')->write($id . strtoupper(__FUNCTION__) . " [Generate] Reset Code FAILED! TOKEN INVALID");
         $this->view("Set/main", "FAILED!");
         exit();
      }

      $where = "no_user = '" . $id . "' AND jenis = 2";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . $this->model('Validasi')->enc($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            $this->model('Log')->write($id . " PIN [Generate] Reset Code Success");
            $this->view("Set/main", "SUKSES! " . $code);
         } else {
            $this->view("Set/main", "DB Error");
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . $this->model('Validasi')->enc($code) . "',2";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            $this->model('Log')->write($id . " PIN [Generate] Reset Code Success");
            $this->view("Set/main", "SUKSES! " . $code);
         } else {
            $this->view("Set/main", "DB Error");
         }
      }
   }

   public function pass_post()
   {
      $id = $_POST['id'];
      $code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
      $lock = $_POST['lock'];

      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
            exit();
         }
      } else {
         exit();
      }

      if ($this->model('Validasi')->enc($lock) <> $this->enc) {
         $this->model('Log')->write($id . strtoupper(__FUNCTION__) . " [Generate] Reset Code FAILED! TOKEN INVALID");
         echo "FAILED!";
         exit();
      }

      $where = "no_user = '" . $id . "' AND jenis = 1";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . $this->model('Validasi')->enc($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            $this->model('Log')->write($id . " PASSWORD [Generate] Reset Code Success");
            echo "SUCCESS! " . $id . " => " . $code;
         } else {
            echo "DB Error";
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . $this->model('Validasi')->enc($code) . "',1";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            $this->model('Log')->write($id . " PASSWORD [Generate] Reset Code Success");
            echo "SUCCESS! " . $id . " => " . $code;
         } else {
            echo "DB Error";
         }
      }
   }

   public function pin_post()
   {

      $id = $_POST['id'];
      $code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
      $lock = $_POST['lock'];

      if (isset($_SESSION['login_payment'])) {
         if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
            exit();
         }
      } else {
         exit();
      }

      if ($this->model('Validasi')->enc($lock) <> $this->enc) {
         $this->model('Log')->write($id . strtoupper(__FUNCTION__) . " [Generate] Reset Code FAILED! TOKEN INVALID");
         echo "FAILED!";
         exit();
      }

      $where = "no_user = '" . $id . "' AND jenis = 2";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . $this->model('Validasi')->enc($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            $this->model('Log')->write($id . " PIN [Generate] Reset Code Success");
            echo "SUCCESS! " . $id . " => " . $code;
         } else {
            echo "DB Error";
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . $this->model('Validasi')->enc($code) . "',2";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            $this->model('Log')->write($id . " PIN [Generate] Reset Code Success");
            echo "SUCCESS! " . $id . " => " . $code;
         } else {
            echo "DB Error";
         }
      }
   }
}
