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
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
            <header class="fix">
                <h1 class="title left"><?php echo $title;?></h1>
            </header>
            <div class="keeper fix">
            
            <?php 
			
				$x = 0;
				$class = NULL;
				$num = count($items);
				 foreach($items as $item): ?>
				<?php
					$link=href($id);
					$x++;
				?>
                <article class="tour left">
                    <div class="img">
                        <a href="<?php echo href(($id), array(), l(), $item['id']);?>"><img src="<?php echo $item["photo1"]; ?>" height="130" width="300" alt=""></a>
            <br />
        </div>
                    <!-- .img -->
                    <header class="title">
                        <h3 class="ttl"><a href="<?php echo href(($id), array(), l(), $item['id']);?>"><?php echo $item["title"]; ?></a></h3>
                        <div class="more">
                            <a href="<?php echo href(($id), array(), l(), $item['id']);?>"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                        </div>
                    </header>
                    <!-- .title -->
           </article>
              
            <?php endforeach; ?>
            
            </div>
            <!-- .keeper fix -->
        </section>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->

