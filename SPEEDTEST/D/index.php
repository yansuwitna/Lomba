<?php
session_start();

function generateRandomString($length)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function createCaptchaImage($text)
{
    //Variabel Acak
    $jml = 8;
    $baris = 10;
    $titik = 50;

    //Font
    $font = 'BERNHC.TTF';
    $fontSize = 20;
    
    //Membuat Kotak
    $width = 300;
    $height = 100;
    $image = imagecreatetruecolor(300, 100);
    $backgroundColor = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $backgroundColor);

    //Acak Data
    $captchaText = generateRandomString($jml);
    $_SESSION['captcha'] = $captchaText;

    //Membuat Tulisan
    for ($i = 0; $i < $jml; $i++) {
        $angle = rand(-10, 10); 
        $x = $i * ($width / $jml) + rand(5, 10);
        $y = rand($height / 2, $height - 10);

        imagettftext($image, $fontSize, $angle, $x, $y, imagecolorallocate($image, 0, 0, 0), $font, $captchaText[$i]);
    }

    // Membuat Line
    for ($i = 0; $i < $baris; $i++) {
        imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), imagecolorallocate($image, 0, 0, 0));
    }

    //Membuat Titik
    for ($i = 0; $i < $titik; $i++) {
        imagesetpixel($image, rand(0, $width), rand(0, $height), imagecolorallocate($image, 0, 0, 0));
    }

    //Menampilkan
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
}

createCaptchaImage($_SESSION['captcha']);
