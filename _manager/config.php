<?php

defined('DIR') OR exit;

$c['cmsversion'] = '5.23';
// SITE CONFIGURATION
$c['site.url'] = 'http://colosseummarina.ge/';
$c['site.base'] = '';
$c["sitefolder"] = '_website/';

$c['admin.slug'] = 'cadmin';
$c['admin.hash'] = 'be4b4e05440083cf31900542d4cf7e2412e57764';

$c['folders.upload'] = DIR . 'files/';
$c['folders.backup'] = 'backup/';
$c['folders.plugins'] = '_plugins/';
$c['folders.players'] = '_players/';

$c['database.hostname'] = 'localhost';
$c['database.charset'] = 'UTF8';
$c['database.username'] = 'colosseu_shindi';
$c['database.password'] = 'MvRWpF9riD';
$c['database.name'] = 'colosseu_shindi';

$c['languages.all'] = array('ge','en','ru');
$c['languages.default'] = $c['languages.all'][0];
$c['languages.admin'] = 'en';
// SITE CONFIGURATION
$c['date.timezone'] = 'Asia/Tbilisi';
$c['date.format'] = 'Y-m-d H:i:s';

$c['output.charset'] = 'UTF-8';
$c['output.buffering'] = 'ob_gzhandler';

$c['section.types'] = array(
    999 => 'error', 0 => 'text', 	1 => 'text', 		2 => 'home',
    3 => 'about', 	4 => 'search', 	5 => 'sitemap', 	6 => 'feedback',
    7 => 'wizard', 	8 => 'news', 	9 => 'articles', 	10 => 'events',
    11 => 'lists', 	12 => 'photo', 	13 => 'video', 		14 => 'audio', 
	15 => 'poll', 	16 => 'catalog',17 => 'faq'
);

$c['section.types.lists'] = array(
    'news',
    'articles',
    'article',
    'events',
    'event',
    'lists',
    'list'
);
$c['section.types.admin_lists'] = $c['section.types.lists'] + array('sitemap');

$c['valid.methods'] = array(
	1=>'files', 		2=>'poll', 				3=>'polls', 		4=>'catalog', 		5=>'catalogs', 
	6=>'pages', 		7=>'sitemap',			8=>'news',			9=>'videogallery',	10=>'imagegallery',
	11=>'audiogallery',	12=>'bannergroups',		13=>'banners',		14=>'gallerylist',	15=>'settings',
	16=>'langdata',		17=>'users',			18=>'siteusers',	19=>'userrights',	20=>'filemanager',
	21=>'backup',		22=>'textconverter',	22=>'log'
);

$c['section.home'] = 1;

$c['section.default'] = $c['section.home'];
$c['section.undeletable'] = array(
    $c['section.default']
);

$c['pager.per_page'] = 10;
$c['users.per_page'] = 10;
//-------------- PAGER PARAMETERS FOR WEBSITE
$c['news.per_page'] = 10;
$c['news.page_count'] = 10;


$c['list.per_page'] = 10;
$c['list.page_count'] = 10;

$c['catalog.per_page'] = 20;
$c['catalog.page_count'] = 15;
//-------------- PAGER PARAMETERS FOR WEBSITE
$c['thumbnail.exts'] = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'mp3');

return $c;
