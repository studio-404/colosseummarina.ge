<div id="wrapper">
<?php if($storage->section["id"]==1) { ?>
    <div id="header-part">
<?php } else { ?>
    <div id="header-part" style="background:url('<?php echo ($storage->section["imagec"]!='') ? $storage->section["imagec"] : 'http://stat.ge/gttu/files/cover/cover4.jpg'; ?>') bottom center no-repeat">
<?php } ?>
        <div id="header">
            <div id="head-top" class="fix">
                <div id="logo" class="left">
                    <h1>
                        <a href="<?php echo href(1);?>"><img src="<?php echo WEBSITE;?>/images/logo.png" width="63" height="60" alt="" /></a>
                        <span><?php echo s('site_title');?></span>
                    </h1>
                </div>
                <!-- #logo .left -->
                <div id="head-nav" class="right">
                    <div id="lang" class="right">
                        <ul>
                            <li><a href="<?php echo href($storage->section['id'], array(), 'ge', $product).$url;?>" class="<?php if(l()=='ge'){echo "active";}?>">ქარ</a></li>
                            <li><a href="<?php echo href($storage->section['id'], array(), 'en', $product).$url;?>" class="<?php if(l()=='en'){echo "active";}?>">Eng</a></li>
                        </ul>
                    </div>
                    <!-- #lang .right -->
                    <div id="head-menu" class="right">
                        <ul>
<?php if($storage->section["id"]!=1) { ?>
                            <li><a href="<?php echo href(1);?>"><?php echo l("home");?></a></li>
 <?php } ?>
                           <li><a href="<?php echo href(740);?>"><?php echo l("site.map");?></a></li>
                            <li><a href="<?php echo href(3);?>"><?php echo l("contact");?></a></li>
                        </ul>
                    </div>
                    <!-- #head-menu .right -->
                </div>
                <!-- #head-nav .fix -->
                <div id="search" class="right">
                    <form id="searchform" name="searchform" method="get" action="<?php echo href(4);?>">
                        <fieldset>
                            <legend>search</legend>
                            <input type="text" value="" name="q" id="q" class="input" />
                            <input type="submit" class="search-btn" />
                        </fieldset>
                    </form>
                </div>
                <!-- #search -->
            </div>
            <!-- #head-top .fix -->
            <div id="head-btm">
                <div id="menu" class="fix" style="background:#<?php echo ($storage->section["color1"]!='') ? $storage->section["color1"] : 'ffd200'; ?>;">
                    <ul>
<?php
if($storage->section["id"]==8 || ($storage->section["id"] > 93 && $storage->section["id"] < 660)){
?>
                        <?php echo main_menu2(8); ?>
<?php } else { ?>
                        <?php echo main_menu(); ?>
<?php
}
?>
                    </ul>
                </div>
                <!-- #menu .fix -->
            </div>
            <!-- #head-btm -->
<?php if($storage->section["id"]==1) { ?>
            <script type="text/javascript" src="_javascript/jssor/jssor.core.js"></script>
            <script type="text/javascript" src="_javascript/jssor/jssor.utils.js"></script>
            <script type="text/javascript" src="_javascript/jssor/jssor.slider.js"></script>
            <script type="text/javascript" src="_javascript/jssor/jssor.ctrl1.js"></script>
    <?php        
        $sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 50 AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position;";
        $images = db_fetch_all($sql);   
    ?>   
            <div id="slider" style="width:1920px;height:680px;cursor:move;">
                <div u="slides" class="slides" style="width:1920px;height:680px;left:0;overflow:hidden;">
                <?php foreach($images as $image): ?>
                <?php $link = $image["itemlink"]; ?>
                    <div class="sld-img" style="background-image:url('<?php echo $image['file'];?>');background-position:top center;height:680px;">
                        <div u="caption" t="A" class="caption" style="width:380px;height:440px;position:absolute;top:240px;left:1170px;background-color:#bf0428;background:rgba(191,4,40,0.6);">
                            <div class="sld-info">
                                <div class="title">
                                    <h2><?php echo $image['title']; ?></h2>
                                </div>
                                <div class="text"><?php echo strip_tags($image['description']); ?></div>
                                <div class="more">
                                    <a href="<?php echo ($image["itemlink"]!='') ? $image["itemlink"]:"javascript:;"; ?>">გაიგე მეტი</a>
                                </div>
                            </div>
                        </div>
                        <!-- .caption -->
                    </div>
                    <!-- .sld-img -->
                <?php endforeach; ?>
                </div>
                <!-- .slides -->
                <span u="arrowleft" class="arrow-left arrow " style="width:47px;height:59px;position:absolute;left:0;"></span>
                <span u="arrowright" class="arrow-right arrow " style="width:47px;height:59px;position:absolute;right:0;"></span>
            </div>
            <!-- #slider -->
<?php } ?>

<?php if($storage->section["id"]!=1) { ?>
<?php if($storage->section["title2"]!='' or $storage->section["description"]!='') { ?>
            <div class="caption" style="width:380px;height:440px;position:absolute;top:240px;right:0;background-color:#<?php echo ($storage->section["color6"]!='' ? $storage->section["color6"] : 'bf0428');?>;background:rgba(<?php echo ($storage->section["color7"]!='' ? $storage->section["color7"] : '191,4,40,0.6');?>);">
                <div class="sld-info">
                    <div class="title">
                        <h2><?php echo $storage->section["title2"];?></h2>
                    </div>
                    <div class="text"><?php echo $storage->section["description"];?></div>
                    <!--<div class="more">
                        <a href="#">Read more</a>
                    </div>-->
                </div>
            </div>
            <!-- .caption -->
<?php } ?>
<?php } ?>
        </div>
        <!-- #header -->
        <div id="social">
            <ul>
                <li>
                    <a href="javascript:;"><img src="_website/images/icon-mygttu.png" width="65" height="65" alt=""></a>
                    <div class="sub-soc">
                        <ul>
                            <li><a href="http://moodle.gttu.edu.ge/" target="_blank">Moodle</a></li>
                            <li><a href="http://openbiblio.gttu.edu.ge/home/index.php" target="_blank">Open Biblio</a></li>
                            <li><a href="http://webmail.gttu.edu.ge/" target="_blank">Web Mail</a></li>
                            <li><a href="http://www.gttu.edu.ge/gttusoft/" target="_blank">My GTT</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="javascript:;"><img src="_website/images/icon-links.png" width="65" height="65" alt=""></a>
                    <div class="sub-soc">
                        <ul>
                            <li><a href="#">title of link comes here</a></li>
                            <li><a href="#">title of link comes here</a></li>
                            <li><a href="#">title of link comes here</a></li>
                            <li><a href="#">title of link comes here</a></li>
                            <li><a href="#">title of link comes here</a></li>
                        </ul>
                    </div>
                </li>
                <li><a target="_blank" title="Share this page" href="http://www.sharethis.com/share?url=<?php echo href($storage->section['id']);?>&title=<?php echo $storage->section['title'];?>&summary=<?php //echo $storage->section['content'];?>&img=<?php echo $storage->section['imagen'];?>&pageInfo=%7B%22hostname%22%3A%22stat.ge/gttu.ge%22%2C%22publisher%22%3A%22<?php //echo $prod_id;?>%22%7D"><img src="_website/images/icon-contact.png" width="65" height="65" alt="Share this"></a></li>
                <li><a href="#"><img src="_website/images/icon-gp.png" width="65" height="65" alt=""></a></li>
                <li><a href="<?php echo s("twlink");?>" target="_blank"><img src="_website/images/icon-tw.png" width="65" height="65" alt=""></a></li>
                <li><a href="<?php echo s("ytlink");?>" target="_blank"><img src="_website/images/icon-yt.png" width="65" height="65" alt=""></a></li>
                <li><a href="<?php echo s("fblink");?>" target="_blank"><img src="_website/images/icon-fb.png" width="65" height="65" alt=""></a></li>
            </ul>
        </div>
        <!-- #social -->
    </div>
    <!-- #header-part -->
    <?php echo html_decode($storage->content); ?>
</div>
<!-- #wrapper -->
<div id="footer">
    <div id="foot-top" class="fix">
        <div class="foot-list left">
<?php echo footer_menu(5);?>
        </div>
        <!-- .foot-list left -->
        <div class="foot-list left">
<?php echo footer_menu(6);?>
        </div>
        <!-- .foot-list left -->
        <div class="foot-list left">
<?php echo footer_menu(7);?>
        </div>
        <!-- .foot-list left -->
        <div class="foot-list left">
<?php echo footer_menu(8);?>
        </div>
        <!-- .foot-list left -->
        <div id="last-update">
            <?php echo l('guest');?>: <br/><span><?php echo counter(); ?></span>
        </div>
        <!-- #last-update -->
    </div>
    <!-- #foot-top .fix -->
    <div id="foot-btm" class="fix">
        <div id="copy" class="left"><?php echo s('copy');?></div>
        <!-- #copy .left -->
        <div id="created" class="right">Created By <a href="http://digitaldesign.ge/">Digital</a></div>
        <!-- #created .right -->
<?php
$maxid = db_fetch("SELECT MAX(`id`) AS `num` FROM log;");
$visit = db_fetch("SELECT id, visitdate FROM log WHERE id='".$maxid["num"]."'");
?>
        <div id="visitor">
            <?php echo l('site.update');?>: <?php echo convert_date($visit["visitdate"]);?>
        </div>
        <!-- #visitor -->
    </div>
    <!-- #foot-btm .fix -->
</div>
<!-- #footer -->

<script type="text/javascript">
$(document).ready(	
	function() {
		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
	}
);

</script>

<script type="text/javascript">
if ($(window).width() < 1180) {
   $('#header').css({overflow:'hidden'});
}
if ($(window).width() < 1600) {
   $('.arrow-left').css({left:'260px'});
   $('.arrow-right').css({right:'260px'});
}
(function() {
var fixedElement = $('#social').offset(),
    scrolled = $(window).scroll(function() {
        var winScrolled = $(this).scrollTop();
        if(winScrolled > fixedElement.top - 40) {
            $('#social').css({position:'fixed',top:'40px'})
        }
        else {
            $('#social').css({position:'absolute',top:'720px'})
        }
    });
})()
</script>
