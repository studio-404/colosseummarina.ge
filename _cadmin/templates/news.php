<?php
defined('DIR') OR exit;

$idx = 0;
$num = count($news);
?>
<div id="location-part">
    <div id="location" class="fix">
        <div class="loc-nav right">
            <ul>
                <?php echo location();?>
            </ul>
        </div>
        <!-- loc-nav -->
    </div>
    <!-- location -->
</div>
<!-- location-part end -->

    	<div id="content" class="fix">
        <div class="page-title"><h2><?php echo l('latestnews');?></h2></div>
    <div id="news-part" class="fix">
<?php
$idx = 0;
foreach ($news AS $item):
	$idx++;
    $link = href($item['id']);
?>				
        <div class="news left">
            <div class="news-img left">
<?php if($item["imagen"]!='') { ?>
                <a href="<?php echo $link ?>"><img src="<?php echo ($item['imagen']!='') ? 'crop.php?img=' . $item['imagen'] . '&width=140&height=90' : WEBSITE.'/img/default_img.png';?>" width="140" height="90" alt="" title="" /></a>
            </div>
            <!-- img end -->
<?php } ?>
            <div class="info">
                <?php echo convert_date($item['pagedate']) ?>
            </div>
            <!-- info end -->
            <div class="title">
                <h3><a href="<?php echo $link ?>"><?php echo $item['title'] ?></a></h3>
            </div>
            <!-- title end -->
            <div class="news-txt">
                <?php echo $item['description'] ?>
            </div>
            <!-- text end -->
        </div>
        <!-- news end -->
<?php
    endforeach;
?>	
    </div>
    <!-- news-part -->
<div id="pages" class="fix clear">

    <?php
     if(count($news) > 1) {
    ?>

    <ul>
    <?php
        }
    //  echo $count_sql;
    // Pager Start
        if (isset($item_count) AND $item_count > $num):
            if ($page_num > 1):
    ?>
                <li><a href="<?php echo href($section["id"], array()) . '?page=1'; ?>">&lt;&lt;</a></li>
                <li><a href="<?php echo href($section["id"], array()) . '?page=' . ($page_num - 1); ?>">&lt;</a></li>
    <?php
            endif;
            $per_side = c('news.page_count');
            $index_start = ($page_num - $per_side) <= 0 ? 1 : $page_num - $per_side;
            $index_finish = ($page_num + $per_side) >= $page_max ? $page_max : $page_num + $per_side;
            if (($page_num - $per_side) > 1)
                echo '<li>...</li>';
            for ($idx = $index_start; $idx <= $index_finish; $idx++):
    ?>
                    <li><a href="<?php echo href($section["id"], array()) . '?page=' . $idx; ?>" <?php echo ($page_num==$idx) ? 'class="active"':'' ;?>><?php echo $idx ?></a></li>
                    
    <?php
            endfor;
            if (($page_num + $per_side) < $page_max)
                echo '<li>...</li>';
            if ($page_num < $index_finish):
    ?>
                         
                        <li><a href="<?php echo href($section["id"], array()) . '?page=' . ($page_num + 1); ?>">&gt;</a></li>
                        <li><a href="<?php echo href($section["id"], array()) . '?page=' . $page_max; ?>">&gt;&gt;</a></li>
    <?php
            endif;
        endif;
    // Pager End
    ?>
    </ul>
</div>
<!-- pages -->
</div>
<!-- content end -->