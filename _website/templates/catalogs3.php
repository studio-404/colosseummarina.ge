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
            
<?php 
$x = 1;
foreach($children as $item) { 
$link = (($item['redirectlink'] == '') || ($item['redirectlink'] == 'NULL')) ? href($item['id']) : $item['redirectlink'];
$x++;
?>

            <!--<div class="headline">
                <h2><?php echo $item["title"]; ?></h2>
            </div>-->
             <div class="keeper fix left">
            <!-- .headline -->
           
                <article class="tour left">
                    <div class="img">
                        <a href="<?php echo $link; ?>"><img src="<?php echo $item['imagen']; ?>" height="130" width="300" alt=""></a>
                    </div>
                    <!-- .img -->
                    <header class="title head">
                        <h3><a href="<?php echo $link; ?>"><?php echo $item["title"]; ?></a></h3>
                        <div class="more">
                            <a href="<?php echo $link; ?>"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                        </div>
                    </header>
                    <!-- .title head -->
                </article>
                <!-- .tour left -->
             
               
            </div>
<?php } ?>
		
           <br/><br/><br/><br/><br/><br/><br/><br/><br/>
        </section><br/><br/>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>