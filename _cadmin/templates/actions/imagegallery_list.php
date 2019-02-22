<?php
   		$ttl = db_retrieve('title', c("table.pages"), 'attached', $title, ' and language = "'.l().'" LIMIT 1');
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_cadmin/img/buttons/_camera.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("imagegallery");?>: <?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref('imagegallery', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addimage");?></a>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="vis"><?php echo a("vis");?>.</div>									
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("name");?></span></div>									
						<div class="act fix"><?php echo a("actions");?></div>
						<div class="pid">ID</div>									
						<div class="ptype"><?php echo a("date");?></div>									
												
					</div>
<?php
	$class = 'list';
    $total = count($images);
    $count = 1;
	if(count($images) > 0) :
		foreach($images as $image) :
			$is_first = ($count == 1);
			$is_last = ($count >= $total);
			$arrow_up = $is_first ? '<img src="_cadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('imagegallery', 'move', array('where' => 'up', 'menu'=>$image['galleryid'], 'idx'=> $image['idx'])) . '"><img src="_cadmin/img/buttons/icon_arrow_up.png" alt="Move Up" title="Move Up" width="9" height="9" /></a>';
			$arrow_down = $is_last ? '<img src="_cadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('imagegallery', 'move', array('where' => 'down', 'menu'=>$image['galleryid'], 'idx'=> $image['idx'])) . '"><img src="_cadmin/img/buttons/icon_arrow_down.png" alt="Move Down" title="Move Down" width="9" height="9" /></a>';
			$arrows = $arrow_up . $arrow_down;
			$count++;
			if($class == 'list2') $class = 'list'; else $class = 'list2';
			$ch = ($image["visibility"]=='true') ? '' : 'un';
?>
					<div id="list" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $image['idx'];?>);"><img src="_cadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $image['idx'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $image['idx'];?>" id="vis_<?php echo $image['idx'];?>" value="<?php echo $image['visibility'];?>" />
                        </div>									
						<div class="icon"><?php echo $arrows;?></div>									
						<div class="name" style="padding: 6px 0 0 15px;"><a href="<?php echo ahref('imagegallery', 'edit', array('idx' => $image['idx'], 'menu'=>$image['galleryid']));?>"><?php echo $image["title"];?></a></div>									
						<div class="action fix" style="padding-top:6px; width:120px;">
							<a class="preview" rel="lightbox[<?php echo $image['idx'];?>]" href="<?php echo $image["file"];?>" title="<?php echo a('ql.preview');?>"><img src="_cadmin/img/buttons/icon_preview.png" style="padding-right:1px;" /></a>
							<a href="<?php echo ahref('imagegallery', 'edit', array('idx' => $image['idx'], 'menu'=>$image['galleryid']));?>" title="<?php echo a('ql.edit');?>"><img src="_cadmin/img/buttons/icon_edit.png" /></a>
							<a href="javascript:del(<?php echo $image['id'];?>, '<?php echo $image['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_cadmin/img/buttons/icon_delete.png" /></a>
						</div>
						<div class="id"><?php echo $image["id"];?></div>									
						<div class="date"><?php echo $image["postdate"];?></div>									
					</div>		
<?php
		endforeach;
	endif;
?>
				</div>	
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('imagegallery', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addimage");?></a>
				</div>					
			</div>		
		</div>
<script type="text/javascript">
function chclick(idx) {
	var active = ($('#vis_'+idx).val()=='false') ? 'true':'false'; 
	$.post("<?php echo ahref('imagegallery', 'visibility');?>&idx=" + idx + "&visibility=" + active, function() {
		if(active=='true') 
	        $('#img_'+idx).attr("src","_cadmin/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+idx).attr("src","_cadmin/img/buttons/icon_unvisible.png"); 
		$('#vis_'+idx).val(active);
	});
};	

function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref('imagegallery','delete');?>&id=" + id + "&menu=<?php echo $_GET["menu"];?>";
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