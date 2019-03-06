<?php
define('PRODUCTION', FALSE);
define('START_TIME', microtime(TRUE));
define('START_MEMORY', memory_get_usage());
require_once '_manager/bootstrap.php'; //_cadmin/bootstrap
date_default_timezone_set('Asia/Tbilisi');

if(isset($_POST) && !empty($_POST)){
    $post = $_POST;
    $post["g_date"] = date("d-m-Y h:i:s");
    $post["g_url"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $post["g_ip"] = $_SERVER["REMOTE_ADDR"];
    $req_dump = print_r($post, true); 

    file_put_contents('post.log', $req_dump, FILE_APPEND);
}

if(isset($_GET) && !empty($_GET)){
    $get = $_GET;
    $get["g_date"] = date("d-m-Y h:i:s");
    $get["g_url"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $get["g_ip"] = $_SERVER["REMOTE_ADDR"];
    $req_dump2 = print_r($get, true); 

    file_put_contents('get.log', $req_dump2, FILE_APPEND);
}


// Administration
if ($router['slug'] == c('admin.slug'))
{
    $storage->action = strtolower(get('action', 'main'));
    $storage->subaction = strtolower(get('subaction'));
    require_once DIR . CMS . '/class.manager.php';
    require_once DIR . WEBSITE . '/class.manager.php';
    file_exists(DIR . WEBSITE . '/functions.php') AND require_once DIR . WEBSITE . '/functions.php';

    checkAdminUsers();

    $manager = new Manager();
    if ($storage->action !== 'manager' AND in_array($storage->action, array_map('strtolower', get_class_methods('Manager'))))
        call_user_func(array($manager, $storage->action));
    exit($manager);
}

// Website
ob_start(c('output.buffering')) AND header('Content-Type: text/html; charset=' . c('output.charset'));
$storage->section = db_fetch('SELECT * FROM '.c('table.pages').' WHERE language = \'' . l() . '\' AND deleted = 0 AND visibility = "true" AND id = ' . current_id() . ' LIMIT 1;');
$storage->current_url = href(current_id());
$page_types = c('section.types');
$storage->page_type = $page_types[empty($storage->section) ? 999 : $storage->section['category']];

if($storage->is_from_list==1) {
    $q1 = db_fetch("select * from menus where language='".l()."' and deleted=0 and id=".$storage->section["menuid"]);
    $q2 = db_fetch("select * from pages where language='".l()."' and deleted=0 and visibility='true' and attached='".$q1["title"]."'");
    $storage->pagetitle = $q2["title"];
} else {
    $storage->pagetitle = $storage->section["title"];
}


require_once DIR . CMS . '/class.pages.php';
require_once DIR . WEBSITE . '/class.pages.php';
file_exists(DIR . WEBSITE . '/functions.php') AND require_once DIR . WEBSITE . '/functions.php';
if ($storage->page_type !== 'pages' AND in_array($storage->page_type, array_map('strtolower', get_class_methods('Pages'))))
    call_user_func(array(new Pages(), $storage->page_type));
if(isset($_GET["ajax"])) 
	require_once WEBSITE . '/ajax.php';
else
	require_once WEBSITE . '/content.php';
$storage->memory_usage = number_format((memory_get_peak_usage() - START_MEMORY) / 1024, 2) . ' KB';
$storage->execution_time = number_format(microtime(TRUE) - START_TIME, 5) . ' seconds';
PRODUCTION OR trace($storage, 'Storage');
exit();
