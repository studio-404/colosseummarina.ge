<?php

$img = isset($_GET['img']) && $_GET['img']!='' ? $_GET['img'] : null;
$w = isset($_GET['width']) && !empty($_GET['width']) ? $_GET['width'] : null;
$h = isset($_GET['height']) && !empty($_GET['height']) ? $_GET['height'] : null;

//if (is_null($img) || is_null($w) && is_null($h)) die;
$w = is_null($w) ? $h : $w;
$h = is_null($h) ? $w : $h;
//$img = urlencode($img);

$ext = substr(strrchr($img, '.'), 1);
if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'))) die;

$cache_file_name = sha1('crop_' . $img . $w . $h) . '.' . $ext;
$file_path = '_cache/' . $cache_file_name;

ini_set("gd.jpeg_ignore_warning", 1);
ini_set("memory_limit","10000M");

//header("Content-Type: image/jpeg");
//header("location: " . $img);

if (file_exists($file_path))
{
    header("location: " . $file_path);
}
else
{
	$src = '_cache/' . sha1('to_crop_' . $img . $w . $h) . '.' . $ext;
	copy(str_replace("http://stat.ge/travel/", "", $img), $src);
    
// removed copy option    
    make_thumb($img, $w, $h, $file_path);
	unlink($src);
    header("location: " . $file_path);
	
}


function make_thumb($img_name, $new_w, $new_h, $new_name = null)
{
    global $ext;
    switch ($ext)
    {
        case 'JPEG':
        case 'JPG':
        case 'jpeg':
        case 'jpg':
            $src_img = imagecreatefromjpeg($img_name);
            break;
        case 'PNG':
        case 'png':
            $src_img = imagecreatefrompng($img_name);
            break;
        case 'GIF':
        case 'gif':
            $src_img = imagecreatefromgif($img_name);
            break;
        default:
            die;
    }

    $old_w = imagesx($src_img);
    $old_h = imagesy($src_img);

    $new_x = 0;
    $new_y = 0;
	
	if($old_w/$old_h > $new_w/$new_h) {
        $orig_h = $old_h;
        $orig_w = round($new_w * $orig_h / $new_h);
        $new_x = ($old_w - $orig_w) / 2;
	} else {
        $orig_w = $old_w;
        $orig_h = round($new_h * $orig_w / $new_w);
        $new_y = ($old_h - $orig_h) / 2;
	}

/*

    if ($old_w > $old_h)
    {
        $orig_h = $old_h;
        $orig_w = round($new_w * $orig_h / $new_h);
        $new_x = ($old_w - $orig_w) / 2;
    }
    else
    {
        $orig_w = $old_w;
        $orig_h = round($new_h * $orig_w / $new_w);
        $new_y = ($old_h - $orig_h) / 2;
    }

*/

    $dst_img = imagecreatetruecolor($new_w, $new_h);
    imagecopyresampled($dst_img, $src_img, 0, 0, $new_x, $new_y, $new_w, $new_h, $orig_w, $orig_h);

    imagejpeg($dst_img, $new_name, 100);

    imagedestroy($dst_img);
    imagedestroy($src_img);
}

?>
