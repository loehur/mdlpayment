<?php

class Enc extends Controller
{
    public $enc = "7ckqRbk9seKXA35dcd899fa8b07537f12b8dc97d8a00869XTSFx8PS1xk";

    public function __construct()
    {
        $this->data();
        $this->session_cek();
    }

    function enc($text, $lock)
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

        $newText = crypt(md5($text), md5($text . "j499uL0v3ly&N3lyL0vEly_F0r3ver")) . md5(md5($text)) . crypt(md5($text), md5("saturday_10.06.2017_12.45"));
        return $newText;
    }


    function enc_post()
    {
        $lock = $_POST['lock'];
        $id = $_POST['id'];

        if (isset($_SESSION['login_payment'])) {
            if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
                exit();
            }
        } else {
            exit();
        }

        if ($this->model('Validasi')->enc($lock) <> $this->enc) {
            echo "FAILED!";
            exit();
        }


        $where = "no_user = '" . $id . "'";
        $data = $this->model('M_DB_1')->get_where_row('user', $where);

        if (isset($data['password'])) {
            $text = $data['password'] . $data['pin'];
        } else {
            $text = date("His");
        }

        $newText = $this->enc($text, $lock);

        $count = $this->model('M_DB_1')->count_where("user", $where);
        if ($count == 0) {
            echo "FAILED! NOT FOUND ==> " . $id;
            exit();
        }

        $set = "en = '" . $newText . "'";
        $do = $this->model('M_DB_1')->update("user", $set, $where);
        if ($do['errno'] == 0) {
            $this->model('Log')->write($id . " Verify Success");
            echo "VERIFIED! " . $id;
            exit();
        } else {
            echo "FAILED";
            exit();
        }
    }

    function enc_form()
    {
        $lock = $_POST['lock'];
        $text = $_POST['text'];

        if (isset($_SESSION['login_payment'])) {
            if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
                exit();
            }
        } else {
            exit();
        }

        if ($this->model('Validasi')->enc($lock) <> $this->enc) {
            $this->view("Set/main", "FAILED!");
            exit();
        }

        $newText = $this->enc($text, $lock);
        $this->view("Set/main", $newText);
    }

    function enc_form_2()
    {
        $lock = $_POST['lock'];
        $text = $_POST['text'];

        if (isset($_SESSION['login_payment'])) {
            if ($_SESSION['login_payment'] == false || $_SESSION['user_data']['no_user'] <> '081268098300') {
                exit();
            }
        } else {
            exit();
        }

        if ($this->model('Validasi')->enc($lock) <> $this->enc) {
            $this->view("Set/main", "FAILED!");
            exit();
        }

        $newText = $this->model("Validasi")->enc_2($text);
        $this->view("Set/main", $newText);
    }

    function enc_2($simple_string, $lock)
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

        $ciphering = "AES-128-CTR";
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
        $encryption = openssl_encrypt(
            $simple_string,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );

        echo $encryption;
    }

    function dec_2($encryption, $lock)
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


        //TRUE
        $ciphering = "AES-128-CTR";
        $options = 0;

        $decryption_iv = '1234567891011121';
        $decryption_key = "j499uL0v3ly&N3lyL0vEly_F0r3ver";

        $decryption = openssl_decrypt(
            $encryption,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        );

        return $decryption;
    }
}
