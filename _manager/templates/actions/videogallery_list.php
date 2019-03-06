<?php
   		$ttl = db_retrieve('title', c("table.pages"), 'attached', $title, ' and language = "'.l().'" LIMIT 1');
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_manager/img/buttons/_film.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("videogallery");?>: <?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref('videogallery', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addvideo");?></a>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="check"><?php echo a("vis");?>.</div>									
						<div class="name-title"><?php echo a("name");?></div>									
						<div class="id">ID</div>									
						<div class="date"><?php echo a("date");?></div>									
						<div class="url">&nbsp;</div>									
						<div class="action fix"><?php echo a("actions");?></div>						
					</div>
<?php
	$class = 'list';
    $total = count($images);
    $count = 1;
	if(count($images) > 0) :
		foreach($images as $video) :
			$is_first = ($count == 1);
			$is_last = ($count >= $total);
			$arrow_up = $is_first ? '<img src="_manager/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('videogallery', 'move', array('where' => 'up', 'menu'=>$video['galleryid'], 'idx'=> $video['idx'])) . '"><img src="_manager/img/buttons/icon_arrow_up.png" alt="Move Up" title="Move Up" width="9" height="9" /></a>';
			$arrow_down = $is_last ? '<img src="_manager/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('videogallery', 'move', array('where' => 'down', 'menu'=>$video['galleryid'], 'idx'=> $video['idx'])) . '"><img src="_manager/img/buttons/icon_arrow_down.png" alt="Move Down" title="Move Down" width="9" height="9" /></a>';
			$arrows = $arrow_up . $arrow_down;
			$count++;
			if($class == 'list2') $class = 'list'; else $class = 'list2';
			$ch = ($video["visibility"]=='true') ? '' : 'un';
?>
					<div id="list" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $video['idx'];?>);"><img src="_manager/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $video['idx'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $video['idx'];?>" id="vis_<?php echo $video['idx'];?>" value="<?php echo $video['visibility'];?>" />
                        </div>									
						<div class="icon"><?php echo $arrows;?></div>									
						<div class="name"><a href="<?php echo ahref('videogallery', 'edit', array('idx' => $video['idx'], 'menu'=>$video['galleryid']));?>"><?php echo $video["title"];?></a></div>									
						<div class="id"><?php echo $video["id"];?></div>									
						<div class="date"><?php echo $video["postdate"];?></div>									
						<div class="url">&nbsp;</div>									
						<div class="action fix" style="padding-top:6px; width:120px;">
							<a href="<?php echo $video['file'];?>" target="_blank" title="<?php echo a('ql.preview');?>"><img src="_manager/img/buttons/icon_preview.png" style="padding-right:1px;" /></a>
							<a href="<?php echo ahref('videogallery', 'edit', array('idx' => $video['idx'], 'menu'=>$video['galleryid']));?>" title="<?php echo a('ql.edit');?>"><img src="_manager/img/buttons/icon_edit.png" style="padding-right:1px;" /></a>
							<a href="javascript:del(<?php echo $video['id'];?>, '<?php echo $video['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_manager/img/buttons/icon_delete.png" style="padding-right:1px;" /></a>
						</div>
					</div>		
<?php
		endforeach;
	endif;
?>
				</div>	
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('videogallery', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addvideo");?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function chclick(idx) {
	var active = ($('#vis_'+idx).val()=='false') ? 'true':'false'; 
	$.post("<?php echo ahref('videogallery', 'visibility');?>&idx=" + idx + "&visibility=" + active, function() {
		if(active=='true') 
	        $('#img_'+idx).attr("src","_manager/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+idx).attr("src","_manager/img/buttons/icon_unvisible.png"); 
		$('#vis_'+idx).val(active);
	});
};	

function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref('videogallery','delete');?>&id=" + id + "&menu=<?php echo $_GET["menu"];?>";
	}
}

$(".list").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#f8f8f8');
    });
$(".list2").mouseover(function(){
    	$(this).css('background', '#ededed');
    }).mouseout(function(){
    	$(this).css('background', '#ffffff');
    });

</script>