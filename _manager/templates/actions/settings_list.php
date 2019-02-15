<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_manager/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $title;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if($_SESSION['auth']["class"] == '0') { ?>
					<a href="<?php echo ahref($section, 'add');?>" class="button br" id="addcategory" style="float: right"><?php echo a('addsetting');?></a>
<?php } ?>
				</div>	
				<div id="info">
					<div class="list-top">
						<div class="name-title"><?php echo a('name');?></div>	
						<div class="act2 fix"><?php echo a('actions');?></div>	
                        <div class="url3"><?php echo a('value');?></div>									
											
					</div>
<?php
	$class = 'list';
	foreach($settings as $setting) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
?>
					<div class="<?php echo $class;?> fix">
						<div class="icon"><img src="_manager/img/table.png" width="16" height="16" alt="" /></div>									
						<div class="name4"><a href="<?php echo ahref($section, 'edit', array('key'=>$setting['key']));?>"><? echo $setting['title']; ?></a>&nbsp;</div>									
						<div class="action2 fix">
							<a href="<?php echo ahref($section, 'edit', array('key'=>$setting['key']));?>" title="<?php echo a('ql.edit');?>"><img src="_manager/img/buttons/icon_edit.png" /></a>
<?php if($_SESSION['auth']["class"] == '0') { ?>
							<a href="javascript:del('<?php echo $setting['key'];?>', '<?php echo $setting['key'];?>');" title="<?php echo a('ql.delete');?>"><img src="_manager/img/buttons/icon_delete.png" /></a>
<?php } ?>
						</div>									
                        <div class="url3"><? echo $setting['value']; ?>&nbsp;</div>		
					</div>		
<?php endforeach; ?>
				</div>	
				<div id="bottom" class="fix">
<?php if($_SESSION['auth']["class"] == '0') { ?>
					<a href="<?php echo ahref($section, 'add');?>" class="button br" style="float: right"><?php echo a('addsetting');?></a>
<?php } ?>
				</div>					
			</div>		
		</div>
<script language="javascript">
function del(key, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref($section,'delete');?>&key=" + key;
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
