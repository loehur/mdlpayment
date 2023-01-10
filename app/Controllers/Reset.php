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
         exit();
      }

      $where = "no_user = '" . $id . "' AND jenis = 1";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . $this->model('Validasi')->enc($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . $this->model('Validasi')->enc($code) . "',1";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
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
         exit();
      }

      $where = "no_user = '" . $id . "' AND jenis = 2";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . $this->model('Validasi')->enc($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . $this->model('Validasi')->enc($code) . "',2";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      }
   }
}
