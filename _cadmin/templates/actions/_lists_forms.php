<?php defined('DIR') OR exit; ?>
<?php 
	if(!isset($params['idx'])) {
		$masterslug = '/';
		$idslug='';
	} else {
		$slugsql = 'select * from ' . c('table.pages') . ' where idx = ' . (($subaction=='edit') ? $edit['masterid'] : $params['idx']);
		$slugres = db_fetch($slugsql);
		$masterslug = $slugres['slug'];
		if($slugres['level']>=1) $masterslug .= '/';
	    $idslug = (is_from_list($params['menu'])) ? '/'.$edit['id'] : '';
	}
?>
    <div id="title" class="fix">
        <div class="icon"><img src="_cadmin/img/edit.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo $ttl . ((isset($subtitle)) ? ' - '. $subtitle : '');?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
                <a href="javascript:v_general();" id="b1" class="selbutton br"><?php echo a("general");?></a>
                <a href="javascript:v_content();" id="b2" class="button br"><?php echo a("content");?></a>
<?php if($subaction=='edit') { ?>
<?php
	if(in_array($edit["category"], array(8,9,10,11,12,13,14,15,16,17))) {
		switch($edit["category"]) {
			case 8:  $menutype = "news"; $btitle = a("bt.news"); break;
			case 9:  $menutype = "articles"; $btitle = a("bt.articles"); break;
			case 10: $menutype = "events"; $btitle = a("bt.events"); break;
			case 11: $menutype = "customlist"; $btitle = a("bt.list"); break;
			case 12: $menutype = "imagegallery"; $btitle = a("bt.imagegallery"); break;
			case 13: $menutype = "videogallery"; $btitle = a("bt.videogallery"); break;
			case 14: $menutype = "audiogallery"; $btitle = a("bt.audiogallery"); break;
			case 15: $menutype = "poll"; $btitle = a("bt.polls"); break;
			case 16: $menutype = "catalog"; $btitle = a("bt.catalogs"); break;
			case 17: $menutype = "faq"; $btitle = a("bt.faq"); break;
		}
		$attachedid = db_retrieve('id', c("table.menus"), 'title', $edit['attached'], ' and language = "'.l().'" LIMIT 1');
?>
                <a href="<?php echo ahref($menutype,'show', array('menu'=>$attachedid)) ?>" id="b3" class="button br"><?php echo $btitle;?></a>
<?php
	} else {
?>
                <a href="<?php echo ahref('files', 'show', array('menu'=>$edit['menuid'], 'id'=>$edit["id"], 'idx'=>$edit["idx"]));?>" id="b3" class="button br"><?php echo a("files");?></a>
<?php } ?>
<?php } ?>
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
					<input type="hidden" name="tabstop" id="tabstop" value="general" />
                    <div class="list2 fix">
                        <div class="icon"><img src="_cadmin/img/minus.png" width="16" height="16" alt="" /></div>								
                        <div class="title"><?php echo a("general");?>:</div>								
                    </div>		
    
                    <div class="list fix">
                        <div class="name"><?php echo a("title");?>: <span class="star">*</span></div>					
                        <input type="text" id="pagetitle" name="title" value="<?php echo ($subaction=='edit') ? $edit["title"] : '' ?>" class="inp"/>
                    </div>	

                    <div class="list2 fix">
                        <div class="name"><?php echo a("menutitle");?>: <span class="star">*</span></div>					
                        <input type="text" id="menutitle" name="menutitle" value="<?php echo ($subaction=='edit') ? $edit["menutitle"] : '' ?>" class="inp"/>
                    </div>	
    
                    <div class="list2 fix">
                        <div class="name"><?php echo a("friendlyURL");?>: <span class="star">*</span></div>					
                        <?php echo c('site.url') . l() . '/' . $masterslug;?>
                        <input type="text" name="slug" value="<?php echo ($subaction=='edit') ? $edit["slug"] : '' ?>" class="inp-ssmall"/>
                        <?php echo $idslug;?>
                    </div>	
<?php
	isset($edit['category']) OR $edit['category'] = 1;
	$catchange_disabled = '';
	if(in_array($edit['category'], array('8','9','10','11','12','13','14','15','16',17))) $catchange_disabled = 'disabled';
	if($action != 'sitemap') $catchange_disabled = 'disabled';
?>
                    <div class="list fix">
<?php if($menuclass != 'list') { ?>
                        <div class="name"><?php echo a("pageclass");?>: <span class="star">*</span></div>	
<script type="text/javascript">
	$(function(){
		$('#category_change').change(function(){
            var v = $(this).val();
            if (v=='7') {
                $('#category_7').show();
            } else {
                $('#category_7').hide();
            }
        });
    });
</script>
                        <select name="category" id="category_change" class="inp-small" style="width:210px;" <?php  echo $catchange_disabled; ?> >
                            <option value='1'  <?php if ($edit['category'] == '1') { echo 'selected'; } ?>><?php echo a("page.text");?></option>
                            <option value='2'  <?php if ($edit['category'] == '2') { echo 'selected'; } ?>><?php echo a("page.home");?></option>
                            <!-- <option value='3'  <?php if ($edit['category'] == '3') { echo 'selected'; } ?>><?php echo a("page.about");?></option> -->
                            <option value='4'  <?php if ($edit['category'] == '4') { echo 'selected'; } ?>><?php echo a("page.search");?></option> 
                            <option value='5'  <?php if ($edit['category'] == '5') { echo 'selected'; } ?>><?php echo a("page.sitemap");?></option>
                            <option value='6'  <?php if ($edit['category'] == '6') { echo 'selected'; } ?>><?php echo a("page.feedback");?></option>
                            <!-- <option value='7'  <?php if ($edit['category'] == '7') { echo 'selected'; } ?>><?php echo a("page.plugin");?></option> -->
                            <option value='8'  <?php if ($edit['category'] == '8') { echo 'selected'; } ?>><?php echo a("page.news");?></option>
                            <option value='9'  <?php if ($edit['category'] == '9') { echo 'selected'; } ?>><?php echo a("page.articles");?></option>
                            <!-- <option value='10' <?php if ($edit['category'] == '10'){ echo 'selected'; } ?>><?php echo a("page.events");?></option> -->
                            <!-- <option value='11' <?php if ($edit['category'] == '11'){ echo 'selected'; } ?>><?php echo a("page.list");?></option> -->
                            <option value='12' <?php if ($edit['category'] == '12'){ echo 'selected'; } ?>><?php echo a("page.photo");?></option>
                            <!-- <option value='13' <?php if ($edit['category'] == '13'){ echo 'selected'; } ?>><?php echo a("page.video");?></option> -->
                            <!-- <option value='14' <?php if ($edit['category'] == '14'){ echo 'selected'; } ?>><?php echo a("page.audio");?></option> -->
                            <!-- <option value='15' <?php if ($edit['category'] == '15'){ echo 'selected'; } ?>><?php echo a("page.poll");?></option> -->
                            <option value='16' <?php if ($edit['category'] == '16'){ echo 'selected'; } ?>><?php echo a("page.catalog");?></option>
                            <!-- <option value='17' <?php if ($edit['category'] == '17'){ echo 'selected'; } ?>><?php echo a("page.faq");?></option> -->
                        </select>
                        <div id="category_7" <?php echo ($edit['category'] == '7' ? 'style="display: block;"' : 'style="display: none;"') ?> >
                            <div class="name"><?php echo a("attachedtopic");?>: <span class="star">*</span></div>
                            <div style="float:left;">
                                <input name='attached' id='attached' type='text' class='inp-small' value='<?php echo isset($edit['attached']) ? $edit['attached'] : NULL ?>' />
                            </div>
                        </div>
<?php } ?>
<?php if($menuclass == "list") { ?>
                        <div class="name"><?php echo a("number");?>: <span class="star">*</span></div>					
                        <input type="text" id="item_number" name="item_number" value="<?php echo ($subaction=='edit') ? $edit["item_number"] : '' ?>" class="inp-smalloj"/>
<?php } ?>
                    </div>	

                    <div class="list2 fix">
                        <div class="name"><?php echo a("date");?>: <span class="star">*</span></div>					
                        <input type="text" name="pagedate" value="<?php echo ($subaction=='edit') ? date('Y-m-d', strtotime($edit["pagedate"])) : date('Y-m-d'); ?>" id="pagedate" class="inp-small" />
<script language="JavaScript">
	new tcal ({
		'formname': 'dataform',
		'controlname': 'pagedate',
	});
</script>
                        <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>					
                        <input type="text" name="pagetime" value="<?php echo ($subaction=='edit') ? date('H:i:s', strtotime($edit["pagedate"])) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                    </div>	
                    <div class="list fix">
                        <div class="name"><?php echo a("expiredate");?>:</div>					
                        <input type="text" name="expiredate" value="<?php echo ($subaction=='edit') ? date('Y-m-d', strtotime($edit["expiredate"])) : date('Y-m-d'); ?>" id="expiredate" class="inp-small" />
<script language="JavaScript">
	new tcal ({
		'formname': 'dataform',
		'controlname': 'expiredate',
	});
</script>
                            <div class="name"><?php echo a("time");?>: <span class="star">*</span></div>					
                            <input type="text" name="expiretime" value="<?php echo ($subaction=='edit') ? date('H:i:s', strtotime($edit["expiredate"])) : date('H:i:s'); ?>" id="posttime" class="inp-small" />
                    </div>	

                    <div class="list2 fix">
                        <div class="name"><?php echo a("template");?>: <span class="star">*</span></div>
                        <!-- <input type="text" name="template" value="<?php echo ($subaction=='edit') ? $edit["template"] : '' ?>" class="inp-small"/> -->
							<select name="template" class="inp-small">
								<option value=""></option>
<?php
	$templates=scandir("_website/templates/custom");
	foreach($templates as $t) :
		if($t !='.' && $t !='..') :
			$tt = str_replace('.php','',$t);
?>                                
								<option value="<?php echo $tt;?>" <?php echo ($subaction=='edit' && $edit["template"]==$tt) ? 'selected="selected"' : ''; ?> ><?php echo $tt;?></option>
<?php
		endif;
	endforeach;
?>                                
                            </select>
                    </div>	
                    
                    <div class="list fix">
                        <div class="name"><?php echo a("redirectlink");?>:</div>					
                        <input type="text" name="redirectlink" value="<?php echo ($subaction=='edit') ? $edit["redirectlink"] : '' ?>" class="inp-small" />
                    </div>

                    <div class="list2 fix">
                        <div class="name"><?php echo a("visibility");?>: <span class="star">*</span></div>					
                        <input type="checkbox" name="visibility" class="inp-check" <?php echo (($subaction=='edit')&&($edit["visibility"]=='true')) ? 'checked' : '' ?> />
                        <div class="name"><?php echo a("show");?>: <span class="star">*</span></div>					
                        <input type="checkbox" name="homepage" class="inp-check" <?php echo (($subaction=='edit')&&($edit["homepage"]=='true')) ? 'checked' : '' ?> />
					</div>
                    
                    <div class="list fix">
                        <div class="name"><?php echo a("description");?> <span class="star">*</span></div>                  
                        <input type="text" name="meta_desc" value="<?php echo ($subaction=='edit') ? $edit["meta_desc"] : '' ?>" class="inp"/>
                    </div>  
    
                    <div class="list2 fix">
                        <div class="name"><?php echo a("keywords");?> <span class="star">*</span></div>					
                        <input type="text" name="meta_keys" value="<?php echo ($subaction=='edit') ? $edit["meta_keys"] : '' ?>" class="inp"/>
                    </div>	

                    <div class="list fix">
                        <div class="name"><?php echo a("image");?>: <span class="star">*</span></div>					
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
                  
                    <!--<div class="list fix" style="display:none"><a href="javascript:$('#additional').slideToggle(); return void(0);"><strong>Click For Additional Colors...</strong></a></div>
                   
                   	<div style="display:none;" id="additional">

                    <div class="list2 fix">
                        <div class="name">Main Menu Color </div>                    
                        <input type="text" name="color1" value="<?php echo ($subaction=='edit') ? $edit["color1"] : '' ?>" class="inp"/>
                    </div>

                    <div class="list2 fix">
                        <div class="name">Page Title Color </div>					
                        <input type="text" name="color2" value="<?php echo ($subaction=='edit') ? $edit["color2"] : '' ?>" class="inp"/>
                    </div>	
    
                    <div class="list2 fix">
                        <div class="name">Alumni Color </div>					
                        <input type="text" name="color3" value="<?php echo ($subaction=='edit') ? $edit["color3"] : '' ?>" class="inp"/>
                    </div>	
    
                    <div class="list2 fix">
                        <div class="name">Announcements Color </div>					
                        <input type="text" name="color4" value="<?php echo ($subaction=='edit') ? $edit["color4"] : '' ?>" class="inp"/>
                    </div>	
    
                    <div class="list2 fix">
                        <div class="name">News Color </div>					
                        <input type="text" name="color5" value="<?php echo ($subaction=='edit') ? $edit["color5"] : '' ?>" class="inp"/>
                    </div>	
    
                    <div class="list2 fix">
                        <div class="name">Header Box Color </div>					
                        <input type="text" name="color6" value="<?php echo ($subaction=='edit') ? $edit["color6"] : '' ?>" class="inp"/>
                    </div>	
    
                    <div class="list2 fix">
                        <div class="name">Header Box Rgba </div>					
                        <input type="text" name="color7" value="<?php echo ($subaction=='edit') ? $edit["color7"] : '' ?>" class="inp"/>
                    </div>	
    
                    </div> -->
                </div>
            </div>
            
            <div id="t2">
                <div id="news">
                    <div class="list fix">
                        <div class="icon"><img src="_cadmin/img/minus.png" width="16" height="16" alt="" /></div>								
                        <div class="title"><?php echo a("shorttext");?>:</div>		
                    </div>	
                
                    <div class="list2 fix">
                        <div class="name"><?php echo a("description");?>: <span class="star">*</span></div>		
                        <textarea id="description" name="description" style="width:800px; height:300px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $edit["description"] : '' ?></textarea>
                    </div>	

                    <div class="list fix">
                        <div class="icon"><img src="_cadmin/img/minus.png" width="16" height="16" alt="" /></div>								
                        <div class="title"><?php echo a("pagecontent");?>:</div>		
                    </div>	
                    <div class="list2 fix">
                        <div class="name"><?php echo a("text");?>: <span class="star">*</span></div>		
                        <textarea id="text_content" name="content" style="width:800px; height:500px; margin-top:2px; margin-bottom:2px;"><?php echo ($subaction=='edit') ? $edit["content"] : '' ?></textarea>
                    </div>	
                </div>
            </div>
			</form>

            <div id="bottom" class="fix">
                <a href="javascript:v_save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:v_savenext();" class="button br"><?php echo a("save&next");?></a>
                <a href="javascript:v_saveclose();" class="button br"><?php echo a("save&close");?></a>
                <a href="<?php echo ahref('sitemap', 'show', $params);?>" class="button br"><?php echo a("cancel");?></a>
            </div>					
        </div>		
    </div>
<script language="javascript" type="text/javascript">
	$("#t2").hide();
	$("#t1").show();
	var section = 1;

	function v_tabswitch(i) {
		if(i=='general') { v_general() }
		if(i=='content') { v_content() }
	}

	function v_general() {
		$("#t1").hide();
		$("#t2").hide();
		$("#t1").show();
		section = 1;
		$('#b1').removeClass('button');
		$('#b2').removeClass('selbutton');
		$('#b1').addClass('selbutton');
		$('#b2').addClass('button');
		setFooter();
	}

	function v_content() {
		$("#t1").hide();
		$("#t2").hide();
		$("#t2").show();
		section = 2;
		$('#b1').removeClass('selbutton');
		$('#b2').removeClass('button');
		$('#b1').addClass('button');
		$('#b2').addClass('selbutton');
		setFooter();
	}

	function save() {
		if($("#category_change").val() > 7)
			$("#attached").val($("#attached1_change").val());
		document.dataform.submit();
	}
	
	function v_save() {
		if(section == 1) { $("#tabstop").val('general'); }
		if(section == 2) { $("#tabstop").val('content'); }
		save();
	}
	
	function v_savenext() {
		if(section == 1) { $("#tabstop").val('content'); }
		if(section == 2) { $("#tabstop").val('general'); }
		save();
	}
	
	function v_saveclose() {
		$("#tabstop").val('close');
		save();
	}
	
	$(document).ready(function() {
		v_tabswitch("<?php echo (isset($_GET["tabstop"])) ? $_GET["tabstop"] : 'general';?>");
	});
</script>