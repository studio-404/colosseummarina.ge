<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
    <main id="content">
        <section id="location">
            <div class="wrapper fix">
                <ul>
                  <?php echo location();?>
                </ul>
            </div>
            <!-- .wrapper fix -->
        </section>
        <!-- #location -->
        <?php  $p=db_fetch("SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND id='".$product["id"]."' LIMIT 0, 1");?>

        <article id="page" class="item wrapper fix">
            <header id="heading" class="right">
                <h1 class="title"><?php echo $product['title'];?></h1>
                <div class="tags"><span><?php echo l('tags');?>:</span> <?php  echo $p['meta_keys'];?></div>
                <div class="field fix">
                    <span class="left"><?php echo l('cost');?>:</span>
                    <span class="price right"><?php echo $p['price'];?></span>                            
                </div>
                <div class="field fix">
                    <span class="left"><?php echo l('departure');?>:</span>
                    <span class="right"><?php echo $p['productdate'];?></span>
                </div>
                <div class="field fix">
                    <span class="left"><?php echo l('duration');?>:</span>
                    <span class="right"><?php echo $p['duration'];?> <?php echo l('day');?></span>
                </div>
                <div id="booking">
                  
                   <a href="<?php echo href(33)."?product=".$product["id"];?>"> <?php echo l('booking');?></a>
                </div>
                <!-- #booking -->
            </header>
            <!-- #heading .right -->
            <script type="text/javascript" src="_javascript/jssor/jssor.core.js"></script>
            <script type="text/javascript" src="_javascript/jssor/jssor.utils.js"></script>
            <script type="text/javascript" src="_javascript/jssor/jssor.slider.js"></script>
            <script type="text/javascript" src="_javascript/jssor/jssor.ctrl2.js"></script>
            <section id="slider2" style="width:700px;height:300px;">
        
       <?php $sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 71 AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position;";
        $images = db_fetch_all($sql);   
?>
                <div u="slides" class="slides" style="width:700px;height:300px;overflow:hidden;"> 
                 <?php foreach($images as $image): ?>
                <?php $link = $image["itemlink"]; ?>
                    <div class="img">
                        <img u="image" src="<?php echo $image['file'];?>" alt="">
                    </div>
                   <?php endforeach;?>
                </div>
                <!-- .slides -->
                <div u="navigator" class="navigator" style="position:absolute;bottom:20px;left:20px;">
                    <div u="prototype" class="prototype " style="position:absolute;width:35px;height:35px;"><NumberTemplate></NumberTemplate></div>
                </div>
                <!-- .navigator -->
            </section>
            <!-- #slider -->
            <div id="tab" class="fix">
                <ul>
                    <li class="active"><a href="#tab1"> <?php echo l('review');?></a></li>
                    <li><a href="#tab2"><?php echo l('settling');?></a></li>
                    <li><a href="#tab3"><?php echo l('prices');?></a></li>
                </ul>
            </div>
            <!-- #tabs .fix -->
            <div id="read" class="tab-content">
                <div id="tab1" class="text" style="display:block;">  
                    <?php echo $p['description'];?>
                </div>
                <div id="tab2" class="text">
                      <?php echo $p['content'];?>
                </div>
                <div id="tab3" class="text">
                      <?php echo $p['review'];?>
                </div>
            </div>
            <!-- tabs-content -->
            
           
<script type="text/javascript">
$(document).ready(function() {
    $("#tab li").click(function() {
        $("#tab li").removeClass("active");
        $(this).addClass("active");
        $(".tab-content .text").hide();
        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn(300);
        return false;
    });
});
</script>
<?php 	         
    $sql_c2 = "SELECT * FROM `".c("table.catalogs")."` WHERE `deleted` = '0' AND `catalogid` = ".$product['catalogid']."  AND language = '" . l() . "'   AND `id` <> ".$product['id']." order by position limit 3;";
		$res_c2 = db_fetch_all($sql_c2);
		foreach($res_c2 as $item2): 
		
		
		$item1 = db_fetch("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$item2['catalogid']."'");
		$item22 = db_fetch("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
	    $id = $item22["id"];
	    $link=href($id);
	  
		 ?>
            <header class="fix">
                <h1 class="title left"><?php echo l('similartours');?></h1>
            </header>
            <section class="keeper fix">
                
                <?php
	
					
		//	echo $sql_c2;
?>	<article class="tour left">
                    <div class="img"> 
                        <a href="<?php echo $link.'/'.$item2['id'];?>"><img src="<?php echo $item2['photo1']?>" height="130" width="300" alt=""></a>
                    </div>
                    <!-- .img -->
                    <header class="title">
                        <hgroup>
                           
                            <h3><?php echo $item2['title']?></h3>
                        </hgroup>
                        <div class="more">
                            <a href="<?php echo $link.'/'.$item2['id'];?>"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                        </div>
                    </header>
                    <!-- .title -->
                    <div class="price"><?php echo $item2['price']?></div>
                      </article>
                
              
                <!-- .tour left -->
               
               
            </section> 
           <?php endforeach;?>
            <!-- .keeper fix -->
        </article>
        <!-- #page .item wrapper fix -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->