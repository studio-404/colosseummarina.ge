<?php defined('DIR') OR exit; ?>

    <div id="content" class="fix">
        <div class="page left">
            <div class="page-title fix" style="background:#75d07f;">
                <h2><?php echo l("news");?></h2>
                <div class="other">
                    <a href="<?php echo href(42);?>"><?php echo l("all.news");?></a>
                </div>
                <!-- .other -->
            </div>
            <!-- .page-title fix -->
            <div class="news-list">
<?php echo news_home();?>				
			</div>
            <!-- End news-list-->
        </div>
        <!-- .page left -->
        <div class="page right">
            <div class="page-title fix" style="background:#ffd200;">
                <h2><?php echo l("announcements");?></h2>
                <div class="other">
                    <a href="<?php echo href(43);?>"><?php echo l("all.announcements");?></a>
                </div>
                <!-- .other -->
            </div>
            <!-- .page-title fix -->
            <div class="news-list">
<?php echo Announcements_home();?>				
            </div>
            <!-- .news-list -->
        </div>
        <!-- .page right -->
        <div id="cat-part" class="fix">
            <a href="<?php echo href(743);?>" class="cat left">
                <img src="_website/images/mark-gallery.png" width="48" height="44" alt="">
                <h2><?php echo l("photogallery");?></h2>
            </a>
            <!-- .cat left -->
            <a href="<?php echo href(629);?>" class="cat left">
                <img src="_website/images/mark-library.png" width="48" height="44" alt="">
                <h2><?php echo l("library");?></h2>
            </a>
            <!-- .cat left -->
            <a href="<?php echo href(19);?>" class="cat left">
                <img src="_website/images/mark-consult.png" width="44" height="44" alt="">
                <h2><?php echo l("consulting.center");?></h2>
            </a>
            <!-- .cat left -->
            <a href="<?php echo href(462);?>" class="cat left">
                <img src="_website/images/mark-works.png" width="40" height="44" alt="">
                <h2><?php echo l("scientific.works");?></h2>
            </a>
            <!-- .cat left -->
        </div>
        <!-- #cat-part .fix -->
    </div>
    <!-- #content .fix -->
