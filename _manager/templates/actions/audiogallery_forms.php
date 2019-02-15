    <div id="title" class="fix">
        <div class="icon"><img src="_manager/img/buttons/_sound.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo ($subaction=='add') ? a('addaudio') : a('editaudio');?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
            </div>	
            
            <div id="t1" style="display:inline; visibility:visible;">
                <div id="news">
<?php $ulink = ($subaction=="add") ? ahref('audiogallery', 'add', array('menu' => $menu)) : ahref('audiogallery', 'edit', array('menu' => $menu, 'idx' => $idx)); ?>
                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
                   	<input type="hidden" name="audiogallery_form_perform" value="1" />
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></a></div>								
                            <div class="title"><?php echo a("info");?>: <span class="star">*</span></div>								
                        </div>		
        
                        <div class="list fix">
                            <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>					
                            <input type="text" id="pagetitle" name="title" value="<?php echo ($subaction=='edit') ? $title : '' ?>" class="inp"/>
                        </div>	
        
                        <div class="list2 fix">
                            <div class="name"><?php echo a("itemlink");?>: <span class="star">*</span></div>					
                            <input type="text" id="itemlink" name="itemlink" value="<?php echo ($subaction=='edit') ? $itemlink : '' ?>" class="inp"/>
                        </div>	
        
                        <div class="list fix">
                            <div class="name"><?php echo a("description");?>: <span class="star">*</span></div>					
                            <input type="text" id="text_description" name="text_description" value="<?php echo ($subaction=='edit') ? $description : '' ?>" class="inp"/>
                        </div>	
        
                        <div class="list2 fix">
                            <div class="name"><?php echo a("audio");?>: <span class="star">*</span></div>					
                            <input type="text" id="file" name="file" value="<?php echo ($subaction=='edit') ? $file : '' ?>" class="inp" style="width:500px;"/>
                            <a href="javascript:browse();" class="button br" ><?php echo a("browse");?></a>
<script language="JavaScript">
		function browse() {
			 aFieldName = 'file', aWin = window;
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
                        
                        <div class="list fix">
                            <div class="name"><?php echo a("date");?>: <span class="star">*</span></div>
                            <input type="text" name="postdate" value="<?php echo ($subaction=='edit') ? date('Y-m-d', strtotime($postdate)) : date('Y-m-d'); ?>" id="postdate" class="inp-small" />
<script language="JavaScript">
	new tcal ({
		'formname': 'catform',
		'controlname': 'postdate',
	});
</script>
                            <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>					
                            <input type="text" name="posttime" value="<?php echo ($subaction=='edit') ? date('H:i:s', strtotime($postdate)) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
						</div>
                        <div class="list2 fix">
                            <div class="name"><?php echo a("visibility");?>: <span class="star">*</span></div>					
                            <input type="checkbox" name="visibility" class="inp-check" style="margin-top:6px;" <?php echo (($subaction=='edit')&&($visibility=='true')) ? 'checked' : '' ?> />
                        </div>	
        			</form>
                </div>
            </div>
            
            <div id="bottom" class="fix">
                <a href="javascript:save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:history.back(-1);" class="button br"><?php echo a("cancel");?></a>
            </div>					
        </div>		
    </div>
    <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>calendar/calendar-mos.css" title="green" media="all" />
<script language="javascript" type="text/javascript">
	function save() {
		var validate = 0;
		var msg = "";
		if($("#pagetitle").val()=='') {
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
	}
</script>