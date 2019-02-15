<?php defined('DIR') OR exit;
$idx = 0;
$num = count($videos);
?>
<div id="location-part">
    <div id="location">
        <div id="loc">
            <div id="page-title">
                <h2><?php echo $title;?></h2>
            </div>
            <!-- page-title -->
            <ul>
                <?php echo location();?>
            </ul>
        </div>
    </div>
    <!-- location -->
</div>
<!-- location-part -->
<div id="content" class="fix">
    <div id="aside" class="right">
        <div id="cat">
            <?php echo right_menu($idx); ?>
        </div>
        <!-- cat -->
        <div id="phone">
            <div class="hotline"><?php echo l('hotline') ?></div> 
            <div class="num"><sub>(032)</sub> <?php echo l('number'); ?></div>
        </div>
        <!-- hotline -->
        <div id="banners">
            <?php echo right_banners(); ?>
        </div>
        <!-- banners -->
    </div>
    <!-- aside -->
    <div id="page" class="fix">
        <div id="galleries" class="fix">
            <div class="video left">
                <div class="img">
                    <?php
                    foreach ($videos AS $item):
                        $link = href($item['id']);
                        $v = str_replace('http://www.youtube.com/watch?','',str_replace('http://youtu.be/','',$item['file']));
                    ?>
                    <object width="340" height="250">
                        <param name="movie" value="http://www.youtube.com/v/<?php echo $v;?>?version=3&amp;hl=en_US"></param>
                        <param name="allowFullScreen" value="true"></param>
                        <param name="allowscriptaccess" value="always"></param>
                        <param name="wmode" value="transparent"></param>
                        <embed src="http://www.youtube.com/v/<?php echo $v;?>?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="340" height="250" wmode="transparent" allowscriptaccess="always" allowfullscreen="true"></embed>
                    </object>        
                </div>
                <!-- img -->
                <div class="ttl">
                    <h3><a href="#"><?php echo $item["title"];?></a></h3>
                </div>
                <!-- ttl -->
            </div>
            <!-- video -->
                    <?php
                        endforeach;
                    ?>
        </div>
        <!-- galleries -->
    </div>
    <!-- page -->