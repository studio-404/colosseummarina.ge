<?php defined('DIR') OR exit; ?>
    <div id="title" class="fix">
        <div class="icon"><img src="_manager/img/edit.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo $title . ((isset($subtitle)) ? ' - '. $subtitle : '');?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
            </div>	
            
			<form id="dataform" name="dataform" method="post" action="<?php echo ahref($action, $subaction, $params);?>">
            <div id="t1">
                <div id="news">
<?php if($subaction=='edit') { ?>
					<input type="hidden" name="idx" value="<?php echo $idx; ?>" />
<?php } ?>
                    <input type="hidden" name="perform" value="1" />
<?php if (isset($_GET['menu'])): ?>
					<input type="hidden" name="menuid" value="<?php echo $_GET['menu'] ?>" />
<?php endif; ?>
<?php if (isset($_GET['level'])): ?>
					<input type="hidden" name="level_num" value="<?php echo $_GET['level'] ?>" />
<?php endif; ?>
					<input type="hidden" name="tabstop" id="tabstop" value="close" />
                    <div class="list2 fix">
                        <div class="icon"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></div>								
                        <div class="title"><?php echo a("general");?>:</div>								
                    </div>		
    
                    <div class="list fix">
                        <div class="name"><?php echo a("title");?>: <span class="star" title="">*</span></div>					
                        <input type="text" id="pagetitle" name="title" value="<?php echo ($subaction=='edit') ? $edit["title"] : '' ?>" class="inp"/>
                    </div>	


                    <div class="list2 fix">
                        <div class="name"><?php echo a("date");?>: <span class="star" title="">*</span></div>					
                        <input type="text" name="pagedate" value="<?php echo ($subaction=='edit') ? date('Y-m-d', strtotime($edit["pagedate"])) : date('Y-m-d'); ?>" id="pagedate" class="inp-small" />
<script language="JavaScript">
	new tcal ({
		'formname': 'dataform',
		'controlname': 'pagedate',
	});
</script>
                            <div class="name"><?php echo a("time");?>: <span class="star" title="<?php echo a('tt.bannertime');?>">*</span></div>					
                            <input type="text" name="pagetime" value="<?php echo ($subaction=='edit') ? date('H:i:s', strtotime($edit["pagedate"])) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                    </div>	

                    <div class="list fix">
                        <div class="name"><?php echo a("expiredate");?>: <span class="star" title="<?php echo a('tt.bannerexpiredate');?>">*</span></div>					
                        <input type="text" name="expiredate" value="<?php echo ($subaction=='edit') ? date('Y-m-d', strtotime($edit["expiredate"])) : date('Y-m-d'); ?>" id="expiredate" class="inp-small" />
<script language="JavaScript">
	new tcal ({
		'formname': 'dataform',
		'controlname': 'expiredate',
	});
</script>
                            <div class="name"><?php echo a("time");?>: <span class="star" title="<?php echo a('tt.bannerexpiretime');?>">*</span></div>					
                            <input type="text" name="expiretime" value="<?php echo ($subaction=='edit') ? date('H:i:s', strtotime($edit["expiredate"])) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                    </div>	

                    <div class="list2 fix">
                        <div class="name"><?php echo a("visibility");?>: <span class="star" title="<?php echo a('tt.visibility');?>">*</span></div>					
                        <input type="checkbox" name="visibility" class="inp-check" <?php echo (($subaction=='edit')&&($edit["visibility"]=='true')) ? 'checked' : '' ?> />
                    </div>
    
                    <div class="list fix">
                        <div class="name"><?php echo a("redirectlink");?>:</div>                    
                        <input type="text" name="redirectlink" value="<?php echo ($subaction=='edit') ? $edit["redirectlink"] : '' ?>" class="inp" />
                    </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("description");?>: <span class="star">*</span></div>     
                        <textarea id="description" name="description" style="width:800px; height:300px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $edit["description"] : '' ?></textarea>
                    </div>  

                   <!--<div class="list fix">
                        <div class="icon"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></div>                              
                        <div class="title"><?php echo a("pagecontent");?>:</div>        
                    </div>  
                     <div class="list2 fix">
                          <div class="name"><?php echo a("text");?>: <span class="star">*</span></div>        
                          <textarea id="text_content" name="content" style="width:800px; height:500px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $edit["content"] : '' ?></textarea>
                      </div> -->  

                    <div class="list2 fix">
                        <div class="name"><?php echo a("file");?>: <span class="star">*</span></div>					
                        <input type="text" id="imagen" name="imagen" value="<?php echo ($subaction=='edit') ? $edit["imagen"] : '' ?>" class="inp" style="width:500px;"/>
                        <a href="javascript:browse();" class="button br" ><?php echo a("browse");?></a>
<script language="JavaScript">
		function browse() {
			 aFieldName = 'imagen', aWin = window;
			 if($('#elfinder').length == 0) {
				 $('body').append($('<div/>').attr('id', 'elfinder'));
				 $('#elfinder').elfinder({
					 url : '<?php echo c('site.url') . JAVASCRIPT;?>/elfinder/connectors/php/connector.php',
					 dialog : { width: 750, modal: true, title: 'Files', zIndex: 400001 }, 
					 editorCallback: function(url) {
						 aWin.document.forms[0].elements[aFieldName].value = url;
					 },
					 closeOnEditorCallback: true
				 });
			 } else {
				 $('#elfinder').elfinder('open');
			 }
		 };
</script>
                   </div>	
    
                </div>
            </div>
			</form>

            <div id="bottom" class="fix">
                <a href="javascript:save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:history.back(-1);" class="button br"><?php echo a("cancel");?></a>
            </div>					
        </div>		
    </div>
<script language="javascript" type="text/javascript">
	$("#tabstop").val('close');
	function save() {
		document.dataform.submit();
	}
</script>