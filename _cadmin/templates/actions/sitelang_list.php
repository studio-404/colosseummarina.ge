<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_cadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a('sitelanguagedata');?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if($_SESSION['auth']["class"] == '0') { ?>
					<a href="<?php echo ahref('langdata', 'add');?>" class="button br" id="addcategory" style="float: right"><?php echo a('addstring');?></a>
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
	foreach($sitelang as $sl) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
?>
					<div class="<?php echo $class;?> fix">
								
						<div class="icon"><img src="_cadmin/img/table.png" width="16" height="16" alt="" /></div>									
						<div class="name4"><a href="<?php echo ahref('langdata', 'edit', array('key'=>$sl['key']));?>"><? echo $sl['title']; ?></a>&nbsp;</div>									
						<div class="action2 fix">
<?php if($_SESSION['auth']["class"] == '0') { ?>
							<a href="<?php echo ahref('langdata', 'edit', array('key'=>$sl['key']));?>" title="<?php echo a('ql.edit');?>"><img src="_cadmin/img/buttons/icon_edit.png" /></a>
<?php } ?>
							<a href="javascript:del('<?php echo $sl['key'];?>', '<?php echo $sl['key'];?>');" title="<?php echo a('ql.delete');?>"><img src="_cadmin/img/buttons/icon_delete.png" /></a>
						</div>									
                        <div class="url3"><? echo $sl['value']; ?>&nbsp;</div>
					</div>		
<?php endforeach; ?>
				</div>	
				<div id="bottom" class="fix">
<?php if($_SESSION['auth']["class"] == '0') { ?>
					<a href="<?php echo ahref('langdata', 'add');?>" class="button br" style="float: right"><?php echo a('addstring');?></a>
<?php } ?>
				</div>					
			</div>		
		</div>
<script language="javascript">
function del(key, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref('langdata','delete');?>&key=" + key;
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
