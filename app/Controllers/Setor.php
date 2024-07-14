<?php

class Setor extends Controller
{
   public $page = "Setor";

   public function __construct()
   {
      $this->session_cek();
      $this->load = $this->page . "/load";
      $this->view_content = $this->page . "/content";
   }

   public function index()
   {
      $view_load = $this->load;
      $this->view("layouts/layout_main", [
         "view_load" => $view_load,
         "title" => "Home"
      ]);
      $this->load();
   }

   public function load()
   {
      $data['data_topup'] = $this->topup_data();
      $data['bank'] = $this->model('M_DB_1')->get('bank');
      $this->view($this->view_content, $data);
   }

   public function insert()
   {
      $jumlah = $_POST['f1'];
      $id_bank = $_POST['f2'];
      $data_bank = $this->model('M_DB_1')->get('bank');

      foreach ($data_bank as $b) {
         if ($b['id_bank'] == $id_bank) {
            $bank = $b['bank'];
            $narek = $b['nama'];
            $norek = $b['norek'];
            $kode_bank = $b['kode_bank'];
         }
      }

      $cols = 'no_master, jumlah, bank, rek, nama, kode_bank';
      $vals = "'" . $this->userData['no_master'] . "'," . $jumlah . ",'" . $bank . "','" . $norek . "','" . $narek . "','" . $kode_bank . "'";

      $whereCount = "no_master = '" . $this->userData['no_master'] . "' AND topup_status = 0";
      $dataCount = $this->model('M_DB_1')->count_where('topup', $whereCount);
      if ($dataCount == 0) {
         $do = $this->model('M_DB_1')->insertCols('topup', $cols, $vals);
         if ($do['errno'] == 0) {
            $this->model('Log')->write($this->userData['no_user'] . " Deposit Input Success!");
            echo 1;
         } else {
            print_r($do['error']);
         }
      } else {
         $this->model('Log')->write($this->userData['no_user'] . " Repeat Deposit Blocked, On Going Deposit on Proses!");
         echo "Masih ada setoran dalam Proses, silahkan Tunggu!";
      }
   }

   function push()
   {
      $id = $_POST['id'];
      $set = "topup_status = 2";
      $where = "id_topup = " . $id;
      $do = $this->model("M_DB_1")->update("topup", $set, $where);

      if ($do['errno'] == 0) {
         $user = $this->userData['nama'] . " " . $this->userData['no_user'];
         $message = "MDL Payment " . $user . ", " . Public_Variables::HOST . "/Setor_/cp/" . $id;
         $curl = curl_init();
         curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => '081268098300', 'message' => $message),
            CURLOPT_HTTPHEADER => array('Authorization: ' . $this->token_wa)
         ));
         curl_exec($curl);
         curl_close($curl);
      }
   }
}
