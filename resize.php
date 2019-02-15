<?php

$img = isset($_GET['img']) AND !empty($_GET['img']) ? $_GET['img'] : NULL;
$w = isset($_GET['width']) AND !empty($_GET['width']) ? $_GET['width'] : NULL;
$h = isset($_GET['height']) AND !empty($_GET['height']) ? $_GET['height'] : NULL;

define('EXT', strtolower(substr(strrchr($img, '.'), 1)));
$cache_file_name = sha1('resized_' . $img . $w . $h) . '.' . EXT;
$file_path = '_cache/' . $cache_file_name;

//header('Content-Type: image/' . EXT);
if (file_exists($file_path))
    header("location: " . $file_path);
else
{
    resize_image($img, $w, $h, TRUE, $file_path);
    header('Location: ' . $file_path);
}

function resize_image($img, $w, $h, $constrain = TRUE, $new_name = NULL)
{
    $x = getimagesize($img);
    $sw = $x[0];
    $sh = $x[1];

    if (isset($w) AND !isset($h))
    {
        $h = (100 / ($sw / $w)) * .01;
        $h = round($sh * $h);
    }
    elseif (isset($h) AND !isset($w))
    {
        $w = (100 / ($sh / $h)) * .01;
        $w = round($sw * $w);
    }
    elseif (isset($h) AND isset($w) AND isset($constrain))
    {
        $hx = (100 / ($sw / $w)) * .01;
        $hx = round($sh * $hx);

        $wx = (100 / ($sh / $h)) * .01;
        $wx = round($sw * $wx);

        if ($hx < $h)
        {
            $h = (100 / ($sw / $w)) * .01;
            $h = round($sh * $h);
        }
        else
        {
            $w = (100 / ($sh / $h)) * .01;
            $w = round($sw * $w);
        }
    }

    switch (EXT)
    {
        case 'jpeg':
        case 'jpg':
            $im = imagecreatefromjpeg($img);
            break;
        case 'png':
            $im = imagecreatefrompng($img);
            break;
        case 'gif':
            $im = imagecreatefromgif($img);
            break;
        default:
            exit;
    }

    $thumb = imagecreatetruecolor($w, $h);
    imagecopyresampled($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);

    switch (EXT)
    {
        case 'jpeg':
        case 'jpg':
            imagejpeg($thumb, $new_name, 100);
            break;
        case 'png':
            imagepng($thumb, $new_name, 100);
            break;
        default:
            exit;
    }

    imagedestroy($thumb);
    imagedestroy($im);
}
