<?php

defined('DIR') OR exit;

function getUserRight($userid, $action="", $subaction="") {
   	$user = db_fetch("SELECT * FROM " . c('table.users') . " WHERE id = '" . $userid . "';");
	if($user["usercat"]=="Administrator") 
		return true;
	$access = db_fetch("SELECT count(*) AS cnt FROM " . c('table.user_access') . " WHERE userid = '" . $userid . "' AND action = '" . $action . "';");
	if($access["cnt"]>0) {
		return true;
	}
	return false;
}

function str_lreplace($search, $replace, $subject) {
	$pos = strrpos($subject, $search);    
	if($pos === false) {        
		return $subject;    
	} else {        
		return substr_replace($subject, $replace, $pos, strlen($search));    
	}
}

function utf82lat($string="")
{
	$utf8 = array("ა", "ბ", "გ", "დ", "ე", "ვ", "ზ", "თ", "ი", "კ", "ლ", "მ", "ნ", "ო", "პ", "ჟ", "რ", "ს", "ტ", "უ", "ფ", "ქ", "ღ", "ყ", "შ", "ჩ", "ც", "ძ", "წ", "ჭ", "ხ", "ჯ", "ჰ", );
	$lat  = array("a", "b", "g", "d", "e", "v", "z", "t", "i", "k", "l", "m", "n", "o", "p", "j", "r", "s", "t", "u", "f", "q", "gh", "k", "sh", "ch", "ts", "dz", "ts", "ch", "kh", "dj", "h", );
	$out = str_replace($utf8, $lat, $string);
	return $out;
}

function utf82lat2($string="")
{
	$utf8 = array("ა", "ბ", "გ", "დ", "ე", "ვ", "ზ", "თ", "ი", "კ", "ლ", "მ", "ნ", "ო", "პ", "ჟ", "რ", "ს", "ტ", "უ", "ფ", "ქ", "ღ", "ყ", "შ", "ჩ", "ც", "ძ", "წ", "ჭ", "ხ", "ჯ", "ჰ", );
	$lat  = array("a", "b", "g", "d", "e", "v", "z", "T", "i", "k", "l", "m", "n", "o", "p", "J", "r", "s", "t", "u", "f", "q", "R", "y", "S", "C", "c", "Z", "w", "W", "x", "j", "h", );
	$out = str_replace($utf8, $lat, $string);
	return $out;
}


function trace($data, $title = NULL)
{
//    include_once DIR . '_manager/firephp/FirePHP.class.php';
//    return FirePHP::getInstance(TRUE)->log($data, $title);
}

function c($key = NULL, $default = NULL)
{
    $config = Storage::instance()->get('configuration');
    if (empty($key))
        return $config;
    return array_key_exists($key, $config) ? $config[$key] : $default;
}

// Get Admin Language Variables
function a($key) 
{
	global $a;
	return (isset($a[$key])) ? $a[$key] : '';
}

function s($key = '')
{
    $value = NULL;
    $storage = Storage::instance();
	$settings_sql = "SELECT `key`, `value` FROM ".c('table.settings')." WHERE `language` = '{$storage->language}' AND `deleted` = 0 AND `key` = '{$key}';";
	$settings_item = db_fetch($settings_sql);
	$value = $settings_item["value"];
    return $value;
}

function a_s($key = '')
{
    $value = NULL;
    $storage = Storage::instance();
	$settings_sql = "SELECT `key`, `value` FROM ".c('table.admin_settings')." WHERE `language` = '{$storage->language}' AND `deleted` = 0 AND `key` = '{$key}';";
	$settings_item = db_fetch($settings_sql);
	$value = $settings_item["value"];
    return $value;
}

function v($key = NULL)
{
	return (sha1(md5(c('site.url')))==c('admin.hash')) ? TRUE : FALSE;
}

function router()
{
    $request_uri = explode('/', $_SERVER['REQUEST_URI']);
    $script_name = explode('/', $_SERVER['SCRIPT_NAME']);
    $segments = array_diff_assoc($request_uri, $script_name);
    if (empty($segments))
    {
        return array(
            'language' => c('languages.default'),
            'slug' => NULL,
            'segments' => array()
        );
    }
    $segments = array_values($segments);
    $language_id = rtrim(sef($segments[0]), '/');
    $has_language = in_array($language_id, c('languages.all'));
    $uri['language'] = $has_language ? $language_id : c('languages.default');
    $has_language AND $segments = array_slice($segments, 1);
	$last_slug = (count($segments) == 0) ? "" : $segments[count($segments) - 1];
    $qs_position = strpos($last_slug, '?');
    FALSE === $qs_position OR $segments[count($segments) - 1] = substr($last_slug, 0, $qs_position);
    foreach ($segments as $key => $value)
    {
        $segments[$key] = rtrim(sef($value), '/');
        if (empty($segments[$key]))
            unset($segments[$key]);
    }
    $uri['slug'] = empty($segments) ? NULL : (string) trim(implode('/', $segments), '/');
    $uri['segments'] = empty($segments) ? array() : $segments;
	$uri['request_uri'] = $request_uri;
    return $uri;
}

function input($type = INPUT_GET, $name = NULL, $default = FALSE)
{
    if (empty($name))
    {
        $array = filter_input_array($type);
        return empty($array) ? $default : $array;
    }
    if (!filter_has_var($type, $name))
        return $default;
    return filter_input($type, $name);
}

function get($name = NULL, $default = FALSE)
{
    return input(INPUT_GET, $name, $default);
}

function post($name = NULL, $default = FALSE)
{
    return input(INPUT_POST, $name, $default);
}

function db_query($sql)
{
    if (($result = mysql_query($sql, Storage::instance()->get('database_link'))) === FALSE)
        return FALSE;
    Storage::instance()->total_queries++;
    return $result;
}

function db_fetch($sql)
{
    $result = db_query($sql);
    if ($result === FALSE)
        return FALSE;
    return mysql_fetch_assoc($result);
}

function db_fetch_all($sql)
{
    $result = db_query($sql);
    if ($result === FALSE)
        return FALSE;
    $rows = array();
    while ($row = mysql_fetch_assoc($result))
        $rows[] = $row;
    return $rows;
}

function db_retrieve($column, $table, $field, $value, $other = NULL, $log = FALSE)
{
    is_numeric($value) OR $value = "'{$value}'";
    empty($other) OR $other = ' ' . $other;
    $sql = "SELECT `{$column}` FROM `{$table}` WHERE `{$field}` = {$value}{$other};";
    $log AND trace($sql, 'db_retrieve() SQL');
    $result = db_fetch($sql);
    if (empty($result))
        return FALSE;
    return $result[$column];
}

function db_escape($value)
{
    if ($value === '')
        return 'NULL';
    switch (gettype($value))
    {
        case 'string':
            $value = mysql_real_escape_string($value, Storage::instance()->database_link);
            break;
        case 'boolean':
            $value = (int) $value;
            break;
        case 'double':
            $value = sprintf('%F', $value);
            break;
        default:
            $value = $value === NULL ? 'NULL' : $value;
            break;
    }
    return (string) $value;
}

function db_insert($table, $data = array())
{
    $fields = array();
    $columns = array();
    foreach ($data as $field => $value)
    {
        $fields[] = "`{$field}`";
        $value = db_escape($value);
        $columns[] = (is_numeric($value) OR 'NULL' === $value) ? $value : '\'' . $value . '\'';
    }
    return 'INSERT INTO `' . $table . '` (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $columns) . ');';
}

function db_update($table, $data = array(), $other = NULL)
{
    $set = array();
    foreach ($data as $field => $value)
    {
        $value = db_escape($value);
        $set[] = "`{$field}` = " . ((is_numeric($value) OR 'NULL' === $value) ? $value : '\'' . $value . '\'');
    }
    return 'UPDATE `' . $table . '` SET ' . implode(', ', $set) . (empty($other) ? NULL : ' ' . $other) . ';';
}

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        return $_SERVER['REMOTE_ADDR'];
}

function sef($string)
{
    $string = preg_replace('/[^-ა-ჰa-zA-Z0-9_ ]/', NULL, $string);
    $string = preg_replace('/[-_ ]+/', '-', trim($string));
    return strtolower($string);
}

function curl_get($url)
{
    $request = curl_init($url);
    if (FALSE === $request)
        return FALSE;
    curl_setopt_array($request, array(
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 10
    ));
    $response = curl_exec($request);
    curl_close($request);
    return $response;
}

function email($from = array(), $to = array(), $subject = NULL, $body = NULL, $xmailer = "")
{
    $headers = array(
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=utf-8',
        'X-Mailer: '.$xmailer,
        'From: ' . $from
    );
    return mail($to, $subject, $body, implode(PHP_EOL, $headers));
}

function redirect($url)
{
    if (headers_sent())
    {
        $js = '<script type=\"text/javascript\"><!-- ';
        $js .= 'window.location.replace(' . $url . ');';
        $js .= ' //--></script>';
        $html = '<noscript>';
        $html .= '<meta http-equiv="refresh" content="0; url=' . $url . '" />';
        $html .= '</noscript>';
        echo exit($js . $html);
    }
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $url);
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    exit;
}

function convert_date($date)
{
    if (empty($date))
        return NULL;
    $parts = explode('-', date('Y-n-j', strtotime($date)));
    switch ($parts[1])
    {
        case 1:
            $month = l('month.jan');
            break;
        case 2:
            $month = l('month.feb');
            break;
        case 3:
            $month = l('month.mar');
            break;
        case 4:
            $month = l('month.apr');
            break;
        case 5:
            $month = l('month.may');
            break;
        case 6:
            $month = l('month.jun');
            break;
        case 7:
            $month = l('month.jul');
            break;
        case 8:
            $month = l('month.aug');
            break;
        case 9:
            $month = l('month.sep');
            break;
        case 10:
            $month = l('month.oct');
            break;
        case 11:
            $month = l('month.nov');
            break;
        case 12:
            $month = l('month.dec');
            break;
        default:
            return NULL;
    }
    return $parts[2] . ' ' . $month . ' ' . $parts[0];
}

function template($file, $variables = array())
{
    $files = array(
        DIR . '_website/templates/' . $file . '.php',
        DIR . '_manager/templates/' . $file . '.php',
        DIR . '_manager/templates/default' . $file . '.php'
    );
    foreach ($files as $template)
    {
        if (!file_exists($template))
            continue;
        ob_start() AND extract($variables);
        include $template;
        return ob_get_clean();
    }
}

function plugin_template($file, $variables = array())
{
    $files = array(
        DIR . '_plugins/templates/' . $file . '.php',
    );
    foreach ($files as $template)
    {
        if (!file_exists($template))
            continue;
        ob_start() AND extract($variables);
        include $template;
        return ob_get_clean();
    }
}

function site_template($file, $variables = array())
{
    $files = array(
        '_website/templates/' . $file . '.php',
        '_manager/templates/' . $file . '.php',
        '_manager/templates/default' . $file . '.php'
    );
    foreach ($files as $template)
    {
        if (!file_exists($template))
            continue;
        ob_start() AND extract($variables);
        include $template;
        return ob_get_clean();
    }
}

function sanitize_input($data)
{
    if (is_array($data) OR is_object($data))
    {
        foreach ($data as $key => $value)
            $data[$key] = sanitize_input($value);
    }
    elseif (is_string($data))
    {
        $data = xss($data);
        (bool) get_magic_quotes_gpc() AND $data = stripslashes($data);
        strpos($data, "\r") !== FALSE AND $data = str_replace(array("\r\n", "\r"), "\n", $data);
    }
    return $data;
}

function error_handler($errno, $errstr, $errfile, $errline)
{
    // TODO: Log errors?
    exit('<b>Error</b>: ' . $errstr . PHP_EOL);
}

function exception_handler($exception)
{
    // TODO: Log errors?
    exit('<b>Error</b>: ' . $exception->getMessage() . PHP_EOL);
}

function shutdown_handler()
{
    //$storage = Storage::instance();
    //$storage->memory_usage = number_format((memory_get_peak_usage() - START_MEMORY) / 1024, 2) . ' KB';
    //$storage->execution_time = number_format(microtime(TRUE) - START_TIME, 5) . ' seconds';
}

function current_id()
{
    $storage = Storage::instance();
    $storage->is_from_list = 0;
    $default = c('section.default');
    if (empty($storage->segments))
        return $default;
    if(!isset($storage->segments[count($storage->segments) - 1])) redirect(href(1));
    $last_segment = $storage->segments[count($storage->segments) - 1];
    if (is_numeric($last_segment)) {
        $storage->is_from_list = 1;
        $segs = array(); 
        for($i=0; $i<count($storage->segments) - 2; $i++) $segs[] = $storage->segments[$i];
        $curseg = implode('/',$segs);
        $sql = "SELECT category,id FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND slug = '{$curseg}' LIMIT 1;";
        $item = db_fetch($sql);
        if($item["category"]==16) {
            $sql = "SELECT id FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND slug = '{$curseg}' LIMIT 1;";
            $section = db_fetch($sql);
            $_GET["product"] = $last_segment;
            return empty($section) ? $default : $section['id'];
        } else {
            return $last_segment;
        }
    }
    $sql = "SELECT id FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND slug = '{$storage->slug}' LIMIT 1;";
    $section = db_fetch($sql);
    return empty($section) ? $default : $section['id'];
}

function generate_params($optionals=NULL) {
	$params = array();
	if($optionals==NULL)
		$optionals = array('menu', 'id', 'idx', 'gameid');
	foreach ($optionals as $name)
	{
		if (($option = get($name)) === FALSE)
			continue;
		$params[$name] = $option;
	}
	return $params;
}

function ahref($action = NULL, $subaction = NULL, $parameters = array(), $language = NULL)
{
    $url = c('site.url');
    $base_file = c('site.base');
    empty($base_file) OR $url .= $base_file . '/';
    $url .= empty($language) ? (count(c('languages.all')) == 1 ? NULL : l() . '/') : $language . '/';
    $url .= c('admin.slug');
    $query_string = array();
    empty($action) OR $query_string['action'] = $action;
    empty($subaction) OR $query_string['subaction'] = $subaction;
    empty($parameters) OR $query_string += $parameters;
    $url_parameters = http_build_query($query_string);
    empty($url_parameters) OR $url .= '?' . $url_parameters;

    return $url;
}

function href($section = NULL, $parameters = array(), $language = NULL, $product=NULL)
{
    $url = c('site.url');
    if (empty($section) AND empty($parameters) AND empty($language))
        return $url;
    $base_file = c('site.base');
    empty($base_file) OR $url .= $base_file . '/';
    $url .= empty($language) ? (count(c('languages.all')) == 1 ? NULL : l() . '/') : $language . '/';
    if (empty($section))
        return $url;
    empty($language) AND $language = l();
    $sql = "SELECT redirectlink, menuid, slug FROM " . c("table.pages") . " WHERE language = '{$language}' AND id = {$section} LIMIT 1;";
    $section_info = db_fetch($sql);
    $sql = "SELECT title FROM " . c("table.menus") . " WHERE language = '{$language}' AND id = '".$section_info["menuid"]."' LIMIT 1;";
    $connector = db_fetch($sql);
    $sql = "SELECT slug FROM " . c("table.pages") . " WHERE language = '{$language}' AND attached = '".$connector["title"]."' LIMIT 1;";
    $menutitle = db_fetch($sql);
    if (empty($section_info))
        return $url;
    if (!empty($section_info['redirectlink']))
        return strtr($section_info['redirectlink'], array(':lang' => $language));

    if(!empty($product)) {
        $sql = "SELECT * FROM " . c("table.catalogs") . " WHERE language = '{$language}' AND id = {$product} LIMIT 1;";
        $prod = db_fetch($sql);
        $product_slug = sef(utf82lat($prod["title"]));
        return $url . $section_info['slug'] . '/' . $product_slug . '/' . $product;
    }

    $section_parameters = c('section.parameters');
    $section_parameters = array_key_exists($section, $section_parameters) ? $section_parameters[$section] + $parameters : $parameters;
    $query_string = empty($section_parameters) ? NULL : '?' . http_build_query($section_parameters);
    if (is_from_list($section_info['menuid']))
        return $url . $menutitle['slug'] . '/' . $section_info['slug'] . '/' . $section . $query_string;
    return $url . $section_info['slug'] . $query_string;
}

function is_from_list($menu_id)
{
    $list_types = c('section.types.lists');
    $lists = array();
    foreach ($list_types as $list)
        $lists[] = '\'' . $list . '\'';
    $sql = 'SELECT id FROM ' . c("table.menus") . ' WHERE type IN (' . implode(', ', $lists) . ');';
    $menus = db_fetch_all($sql);
    if (empty($menus))
        return FALSE;
    $menu_ids = array();
    foreach ($menus as $menu)
        $menu_ids[] = $menu['id'];
    empty($menu_id) AND $menu_id = Storage::instance()->section['menuid'];
    return in_array($menu_id, $menu_ids);
}

function get_idx($id)
{
    return db_retrieve('idx', c("table.pages"), 'id', $id, "AND `language` = '" . l() . "' LIMIT 1");
}

function get_id($idx)
{
    return db_retrieve('id', c("table.pages"), 'idx', $idx);
}

function is_home()
{
    $section = Storage::instance()->get('section');
    return (c('section.default') == $section['id']);
}

function title()
{
    $title = NULL;
	$maintitle = NULL;
    $storage = Storage::instance();
	$settings_sql = "SELECT `key`, `value` FROM ".c('table.settings')." WHERE `language` = '{$storage->language}' AND `deleted` = 0 AND `key` = 'sitetitle';";
	$settings_item = db_fetch($settings_sql);
	$maintitle = $settings_item["value"];
    if (!is_home())
        $title = ' - ' . $storage->section['title'];
    return $maintitle . $title;
}

function in()
{
    return (isset($_SESSION['user']) AND !empty($_SESSION['user']));
}

function xss($data)
{
    return $data;


    if (is_array($data) OR is_object($data))
    {
        foreach ($data as $key => $value)
            $data[$key] = xss($value);
        return $data;
    }
    if (trim($data) === '')
    {
        return $data;
    }
    $data = str_replace(array('&', '&lt;', '&gt;'), array('&amp;', '&lt;', '&gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
    do
    {
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    }
    while ($old_data !== $data);
    return $data;
}

function child_of($section, $parent_idx = NULL)
{
    if (FALSE === ($section_idx = get_idx($section)))
        return FALSE;
    if (!$parent_idx)
    {
        $parent_idx = Storage::instance()->section['idx'];
        if ($section_idx == $parent_idx)
            return TRUE;
    }
    $sql = "SELECT menuid, masterid, attached FROM " . c("table.pages") . " WHERE idx = {$parent_idx} LIMIT 1;";
    $result = db_fetch($sql);
    if (empty($result))
        return FALSE;
    $attached = db_retrieve('name', c("table.menus"), 'id', $result['menuid'], 'LIMIT 1');
    if ($result['attached'] == $attached)
        return TRUE;
    if ($section_idx == $result['masterid'])
        return TRUE;
    return empty($result['masterid']) ? FALSE : child_of($section, $result['masterid']);
}

function new_slug($slug, $parent = NULL, $edit = FALSE)
{
    $idx = empty($edit) ? $parent : db_retrieve('masterid', c("table.pages"), 'idx', $parent, 'LIMIT 1');
    $text = ltrim((empty($parent) ? NULL : db_retrieve('slug', c("table.pages"), 'idx', $idx, 'LIMIT 1')) . '/' . sef($slug), '/');
	$slug = utf82lat($text);
	return $slug;
}

function category_to_type($category_id)
{
    switch ($category_id)
    {
        default:
            return 'Text';
        case 2:
            return 'Home Page';
        case 3:
            return 'About Page';
        case 4:
            return 'Search Page';
        case 5:
            return 'Sitemap Page';
        case 6:
            return 'Feedback Page';
        case 7:
            return 'Wizard Page';
        case 8:
            return 'News Page';
        case 9:
            return 'Articles Page';
        case 10:
            return 'Events Page';
        case 11:
            return 'List Page';
        case 12:
            return 'Photo Page';
        case 13:
            return 'Video Page';
        case 14:
            return 'Audio Page';
        case 15:
            return 'Poll Page';
        case 16:
            return 'Catalog Page';
    }
}

function html_decode($value, $sec = ""){
	switch($sec){
		case "pdf":
		$ret = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
		$ret = str_replace("&nbsp;"," ",$ret);
		return $ret;
		break;
		default:
		return html_entity_decode($value, ENT_COMPAT, 'UTF-8');
		break;
	}
}

function check_image($file) {
	$ext = strtolower(substr(strrchr($gal['path'], '.'), 1));
	if(in_array($ext, array('jpg','jpeg','png','gif'))) { 
		return true;
	} else {
		return false;
	}
}

function get_extension($file) {
	$ext = strtolower(substr(strrchr($gal['path'], '.'), 1));
	return $ext;
}

function counter() {
	$counter = 0;
	if(!isset($_SESSION)) session_start();
	if(isset($_SESSION["counter"])) {
		$counter = $_SESSION["counter"];
	} else {
		$counter = intval(file_get_contents('counter.txt')) + 1;
		$_SESSION["counter"] = $counter;
		file_put_contents('counter.txt', $counter);
	}
	return $counter;
}