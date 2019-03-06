<script type="text/javascript" src="_javascript/jquery/jquery.form.js"></script>
<script>
	$(document).ready(function() {
	//elements
		var progressbox     = $('#progressbox');
		var progressbar     = $('#progressbar');
		var statustxt       = $('#statustxt');
		var submitbutton    = $("#SubmitButton");
		var myform          = $("#UploadForm");
		var output          = $("#output");
		var completed       = '0%';

		$("#dataform").ajaxForm({
			beforeSend: function() { //brfore sending form
				submitbutton.attr('disabled', ''); // disable upload button
				statustxt.empty();
				$("#progress").text("0%");
			},
			uploadProgress: function(event, position, total, percentComplete) { //on progress
				$("#progress").text(percentComplete + '%'); //update status text
			},
			complete: function(response) { // on complete
				$("#progress").text("COMPLETE");
			}
		});
	});

</script>

<?php
	$curnews=db_fetch("select * from catalogs where language='".l()."' and id=".$id);
	$folder = './files/_tour_images/';
	if(!file_exists($folder)) :
		mkdir($folder);
	endif;
//	$folder .= date('Y-m-d', strtotime($curnews["pagedate"]));
	$folder .= $curnews["id"];
	if(!file_exists($folder)) :
		mkdir($folder);
	endif;
?>		
		<div id="title" class="fix">
			<div class="icon"><img src="_manager/img/table.png" width="16" height="16" alt="" /></div>			
			<div class="name"><?php echo $curnews["title"];?></div>
		</div>	

		<div id="box">
			<div id="part">
				<div id="top" class="fix">
				</div>	
				<div id="news">
					<form id="dataform" name="dataform" method="post" action="<?php echo ahref($action, 'upload', array('idx'=> $curnews["idx"], 'id'=> $curnews["id"], 'menu'=> $menu));?>" enctype="multipart/form-data">
                    <input type="hidden" name="file_form_perform" value="1" />
                    <input type="hidden" name="folder" value="<?php echo $folder;?>" />
                    <div class="list2 fix">
                        <div class="name">Upload File: <span class="star">*</span></div>					
                        <input type="file" name="file[]" value="" multiple style="float: left"/>
						<a href="javascript:document.dataform.submit();" class="button br" style="float: left">Upload</a>
						<div id="progress" style="float:right;">&nbsp;</div>
                    </div>	
					</form>
				</div>                    
                <div id="info">
					<div class="list-top">
						<div class="id">&nbsp;</div>									
						<div class="icon">&nbsp;</div>									
						<div class="name-title" style="width:600px;"><?php echo a("name").', '.a("URL");?></div>									
						<div class="date">&nbsp;</div>									
						<div class="action fix"><?php echo a("actions");?></div>						
					</div>
<?php
	if(file_exists($folder)) :
		$files=scandir($folder);
		foreach($files as $file) :
			if($file !='.' && $file !='..') :
?>
					<div class="list2 fix" id="div_<?php echo $file;?>">
						<div class="id">&nbsp;</div>									
						<div class="icon">&nbsp;</div>									
						<div class="name" style="width:100px;">
<?php if(strtolower(substr(strrchr($file, '.'), 1))!='flv' && strtolower(substr(strrchr($file, '.'), 1))!='mp4') { ?>
							<img src="<?php echo $folder . '/' . $file; ?>" width="100" />
<?php } ?>								
							&nbsp;
						</div>									
						<div class="name" style="width:580px;"><?php echo $file; ?>&nbsp;</div>									
						<div class="date">&nbsp;</div>	
						<ul class="action fix">
                        	<a href="<?php echo $folder . '/' . $file; ?>" target="_blank"><img src="_manager/img/buttons/icon_preview.png" class="star" title="<?php echo a('ql.preview');?>" /></a>
                            <a href="javascript:del('<?php echo $curnews["id"];?>', '<?php echo $file;?>', '<?php echo $file;?>');"><img src="_manager/img/buttons/icon_delete.png" class="star" title="<?php echo a('ql.delete');?>" /></a>
						</ul>		
						<div style="clear:both;"></div>
					</div>		
<?php
			endif;
		endforeach;
	endif;
?>
                </div>
				<div id="bottom" class="fix">
					<a href="<?php echo ahref('news', 'edit', array('menu' => $menu, 'idx' => $curnews["idx"], 'id' => $id));?>" class="button br">Back</a>
	                <a href="<?php echo ahref('news', 'show', array('menu' => $menu));?>" class="button br">Save & Close</a>

                </div>
			</div>		
		</div>
<script language="javascript">
function del(folder, file, title) {
	if (confirm("<?php echo a("deletequestion"); ?>" + title + "?")) { 
		$.post("<?php echo ahref('uploadfiles', 'delete');?>&folder=" + folder + "&file=" + file + "&idx=<?php echo $curnews["idx"];?>", function(){
			$("#div_" + file).innerHTML = "";
			$("#div_" + file).hide();
			setFooter();
			location.reload();
		});
	}
}
</script>
