<?php
$class = 'list';
function _build_lists($parent, $order_by, $start = -1, $per_page)
{
	global $class;
	$limit = ($start == -1) ? "" : "LIMIT ".$start.", ".$per_page;
    $action = Storage::instance()->action;
    $sql = "SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND `deleted` = 0 AND masterid = {$parent} AND menuid = {$_GET['menu']} AND `title` LIKE '%" . get('srch', '') . "%' ORDER BY {$order_by} ".$limit.";";
    $results = db_fetch_all($sql);
    if (empty($results))
        return NULL;
//    $undeletable = c('section.undeletable');
    $total = count($results);
    $count = 1;
    foreach ($results AS $result):
		switch($result["category"]) {
			case 1:  $menutype = a("mt.text"); 			$menulink = ""; 			break;
			case 2:  $menutype = a("mt.home"); 			$menulink = ""; 			break;
			case 3:  $menutype = a("mt.about"); 		$menulink = ""; 			break;
			case 4:  $menutype = a("mt.searchresults"); $menulink = ""; 			break;
			case 5:  $menutype = a("mt.sitemap"); 		$menulink = ""; 			break;
			case 6:  $menutype = a("mt.feedback"); 		$menulink = ""; 			break;
			case 7:  $menutype = a("mt.plugin"); 		$menulink = ""; 			break;
			case 8:  $menutype = a("mt.news"); 			$menulink = "news"; 		break;
			case 9:  $menutype = a("mt.articles"); 		$menulink = "articles"; 	break;
			case 10: $menutype = a("mt.events"); 		$menulink = "events"; 		break;
			case 11: $menutype = a("mt.list"); 			$menulink = "list"; 		break;
			case 12: $menutype = a("mt.imagegallery"); 	$menulink = "imagegallery"; break;
			case 13: $menutype = a("mt.videogallery"); 	$menulink = "videogallery";	break;
			case 14: $menutype = a("mt.audiogallery"); 	$menulink = "audiogallery";	break;
			case 15: $menutype = a("mt.poll"); 			$menulink = "poll"; 		break;
			case 16: $menutype = a("mt.catalog"); 		$menulink = "catalog";		break;
			case 17: $menutype = a("mt.faq"); 			$menulink = "faq";			break;
		}
        $is_first = ($count == 1);
        $is_last = ($count >= $total);
        $arrow_up = $is_first ? '<img src="_manager/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref($action, 'move', array('where' => 'up', 'idx' => $result['idx'], 'menu' => $result['menuid'])) . '"><img src="_manager/img/buttons/icon_arrow_up_' . ($result['level'] > 4 ? 1 : $result["level"] - 1) . '.png" class="star" title="' .  a('tt.moveup') . '" width="9" height="9" /></a>';
        $arrow_down = $is_last ? '<img src="_manager/img/none.png" width="9" height="9" style="float:left;" />' : '<a href="' . ahref($action, 'move', array('where' => 'down', 'idx' => $result['idx'], 'menu' => $result['menuid'])) . '"><img src="_manager/img/buttons/icon_arrow_down_' . ($result['level'] > 4 ? 1 : $result["level"] - 1) . '.png" class="star" title="' .  a('tt.movedn') . '" width="9" height="9" /></a>';
        $edit_link = ahref($action, 'edit', array('menu' => $result['menuid'], 'idx' => $result['idx']));
		$arrows = $arrow_up . $arrow_down;
        $count++;
        $pad = NULL;
        $spad = NULL;
		$lnks = '';
		$lnke = '';
		if($class == 'list2') $class = 'list'; else $class = 'list2';
	    $sqlchilds = db_fetch("SELECT count(*) as cnt FROM ".c("table.pages")." WHERE masterid = {$result['idx']}");
		$bn = ($sqlchilds['cnt'] == 0) ? 'icons_down_bullet' : 'icons_up_bullet';
		$collapse = ($result['collapsed']==1) ? 'plus' : 'minus';
		if($sqlchilds['cnt'] == 0) $collapse = 'none';
		if($collapse == 'plus') { $lnks = '<a href="' . ahref($action, 'expand') . '&idx=' . $result['idx'] . '&menu=' . $result['menuid'] . '">'; $lnke = '</a>'; }
		if($collapse == 'minus') { $lnks = '<a href="' . ahref($action, 'collapse') . '&idx=' . $result['idx'] . '&menu=' . $result['menuid'] . '">'; $lnke = '</a>'; }
		$pad .= $lnks . '<img src="_manager/img/' . $collapse . '.png" width="16" height="16" style="margin:0 0 0 ' . ((($result['level'] - 1) * 25) + 5) . 'px;" >' . $lnke;		
		$pad .= '<img src="_manager/img/buttons/' . $bn . '.png" style="margin:0 10px 0 0;" >';
		$spad .= '<img src="_manager/img/none.png" style="margin:0 5px 0 ' . ((($result['level'] - 1) * 25) + 5) . 'px;" >&nbsp;';
		$ch = ($result["visibility"]=='true') ? '' : 'un';
?>
					
                    <div class="<?php echo $class;?> fix" id="div<?php echo $result["id"];?>" >
						<div class="check">
							<a href="javascript:chclick(<?php echo $result['idx'];?>);"><img src="_manager/img/buttons/icon_<?php echo $ch;?>visible.png" class="star" title="<?php echo a('tt.visibility');?>" id="img_<?php echo $result['idx'];?>" style="width:9px;height:9px;" /></a>
                            <input type="hidden" name="vis_<?php echo $result['idx'];?>" id="vis_<?php echo $result['idx'];?>" value="<?php echo $result['visibility'];?>" />
                        </div>
<?php if(is_from_list($result["menuid"])&&$result['menuid']!=15 ) {	?>						
						<div class="icon">&nbsp;</div>	
<?php } else { ?>
						<div class="icon"><?php echo $arrows;?>&nbsp;</div>
<?php } ?>                        
						<div class="name">
                        	<div class="arrows"><?php echo $pad;?></div>
                            <div class="links">
                                <a href="<?php echo ahref($action, 'edit', array('menu'=>$result['menuid'], 'id'=>$result["id"], 'idx'=>$result["idx"]));?>">
                                    <strong><span class="star" title="<?php echo $result["title"];?>">
                                        <?php echo mb_substr($result["title"],0,64,'UTF-8') . ((mb_strlen($result["title"],'UTF-8')>64) ? '...' : '');?>
                                    </span></strong>
                                </a>
                                <br />
									<a href="<?php echo c('site.url') . l() . '/' . $result["slug"];?>" target="_blank">
                                    	<span class="star" style="font-size:10px; color:#999" title="<?php echo c('site.url') . l() . '/' . $result["slug"].'/'.$result['id'] ;?>">
<?php echo mb_substr(c('site.url') . l() . '/' . $result["slug"], 0,84,'UTF-8') . ((mb_strlen(c('site.url') . l() . '/' . $result["slug"],'UTF-8')>84) ? '...' : '');?>
        	                    	</span>
                                </a>
                            </div>
                        </div>									
                        <div class="action fix">
                        	<a href="<?php echo href($result['id']) ?>" target="_blank"><img src="_manager/img/buttons/icon_preview.png" class="star" title="<?php echo a('ql.preview');?>" /></a>
                            <a href="<?php echo ahref($action, 'edit', array('menu'=>$result['menuid'], 'id'=>$result["id"], 'idx'=>$result["idx"]));?>"><img src="_manager/img/buttons/icon_edit.png" class="star" title="<?php echo a('ql.edit');?>" /></a>
<?php
	if(in_array($result["category"], array(8,9,10,11,12,13,14,15,16,17))) {
		$attachedid = db_retrieve('id', c("table.menus"), 'title', $result['attached'], ' and language = "'.l().'" LIMIT 1');
		switch($result["category"]) :
			case 12:
			case 13:
			case 14:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.galleries") . " WHERE `galleryid` = {$attachedid} AND `deleted` = 0;");		
				break;
			case 15:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.pollanswers") . " WHERE `pollid` = {$attachedid} AND `deleted` = 0;");		
				break;
			case 16:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.catalogs") . " WHERE `catalogid` = {$attachedid} AND `deleted` = 0;");		
				break;
			default:
				$page_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.pages") . " WHERE `menuid` = {$attachedid} AND `deleted` = 0;");		
				break;
		endswitch;
		$menulink1 = ($menulink == 'list') ? 'customlist' : $menulink;
?>
							<a href="<?php echo ahref($menulink1,'show', array('menu'=>$attachedid)) ?>"><img src="_manager/img/buttons/icon_files<?php echo ($page_count['cnt']==0)	? '' : '_r';?>.png" class="star" title="<?php echo a('ql.editcontent');?>" /></a>
<?php
	} else {
?>
							<a href="javascript:"><img src="_manager/img/buttons/icons_no_files.png" class="star" title="" style="width:15px;height:15px;" /></a>
<?php } ?>     
<?php                       
	$att_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.attached") . " WHERE `page` = {$result['idx']};");		
?>
                            <a href="<?php echo ahref('files', 'show', array('menu'=>$result['menuid'], 'id'=>$result["id"], 'idx'=>$result["idx"]));?>"><img src="_manager/img/buttons/icon_attach<?php echo ($att_count['cnt']==0)	? '' : '_r';?>.png" class="star" title="<?php echo a('ql.attachments');?>" /></a>
                            <a href="javascript:addr('Page Address:', '<?php echo href($result['id']) ?>');"><img src="_manager/img/buttons/icon_link.png" class="star" title="<?php echo a('ql.link');?>" /></a>
<?php if($action =='sitemap') : ?>
							<a href="<?php echo ahref($action, 'add', array('menu'=>$result['menuid'], 'id'=>$result["id"], 'idx'=>$result["idx"], 'level'=>$result["level"]));?>"><img src="_manager/img/buttons/icon_add.png" class="star" title="<?php echo a('ql.addsubpage');?>" /></a>
<?php endif; ?>
<?php
	$undeletable = 0;
	if((in_array($result["category"], array(8,9,10,11,12,13,14,15,16,17))) && ($page_count['cnt']>0)) $undeletable = 1;
	if($att_count['cnt']>0) $undeletable = 1;
	if($result["category"] == 2) $undeletable = 1;
	if(in_array($result["id"], c("section.site.undeletable"))) $undeletable = 1;
	$child_count = db_fetch("SELECT count(*) AS cnt FROM " . c("table.pages") . " WHERE `masterid` = {$result['idx']} AND `deleted` = 0;");		
	if($child_count['cnt']>0) $undeletable = 1;
	if($undeletable == 0) {
?>
                            <a href="javascript:del(<?php echo $result['id'];?>, '<?php echo $result['title'];?>');"><img src="_manager/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
<?php } else { ?>
							<a href="javascript:"><img src="_manager/img/buttons/icon_delete_inactive.png" class="star" title="" style="width:15px;height:15px;" /></a>
<?php } ?>     
                        </div>
						
						<div class="id"><?php echo $result["id"];?></div>
						<?php if(is_from_list($result["menuid"])) {	?>						
						<div class="date"><?php echo $result["pagedate"];?></div>
<?php } else { ?>
						<div class="date"><?php echo $menutype;?></div>
<?php } ?>                        
															

						
					</div>		
<?php
		if($result['collapsed']==0)	echo _build_lists($result['idx'], $order_by, 0, $per_page);
	endforeach;
}
?>
		<div id="title" class="fix">
			<div class="icon"><img src="_manager/img/table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $ttl;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
<?php if(is_from_list($_GET['menu'])) {	?>						
					<input type="text" class="inp" id="srch" name="srch" style="margin-top:0px;" value="<?php echo get('srch', ''); ?>" />
					<a href="javascript:srch();" class="button br"><?php echo a('search');?></a>
					<a href="<?php echo ahref($action, 'show', array('menu'=>$params['menu']));?>" class="button br"><?php echo a('reset');?></a>
<?php } ?>
					<a href="<?php echo ahref($action, 'add', array('menu'=>$params['menu'], 'level'=>0));?>" class="button br" style="float: right"><?php echo a('add');?></a>
				</div>	
				<div id="info">
                    <div class="list-top">
						<div class="vis"><?php echo a("vis");?>.</div>	
						<div class="pos"><?php echo a("pos");?>.</div>									
						<div class="name-title"><span style="padding-left:45px;"><?php echo a("name");?></span></div>									
						<div class="act fix"><?php echo a("actions");?></div>						
						<div class="pid">ID</div>
						<?php if(is_from_list($params['menu'])) {	?>						
						<div class="ptype"><?php echo a("date");?></div>									
						<?php } else { ?>
						<div class="ptype"><?php echo a("pagetype");?></div>									
						<?php } ?>                        
					</div>
<?php 
	$st = ($pager == 'true') ? $start : -1;
	
	$per_page = 20;
	switch($action) :
		case 'news': 
		case 'articles': 
		case 'events': 
			$per_page = a_s('news.per.page');
			break;
		case 'customlist': 
			$per_page = a_s('list.per.page');
			break;
	endswitch;

	echo _build_lists(0, $order_by, $st, $per_page) 
?>
				</div>	
				<div id="bottom" class="fix">
<?php
	if($pager == 'true') {
		$curpage = ceil(($start + 1) / $per_page);
		$firstpage = 1;
		$lastpage = ceil(($count) / $per_page);
		$prevpage = ($curpage == 1) ? 1 : $curpage - 1;
		$nextpage = ($curpage == $lastpage) ? $lastpage : $curpage + 1;
		$first = 0;
		$last = $per_page * ($lastpage - 1);
		$prev = $per_page * ($prevpage - 1);
		$next = $per_page * ($nextpage - 1);
?>
					<ul id="page" class="fix left" style="width:900px;">
						<li><a href="<?php echo ahref($action, $subaction, $params) . '&start=' . $first;?>"><img src="_manager/img/prev2.png" width="5" height="5" alt=""  class="arrow" /></a></li>
						<li><a href="<?php echo ahref($action, $subaction, $params) . '&start=' . $prev;?>"><img src="_manager/img/prev.png" width="5" height="5" alt=""  class="arrow" /></a></li>
<?php
		for($i = $firstpage; $i<=$lastpage; $i++) {
			$nst = $per_page * ($i - 1);
?>
						<li><?php echo ($i == $curpage) ? '<span style="color:#2e84d7; font-weight:bold;">' : '<a href="' . ahref($action, $subaction, $params) . '&start=' . $nst . '">';?><?php echo $i;?><?php echo ($i == $curpage) ? '</span>' : '</a>';?></li>
<?php } ?>
						<li><a href="<?php echo ahref($action, $subaction, $params) . '&start=' . $next;?>"><img src="_manager/img/next.png" width="5" height="5" alt="" class="arrow" /></a></li>
						<li><a href="<?php echo ahref($action, $subaction, $params) . '&start=' . $last;?>"><img src="_manager/img/next2.png" width="5" height="5" alt="" class="arrow" /></a></li>
					</ul>
<?php } ?>
<?php if($action=='sitemap') { ?>
					<a href="<?php echo ahref($action, 'collapseall', array('menu'=>$params['menu']));?>" class="button br"><?php echo a('collapse.all');?></a>
					<a href="<?php echo ahref($action, 'expandall', array('menu'=>$params['menu']));?>" class="button br"><?php echo a('expand.all');?></a>
<?php } ?>
					<a href="<?php echo ahref($action, 'add', array('menu'=>$params['menu'], 'level'=>0));?>" class="button br" style="float: right"><?php echo a('add');?></a>
				</div>					
			</div>		
		</div>
<script language="javascript">
function chclick(idx) {
	var active = ($('#vis_'+idx).val()=='false') ? 'true':'false'; 
	$.post("<?php echo ahref($action, 'visibility');?>&idx=" + idx + "&visibility=" + active + "&menu=" + <?php echo $params["menu"];?>, function() {
		if(active=='true') 
	        $('#img_'+idx).attr("src","_manager/img/buttons/icon_visible.png"); 
		else
	        $('#img_'+idx).attr("src","_manager/img/buttons/icon_unvisible.png"); 
		$('#vis_'+idx).val(active);
	});
};	

function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
//		window.location="<?php echo ahref($action,'delete');?>&id=" + id + "&menu=<?php echo $_GET["menu"];?>";
		
		$.post("<?php echo ahref($action, 'delete');?>&id=" + id + "&menu=<?php echo $_GET["menu"];?>", function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
			setFooter();
		});
	}
}

function addr(title, value) {
	prompt(title, value);
}

function srch() {
	window.location="<?php echo ahref($action, 'show', array('menu'=>$params['menu']));?>&srch=" + $("#srch").val();
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
