<?php defined('DIR') OR exit; ?>
<?php            
   		$ttl = (in_array($_GET["action"], array('pages', 'bannergroups'))) ? $title : db_retrieve('title', c("table.pages"), 'attached', $title, ' and language = "'.l().'" LIMIT 1');
?>
    	<div id="title" class="fix">
			<div class="icon"><img src="_cadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
				</div>	

				<div id="news">
					<div class="list fix">
						<div class="icon"><a href="#"><img src="_cadmin/img/minus.png" width="16" height="16" alt="" /></a></div>								
						<div class="title">Info: <span class="star">*</span></div>								
					</div>	
<?php $ulink = ($action=="add") ? ahref($type, 'add', array('menutype' => $menutype)) : ahref($type, 'edit', array('idx'=>$data["idx"], 'menutype' => $menutype)); ?>
	                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
                   		<input type="hidden" name="topics_form_perform" value="1" />
                        <div class="list2 fix">
                            <div class="name"><?php echo a('title');?> <span class="star">*</span></div>					
                            <input type="text" id="menutitle" name="title" value="<?php echo ($action=="edit") ? $data["title"] : '' ;?>" <?php echo (in_array($_GET["action"], array('pages', 'bannergroups'))) ? '' : 'disabled';?> class="inp"/>
                        </div>	
                        <div class="list fix">
                            <div class="name"><?php echo a('items.per.page');?> <span class="star">*</span></div>					
                            <input type="text" id="items_per_page" name="items_per_page" value="<?php echo ($action=="edit") ? $data["items_per_page"] : '0' ;?>" class="inp" style="width:80px;" />
                        </div>	
                        <div class="list2 fix">
                            <div class="name"><?php echo a('items.on.homepage');?> <span class="star">*</span></div>					
                            <input type="text" id="items_on_homepage" name="items_on_homepage" value="<?php echo ($action=="edit") ? $data["items_on_homepage"] : '0' ;?>" class="inp" style="width:80px;" />
                        </div>	
                        
<?php
	if(($type=='gallerylist')&&($action=='add')) {
?>
                        <div class="list fix">
                            <div class="name"><?php echo a('gallerytype');?><span class="star">*</span></div>					
                            <select name="menutype" class="inp" style="width:200px;">
                            	<option value="imagegallery"><?php echo a("imagegallery");?></option>
                            	<option value="videogallery"><?php echo a("videogallery");?></option>
                            	<option value="audiogallery"><?php echo a("audiogallery");?></option>
                            </select>
                        </div>	
<?php
	} elseif((($type=='categories'))&&($action=='add')) {
?>
                        <div class="list fix">
                            <div class="name"><?php echo a('gallerytype');?><span class="star">*</span></div>					
                            <select name="menutype" class="inp" style="width:200px;">
                            	<option value="news"><?php echo a("news");?></option>
                            	<option value="articles"><?php echo a("articles");?></option>
                            	<option value="events"><?php echo a("events");?></option>
                            </select>
                        </div>	
<?php
	} else {
?>
                   		<input type="hidden" name="menutype" value="<?php echo $menutype;?>" />
<?php
	} 
?>
					</form>
				</div>	
				<div id="bottom" class="fix">
					<a href="javascript:save();" class="button br" id="save"><?php echo a("save");?></a>
					<a href="javascript:history.back(-1);" class="button br" id="cancel"><?php echo a("cancel");?></a>
				</div>					
			</div>	
		</div>
<script language="javascript">
	function save() {
		var validate = 0;
		var msg = "";
		if($("#menutitle").val()=='') {
			msg = "<?php echo a('error.title');?>";
			validate = 0; 
		} else {
			validate = 1;
		}
		if(validate == 1) {		
			document.catform.submit();
		} else {
			alert(msg);
		}
	};
</script>                
