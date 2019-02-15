<?php
defined('DIR') OR exit;

$num = count($news);
?>
    <div id="content" class="fix">
        <div id="aside" class="right">
            <div id="graduate">
                <div class="page-title fix" style="background:#<?php echo ($color3!='') ? $color3 : 'fa5b8d';?>;">
                    <h2><?php echo l("friends");?></h2>
                </div>
                <!-- .page-title fix -->
<?php echo Alumni();?>
            </div>
            <!-- #graduate -->
            <div id="side-news">
                <div class="page-title fix" style="background:#<?php echo ($color4!='') ? $color4 : 'ffd200';?>;">
                    <h2><?php echo l("news");?></h2>
                    <a href="<?php echo href(42);?>" class="other"><?php echo l("all.news");?></a>
                </div>
                <!-- .page-title fix -->
<?php echo features();?>				
            </div>
            <!-- #side-news -->
<?php echo right_banners();?>
        </div>
        <!-- #aside .right -->
        <div class="page">
            <div class="page-title fix" style="background:#<?php echo ($color2!='') ? $color2 : '00b0dc';?>;">
                <h2><?php echo $title; ?></h2>
                <div id="location">
                    <ul>
<?php echo location(); ?>
                    </ul>
                </div>
                <!-- #location .right -->
            </div>
            <!-- .page-title fix -->
            <div class="news-list">
<?php
$i = 0;
foreach ($news AS $item):
    $i++;
    $link = href($item['id']);
?>
                <div class="news fix">
<?php if($item["imagen"]!='NULL'){ ?>
                    <div class="img left">
                        <a href="<?php echo $link ?>"><img src="<?php echo 'crop.php?img=' . $item['imagen'] . '&width=180&height=120';?>" width="180" height="120" alt=""></a>
                    </div>
<?php } ?>
                    <!-- .img left -->
                    <div class="info">
                        <div class="title">
                            <h3><a href="<?php echo $link ?>"><?php echo $item['title'] ?></a></h3>
                        </div>
                        <!-- .title -->
                        <div class="date"><?php echo date("d", strtotime($item['pagedate']));?> / <?php echo date("M", strtotime($item['pagedate']));?></div>
                        <!-- .date -->
                        <div class="text"><?php echo $item['description'] ?></div>
                        <!-- .text -->
                    </div>
                    <!-- .info -->
                </div>
                <!-- .news fix -->
<?php
    endforeach;
?>  
            </div>
            <!-- .news-list -->

        <?php if (count($news) > 0) : ?> 
            <div id="pager" class="fix">

                <?php
                 if(count($news) > 0) {
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
                                <li><a <?php echo ($page_num==$idx) ? 'class="active"':'' ;?> href="<?php echo href($section["id"], array()) . '?page=' . $idx; ?>"><?php echo $idx ?></a></li>
                                
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
            <!-- #pager .fix -->
            <?php endif; ?>
        </div>
        <!-- .page -->
    </div>
    <!-- #content .fix -->
