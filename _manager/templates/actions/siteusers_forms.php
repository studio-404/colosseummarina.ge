<?php defined('DIR') OR exit; ?>
    <div id="title" class="fix">
        <div class="icon"><img src="_manager/img/aduser.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo $title;?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
			</div>	
			<div id="news">
<?php $ulink = ($action=="add") ? ahref('siteusers', 'add') : ahref('siteusers', 'edit', array('id'=>$user["id"])); ?>
                <form id="catform" method="post" action="<?php echo $ulink;?>">
                   	<input type="hidden" name="users_form_submit" value="1" />
					<div class="list fix">
						<div class="icon"><a href="#"><img src="_manager/img/minus.png" width="16" height="16" alt="" /></a></div>								
						<div class="title"><?php echo $title;?>:</div>								
					</div>		
					
					<div class="list2 fix">
						<div class="name"><?php echo a("username");?>: <span class="star">*</span></div>					
						<input type="text" name="username" id="username" value="<?php echo ($action=="edit") ? $user["username"] : '' ;?>" class="inp-small"/>
						<div class="name"><?php echo a("nickname");?>: <span class="star">*</span></div>					
						<input type="text" name="nickname" id="nickname" value="<?php echo ($action=="edit") ? $user["nickname"] : '' ;?>" class="inp-small"/>
					</div>	

					<div class="list fix">
						<div class="name"><?php echo a("password");?>: <span class="star">*</span></div>					
						<input type="password" name="password" id="password" value="" class="inp-small"/>
						<div class="name"><?php echo a("repassword");?>: <span class="star">*</span></div>					
						<input type="password" name="password2" id="password2" value="" class="inp-small"/>
					</div>	

					<div class="list2 fix">
						<div class="name"><?php echo a("firstname");?>: </div>					
						<input type="text" name="firstname" id="firstname" value="<?php echo ($action=="edit") ? $user["firstname"] : '' ;?>" class="inp-small"/>
						<div class="name"><?php echo a("lastname");?>: </div>					
						<input type="text" name="lastname" id="lastname" value="<?php echo ($action=="edit") ? $user["lastname"] : '' ;?>" class="inp-small"/>
					</div>	
                    
					<div class="list fix">
						<div class="name"><?php echo a("personalid");?>: <span class="star">*</span></div>					
						<input type="text" name="personalid" id="personalid" value="<?php echo ($action=="edit") ? $user["personalid"] : '' ;?>" class="inp-small"/>
					</div>	

					<div class="list2 fix">
						<div class="name"><?php echo a("email");?>: <span class="star">*</span></div>					
						<input type="text" name="email" id="email" value="<?php echo ($action=="edit") ? $user["email"] : '' ;?>" class="inp-small"/>
						<div class="name"><?php echo a("usergroup");?>: </div>					
						<select name="usercat" id="usercat" class="inp-small">
                        	<option value="Guest" <?php echo (($action=="edit")&&($user["usercat"]=='Guest')) ? 'selected' : '' ;?>><?php echo a("guest");?></option>
                        	<option value="User" <?php echo (($action=="edit")&&($user["usercat"]=='User')) ? 'selected' : '' ;?>><?php echo a("user");?></option>
                        	<option value="Poweruser" <?php echo (($action=="edit")&&($user["usercat"]=='Poweruser')) ? 'selected' : '' ;?>><?php echo a("poweruser");?></option>
                        	<option value="Moderator" <?php echo (($action=="edit")&&($user["usercat"]=='Moderator')) ? 'selected' : '' ;?>><?php echo a("moderator");?></option>
                        	<option value="Administrator" <?php echo (($action=="edit")&&($user["usercat"]=='Administrator')) ? 'selected' : '' ;?>><?php echo a("administrator");?></option>
                        </select>
					</div>	
                    
					<div class="list fix">
						<div class="name"><?php echo a("companyname");?>: <span class="star">*</span></div>					
						<input type="text" name="companyname" id="companyname" value="<?php echo ($action=="edit") ? $user["companyname"] : '' ;?>" class="inp-small"/>
						<div class="name"><?php echo a("position");?>: <span class="star">*</span></div>					
						<input type="text" name="position" id="position" value="<?php echo ($action=="edit") ? $user["position"] : '' ;?>" class="inp-small"/>
					</div>	

					<div class="list2 fix">
						<div class="name"><?php echo a("mobile");?>: </div>					
						<input type="text" name="mobile" id="mobile" value="<?php echo ($action=="edit") ? $user["mobile"] : '' ;?>" class="inp-small"/>
						<div class="name"><?php echo a("phone");?>: </div>					
						<input type="text" name="phone" id="phone" value="<?php echo ($action=="edit") ? $user["phone"] : '' ;?>" class="inp-small"/>
					</div>	

					<div class="list fix">
						<div class="name"><?php echo a("address");?>: <span class="star">*</span></div>					
						<input type="text" name="address" id="address" value="<?php echo ($action=="edit") ? $user["address"] : '' ;?>" class="inp"/>
					</div>	
                    
                    <div class="list2 fix">
                        <div class="name"><?php echo a("avatar");?>: <span class="star">*</span></div>					
                        <input type="text" id="avatar" name="avatar" value="<?php echo ($action=='edit') ? $user["avatar"] : '' ?>" class="inp" style="width:500px;"/>
                        <a href="javascript:browse();" class="button br" ><?php echo a("browse");?></a>
<script language="JavaScript">
		function browse() {
			 aFieldName = 'avatar', aWin = window;
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
						<div class="name"><?php echo a("regdate");?>: <span class="star">*</span></div>					
						<input type="text" name="regdate" id="regdate" value="<?php echo ($action=="edit") ? date('Y-m-d', strtotime($user["regdate"])) : date('Y-m-d');?>" class="inp-small"/>
<script language="JavaScript">
	new tcal ({
		'formname': 'catform',
		'controlname': 'regdate',
	});
</script>
					</div>	

					<div class="list2 fix">
						<div class="name"><?php echo a("birthdate");?>: <span class="star">*</span></div>					
						<input type="text" name="birthdate" id="birthdate" value="<?php echo ($action=="edit") ? date('Y-m-d', strtotime($user["birthdate"])) : date('Y-m-d');?>" class="inp-small"/>
<script language="JavaScript">
	new tcal ({
		'formname': 'catform',
		'controlname': 'birthdate',
	});
</script>
					</div>	
                    
					<div class="list fix">
						<div class="name"><?php echo a("about");?>: <span class="star">*</span></div>					
						<input type="text" name="about" id="about" value="<?php echo ($action=="edit") ? $user["about"] : '' ;?>" class="inp"/>
					</div>	
                    
					<div class="list2 fix">
						<div class="name"><?php echo a("active");?>: </div>					
						<input type="checkbox" name="active" id="active" <?php echo (($action=="add")||(($action=="edit")&&($user["active"]=='1'))) ? 'checked' : '' ;?> />
					</div>	

					<div class="list fix">
						<div class="name"><?php echo a("banned");?>: </div>					
						<input type="checkbox" name="banned" id="banned" <?php echo (($action=="add")||(($action=="edit")&&($user["banned"]=='1'))) ? 'checked' : '' ;?> />
					</div>	
				</form>	
            
            </div>	
            <div id="bottom" class="fix">
                <a href="javascript:save();" class="button br"><?php echo a("save");?></a>
                <a href="javascript:history.back(-1);" class="button br"><?php echo a("cancel");?></a>
            </div>					
        </div>		
    </div>		
<script language="javascript">
	function save() {
		var validate = 0;
		var msg = "";
		if($("#username").val()=='') {
			msg = "<?php echo a('error.username');?>";
			validate = 0; 
		} else {
			validate = 1;
		}

		if(validate == 1) {		
			if($("#email").val()=='') {
				msg = "<?php echo a('error.email');?>";
				validate = 0; 
			} else {
				validate = 1;
			}
		}
<?php if($action=="add") { ?>
		if(validate == 1) {		
			if($("#password").val()=='') {
				msg = "<?php echo a('error.password');?>";
				validate = 0; 
			} else {
				validate = 1;
			}
		}
<?php } ?>
		if(validate == 1) {		
			if($("#password").val()!=$("#password2").val()) {
				msg = "<?php echo a('error.repassword');?>";
				validate = 0; 
			} else {
				validate = 1;
			}
		}
		
		if(validate == 1) {		
			this.catform.submit();
		} else {
			alert(msg);
		}
	};
</script>                
