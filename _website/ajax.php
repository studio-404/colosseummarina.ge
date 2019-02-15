<?php defined('DIR') OR exit; ?>
<?php
	$url="";
	$urlparts=array();
	foreach($_GET as $k=>$v) {
        if($k!='product')
		  $urlparts[]=$k."=".$v;
	}
	if(count($urlparts)>0)
		$url='?'.implode("&",$urlparts);
    $product=NULL;
    if(isset($_GET["product"])) 
        $product=$_GET["product"];
?>
<!DOCTYPE html>
<head>
    <base href="<?php echo href(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="google-site-verification" content="" />
    <meta name="keywords" content="<?php echo s('keywords'); ?>" />
    <meta name="description" content="<?php echo s('description'); ?>" />
    <meta name="robots" content="Index, Follow" /> 
    <meta name="author" content="" />
<?php
	$pagetitle = $storage->section['title'];
	if(isset($_GET["product"])) {
		$prod = db_fetch("select * from catalogs where language='".l()."' and id=".db_escape($_GET["product"]));
		$pagetitle = $prod["title"];
	}
?>
	<title><?php echo s('sitetitle').' - '. $pagetitle; ?></title>
	<link type="text/css" media="all" rel="stylesheet" href="_website/css/general.css" />
	<link type="text/css" media="all" rel="stylesheet" href="_website/css/<?php echo l();?>.css" />
	<link type="text/css" media="screen" rel="stylesheet" href="<?php echo JAVASCRIPT;?>/prettyphoto/css/prettyPhoto.css" charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="<?php echo JAVASCRIPT;?>/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/custom.css" />
	<script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/prettyphoto/js/jquery.prettyPhoto.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
	<?php echo html_decode($storage->content); ?>
</body>
</html>