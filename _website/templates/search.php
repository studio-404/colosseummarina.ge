<?php defined('DIR') OR exit; ?>

  <main id="content">
        <section id="location">
        
            <div class="wrapper fix">
                <ul>
               <?php echo location();?>
                </ul>
            </div>
            <!-- .wrapper fix -->
        </section>
      <section id="page" class="list wrapper">
            <header class="fix">
                <h1 class="title left"><?php echo $title;?></h1>
            </header>
            <?php if($m3char == 1) { ?>
<i><?php echo l('search.simbol');?></i>
<?php } elseif($noresult == 1) { ?>
<i><?php echo l('search.not_found');?></i>
<?php } else { ?>
            <div class="keeper fix">
            <?php 
$x = 1;

 foreach($results as $item) { ?>
<?php
	$item1 = db_fetch("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$item['catalogid']."'");
	$item2 = db_fetch("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
	$id = $item2["id"];
	$link=href($id);
	$x++;
	//echo "SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$item['catalogid']."'";
?>
                <article class="tour left">
                    <div class="img">
                        <a href="<?php echo $link.'/'.$item['id'];?>"><img src="<?php echo $item["photo1"]; ?>" height="130" width="300" alt=""></a>
                    </div>
                    <!-- .img -->
                    <header class="title">
                        <h3 class="ttl"><a href="<?php echo $link.'/'.$item['id'];?>"><?php echo $item["title"]; ?></a></h3>
                        <div class="more">
                            <a href="<?php echo $link.'/'.$item['id'];?>"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                        </div>
                    </header>
                    <!-- .title -->
           </article>
              
            <?php }  ?>
            
            </div>
            <!-- .keeper fix -->
            <?php } ?>
        </section>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->



