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
        <!-- #location -->
        
        <section id="page" class="list wrapper" >
            <header class="fix">
                <h1 class="title left"><?php echo $title;?></h1>
            </header>
 ggggggggggggggggggg           
 <?php 

 foreach($children as $item): ?>

<?php if($title=='Tours' || $title=='ტურები'  || $title=='Туры'){?>
            <div class="headline">
                <h2><?php echo $item["title"]; ?></h2>
            </div>
       <?php } ?>     
             
             <div class="keeper fix left">
            <?php  if($title=='Tours' || $title=='ტურები'  || $title=='Туры'){$sql_c2 = "select * from pages where deleted=0 and visibility='true' and language='".l()."' and masterid=".$item["idx"]." ORDER BY position asc";}
			else {$sql_c2 = "select * from pages where deleted=0 and visibility='true' and language='".l()."' and idx=".$item["idx"]."   ORDER BY position asc";}
			//echo $sql_c2."".$item['id'];
					$res_c2 = db_fetch_all($sql_c2);
					 foreach($res_c2 as $item2): 
					 
				//die($item2['idx']);
				$link = (($item2['redirectlink'] == '') || ($item2['redirectlink'] == 'NULL')) ? href($item2['id']) : $item2['redirectlink'];
				//echo $sql_c2;
			
			
?>	

            <!-- .headline -->
           
                <article class="tour left">
                    <div class="img">
                        <a href="<?php echo $link; ?>"><img src="<?php echo $item2['imagen']; ?>" height="130" width="300" alt=""></a>
                    </div>
                    <!-- .img -->
                    <header class="title head">
                        <h3><a href="<?php echo $link; ?>"><?php echo $item2["title"]; ?></a></h3>
                        <div class="more">
                            <a href="<?php echo $link; ?>"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                        </div>
                    </header>
                    <!-- .title head -->
                </article>
                <!-- .tour left -->
                
            
             
        	 <?php endforeach; ?>
            </div> 
		   <?php  endforeach; ?>
		
           
           
           

        </section>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->

    <div class="clear"></div>
