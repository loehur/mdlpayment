<?php

class Reset extends Controller
{
   public function pass($id, $code)
   {
      $code += 99;
      $where = "no_user = '" . $id . "' AND jenis = 1";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . md5($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . md5($code) . "',1";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      }
   }

   public function pin($id, $code)
   {
      $code += 99;
      $where = "no_user = '" . $id . "' AND jenis = 2";
      $cek = $this->model('M_DB_1')->count_where('reset_code', $where);
      if ($cek > 0) {
         $set = "reset_code ='" . md5($code) . "'";
         $update = $this->model('M_DB_1')->update('reset_code', $set, $where);
         if ($update['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      } else {
         $cols = "no_user, reset_code, jenis";
         $vals = "'" . $id . "','" . md5($code) . "',2";
         $insert = $this->model('M_DB_1')->insertCols('reset_code', $cols, $vals, $where);
         if ($insert['errno'] == 0) {
            echo "SUKSES!";
         } else {
            echo "ERROR!";
         }
      }
   }
}
