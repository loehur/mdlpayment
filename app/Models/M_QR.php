<?php
require 'app/Library/QRGen/qrlib.php';

class M_QR
{
    public function GenQR($val)
    {
        $tempdir = "img-qrcode/";
        if (!file_exists($tempdir))
            mkdir($tempdir, 0755);
        $valMod = str_replace("/", "", $val);
        $file_name = $valMod . ".png";
        $file_path = $tempdir . $file_name;
        QRcode::png($val, $file_path, "H", 6, 4);
        return $file_path;
    }
}
