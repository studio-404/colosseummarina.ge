<?php defined('DIR') OR exit; ?>

    <div id="content" class="fix">
        <div class="page gallery fix">
            <div class="page-title fix" style="background:#<?php echo ($color2!='') ? $color2 : '73a4df';?>;">
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
$idx = 0;
$num = count($photos);
$idx = 0;
foreach ($photos AS $item):
	if($idx == 0) $idx = 1; else $idx = 0;
    $link = $item['file'];
?>
                <div class="img left">
                    <a href="<?php echo $link; ?>" rel="prettyPhoto[3]"><img src="<?php echo 'crop.php?img=' . $item['file'] . '&width=278&height=278';?>" width="278" height="278" alt=""></a>
                </div>
                <!-- .img left -->
<?php
endforeach;
?>
            </div>
            <!-- #block .fix -->
        </div>
        <!-- .page gallery fix -->
    </div>
    <!-- #content .fix -->
