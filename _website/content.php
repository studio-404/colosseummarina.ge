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

	$photo = "";
	$desc = "";
	$producttitle = "";
	$prod = 0;
	if(isset($_GET["product"])) {
		$prod = $_GET["product"];
		$cat = db_fetch("select * from catalogs where id = '".$_GET["product"]."' and language = '".l()."'");
		$photo = $cat["photo1"];
		$producttitle = $cat["title"];
		$desc = $cat["description"];
		if($desc=="") $desc = $producttitle;
	}
	if($photo=="") $photo = href().WEBSITE."/images/logo.png";
	$pageid = href($storage->section['id']).(($prod>0) ? "?product=".$_GET["product"]:"");

?>
<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<head>
    <base href="<?php echo href(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
?>
    <meta name="keywords" content="<?php echo s('keywords') .', ' . $storage->section["meta_keys"]; ?>" />
    <meta name="description" content="<?php echo s('description') . ', ' . $storage->section["meta_desc"]; ?>" />
    <meta name="robots" content="Index, Follow" />
<?php
	$pagetitle = $storage->section['title'];
	if(isset($_GET["product"])) {
		$prod = db_fetch("select * from catalogs where language='".l()."' and id=".db_escape($_GET["product"]));
		$pagetitle = $prod["title"];
	}
?>
	<title><?php echo s('sitetitle').' - '.$storage->section['title']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo WEBSITE;?>/assets/img/favicon.ico">

    <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/custom.css">
    <link href="<?php echo WEBSITE;?>/assets/css/<?php echo l();?>.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="image_src" type="image/gif" href="<?php echo WEBSITE;?>/assets/img/Colosseum_Marina_Logo.png" />
	<link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/prettyphoto/css/prettyPhoto.css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />

    <meta property="og:image" content="<?php echo ($storage->section["imagen"]!="") ? $storage->section["imagen"] : $photo;?>" />
    <meta property="og:title" content="<?php echo $producttitle;?>" />
    <meta property="og:description" content="<?php echo mb_substr(strip_tags($storage->section['content']),0,800,'UTF-8'); ?>"/>
    <meta property="og:url" content="<?php echo href($storage->section['id']).(($prod>0) ? "?product=".$_GET["product"]:"");?>" />
    <meta property="og:site_name" content="<?php echo s('sitetitle').' - '.$pagetitle; ?>" />
    <meta property="og:type" content="website" />

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic%7cPlayfair+Display:400,700%7cGreat+Vibes'
		  rel='stylesheet' type='text/css'><!-- Attach Google fonts -->
	<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE;?>/assets/css/styles.css">
	<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE;?>/assets/css/gstyle.css">
	<style type="text/css">
	body,td,th {
	font-size: 12px;
}
    </style>
	<!-- Attach the main stylesheet file -->

</head>
<?php if($storage->section["id"]==1) {  ?>
<body class="home-page-1">
<?php }else if($storage->section["id"]==4 OR $storage->section["id"]==5 OR $storage->section["id"]==6 OR $storage->section["id"]==7 OR $storage->section["id"]==23 OR $storage->section["id"]==24 OR $storage->section["id"]==25 OR $storage->section["id"]==26 OR $storage->section["id"]==11 OR $storage->section["id"]==9 OR
$storage->section["id"]==27 OR $storage->section["id"]==28 OR $storage->section["id"]==29 OR $storage->section["id"]==30 OR $storage->section["id"]==31 OR $storage->section["id"]==32 OR $storage->section["id"]==33 OR $storage->section["id"]==34 OR $storage->section["id"]==35 OR $storage->section["id"]==36)
{ ?>
<body class="room-detials">
<?php } else {?>
<body>
<?php }?>
	<div class="main-wrapper">
		<!-- Header Section -->
		<header id="main-header">
			<div class="inner-container container">
		
	        <!--Breadcrumb Section-->
			<div style="border-radius: 0; list-style: outside none none;  float:right;  padding: 5px; clear:both; margin-bottom: -25px;    position: relative;    z-index: 2147483647;">
					<ul class="list-inline">

                        	<li><a href="<?php echo href('20');?>"><?php echo l('site.map');?></a></li>
                            •
                        	<li><a href="<?php echo href('14');?>"><?php echo l('contact.us');?></a></li>
							<li><a href="https://www.facebook.com/ColosseumMarinaHotel/" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://www.instagram.com/colosseummarinahotel/" target="_blank"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
			<!--End of Breadcrumb Section-->
		
        		<div class="l-sec col-xs-8 col-sm-6 col-md-3">
					<a href="<?php echo href('1');?>" id="t-logo">
                    	<img src="<?php echo WEBSITE;?>/assets/img/Colosseum_Marina_Logo.png" alt="<?php echo s('sitetitle'); ?>" title="<?php echo s('sitetitle'); ?>"/>
					</a>
				</div>
				<div class="r-sec col-xs-4 col-sm-6 col-md-9">
					<nav id="main-menu">
						<ul class="list-inline">
                        	<li><a href="<?php echo href('1');?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                        	<li><a href="<?php echo href('2');?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                        	<?php echo main_menu();?>
							<li><a href="javascript:;"><i class="fa fa-globe" aria-hidden="true"></i></a>
								<ul>
									<li><a href="<?php echo href($storage->section['id'], array(), 'ge', $product);?>">GE</a></li>
									<li><a href="<?php echo href($storage->section['id'], array(), 'en', $product);?>">EN</a></li>
									<li><a href="<?php echo href($storage->section['id'], array(), 'ru', $product);?>">RU</a></li>
								</ul>
							</li>
						</ul>
					</nav>
					<div id="main-menu-handle" class="ravis-btn btn-type-2"><i class="fa fa-bars"></i><i class="fa fa-close"></i></div><!-- Mobile Menu handle -->
					<a href="<?php echo s('book.now.url');?>" id="header-book-bow" target="_blank" class="ravis-btn btn-type-2"><span><?php echo l('book.now');?></span> <i class="fa fa-calendar"></i></a>
					<!--<a href="javascript:;" id="header-book-bow" class="ravis-btn btn-type-2"><span>Book Now</span> <i class="fa fa-calendar"></i></a>-->
				</div>
			</div>
			<div id="mobile-menu-container"></div>
		</header>
		<!-- End of Header Section -->

		<?php echo html_decode($storage->content); ?>

		<!--Footer Section-->
		<footer id="main-footer">
			<div class="inner-container container">
				<div class="t-sec clearfix">
					<div class="widget-box col-sm-6 col-md-6">
                    <?php echo about_home_footer();?>
					</div>
					<div class="widget-box col-sm-6 col-md-3">
						<h4 class="title"><?php echo l('events');?></h4>
						<div class="widget-content latest-posts">
							<ul>
                            	<?php echo news_home();?>
							</ul>
						</div>
					</div>
					<div class="widget-box col-sm-6 col-md-3">
						<h4 class="title"><?php echo l('contact.us');?></h4>
						<div class="widget-content contact">
							<ul class="contact-info">
								<li>
									<i class="fa fa-home"></i>
									<?php echo s('address');?>
								</li>
								<li>
									<i class="fa fa-phone"></i>
                                    <?php echo s('tel1');?>
                                </li>
                                <li>    
									<i class="fa fa-phone"></i>
                                    <?php echo s('tel2');?>
                                </li>
                                <li>    
									<i class="fa fa-phone"></i>
                                    <?php echo s('tel3');?>
                                </li>                                
								<li>
									<i class="fa fa-envelope"></i>
									<?php echo s('feedback');?>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="b-sec clearfix">
				  <div class="copy-right"> Developed by <a href="http://shindi.ge" target="_blank">ShinDi</a> © 2017. All Rights Reserved. </div>
				  <ul class="social-icons list-inline">
						<li><a href="https://www.facebook.com/ColosseumMarinaHotel/" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://www.instagram.com/colosseummarinahotel/" target="_blank"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
			</div>
		</footer>
		<!--End of Footer Section-->

	</div>	

	<!-- JS Include Section -->
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/helper.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/isotope.pkgd.min.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="<?php echo WEBSITE;?>/assets/js/template.js"></script>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_v_wtA7aaRvAWFljuqdcHmjvninSm3_E"></script>

    
	<script type="text/javascript">
		jQuery(document).ready(function () {

			var main_image_slider = jQuery("#main-image-slider");
			var thumbnail_slider  = jQuery("#thumbnail-slider");

			main_image_slider.owlCarousel({
				singleItem:            true,
				slideSpeed:            1000,
				navigation:            true,
				pagination:            false,
				autoPlay:              true,
				afterAction:           syncPosition,
				navigationText: ['<span>Prev</span>', '<span>Next</span>'],
				responsiveRefreshRate: 200,
				afterInit:             function (el) {
					el.find(".owl-item").eq(0).addClass("active");
				}
			});

			thumbnail_slider.owlCarousel({
				items:                 5,
				itemsDesktop:          [1199, 6],
				itemsDesktopSmall:     [979, 4],
				itemsTablet:           [768, 3],
				itemsMobile:           [479, 2],
				pagination:            false,
				responsiveRefreshRate: 100,
				afterInit:             function (el) {
					el.find(".owl-item").eq(0).addClass("synced");
				}
			});

			function syncPosition(el) {
				var current = this.currentItem;
				thumbnail_slider.find(".owl-item").removeClass("synced").eq(current).addClass("synced");
				main_image_slider.find(".owl-item").removeClass("active").eq(current).addClass("active");
				if (thumbnail_slider.data("owlCarousel") !== undefined) {
					center(current)
				}
			}

			thumbnail_slider.on("click", ".owl-item", function (e) {
				e.preventDefault();
				var number = jQuery(this).data("owlItem");
				main_image_slider.trigger("owl.goTo", number);
			});

			function center(number) {
				var thumbnail_slidervisible = thumbnail_slider.data("owlCarousel").owl.visibleItems;
				var num                     = number;
				var found                   = false;
				for (var i in thumbnail_slidervisible) {
					if (num === thumbnail_slidervisible[i]) {
						var found = true;
					}
				}

				if (found === false) {
					if (num > thumbnail_slidervisible[thumbnail_slidervisible.length - 1]) {
						thumbnail_slider.trigger("owl.goTo", num - thumbnail_slidervisible.length + 2)
					} else {
						if (num - 1 === -1) {
							num = 0;
						}
						thumbnail_slider.trigger("owl.goTo", num);
					}
				} else if (num === thumbnail_slidervisible[thumbnail_slidervisible.length - 1]) {
					thumbnail_slider.trigger("owl.goTo", thumbnail_slidervisible[1])
				} else if (num === thumbnail_slidervisible[0]) {
					thumbnail_slider.trigger("owl.goTo", num - 1)
				}

			}

		});
	</script>
    
</body>
</html>
