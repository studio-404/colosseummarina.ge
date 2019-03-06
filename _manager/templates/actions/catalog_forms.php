    <div id="title" class="fix">
        <div class="icon"><img src="_manager/img/edit.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo ($subaction=='add') ? a('addcatalogitem') : a('editcatalogitem');?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
            </div>
            <div id="t1" style="display:inline; visibility:visible;">
                <div id="news">
<?php $ulink = ($subaction=="add") ? ahref('catalog', 'add', array('menu' => $menu)) : ahref('catalog', 'edit', array('menu' => $menu, 'idx' => $idx)); ?>
                <form id="catform" name="catform" method="post" action="<?php echo $ulink;?>">
					<input type="hidden" name="tabstop" id="tabstop" value="close" />
                   	<input type="hidden" name="catalog_form_perform" value="1" />
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></a></div>								
                            <div class="title"><?php echo a("info");?>: <span class="star">*</span></div>								
                        </div>		
        
                        <div class="list fix">
                            <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>					
                            <input type="text" id="title" name="title" value="<?php echo ($subaction=='edit') ? $title : '' ?>" class="inp"/>
                        </div>	
                        <div class="list fix">
                            <div class="name">Short Description: <span class="star">*</span></div>					
                            <input type="text" id="street" name="street" value="<?php echo ($subaction=='edit') ? $street : '' ?>" class="inp"/>
                        </div>	
         			 <div class="list2 fix">
                            <div class="name"><?php echo a("price");?>: <span class="star">*</span></div>					
                            <input type="text" id="price" name="price" value="<?php echo ($subaction=='edit') ? $price : '' ?>" class="inp-small"/>
</div>
                      <div class="list fix"> 
                            <div class="name">Duration: <span class="star">*</span></div>                   
                            <input type="text" id="duration" name="duration" value="<?php echo ($subaction=='edit') ? $duration : '' ?>" class="inp"/>
                            </div>
                    <!--<div class="list2 fix">   
                            <div class="name">Review1: <span class="star">*</span></div>                  
                            <input type="text" id="review1" name="review1" value="<?php echo ($subaction=='edit') ? $review1 : '' ?>" class="inp"/></div>
                     <div class="list fix">
                            <div class="name">Review2: <span class="star">*</span></div>                  
                            <input type="text" id="review2" name="review2" value="<?php echo ($subaction=='edit') ? $review2 : '' ?>" class="inp"/>
                     <div class="list2 fix">     </div>               

                            <div class="name">Review3: <span class="star">*</span></div>                   
                            <input type="text" id="review3" name="review3" value="<?php echo ($subaction=='edit') ? $review3 : '' ?>" class="inp"/>
                      </div>-->
                       <div class="list2 fix" style="display:none;">
                             <div class="name">Mobile: <span class="star">*</span></div>                  
                            <input type="text" id="mob1" name="mob1" value="<?php echo ($subaction=='edit') ? $mob1 : '' ?>" class="inp"/>
                        </div>

                        <div class="list fix">
                            <div class="name"><?php echo a("visibility");?>: <span class="star" title="<?php echo a('tt.visibility');?>">*</span></div>                 
                            <input type="checkbox" name="visibility" class="inp-check" style="margin-top:10px;" <?php echo (($subaction=='edit')&&($visibility=='true')) ? 'checked' : '' ?> />
                        </div>
                        
                        
                         <div class="list2 fix">
                        <div class="name"><?php echo a("keywords");?> <span class="star">*</span></div>					
                        <input type="text" name="meta_keys" id ="meta_keys" value="<?php echo ($subaction=='edit') ? $meta_keys : '' ?>" class="inp"/>
                    </div>	
                    
						  <div class="list2 fix">
                             <div class="name" style="width:125px;">Hot: <span class="star">*</span></div>                   
                            <input type="checkbox" name="hot" class="inp-check" style="margin-top:10px;margin-right:155px;" <?php echo (($subaction=='edit')&&($hot=='1')) ? 'checked' : '' ?> />
						</div>
                        <div class="list fix">
                             <div class="name">Popular: <span class="star">*</span></div>					
                            <input type="checkbox" name="top25" class="inp-check" style="margin-top:10px;margin-right:155px;" <?php echo (($subaction=='edit')&&($top25=='1')) ? 'checked' : '' ?> /> 
                        </div>
                        
                   
                        <div class="list2 fix">
                            <div class="icon"><a href="#"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></a></div>								
                            <div class="title"><?php echo a("general");?>: <span class="star">*</span></div>								
                        </div>	
        
                        <div class="list fix">
                            <div class="name" style="line-height:16px;">Review1: <span class="star">*</span></div>					
	                        <textarea id="description" name="description" style="width:800px; height:300px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $description : '' ?></textarea>
                        </div>	

                        <div class="list2 fix">
                            <div class="name" style="line-height:16px;">Review2: <span class="star">*</span></div>					
	                        <textarea id="text_content" name="content" style="width:800px; height:300px; margin-top:2px; margin-bottom:2px;">
							<?php echo ($subaction=='edit') ? $content : '' ?></textarea>
                        </div>	
                        
                         <div class="list fix">
                            <div class="name" style="line-height:16px;">Review3: <span class="star">*</span></div>					
	                        <textarea id="review" name="review" style="width:800px; height:300px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $review : '' ?></textarea>
                        </div>
                        
                        <div class="list2 fix">
                            <div class="name"><?php echo a("date");?>: <span class="star">*</span></div>					
                            <input type="text" name="productdate" value="<?php echo ($subaction=='edit') ? date('Y-m-d', strtotime($productdate)) : date('Y-m-d'); ?>" id="productdate" class="inp-small" />
    <script language="JavaScript">
        new tcal ({
            'formname': 'catform',
            'controlname': 'productdate',
        });
    </script>
                            <!-- <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>					
                            <input type="text" name="producttime" value="<?php echo ($subaction=='edit') ? date('H:i:s', strtotime($productdate)) : date('H:i:s'); ?>" id="producttime" class="inp-small" /> -->
                        </div>	

                        <div class="list fix">
                            <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>					
                            <input type="text" id="photo1" name="photo1" value="<?php echo ($subaction=='edit') ? $photo1 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo1');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                       </div>	

                        <div class="list fix">
                            <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>       
                            <input type="text" id="photo2" name="photo2" value="<?php echo ($subaction=='edit') ? $photo2 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo2');" class="button br" ><?php echo a("browse");?></a>
                       </div>

                        <div class="list fix">
                            <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>                   
                            <input type="text" id="photo3" name="photo3" value="<?php echo ($subaction=='edit') ? $photo3 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo3');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>
                        </div>

                        <div class="list2 fix">
                            <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>
                            <input type="text" id="photo4" name="photo4" value="<?php echo ($subaction=='edit') ? $photo4 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo4');" class="button br" ><?php echo a("browse");?></a>
                        </div>
                        <div class="list2 fix" style="display:none;">
                            <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>					
                            <input type="text" id="photo5" name="photo5" value="<?php echo ($subaction=='edit') ? $photo5 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo5');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>

                            <input type="text" id="photo6" name="photo6" value="<?php echo ($subaction=='edit') ? $photo6 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('photo6');" class="button br" ><?php echo a("browse");?></a>
                       </div>	

                       <div class="list fix" style="display:none;">
                            <div class="name"><?php echo a("video");?>: <span class="star">*</span></div>					
                            <input type="text" id="video1" name="video1" value="<?php echo ($subaction=='edit') ? $video1 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('video1');" class="button br" style="margin-right:110px;" ><?php echo a("browse");?></a>

                            <input type="text" id="video2" name="video2" value="<?php echo ($subaction=='edit') ? $video2 : '' ?>" class="inp-small" style="margin-right:5px;" />
                            <a href="javascript:browse('video2');" class="button br" ><?php echo a("browse");?></a>
                       </div>

        			</form>
                </div>
            </div>

            <div id="bottom" class="fix">
                <a href="javascript:save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:v_saveclose();" class="button br"><?php echo a("save&close");?></a>
                <a href="javascript:history.back(-1);" class="button br"><?php echo a("cancel");?></a>
                <!-- <a href="<?php echo ahref('uploadfiles', 'show', array('menu'=>$menu, 'id'=>$id, 'idx'=>$idx));?>" id="b3" class="button br">Upload Slider Images</a> -->
            </div>					
        </div>		
    </div>
    <link rel="stylesheet" type="text/css" href="<?php echo JSPATH;?>calendar/calendar-mos.css" title="green" media="all" />
    

<script language="javascript" type="text/javascript">
	function save() {
		$("#tabstop").val('edit');
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

	function v_saveclose() {
		$("#tabstop").val('close');
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

<script language="JavaScript">
		function browse(fieldname) {
			 aFieldName = fieldname, aWin = window;
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
