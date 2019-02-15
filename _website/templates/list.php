<?php 
    defined('DIR') OR exit; 

$idx = 0;
$num = count($news);
?>
    <div id="location" class="fix">
        <ul>
            <?php echo location(); ?>
        </ul>
    </div>
    <!-- #location -->
    <div id="content" class="fix">
        <div id="page" class="bxs">
            <div id="lists" class="fix">
            <?php
            foreach ($news AS $item):
            ?>      
                <div class="projects left">
                <?php if ($item["imagen"]!='') : ?> 
                    <div class="img bxs">
                       <a href="<?php echo $item["imagen"]; ?>" rel="prettyPhoto[3]"><img src="<?php echo $item["imagen"]!='' ? 'crop.php?img=' . $item["imagen"] . '&width=264&height=195' : '';?>" width="264" height="195" alt="<?php echo $item["title"];?>" title="" /></a>
                    </div>
                    <!-- .img -->
                <?php endif;?>  
                    <div class="title">
                        <h3><a href="<?php echo $item["imagen"];?>"><?php echo $item["title"];?></a></h3>
                    </div>
                    <!-- att-name -->
                    <div class="select">
                        <a href="#"><?php echo l('choose.flat') ?></a>
                    </div>
                    <!-- .select -->
                </div>
                <!-- .projects -->
            <?php
            endforeach;
            ?> 
            </div>
            <!-- #lists -->
            <div class="other left">
                <a href="<?php echo href(9); ?>"><?php echo l('other.current') ?></a>
            </div>
            <!-- .other -->
            <div id="pager" class="fix">

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
            <!-- pager -->
        </div>
        <!-- #page -->
        <div id="blocks">
            <div class="block left">
                <div class="img bxs">
                    <a href="<?php echo href(9); ?>"><img src="files/img1.jpg" width="214" height="154" alt="" /></a>
                </div>
                <!-- .img -->
                <div class="title">
                    <h3><a href="<?php echo href(9); ?>"><?php echo l('current.projects'); ?></a></h3>
                </div>
                <!-- .title -->
            </div>
            <!-- .block -->
            <div class="block left">
                <div class="img bxs">
                    <a href="<?php echo href(16); ?>"><img src="files/img2.jpg" width="214" height="154" alt="" /></a>
                </div>
                <!-- .img -->
                <div class="title">
                    <h3><a href="<?php echo href(16); ?>"><?php echo l('flats'); ?></a></h3>
                </div>
                <!-- .title -->
            </div>
            <!-- .block -->
            <div class="block left">
                <div class="img bxs">
                    <a href="<?php echo href(5); ?>"><img src="files/img3.jpg" width="214" height="154" alt="" /></a>
                </div>
                <!-- .img -->
                <div class="title">
                    <h3><a href="<?php echo href(5); ?>"><?php echo l('purchase.terms'); ?></a></h3>
                </div>
                <!-- .title -->
            </div>
            <!-- .block -->
            <div class="block left">
                <div class="img bxs">
                    <a href="<?php echo href(3); ?>"><img src="files/img1.jpg" width="214" height="154" alt="" /></a>
                </div>
                <!-- .img -->
                <div class="title">
                    <h3><a href="<?php echo href(3); ?>"><?php echo l('news'); ?></a></h3>
                </div>
                <!-- .title -->
            </div>
            <!-- .block -->
        </div>
        <!-- #blocks -->
    </div>
    <!-- #content -->