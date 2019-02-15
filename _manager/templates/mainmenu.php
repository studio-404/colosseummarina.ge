<?php defined('DIR') OR exit; ?>
<?php
	$menus = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="pages" order by type, title');
	$categories = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and (type="news" or type="articles" or type="events") order by type, title');
	$lists = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="list" order by type, title');
	$galleries = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type like "%gallery%" order by type, title');
	$polls = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="poll" order by type, title');
	$catalogs = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="catalog" order by type, title');
	$banners = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="banners" order by type, title');
	$faqs = db_fetch_all('select * from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="faq" order by type, title');

	$categories_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and (type="news" or type="articles" or type="events") order by type, title');
	$lists_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="list" order by type, title');
	$galleries_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type like "%gallery%" order by type, title');
	$polls_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="poll" order by type, title');
	$catalogs_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="catalog" order by type, title');
	$faqs_cnt = db_fetch('select count(*) as cnt from '.c('table.menus').' where language="'.l().'" and deleted=0 and type="faq" order by type, title');
?>
        <ul id="topnav" class="menu fix">
            <li>
            	<div class="rootmenu" >
					<a href="<?php echo ahref('main');?>"><?php echo a("home"); ?></a>
                </div>
                <ul></ul>
            </li>
<?php 
	if(getUserRight($_SESSION['auth']["id"], 'pages')) {
?>
			<li><div class="rootmenu" ><?php echo a("site"); ?></div>
                <div class="sub">
                    <ul>
<?php
	$cats = $menus;
	foreach($cats as $cat) :
?>                    
						<li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('sitemap','show', array('menu'=>$cat['id']));?>"><?php echo $cat["title"]; ?></a>
                            </div>
                        </li>
<?php
	endforeach;
?>
                        <li style="background:none;">
                            <div class="submenu1">
								<a href="<?php echo ahref('pages','show');?>"><?php echo a("menulist"); ?></a>
                            </div>
                        </li>
            		</ul>
                </div>
            </li>
<?php            
	}
	if(getUserRight($_SESSION['auth']["id"], 'files')) {
?>
			<li>
            	<div class="rootmenu" >
					<a href="<?php echo ahref('filemanager','show');?>"><?php echo a("filemanager"); ?></a>
                </div>
            </li>
<?php 
	}
	if(getUserRight($_SESSION['auth']["id"], 'modules')) {
?>       
			<li><div class="rootmenu" ><?php echo a("modules"); ?></div>
                <div class="sub">
                    <ul>
<?php
		if(getUserRight($_SESSION['auth']["id"], 'categories')) {
			if($categories_cnt["cnt"]>0) {
?>            
                        <li style="background:none;">
                            <div class="submenu">
								<a href="<?php echo ahref('categories','show');?>"><?php echo a("news.articles"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'lists')) {
			if($lists_cnt["cnt"]>0) {
?>            
                        <li style="background:none;">
                            <div class="submenu">
								<a href="<?php echo ahref('lists','show');?>"><?php echo a("lists"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'galleries')) {
			if($galleries_cnt["cnt"]>0) {
?>            
                        <li style="background:none;">
                            <div class="submenu">
								<a href="<?php echo ahref('gallerylist','show');?>"><?php echo a("galleries"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'polls')) {
			if($polls_cnt["cnt"]>0) {
?>            
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('polls','show');?>"><?php echo a("polls"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'catalogs')) {
			if($catalogs_cnt["cnt"]>0) {
?>            
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('catalogs','show');?>"><?php echo a("catalogs"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'faqs')) {
			if($faqs_cnt["cnt"]>0) {
?>            
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('faqs','show');?>"><?php echo a("faqs"); ?></a>
                            </div>
                        </li>
<?php
			}
		}
		if(getUserRight($_SESSION['auth']["id"], 'banners')) {
?>
                        <!-- <li style="background:none">
                            <div class="submenu1">
								<a href="<?php echo ahref('bannergroups','show');?>"><?php echo a("bannergroups"); ?></a>
                            </div>
                        </li> -->
<?php
		}
?>
    	            </ul>
        	    </div>
            </li>
<?php 
	}
	if(getUserRight($_SESSION['auth']["id"], 'users')) {
?>
            <li><div id="users" class="rootmenu" ><?php echo a("users"); ?></div>
                <div class="sub">
                    <ul>

<?php
		if(getUserRight($_SESSION['auth']["id"], 'users')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('users','show');?>"><?php echo a("userlist"); ?></a>
                            </div>
                        </li>
<?php 
		}
		if(getUserRight($_SESSION['auth']["id"], 'userrights')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('userrights','show');?>"><?php echo a("userrights"); ?></a>
                            </div>
                        </li>
<?php
		}
		if(getUserRight($_SESSION['auth']["id"], 'siteusers')) {
?>
                        <li style="background:none">
                            <div class="submenu1">
								<a href="<?php echo ahref('siteusers','show');?>"><?php echo a("siteuserlist"); ?></a>
                            </div>
                        </li>
<?php
		}
?>
                    </ul>
                </div>
            </li>
<?php 
	}
?>
            <li><div id="tools" class="rootmenu" ><?php echo a("tools"); ?></div>
                <div class="sub">
                    <ul>
<?php 
	if(getUserRight($_SESSION['auth']["id"], 'backup')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('backup','show');?>"><?php echo a("backup"); ?></a>
                            </div>
                        </li>
<?php 
	}
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('textconverter','show');?>"><?php echo a("textconverter"); ?></a>
                            </div>
                        </li>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('log','show');?>"><?php echo a("log"); ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            
<?php
	if((getUserRight($_SESSION['auth']["id"], 'settings'))||(getUserRight($_SESSION['auth']["id"], 'langdata'))||(getUserRight($_SESSION['auth']["id"], 'adminsettings'))) {
?>
            <li><div id="settings" class="rootmenu" ><?php echo a("settings"); ?></div>
                <div class="sub">
                    <ul>
<?php 
		if(getUserRight($_SESSION['auth']["id"], 'settings')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('settings','show');?>"><?php echo a("sitesettings"); ?></a>
                            </div>
                        </li>
<?php 
		}
		if(getUserRight($_SESSION['auth']["id"], 'langdata')) {
?>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('langdata','show');?>"><?php echo a("sitelanguagedata"); ?></a>
                            </div>
                        </li>
<?php 
		}
		if($_SESSION['auth']["class"]==0) {
?>
                        <li style="background:none;">
                            <div class="submenu1">
								<a href="<?php echo ahref('adminsettings','show');?>"><?php echo a("adminsettings"); ?></a>
                            </div>
                        </li>
<?php 
		}
?>
    	            </ul>
        	    </div>
            </li>
<?php 
	}
?>
            <!-- <li><div id="help" class="rootmenu" ><?php echo a("help"); ?></div>
                <div class="sub">
                    <ul>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('help','show');?>"><?php echo a("help"); ?></a>
                            </div>
                        </li>
                        <li style="background:none">
                            <div class="submenu">
								<a href="<?php echo ahref('about','show');?>"><?php echo a("about"); ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </li> -->
        	<!--<li class="last"><div id="tools" class="rootmenu" ><a href="<?php echo ahref('help','show');?>">Check</a></div></li>-->
        </ul>
<script language="javascript">
$(".rootmenu").mouseover(function(){
    	$(this).css('color', '#999999');
    }).mouseout(function(){
    	$(this).css('color', '#fff');
    });
$(".submenu").mouseover(function(){
    	$(this).css('background', '#575757');
    }).mouseout(function(){
    	$(this).css('background', '#494949');
    });
$(".submenu1").mouseover(function(){
    	$(this).css('background', '#575757');
    }).mouseout(function(){
    	$(this).css('background', '#494949');
    });
</script>
