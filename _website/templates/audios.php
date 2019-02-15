<script type="text/javascript" src="<?php echo c("players");?>/swfobject.js"></script>
<script type="text/javascript">
	swfobject.registerObject("player","9.0.98","expressInstall.swf");
</script>

<?php
defined('DIR') OR exit;

$idx = 0;
$num = count($audio);
?>
    <div class="block br fix">
        <ul class="menu">
            <li><a href="<?php echo href(2, array('all' => 'show'), l());?>"><?php echo l('video');?></a></li>					
		</ul>
		<div class="white fix">
            <div class="part">
                <div class="list fix" style="border:none">
                    <div class="item-info">
                        <div class="news-name cufon"><?php echo $title; ?></div>	
                    </div>	
                </div>
			</div>
<?php
$half = ceil((count($audio) - 1 ) / 2) + 1;
$idx = 0;
foreach ($audio AS $item):
	$idx++;
    $link = href($item['id']);
    $is_last = ($idx == ($num - 1));
?>
            <div class="part">
                <div class="list fix">
                    <div class="news-img" id="mp3player<?php echo $item['id'] ?>">
	<script type="text/javascript">
	var s2 = new SWFObject("<?php echo c("players");?>/player.swf", "line", "280", "20", "6");
	s2.addVariable("file","<?php echo $item['file'] ?>");
	s2.addVariable("backcolor","0x45535F");
	s2.addVariable("frontcolor","0xFFFFFF");
	s2.addVariable("lightcolor","0xeeeeee");
	s2.addVariable("displayheight","0");
	s2.addVariable("width","280");
	s2.addVariable("height","20");
	s2.addVariable("autostart","false");
	s2.addVariable("shuffle","false");
	s2.addVariable("repeat","list");
	s2.addVariable("thumbsinplaylist","false");
	s2.addVariable("titlesinplaylist","true");
	s2.addVariable("playlist","top");
	s2.addVariable("playlistsize","0");
	s2.addVariable("item","1");
	s2.write("mp3player<?php echo $item['id'] ?>");
	</script>
					</div>								
                    <div class="news-info">
                        <div class="news-name"><?php echo $item['title'] ?></div>	
                        <div class="news-text"><?php echo $item['description']; ?></div>		
                    </div>								
                </div>
            </div>
<?php
    endforeach;
?>
        </div>
    </div>


<!--
<?php
// Pager Start
    if (isset($item_count) AND $item_count > $num):
        echo '<ul id="page">';
        if ($page_num > 1):
?>
            <li><a href="<?php echo href($section, array('page' => 1)) ?>">&lt;&lt;</a></li>
            <li><a href="<?php echo href($section, array('page' => $page_num - 1)) ?>">&lt;</a></li>
<?php
            endif;
            $per_side = 5;
            $index_start = ($page_num - $per_side) <= 0 ? 1 : $page_num - $per_side;
            $index_finish = ($page_num + $per_side) >= $page_max ? $page_max : $page_num + $per_side;
            if (($page_num - $per_side) > 1)
                echo '...';
            for ($idx = $index_start; $idx <= $index_finish; $idx++):
?>
                <li><a href="<?php echo href($section, array('page' => $idx)) ?>"<?php echo $idx == $page_num ? ' class="current"' : NULL ?>><?php echo $idx ?></a></li>
<?php
                endfor;
                if (($page_num + $per_side) < $page_max)
                    echo '...';
                if ($page_num < $index_finish):
?>
                    <li><a href="<?php echo href($section, array('page' => $page_num + 1)) ?>">&gt;</a></li>
                    <li><a href="<?php echo href($section, array('page' => $page_max)) ?>">&gt;&gt;</a></li>
<?php
                    endif;
                    echo '</ul>';
                endif;
// Pager End
?>

                <a href="<?php echo href(c('section.news')) ?>" class="all"><?php echo l('all_news') ?></a>
-->