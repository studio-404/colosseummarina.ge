<?php defined('DIR') OR exit;
    $p=db_fetch("SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND id='".$product["id"]."' LIMIT 0, 1");

    $mphotos = Array();
    if($p['photo1']!='') $mphotos[] = $p['photo1'];
    if($p['photo2']!='') $mphotos[] = $p['photo2'];
    if($p['photo3']!='') $mphotos[] = $p['photo3'];
    if($p['photo4']!='') $mphotos[] = $p['photo4'];
    $num = count($mphotos);
    $cursor = "move";
    if ($num == 1) {
        $cursor = "default";
    }
?>
    <?php if ($num != 1): ?>
    <script type="text/javascript" src="_javascript/jssor/jssor.core.js"></script>
    <script type="text/javascript" src="_javascript/jssor/jssor.utils.js"></script>
    <script type="text/javascript" src="_javascript/jssor/jssor.slider.js"></script>
    <script type="text/javascript" src="_javascript/jssor/jssor.ctrl2.js"></script>
    <?php endif; ?>
    <div id="location-part">
        <div id="location">
            <div id="page-title">
                <h2><?php echo $product['title']; ?></h2>
            </div>
            <!-- #page-title -->
            <div id="loc-bar">
                <ul>
                    <?php echo location();?>
                </ul>
            </div>
            <!-- #loc-bar -->
        </div>
        <!-- #location .fix -->
    </div>
    <!-- #location-part -->
    <div id="content">
        <div id="page" class="fix">
            <div id="aside" class="right">
                <div id="booking">
                    <div class="title">
                        <h3><?php echo $product['title']; ?></h3>
                        <h4><?php echo $p["city"]; ?></h4>
                    </div>
                    <!-- .title -->
                <?php if($p["price"]!='' || $p["duration"]!=''): ?> 
                    <div id="fee">
                    <?php if($p["price"]!=''): ?> 
                        <div>
                            <span><?php echo l('price.from'); ?>:</span>
                        <?php if ($p["price"]!=''): ?> 
                            <span class="price">&euro;<?php echo $p["price"]; ?></span>
                        <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($p["duration"]!=''): ?> 
                        <div>
                            <span><?php echo l('duration'); ?>:</span>
                            <span class="days"><?php echo $p["duration"]; ?></span>
                        </div>
                    <?php endif; ?>
                    </div>
                    <!-- #fee -->
                <?php endif; ?>
                <?php if($p["price"]!=''): ?> 
                    <div class="text">
                        <?php echo $p["description"]; ?>
                    </div>
                    <!-- .text -->
                <?php endif; ?>
                    <div id="book">
                        <a href="<?php echo href(21)."?product=".$product["id"];?>&ajax=1&iframe=true&width=920&height=90%" rel="prettyPhoto[iframes]"><?php echo l('booking'); ?></a>
                    </div>
                    <!-- #book -->
                </div>
                <!-- #booking -->
                <?php if($p["content4"]!=''): ?> 
                <div id="inc-tours">
                    <div class="title">
                        <h3><?php echo l('inc.tours'); ?></h3>
                    </div>
                    <!-- .title -->
                    <div class="text">
                        <?php echo $p["content4"]; ?>
                    </div>
                    <!-- .text -->
                </div>
                <!-- #inc-tours -->
                <?php endif; ?>
            </div>
            <!-- #aside .right -->
            <div id="product">
            <?php if (!empty($mphotos)): ?> 
                <div id="slider2" style="width:640px;height:400px;">
                    <div u="slides" class="slides" style="width:640px;height:400px;overflow:hidden;">
                    <?php foreach($mphotos as $mphoto): ?> 
                        <div class="sld-img" style="background:url('<?php echo $mphoto; ?>') center no-repeat;width:640px;height:400px;cursor:<?php echo $cursor ?>;"></div>
                    <?php endforeach; ?>
                    </div>
                    <!-- .slides -->
                    <?php if ($num != 1): ?>
                    <div u="navigator" class="navigator" style="position:absolute;bottom:20px;left:20px;">
                        <div u="prototype" class="prototype " style="position:absolute;width:35px;height:35px;"><NumberTemplate></NumberTemplate></div>
                    </div>
                    <!-- .navigator -->
                    <?php endif; ?>
                </div>
                <!-- #slider2 -->
            <?php endif; ?>
                <div id="prod-info">
                    <div id="tabs" class="fix">
                        <ul>
                            <li class="active"><a href="#tab1"><?php echo l('overview'); ?></a></li>
                            <li><a href="#tab2"><?php echo l('itinerary'); ?></a></li>
                            <li><a href="#tab3"><?php echo l('prices'); ?></a></li>
                        </ul>
                    </div>
                    <!-- #tabs .fix -->
                    <div id="tabs-content">
                        <div id="tab1" class="text" style="display:block;">
                            <?php echo $p["content"]; ?>
                        </div>
                        <div id="tab2" class="text">
                            <?php echo $p["content2"]; ?>
                        </div>
                        <div id="tab3" class="text">
                            <?php echo $p["content3"]; ?>
                        </div>
                    </div>
                    <!-- #tabs-content -->
                </div>
                <!-- #prod-info -->
            </div>
            <!-- #product -->
        </div>
        <!-- #page .fix -->
    </div>
    <!-- #content .fix -->
    <script type="text/javascript">
        $(function(){
            $("#loc-bar li").last().addClass('last');
        });
        $(document).ready(function(){
            $("#tabs li").click(function() {
                $("#tabs li").removeClass('active');
                $(this).addClass("active");
                $("#tabs-content .text").hide();
                var selected_tab = $(this).find("a").attr("href");
                $(selected_tab).fadeIn();
                return false;
            });
        });
    </script>