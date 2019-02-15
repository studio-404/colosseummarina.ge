 <?php defined('DIR') OR exit ?>

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
            
             <div id="read" class="fix">
		<?php if (content($imagen)!='') {?>		
                <div class="image right">
              
                    <a href="<?php echo content($imagen); ?>" rel="prettyPhoto"><img src="<?php echo (content($imagen)!='') ? 'crop.php?img=' . content($imagen) . '&width=460&height=270' : '';?>" height="270" width="460" alt=""></a>
                </div> 
                 <?php } ?> 
                 <div class="text"  id="text"><?php echo content($content); ?></div>
            </div>
          
             
              
			   
            <!-- #read .fix -->
        </article>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
