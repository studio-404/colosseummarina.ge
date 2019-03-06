<?php
	defined('DIR') OR exit;
?>
    <div id="title" class="fix">
        <div class="icon"><img src="_manager/img/table.png" width="16" height="16" alt="" /></div>			
        <div class="name"><?php echo a("filemanager");?></div>
    </div>	
    <div id="box">
        <div id="part">
        	<div id="finder">File Manager</div> 
        </div>
    </div>
	<script language="javascript">
		$('#finder').height(getWindowHeight() - 240);
        $().ready(function() {
			var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
			var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");
            var f = $('#finder').elfinder({
                url : '<?php echo c('site.url') . JAVASCRIPT;?>/elfinder/connectors/php/connector.php',
                lang : 'en',
                editorCallback : function(url) {
					window.opener.CKEDITOR.tools.callFunction(funcNum, url);
			        window.close();
                }
            })
		})
		$('.el-finder-nav').height(getWindowHeight() - 306);
		$('.el-finder-cwd').height(getWindowHeight() - 306);
    </script>
