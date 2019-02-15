<?php
defined('DIR') OR exit;
?>
     <!-- #header .fix -->
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
        <section id="page" class="list wrapper">
            <header class="fix">
                <h1 class="title left"><?php echo $title;?></h1>
            </header>
            <div class="keeper fix">
            <?php
$i = 0;
foreach ($news AS $item):
    $i++;
    $link = href($item['id']);
?>
                <article class="tour left">
                    <div class="img">
                        <a href="<?php echo $link; ?>"><img src="<?php echo $item['imagen']; ?>" height="130" width="300" alt=""></a>
                    </div>
                    <!-- .img -->
                    <header class="title">
                        <h3 class="ttl"><a href="<?php echo $link; ?>"><?php echo $item['title'] ?></a></h3>
                        <div class="more">
                            <a href="<?php echo $link; ?>"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                        </div>
                    </header>
                    <!-- .title -->
                </article>
             <?php endforeach;?>
             
            </div>
            <!-- .keeper fix -->
        </section>
        <!-- #page .list wrapper -->
    </main>
    <!-- #content -->
</div>
<!-- #root -->