<?php defined('DIR') OR exit; ?>
		<div id="title" class="fix">
			<div class="icon"><img src="_manager/img/buttons/_user.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo a("userlist");?></div>
		</div>	
		<div id="box">
			<div id="part">
				<div id="top" class="fix">
					<a href="<?php echo ahref('siteusers', 'add');?>" class="button br" style="float: right"><?php echo a("newuser");?></a>
				</div>	
				<div id="user">
					<div class="list-top">
						<div class="check"><?php echo a("active");?></div>
						<div class="check"><?php echo a("banned");?></div>
						<div class="name" style="width:280px;"><?php echo a("username");?></div>
						<div class="name" style="width:300px;"><?php echo a("name");?></div>
						<div class="fullname" style="width:90px;"><?php echo a("group");?></div>
						<div class="group" style="width:70px;">ID</div>
						<div class="action fix"><?php echo a("actions");?></div>
					</div>
<?php
	$class = 'list';
	foreach($data["users"] as $user) :
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ch = ($user["active"]=='1') ? '' : 'un';
		$bn = ($user["banned"]=='1') ? '' : 'un';
?>
					<div id="user" class="<?php echo $class;?> fix">
						<div class="check">
							<a href="javascript:chclick(<?php echo $user['id'];?>);"><img src="_manager/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $user['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $user['id'];?>" id="vis_<?php echo $user['id'];?>" value="<?php echo $user['active'];?>" />
                        </div>
						<div class="check">
							<a href="javascript:banclick(<?php echo $user['id'];?>);"><img src="_manager/img/buttons/icon_<?php echo $bn;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="bimg_<?php echo $user['id'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="ban_<?php echo $user['id'];?>" id="ban_<?php echo $user['id'];?>" value="<?php echo $user['banned'];?>" />
                        </div>
						<div class="name" style="width:280px;"><a href="<?php echo ahref('siteusers', 'edit', array('id' => $user['id']));?>"><?php echo $user["username"];?></a></div>
						<div class="name" style="width:300px;"><?php echo $user["firstname"].' '.$user["lastname"];?></div>
						<div class="fullname" style="width:90px;"><?php echo $user["usercat"];?></div>		
						<div class="group" style="width:70px;"><?php echo $user["id"];?></div>
						<div class="action fix" style="padding-top:6px; width:60px;">
							<a href="<?php echo ahref('siteusers', 'edit', array('id' => $user['id']));?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.editcontent');?>" /></a>
							<a href="javascript:del(<?php echo $user['id'];?>, '<?php echo $user['username'];?>');"><img src="_manager/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</div>
					</div>
<?php endforeach; ?>
				</div>	
<?php
	$uc = a_s("siteusers.per.page");
	$curpage = ceil((get("start", 0) + 1) / $uc);
	$firstpage = 1;
	$lastpage = ceil(($data["count"]) / $uc);
	$first = get("start", 0) - ($uc * 3);
	$j = ($curpage > 1) ? $curpage - 1 : 0; 
	$k = ($curpage < $lastpage) ? $curpage + 1 : $lastpage; 
?>
				<div id="bottom" class="fix">
					<ul id="page" class="fix left">
						<li><a href="<?php echo ahref('siteusers', 'show', array('start' => 0));?>"><img src="_manager/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref('siteusers', 'show', array('start' => $uc * ($j - 1)));?>"><img src="_manager/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
	for($i = $firstpage; $i<=$lastpage; $i++) {
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="'.ahref('siteusers', 'show', array('start' => $uc * ($i - 1))).'">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php
	}
?>
						<li><a href="<?php echo ahref('siteusers', 'show', array('start' => $uc * ($k - 1)));?>"><img src="_manager/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref('siteusers', 'show', array('start' => $uc * ($lastpage - 1)));?>"><img src="_manager/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
					<a href="<?php echo ahref('siteusersss', 'add');?>" class="button br" style="float: right"><?php echo a("newuser");?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function chclick(id) {
	var activity = ($('#vis_'+id).val()=='1') ? '0':'1'; 
	$.post("<?php echo ahref('siteusers', 'activity');?>&id=" + id + "&active=" + activity, function() {
		if(activity=='1') 
	        $('#img_'+id).attr("src","_manager/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+id).attr("src","_manager/img/buttons/icon_unvisible.png"); 
		$('#vis_'+id).val(activity);
	});
};	

function banclick(id) {
	var ban = ($('#ban_'+id).val()=='1') ? '0':'1'; 
	$.post("<?php echo ahref('siteusers', 'ban');?>&id=" + id + "&banned=" + ban, function() {
		if(ban=='1') 
	        $('#bimg_'+id).attr("src","_manager/img/buttons/icon_visible.png"); 
		else
	        $('#bimg_'+id).attr("src","_manager/img/buttons/icon_unvisible.png"); 
		$('#ban_'+id).val(ban);
	});
};	

function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		window.location="<?php echo ahref('siteusers','delete');?>&id=" + id;
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