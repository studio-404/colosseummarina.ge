<?php
   		$ttl = db_retrieve('title', c("table.pages"), 'attached', $title, ' and language = "'.l().'" LIMIT 1');
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_cadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("mt.catalog");?>: <?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref('catalog', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addcatalogitem");?></a>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="vis"><?php echo a("vis");?>.</div>									
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("title");?></span></div>									
						<div class="act fix"><?php echo a("actions");?></div>	
						<div class="pid">ID</div>									
						<div class="ptype"><?php echo a("price");?></div>									
											
					</div>
<?php
	$class = 'list';
    $total = count($catalogs);
    $count = 1;
	if(count($catalogs) > 0) :
		foreach($catalogs as $catalog) :
			$is_first = ($count == 1);
			$is_last = ($count >= $total);
			$arrow_up = $is_first ? '<img src="_cadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('catalog', 'move', array('where' => 'up', 'menu'=>$catalog['catalogid'], 'idx'=> $catalog['idx'])) . '"><img src="_cadmin/img/buttons/icon_arrow_up.png" alt="Move Up" title="Move Up" width="9" height="9" /></a>';
			$arrow_down = $is_last ? '<img src="_cadmin/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref('catalog', 'move', array('where' => 'down', 'menu'=>$catalog['catalogid'], 'idx'=> $catalog['idx'])) . '"><img src="_cadmin/img/buttons/icon_arrow_down.png" alt="Move Down" title="Move Down" width="9" height="9" /></a>';
			$arrows = $arrow_up . $arrow_down;
			$count++;
			if($class == 'list2') $class = 'list'; else $class = 'list2';
			$ch = ($catalog["visibility"]=='true') ? '' : 'un';
?>
					<div id="list" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $catalog['idx'];?>);"><img src="_cadmin/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $catalog['idx'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $catalog['idx'];?>" id="vis_<?php echo $catalog['idx'];?>" value="<?php echo $catalog['visibility'];?>" />
                        </div>									
						<div class="icon"><?php echo $arrows;?></div>									
						<div class="catname"><a href="<?php echo ahref('catalog', 'edit', array('idx' => $catalog['idx'], 'menu'=>$catalog['catalogid']));?>"><?php echo $catalog["title"];?></a></div>									
						<div class="catfield">
							<select name="cat" id="cat<?php echo $catalog['idx'];?>" onchange="javascript:chccat('<?php echo $catalog["idx"];?>', $('#cat<?php echo $catalog['idx'];?>').val());">
								<?php
									$acc=db_fetch_all("select * from pages where menuid=4 and language='".l()."' order by title");
									foreach($acc as $a) :
									$acc_l=db_fetch("select * from menus where title='".$a["attached"]."' and language='".l()."'");
								?>
                                <option value="<?php echo $acc_l["id"];?>" <?php echo ($catalog['catalogid']==$acc_l["id"]) ? "selected='selected'":"" ;?> ><?php echo $a["title"];?></option>
								<?php
									endforeach;	
								?>
							</select>
						</div>									
															
						<div class="action fix">
							<a href="<?php echo ahref('catalog', 'edit', array('idx' => $catalog['idx'], 'menu'=>$catalog['catalogid']));?>" title="<?php echo a('ql.edit');?>"><img src="_cadmin/img/buttons/icon_edit.png" /></a>
							<a href="javascript:del(<?php echo $catalog['id'];?>, '<?php echo $catalog['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_cadmin/img/buttons/icon_delete.png" /></a>
						</div>	
						<div class="id"><?php echo $catalog["id"];?></div>
						<div class="date"><?php echo $catalog["price"];?>&nbsp;</div>								
					</div>		
<?php
		endforeach;
	endif;
?>
				</div>	
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('catalog', 'add', array('menu'=>$_GET["menu"]));?>" class="button br" id="addcategory" style="float: right"><?php echo a("addcatalogitem");?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function chclick(idx) {
	var active = ($('#vis_'+idx).val()=='false') ? 'true':'false'; 
	$.post("<?php echo ahref('catalog', 'visibility');?>&idx=" + idx + "&visibility=" + active + "&menu=" + <?php echo $_GET["menu"];?>, function() {
		if(active=='true') 
	        $('#img_'+idx).attr("src","_cadmin/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+idx).attr("src","_cadmin/img/buttons/icon_unvisible.png"); 
		$('#vis_'+idx).val(active);
	});
};	

function chccat(idx, cat) {
	window.location="<?php echo ahref('catalog', 'changecatalog');?>&idx=" + idx + "&cat=" + cat + "&menu=<?php echo $_GET["menu"];?>";
};	

function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref('catalog','delete');?>&id=" + id + "&menu=<?php echo $_GET["menu"];?>";
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