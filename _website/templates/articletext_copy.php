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
        <article id="page" class="list wrapper">
            <header class="fix">
                <h1 class="title left">  <?php echo $title;?></h1>
                
            </header>
            
          
             <?php
			$x=0;
			$sql_c = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND `idx` = ".$idx." order by position;";
			$res_c = db_fetch_all($sql_c);
			foreach($res_c as $item): 
		 
			?>
             <div id="read" class="fix">
              <div><?php echo $item['description'];?></div>
             <?php if($item['imagen']!='') : ?>
                <div class="image right">
              
                    <a href="<?php echo $item['imagen'];?>"><img src="<?php echo $item['imagen'];?>" height="270" width="460" alt=""></a>
                </div> 
                 <?php endif; ?> 
                
            </div>
             <?php endforeach; ?>  
             
              
		 
            <!-- #read .fix -->
        </article>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->