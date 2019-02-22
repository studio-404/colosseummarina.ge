<?php defined('DIR') OR exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <base href="<?php echo href() ?>" />
        <meta http-equiv="content-type" content="text/html;charset=<?php echo c('output.charset') ?>" />
        <title>Digital Design Smart CMS</title>
        <link type="text/css" rel="stylesheet" href="<?php echo CMS;?>/css/style-en.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/css/dropdown.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/tigra-calendar/calendar.css">
        <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/elfinder/js/ui-themes/base/ui.all.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/elfinder/css/elfinder.css" media="screen" title="no title" charset="utf-8">
	    <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/tiptip/tipTip.css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/css/lightbox.css" />       
		<link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/custom.css">        
        
		<script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery-1.4.1.min.js"></script>
	    <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/tiptip/jquery.tipTip.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.dropdown.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.hoverIntent.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.modal.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.history.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.bgiframe.js"></script>
		<script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.lightbox-slideshow.js" ></script>
		<?php 
            $ttip = 0;
            if(isset($_SESSION['auth']) AND !empty($_SESSION['auth']) AND isset($_GET['subaction']) AND $_GET['subaction'] !='show') 
                $ttip = 1;
            if(!(isset($_SESSION['auth']) AND !empty($_SESSION['auth']))) 
                $ttip = 1;
            if($ttip == 1) {	
        ?>        
		<script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.colortip-1.0.js"></script>
		<?php } ?>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/height-cms.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/base64.js"></script>
		<script type="text/javascript" src="<?php echo JAVASCRIPT;?>/tigra-calendar/calendar_<?php echo c("languages.admin");?>.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/elfinder/js/jquery-ui-1.7.3.custom.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/elfinder/js/elfinder.full.js" charset="utf-8"></script>
		<script type="text/javascript" type="text/javascript">
			tinyMCE.init({ 
				// General Options 
				mode : "exact", 
				elements : "text_content, text_content2, text_content3, text_content4, description, contact, review", 
				entity_encoding: "named",
				entities: "160,nbsp",
				
				skin : "default",
				skin_variant : "silver",
				theme : "advanced", 
				plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template", 
				// Theme Options 
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect", 
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate, inserttime, preview,|,forecolor,backcolor", 
				theme_advanced_buttons3 :  "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen", 
				theme_advanced_toolbar_location : "top", 
				theme_advanced_toolbar_align : "left", 
				theme_advanced_statusbar_location : "bottom", 
				theme_advanced_resizing : true, 
				cleanup : false,
				convert_urls : false,
				//				relative_urls : false,
				//				remove_script_host : false,
				//				document_base_url : "<?php echo href() ?>",				
				// File Browser 
				file_browser_callback: function(field_name, url, type, win) {
					 aFieldName = field_name, aWin = win;
					 if($('#elfinder').length == 0) {
						 $('body').append($('<div/>').attr('id', 'elfinder'));
						 $('#elfinder').elfinder({
							 url : '<?php echo c('site.url') . JAVASCRIPT;?>/elfinder/connectors/php/connector.php',
							 dialog : { width: 750, modal: true, title: 'Files', zIndex: 400001 }, // open in dialog window
							 editorCallback: function(url) {
								 aWin.document.forms[0].elements[aFieldName].value = url;
							 },
							 closeOnEditorCallback: true
						 });
					 } else {
						 $('#elfinder').elfinder('open');
					 }
				 }
			}); 
		</script>
    </head>
    <body>
        <div id="digital">
            <div id="header">
                <a href="<?php echo ahref('main') ?>"><img src="<?php echo CMS;?>/img/logo.png" width="300" height="23" alt="" id="logo"/></a>
                <a href="<?php echo ahref('access', 'logout') ?>" id="logout"><?php echo a("logout");?></a>
                <span id="welcome">
					<?php echo a("user"); ?>: 
                	<span id="welcome_user"><?php echo $_SESSION['auth']['username'] ?></span> 
                    (<?php echo $_SESSION['auth']['usercat'] ?>)
                </span>
            </div>
			<!-- CMS Main Menu -->
            <div id="mainmenu"><?php require(CMS . "/templates/mainmenu.php"); ?></div>
			<!-- CMS Main Menu -->
			<!-- Site Language Switcher -->
            <div id="language"><?php require(CMS . "/templates/language.php"); ?></div>
			<!-- Site Language Switcher -->
            <div class="clear"></div>
            <div id="line"></div>
			<!-- CMS Content -->
            <div id="content">
				<?php 
                    $action = Storage::instance()->action;
                    if($action == 'filemanager') {
                        require(CMS . '/templates/actions/filemanager.php');
                    }elseif(($action == 'main')||($action == ''))
                        require(CMS . '/templates/actions/home.php');
                    else
                        echo $content;
                ?>
			</div>
			<!-- CMS Content -->
            <div id="preloader"><img src="_cadmin/img/preloader.gif"  /></div>
        </div>
        <!-- Footer -->
        <div id="footer">
            <div class="part">
                <div class="menu"><a href="<?php echo ahref('terms', 'show') ?>"><?php echo a("terms");?></a> &nbsp; | &nbsp; <a href="<?php echo ahref('privacy', 'show') ?>"><?php echo a("privacy");?></a></div>
                <div class="contact">For support call: +995 32 2473211,  E-mail: <a href="mailto:info@digitaldesign.ge">info@digitaldesign.ge</a></div>
                <div class="copyright"><?php echo a("copyright"); ?></div>		
            </div>
        </div>
        <!-- Footer -->
        <div id="tiptip_holder" class="tip_left_top">
            <div id="tiptip_content">
                <div id="tiptip_arrow">
                    <div id="tiptip_arrow_inner"></div>
                </div>
            </div>
        </div>
		<script type="text/javascript">
            $(function(){
                $(".star").tipTip();
                $('.preview').lightBox({slideshow: false, nextSlideDelay: 10000, fixedNavigation: true, imgdir: "<?php echo JAVASCRIPT;?>/images/"});
            });
        </script>
    </body>
</html>