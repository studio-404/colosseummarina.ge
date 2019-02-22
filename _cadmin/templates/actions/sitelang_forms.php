<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_cadmin/img/edit.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo ($action=='add') ? a('addtext') : a('edittext').': '.$sitelang["title"];?></div>
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
<?php $ulink = ($action=="add") ? ahref('langdata', 'add') : ahref('langdata', 'edit', array('key'=>$sitelang["key"])); ?>
	                <form id="catform" method="post" action="<?php echo $ulink;?>">
                   		<input type="hidden" name="sitelang_form_perform" value="1" />
<?php if($action=="add") { ?>
                        <div class="list2 fix">
                            <div class="name"><?php echo a('title');?> <span class="star">*</span></div>					
                            <input type="text" id="title" name="title" value="<?php echo ($action=="edit") ? $sitelang["title"] : '' ;?>" class="inp"/>
                        </div>	
                        <div class="list fix">
                            <div class="name"><?php echo a('name');?> <span class="star">*</span></div>					
                            <input type="text" id="key" name="key" value="<?php echo ($action=="edit") ? $sitelang["key"] : '' ;?>" class="inp"/>
                        </div>	
<?php } else {?>
                            <input type="hidden" id="key" name="key" value="<?php echo ($action=="edit") ? $sitelang["key"] : '' ;?>" class="inp"/>
<?php } ?>
                        <div class="list2 fix">
                            <div class="name"><?php echo a('value');?> <span class="star">*</span></div>					
                            <input type="text" id="value" name="value" value="<?php echo ($action=="edit") ? $sitelang["value"] : '' ;?>" class="inp"/>
                        </div>	
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
		if($("#title").val()=='') {
			msg = "<?php echo a('error.title');?>";
			validate = 0; 
		} else {
			validate = 1;
		}
		if($("#key").val()=='') {
			msg = "<?php echo a('error.title');?>";
			validate = 0; 
		} else {
			validate = 1;
		}
		if(validate == 1) {		
			this.catform.submit();
		} else {
			alert(msg);
		}
	};
</script>                
