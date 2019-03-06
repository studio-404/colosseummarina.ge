		<div id="title" class="fix">
			<div class="icon"><img src="_manager/img/table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $title;?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
				</div>	
				<div id="news">
					<form id="dataform" name="dataform" method="post" action="<?php echo ahref($action, 'add', array('idx'=> $idx, 'menu'=> $menu));?>">
                    <input type="hidden" name="file_form_perform" value="1" />
                    <div class="list2 fix">
                        <div class="name"><?php echo a("title");?> <span class="star">*</span></div>					
                        <input type="text" name="title" value="<?php echo ($subaction=='edit') ? $edit["title"] : '' ?>" class="inp"/>
                    </div>	

                    <div class="list fix">
                        <div class="name"><?php echo a("addfiles");?>: <span class="star">*</span></div>					
                        <input type="text" id="path" name="path" value="<?php echo ($subaction=='edit') ? $edit["path"] : '' ?>" class="inp" style="width:500px;"/>
                        <a href="javascript:browse();" class="button br" ><?php echo a("browse");?></a>
<script language="JavaScript">
	function browse() {
		 aFieldName = 'path', aWin = window;
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

                    <!--<div class="list2 fix">
                        <div class="name">Link <span class="star">*</span></div>					
                        <input type="text" name="attachedlink" value="<?php echo ($subaction=='edit') ? $edit["attachedlink"] : '' ?>" class="inp"/>
                    </div>-->	

                    <div class="list fix">
						<a href="javascript:document.dataform.submit();" class="button br" style="float: right"><?php echo a('add');?></a>
					</div>
					</form>
				</div>                    
                <div id="info">
					<div class="list-top">
						<div class="id">ID</div>									
						<div class="icon">&nbsp;</div>									
						<div class="name-title" style="width:600px;"><?php echo a("name").', '.a("URL");?></div>									
						<div class="date">&nbsp;</div>									
						<div class="action fix"><?php echo a("actions");?></div>						
					</div>
<?php
	$class = 'list';
    $total = count($files);
    $count = 1;
	foreach($files as $file) :
        $is_first = ($count == 1);
        $is_last = ($count >= $total);
        $arrow_up = $is_first ? '<img src="_manager/img/none.png" width="10" height="7" />' : '<a href="' . ahref('files', 'move', array('where' => 'up', 'id' => $file['id'], 'menu' => $menu, 'idx'=> $idx)) . '"><img src="_manager/img/buttons/icon_arrow_up.png" class="star" title="' .  a('tt.moveup') . '" width="10" height="7" /></a>';
        $arrow_down = $is_last ? '<img src="_manager/img/none.png" width="10" height="7" />' : '<a href="' . ahref('files', 'move', array('where' => 'down', 'id' => $file['id'], 'menu' => $menu, 'idx'=> $idx)) . '"><img src="_manager/img/buttons/icon_arrow_down.png" class="star" title="' .  a('tt.movedn') . '" width="10" height="7" /></a>';
		$arrows = $arrow_up . $arrow_down;
        $count++;
		if($class == 'list2') $class = 'list'; else $class = 'list2';
		$ext = strtolower(substr(strrchr($file['path'], '.'), 1));
?>
					<div class="<?php echo $class;?> fix" id="div<?php echo $file["id"];?>">
						<div class="id"><?php echo $file['id']; ?></div>									
						<div class="icon"><img src="_manager/img/icons/<?php echo $ext;?>.gif" /></div>									
						<div class="icon"><?php echo $arrows;?></div>									
						<div class="name" style="white-space:nowrap;width:680px;"><?php echo $file['title'].'<br />'.$file['path'].'<br />'.$file['attachedlink']; ?>&nbsp;</div>									
						<div class="date">&nbsp;</div>	
						<ul class="action fix">
                        	<a href="#" target="_blank"><img src="_manager/img/buttons/icon_preview.png" class="star" title="<?php echo a('ql.preview');?>" /></a>
                            <a href="javascript:del(<?php echo $file['id'];?>, '<?php echo $file['title'];?>');"><img src="_manager/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</ul>									
					</div>		
<?php
	endforeach;
?>
                </div>
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('sitemap', 'edit', array('menu' => $menu, 'idx' => $idx));?>" class="button br"><?php echo a("cancel");?></a>
                </div>
			</div>		
		</div>
<script language="javascript">
function del(id, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		$.post("<?php echo ahref('files', 'delete');?>&id=" + id + "&idx=<?php echo $_GET["idx"];?>", function(){
			$("#div" + id).innerHTML = "";
			$("#div" + id).hide();
			setFooter();
		});
	}
}
</script>
