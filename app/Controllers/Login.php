<?php
class Login extends Controller
{
    public function index()
    {
        if (isset($_SESSION['login_payment'])) {
            if ($_SESSION['login_payment'] == TRUE) {
                header('Location: ' . $this->BASE_URL . "Home");
            } else {
                $this->view('pre_login/login');
            }
        } else {
            $this->view('pre_login/login');
        }
    }

    public function cek_login()
    {
        if (!$_SESSION['submit']) {
            $this->index();
        } else {
            if ($_SESSION['submit'] == false) {
                $this->index();
            }
        }

        $_SESSION['pre_log'] = false;

        $fh = fopen("assets/users", "r") or die("Unable to open file!");
        $cek = "";
        $hp = "";
        $hp = $_POST['HP'];
        $c = $_POST['c_'];
        $token = $_POST['token_'];

        $_SESSION['secure']['encryption'] = "j499uL0v3ly&N3lyL0vEly_F0r3ver";
        $token_ = $this->model("Validasi")->dec_2($this->login_key);

        if ($c <> $_SESSION['captcha']) {
            $this->model('Log')->write($hp . " PRE Login Failed, INVALID CAPTCHA");
            $this->view('pre_login/login', "INVALID CAPTCHA");
            exit();
        }

        $match = false;
        while ($line = fgets($fh)) {
            $cek = $line;
            $cek = preg_replace('/\s+/', '', $cek);

            if (strtoupper($cek) == strtoupper($hp)) {
                $match = true;
            }
        }

        fclose($fh);

        if ($match == true) {
            if ($token <> $token_) {
                $this->model('Log')->write($hp . " INVALID SECRET KEY");
                $this->view('pre_login/login', "INVALID SECRET KEY");
                exit();
            } else {
                $_SESSION['submit'] = false;
                $_SESSION['pre_log'] = true;
                echo "<script>window.location.href = '" . $this->BASE_URL . "Login_99/index/" . $hp . "';</script>";
            }
        } else {
            $this->model('Log')->write($hp . " PRE Login Failed, INVALID NUMBER");
            $this->view('pre_login/login', "INVALID NUMBER");
            exit();
        }
    }

    public function captcha()
    {
        $random_alpha = md5(rand());
        $captcha_code = substr($random_alpha, 0, 4);
        $_SESSION['captcha'] = $captcha_code;

        $target_layer = imagecreatetruecolor(45, 24);
        $captcha_background = imagecolorallocate($target_layer, 255, 160, 199);
        imagefill($target_layer, 0, 0, $captcha_background);
        $captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
        imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
        header("Content-type: image/jpeg");
        imagejpeg($target_layer);
    }
}
