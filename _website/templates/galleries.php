<?php defined('DIR') OR exit; ?>

    <div id="content" class="fix">
        <div class="page gallery fix">
<?php 
$menu = db_fetch("SELECT id, type FROM menus WHERE type = 'imagegallery'");
$color = db_fetch("SELECT id, color2 FROM pages WHERE id = '".$menu["id"]."'");
?>
            <div class="page-title fix" style="background:#<?php echo ($color["color2"]!='') ? $color["color2"] : '73a4df';?>;">
                <h2><?php echo $title; ?></h2>
                <div id="location">
                    <ul>
<?php echo location(); ?>
                    </ul>
                </div>
                <!-- #location .right -->
            </div>
            <!-- .page-title fix -->
            <div id="block" class="fix">
<?php 
	$i=0;
	foreach($children as $item) { 
		$link = (($item['redirectlink'] == '') || ($item['redirectlink'] == 'NULL')) ? href($item['id']) : $item['redirectlink'];
		$i++;
?>
                <div class="img left first">
    <?php if($item["imagen"]!='') { ?>
                    <a href="<?php echo $link; ?>"><img src="<?php echo ($item['imagen']!='') ? 'crop.php?img=' . $item['imagen'] . '&width=278&height=278' : WEBSITE.'/img/default_img.png';?>" width="278" height="278" alt="<?php echo $title;?>" title="" /></a>
	<?php } ?>
                    <div class="title">
                        <h3><a href="<?php echo $link; ?>"><?php echo $item['title']; ?></a></h3>
                    </div>
                    <!-- .title -->
                </div>
                <!-- .img left -->
<?php } ?>
            </div>
            <!-- #block .fix -->
        </div>
        <!-- .page gallery fix -->
    </div>
    <!-- #content .fix -->
