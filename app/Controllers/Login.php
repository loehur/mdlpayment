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
        }

        $_SESSION['submit'] = false;

        $fh = fopen("users", "r") or die("Unable to open file!");
        $cek = "";
        $hp = "";
        $hp = $_POST['HP'];
        $c = $_POST['c_'];
        $token = $_POST['token_'];
        $token_ = "";

        if ($c <> $_SESSION['captcha']) {
            $this->model('Log')->write($hp . " PRE Login Failed, INVALID CAPTCHA");
            $this->view('pre_login/login', "INVALID CAPTCHA");
            exit();
        }

        $match = false;
        while ($line = fgets($fh)) {
            $cek = $line;
            $cek = preg_replace('/\s+/', '', $cek);

            if (strpos($cek, "key") !== false) {
                $key = explode("_", $cek);
                $token_ = $key[1];
            }
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
