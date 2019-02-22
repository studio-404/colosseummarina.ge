<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_cadmin/img/buttons/_table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $title;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if(in_array($_GET["action"], array('pages', 'bannergroups'))) { ?>                
					<a href="<?php echo ahref($type, 'add');?>" class="button br" id="addcategory" style="float: right"><?php echo $add;?></a>
<?php } ?>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="name-title"  style="padding-left:45px;"><?php echo a('name');?></div>	
						<div class="act2 fix"><?php echo a('actions');?></div>	
                        <div class="ptype"><?php echo a('type');?></div>									
						<div class="pid">ID</div>									
											
					</div>
<?php
	$class = 'list';
	foreach($topics as $topic) :
		$img="table";
		switch($topic['type']): 
			case 'audiogallery' : 	$img = "sound"; break;
			case 'videogallery' : 	$img = "film"; break;
			case 'imagegallery' : 	$img = "camera"; break;
			case 'poll' : 			$img = "chart_bar"; break;
			case 'catalog' : 		$img = "cart"; break;
			case 'faq' : 			$img = "question"; break;
		endswitch;
		$linktype = $topic['type']; if($linktype == 'pages') $linktype = 'sitemap'; if($linktype == 'list') $linktype = 'customlist';
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		if(($topic['type']!='banners')&&($topic['type']!='pages'))
			$ttl = db_retrieve('title', c("table.pages"), 'attached', $topic['title'], ' and language = "'.l().'" LIMIT 1');
		else
			$ttl = $topic['title'];
?>
					<div class="<?php echo $class;?> fix">
						<div class="icon4"><img src="_cadmin/img/buttons/_<?php echo $img;?>.png" width="16" height="16" alt="" /></div>									
						<div class="name4"><a href="<?php echo ahref($linktype,'show', array('menu'=>$topic["id"]));?>"><? echo $ttl; ?>&nbsp;</a></div>									
						<div class="action2 fix">
                            <a href="<?php echo ahref($linktype,'show', array('menu'=>$topic["id"])) ?>" title="<?php echo a('ql.editcontent');?>"><img src="_cadmin/img/buttons/icon_files_edit.png" /></a>
							<a href="<?php echo ahref($type, 'edit', array('idx'=>$topic['idx']));?>" title="<?php echo a('ql.edit');?>"><img src="_cadmin/img/buttons/icon_edit.png" /></a>
<?php if(in_array($_GET["action"], array('pages', 'bannergroups'))) { ?>
							<a href="javascript:del('<?php echo $topic['id'];?>', '<?php echo $topic['title'];?>');" title="<?php echo a('ql.delete');?>"><img src="_cadmin/img/buttons/icon_delete.png" /></a>
<?php } ?>
						</div>
                        <div class="date"><? echo $topic['type']; ?></div>									
						<div class="id"><? echo $topic['id']; ?></div>									
															
					</div>		
<?php endforeach; ?>
				</div>	
				<div id="bottom" class="fix">
<?php if(in_array($_GET["action"], array('pages', 'bannergroups'))) { ?>                
					<a href="<?php echo ahref($type, 'add');?>" class="button br" id="addcategory" style="float: right"><?php echo $add;?></a>
<?php } ?>
				</div>					
			</div>		
		</div>
<script language="javascript">
function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref($type,'delete');?>&id=" + id;
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
