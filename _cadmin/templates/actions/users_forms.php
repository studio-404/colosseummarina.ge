<?php defined('DIR') OR exit; ?>
    <div id="title" class="fix">
        <div class="icon"><img src="_cadmin/img/aduser.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo $title;?></div>
    </div>	

    <div id="box">
        <div id="part">
            <div id="top" class="fix">
			</div>	
			<div id="news">
<?php $ulink = ($action=="add") ? ahref('users', 'add') : ahref('users', 'edit', array('id'=>$user["id"])); ?>
                <form id="catform" method="post" action="<?php echo $ulink;?>">
                   	<input type="hidden" name="users_form_submit" value="1" />
					<div class="list fix">
						<div class="icon"><a href="#"><img src="_cadmin/img/minus.png" width="16" height="16" alt="" /></a></div>								
						<div class="title"><?php echo $title;?>:</div>								
					</div>		
					
					<div class="list2 fix">
						<div class="name"><?php echo a("username");?>: <span class="star">*</span></div>					
						<input type="text" name="username" id="username" value="<?php echo ($action=="edit") ? $user["username"] : '' ;?>" class="inp-small"/>
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
						<div class="name"><?php echo a("email");?>: <span class="star">*</span></div>					
						<input type="text" name="email" id="email" value="<?php echo ($action=="edit") ? $user["email"] : '' ;?>" class="inp-small"/>
						<div class="name"><?php echo a("usergroup");?>: </div>					
						<select name="usercat" id="usercat" class="inp-small">
                        	<option value="Administrator" <?php echo (($action=="edit")&&($user["usercat"]=='Administrator')) ? 'selected' : '' ;?>><?php echo a("administrator");?></option>
                        	<option value="User" <?php echo (($action=="edit")&&($user["usercat"]=='User')) ? 'selected' : '' ;?>><?php echo a("user");?></option>
                        	<option value="Guest" <?php echo (($action=="edit")&&($user["usercat"]=='Guest')) ? 'selected' : '' ;?>><?php echo a("guest");?></option>
                        </select>
					</div>	

					<div class="list2 fix">
						<div class="name"><?php echo a("active");?>: </div>					
						<input type="checkbox" name="active" id="active" <?php echo (($action=="add")||(($action=="edit")&&($user["active"]=='1'))) ? 'checked' : '' ;?> />
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
