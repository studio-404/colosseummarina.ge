<?php
defined('DIR') OR exit;
$num = count($news);
?>
<!--Breadcrumb Section-->
		<section id="breadcrumb-section" data-bg-img="<?php echo WEBSITE;?>/assets/img/testimonails.jpg">
			<div class="inner-container container">
				<div class="ravis-title">
					<div class="inner-box">
						<div class="title"><?php echo $title;?></div>
					</div>
				</div>

				<div class="breadcrumb">
					<ul class="list-inline">
                    	<?php echo location();?>
					</ul>
				</div>
			</div>
		</section>
		<!--End of Breadcrumb Section-->

<!--Blog Container-->
		<section id="blog-section">
			<div class="inner-container container">
				<div class="post-main-container clearfix">
					<?php 
                        $i = 0;
                        foreach ($news AS $item):
                            $i++;
                            $link = href($item['id']);
                    ?>
					<!-- Post boxes -->
					<div class="post-outer-box col-md-6">
						<div class="post-box">
                        	<? if($item['imagen']!=''){?>
							<a class="post-img-box" href="<?php echo $link;?>">
								<img src="<?php echo $item['imagen'];?>" alt="<?php echo $item['title'];?>" class="post-img">
							</a>
                            <?php }?>
							<div class="post-b-sec">
								<div class="post-title-box">
									<a href="<?php echo $link; ?>" class="post-title"><?php echo $item['title'];?></a>
								</div>
								<div class="post-meta clearfix">
									<div class="post-date"><i class="fa fa-calendar"></i> <?php echo convert_date($item['pagedate']) ?></div>
									
								</div>
								<div class="post-desc">
									<?php echo $item['description'];?>
								</div>
								<div class="read-more-container">
									<a href="<?php echo $link; ?>" class="btn btn-default read-more"><?php echo l('more');?></a>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>

				</div>
				<!-- Pagination -->                
				<?php if (count($news) > 0) : ?> 
                <div class="pagination-box">
    
                    <?php
                     if(count($news) > 0) {
                    ?>
    
                    <ul class="list-inline">
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
				<!-- End of Pagination -->
			</div>
		</section>
		<!--End of Blog Container-->