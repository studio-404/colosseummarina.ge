<?php
	session_start();
	if(!isset($_SESSION["auth"])) exit;

die("You dont have permition!");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>elFinder</title>
	<link rel="stylesheet" href="js/ui-themes/base/ui.all.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<script src="js/jquery-1.4.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery-ui-1.7.3.custom.min.js" type="text/javascript" charset="utf-8"></script>

	<script src="js/elfinder.full.js" type="text/javascript" charset="utf-8"></script>
	<script language="javascript">
		function getWindowHeight() {
			var windowHeight = 0;
			if (typeof(window.innerHeight) == 'number') {
				windowHeight = window.innerHeight;
			}
			else {
				if (document.documentElement && document.documentElement.clientHeight) {
					windowHeight = document.documentElement.clientHeight;
				}
				else {
					if (document.body && document.body.clientHeight) {
						windowHeight = document.body.clientHeight;
					}
				}
			}
			return windowHeight;
		}

		$('#finder').height(getWindowHeight() - 240);
        $().ready(function() {
			var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
			var langCode = window.location.search.replace(/^.*langCode=([a-z]{2}).*$/, "$1");
            var f = $('#finder').elfinder({
                url : 'connectors/php/connector.php',
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
</head>
<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" rightmargin="0" >
	<div id="finder" style="padding:0; margin:0;">finder</div>
</body>
</html>
