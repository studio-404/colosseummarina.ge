<?php

defined('DIR') OR exit;

class Admin_Manager
{
    protected $action = 'main',
    $subaction,
    $content,
    $actions = array(),
    $navigation = array();

    public function __construct()
    {
        $this->action = Storage::instance()->action;
        $this->subaction = Storage::instance()->subaction;
        (isset($_SESSION['auth']) AND !empty($_SESSION['auth'])) AND v() OR $this->access();
		$this->write_log();
    }

	public function write_log() 
	{
		$ipaddress = get_ip() . ' : '. $_SERVER['REMOTE_ADDR'];
		switch($this->action) :
			case 'files': 			$pagetitle = 'File Attachements'; break;
			case 'poll': 			$pagetitle = 'Poll Management'; break;
			case 'polls': 			$pagetitle = 'Polls Management'; break;
			case 'catalog': 		$pagetitle = 'Catalog Management'; break;
			case 'catalogs': 		$pagetitle = 'Catalogs Management'; break;
			case 'pages': 			$pagetitle = 'Sitemap Management'; break;
			case 'sitemap': 		$pagetitle = 'Site Map'; break;
			case 'faq': 			$pagetitle = 'FAQ Management'; break;
			case 'faqs':	 		$pagetitle = 'FAQ Pages Management'; break;
			case 'news': 			$pagetitle = 'News List'; break;
			case 'customnews': 		$pagetitle = 'News List'; break;
			case 'articles': 		$pagetitle = 'Article List'; break;
			case 'events': 			$pagetitle = 'Event List'; break;
			case 'lists': 			$pagetitle = 'Lists Management '; break;
			case 'customlist': 		$pagetitle = 'List Management'; break;
			case 'videogallery': 	$pagetitle = 'Video gallery'; break;
			case 'imagegallery': 	$pagetitle = 'Image gallery'; break;
			case 'audiogallery': 	$pagetitle = 'Audio gallery'; break;
			case 'bannergroups': 	$pagetitle = 'Banner Group Management'; break;
			case 'banners': 		$pagetitle = 'Banner Management'; break;
			case 'gallerylist': 	$pagetitle = 'Gallery Management'; break;
			case 'settings': 		$pagetitle = 'Site Settings'; break;
			case 'adminsettings': 	$pagetitle = 'Admin Settings'; break;
			case 'langdata': 		$pagetitle = 'Site Phrases'; break;
			case 'users': 			$pagetitle = 'User Management'; break;
			case 'siteusers': 		$pagetitle = 'Site User Management'; break;
			case 'userrights': 		$pagetitle = 'User Right Management'; break;
			case 'filemanager': 	$pagetitle = 'File Manager'; break;
			case 'backup': 			$pagetitle = 'Database Backup'; break;
			case 'textconverter': 	$pagetitle = 'Text Converter'; break;
			case 'log': 			$pagetitle = 'Admin Log'; break;
			default: 				$pagetitle = 'Main'; break;
		endswitch;
		$menu = get('menu', '0');
		$lang = l();
		
		$href = $_SERVER['REQUEST_URI'];
		$sql='insert into ' . c('table.log') . ' (user, action, subaction, menu, language, visitdate, href, ipaddress, pagetitle) values ("' . $_SESSION['auth']['username'] . '", "' . $this->action . '", "' . $this->subaction . '", "' . $menu . '",  "' . $lang . '", "' . date('Y-m-d H:i:s') . '", "' . $href . '", "' . $ipaddress . '", "' . $pagetitle . '");';
		db_query($sql);
	}

    public function __toString()
    {
        return template('layout', array(
            'header' => template('header', array(
                'action' => $this->action,
                'subaction' => $this->subaction
            )),
            'left' => template('left', array(
                'action' => $this->action,
                'navigation' => $this->navigation
            )),
            'content' => $this->content,
            'footer' => template('footer'),
        ));
    }

    public function access()
    {
        $tpl['message'] = '';
        switch ($this->subaction):
            case 'login':
                post('perform') === FALSE AND redirect(ahref());
                $username = db_escape($_POST['username']);
                $password = sha1(md5(db_escape($_POST['password'])));
                $sql = "SELECT * FROM users WHERE username = '{$username}' AND userpass = '{$password}' LIMIT 1;";
                $user = db_fetch($sql);
                if (empty($user))
                {
                    $tpl['message'] = a('admin.incorrect_password');
                    break;
                }
				if((strtoupper(a_s("ipprotection"))=='YES')&&($user["class"]=='1')) {
					$ip_list=explode(',', a_s("iplist"));
					$in_array = 0;
					foreach($ip_list as $key=>$value) : 
						$cur_ip = trim(get_ip(), ' ');
						if($cur_ip == trim($value)) $in_array = 1;
					endforeach;
					if($in_array==0)
//					if(!in_array($cur_ip, $ip_list))
					{
						$tpl['message'] = a('admin.access_denied');
						break;
					}
				}
                session_regenerate_id();
                $_SESSION['auth'] = $user;
				if(getUserRight($_SESSION['auth']["id"], get('action',''), get('subaction','')))
	                redirect(ahref());
				else
	                redirect(ahref('main'));
                break;
            case 'logout':
                if (isset($_SESSION['auth']) AND !empty($_SESSION['auth']))
                {
                    unset($_SESSION['auth']);
                    redirect(ahref());
                }
                redirect(ahref());
                break;
        endswitch;
        exit(template('access', $tpl));
    }

    protected function _lists($order_by = 'position', $pager = 'false', $title='sitemap', $form_template = 'actions/_lists_forms', $list_template = 'actions/_lists')
    {
		$start=0; if(isset($_GET["start"])) $start=$_GET["start"];
        $tpl = $params = array();
		$cnt = db_fetch('SELECT count(*) AS cnt FROM `'.c("table.pages").'` WHERE language="'.l().'" AND deleted=0 AND menuid="'.$_GET['menu'].'" AND `title` LIKE "%' . get('srch', '') . '%";');
		$tpl["count"] = $cnt["cnt"];
		$tpl["start"] = $start;
        isset($_GET['start']) AND $params['start'] = $_GET['start'];
        isset($_GET['menu']) AND $params['menu'] = $_GET['menu'];
        isset($_GET['id']) AND $params['id'] = $_GET['id'];
        isset($_GET['idx']) AND $params['idx'] = $_GET['idx'];
        isset($_GET['level']) AND $params['level'] = $_GET['level'];
        $tpl['action'] = $this->action;
        $tpl['subaction'] = $this->subaction;
        $tpl['params'] = $params;
//		$menu = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = ". get("menu", 0));
		$mtitle = db_retrieve('title', c("table.menus"), 'id', get("menu", 0), ' and language = "'.l().'" LIMIT 1');
        $tpl['title'] = a($title) .': '. db_retrieve('title', c("table.menus"), 'id', get("menu", 0), ' and language = "'.l().'" LIMIT 1');
   		$mttl = (in_array($_GET["action"], array('pages', 'bannergroups'))) ? $mtitle : db_retrieve('title', c("table.pages"), 'attached', $mtitle, ' and language = "'.l().'" LIMIT 1');
        $tpl['ttl'] = a($title) .': '. $mttl;
        $tpl['edit'] = array();
        $tpl['pager'] = $pager;
		$lng = l();
        switch ($this->subaction):
            case 'show':
                $tpl['order_by'] = $order_by;
                $this->content = template($list_template, $tpl);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.pages"), array('visibility' => $_GET['visibility']), "WHERE `idx` = {$_GET['idx']}");
				$this->content = $update;
                db_query($update);
                break;
            case 'delete':
// AJAX CALL
				$category = db_retrieve('category', c("table.pages"), 'id', $_GET['id'], "AND language = '{$lng}' LIMIT 1");
                $delete_sql = "UPDATE `".c("table.pages")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
				if(in_array($category, array(8,9,10,11,12,13,14,15,16,17))) {
					$attached = db_retrieve('attached', c("table.pages"), 'id', $_GET['id'], "AND language = '{$lng}' LIMIT 1");
					$attached_id = db_retrieve('id', c("table.menus"), 'title', $attached, "AND language = '{$lng}' LIMIT 1");
                    $languages = c('languages.all');
					db_query("DELETE FROM `" . c("table.menus") . "` WHERE id={$attached_id}");
				}
                db_query($delete_sql);
                break;
            case 'collapse':
                $collapse_sql = "UPDATE `".c("table.pages")."` SET `collapsed` = 1 WHERE `idx` = {$_GET['idx']};";
                db_query($collapse_sql);
                redirect(ahref($this->action, 'show', $params));
                break;
            case 'expand':
                $collapse_sql = "UPDATE `".c("table.pages")."` SET `collapsed` = 0 WHERE `idx` = {$_GET['idx']};";
                db_query($collapse_sql);
                redirect(ahref($this->action, 'show', $params));
                break;
            case 'collapseall':
                $collapse_sql = "UPDATE `".c("table.pages")."` SET `collapsed` = 1 WHERE `language` = '{$lng}' AND `menuid` = {$_GET['menu']};";
                db_query($collapse_sql);
                redirect(ahref($this->action, 'show', $params));
                break;
            case 'expandall':
                $collapse_sql = "UPDATE `".c("table.pages")."` SET `collapsed` = 0 WHERE `language` = '{$lng}' AND `menuid` = {$_GET['menu']};";
                db_query($collapse_sql);
                redirect(ahref($this->action, 'show', $params));
                break;
            case 'move':
                $sql = "SELECT idx, level, position, masterid FROM `".c("table.pages")."` WHERE `idx` = {$_GET['idx']} LIMIT 1;";
                $result = db_fetch($sql);
				$pos1 = $result['position'];
                switch ($_GET['where']):
                    case 'up':
                        $pos_sql = "< {$result['position']} ORDER BY `position` DESC";
                        break;
                    case 'down':
                        $pos_sql = "> {$result['position']} ORDER BY `position`";
                        break;
                endswitch;
                $sql = "SELECT idx, level, position, masterid FROM `".c("table.pages")."` WHERE `language` = '" . l() . "' AND `menuid` = '{$_GET['menu']}' AND `masterid` = {$result['masterid']} AND `level` = {$result['level']} AND `deleted` = 0 AND `position` {$pos_sql} LIMIT 1;";
                $result = db_fetch($sql);
				$pos2 = $result['position'];
                $update1 = db_update(c("table.pages"), array('position' => $pos2), "WHERE `idx` = {$_GET['idx']} LIMIT 1;");
                db_query($update1);
                $update2 = db_update(c("table.pages"), array('position' => $pos1), "WHERE `idx` = {$result['idx']} LIMIT 1;");
                db_query($update2);
                redirect(ahref($this->action, 'show', $params));
                break;
			case 'add':
                if (isset($_POST['perform']) && !empty($_POST['title'])):
// ADD TOPIC		
					if(isset($_POST["category"])) {
						if(in_array($_POST["category"], array(8,9,10,11,12,13,14,15,16,17))) {
							switch($_POST["category"]) {
								case 8:  $menutype = "news"; break;
								case 9:  $menutype = "articles"; break;
								case 10: $menutype = "events"; break;
								case 11: $menutype = "list"; break;
								case 12: $menutype = "imagegallery"; break;
								case 13: $menutype = "videogallery"; break;
								case 14: $menutype = "audiogallery"; break;
								case 15: $menutype = "poll"; break;
								case 16: $menutype = "catalog"; break;
								case 17: $menutype = "faq"; break;
							}
							$id = db_fetch('select max(id) as maxid from `'.c("table.menus").'`');
							$new_id = $id["maxid"]+1;
							foreach(c('languages.all') as $language) :
								$insert = db_insert(c("table.menus"), array(
											'title' => $menutype . $new_id,
											'items_per_page' => c('news.per_page'),
											'items_on_homepage' => c('news.per_page'),
											'id' => $new_id,
											'language' => $language,
											'type' => $menutype
										));
								db_query($insert);
							endforeach;
							$_POST['attached'] = $menutype . $new_id;
						}
					}
// ADD TOPIC				
                    $new_id_res = db_fetch("SELECT MAX(`id`) AS `num` FROM `".c("table.pages")."`;");
                    $new_id = $new_id_res['num'] + 1;
                    $languages = c('languages.all');
					$page = "";
                    $page = isset($_POST['page']) ? $_POST["page"] : '';
					$tabstop = $_POST["tabstop"];
                    if (!empty($languages))
                    {
						$level=0;
						if (isset($_POST['level_num']))
						{
							$level = $_POST['level_num'] + 1;
							unset($_POST['level_num']);
						}
                        $master_id = isset($_GET['idx']) ? db_retrieve('id', c("table.pages"), 'idx', $_GET['idx']) : 0;
						$title = $_POST['title'];
						$slug = empty($_POST['slug']) ? $_POST['title'] : $_POST['slug'];
						$pagetime = $_POST["pagetime"];
						$expiretime = $_POST["expiretime"];
						$_POST["pagedate"] .= ' ' . $pagetime;
						$_POST["expiredate"] .= ' ' . $expiretime;
						$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 'true' : 'false';
						$_POST["visibility"] = $vis;
						$show = ((isset($_POST["homepage"])) && ($_POST["homepage"] == 'on')) ? 'true' : 'false';
						$_POST["homepage"] = $show;
                        foreach ($languages as $language)
                        {
                            unset($_POST['perform'], $_POST['attached1'], $_POST['idx'], $_POST["page"], $_POST["expiretime"], $_POST["pagetime"], $_POST["tabstop"]);
                            $_POST['id'] = $new_id;
                            $_POST['masterid'] = isset($_GET['idx']) ? db_retrieve('idx', c("table.pages"), 'id', $master_id, "AND language = '{$language}' LIMIT 1") : 0;							
                            $_POST['language'] = $language;
                            $_POST['level'] = $level;
                            $_POST['title'] = ($language == l()) ?  $title : $title . ' (' . strtoupper($language) . ')';
                            $_POST['slug'] = new_slug($slug, $_POST['masterid'], FALSE);
	                    	$pos_res = db_fetch("SELECT MAX(`position`) AS `pos` FROM " . c("table.pages") . " WHERE `masterid` = {$_POST['masterid']};");
                    		$new_pos = $pos_res['pos'] + 1;
                            $_POST['position'] = $new_pos;
                            empty($_POST['pagedate']) AND $_POST['pagedate'] = date('Y-m-d');
                            empty($_POST['expiredate']) AND $_POST['expiredate'] = date('Y-m-d');
                            $insert = db_insert(c("table.pages"), $_POST);
                            db_query($insert);
                        }
                    }
					$params['id'] = $new_id;
					$idx_sql = db_fetch("SELECT idx FROM `".c("table.pages")."` WHERE `id` = {$new_id} AND `language`= '".l()."' LIMIT 1;");
					$params['idx'] = $idx_sql["idx"];
					$params["page"] = $page;
					if($tabstop == 'close') 
    	                redirect(ahref($this->action, 'show', $params));
					$params["tabstop"] = $tabstop;
                    redirect(ahref($this->action, 'edit', $params));
	                break;
                endif;
                $tpl['subtitle'] = 'Insert new record';
				$tpl["menuclass"] = db_retrieve('type', c("table.menus"), 'id', $_GET['menu'], ' LIMIT 1');
                $this->content = template($form_template, $tpl);
                break;
            case 'edit':
                if (isset($_POST['perform']) && !empty($_POST['title'])):
// ADD TOPIC		
					$cur_category = db_retrieve('category', c("table.pages"), 'idx', get("idx", 0), ' LIMIT 1');
					if(isset($_POST["category"])) {
						if($cur_category!=$_POST["category"]) {
							if(in_array($_POST["category"], array(8,9,10,11,12,13,14,15,16,17))) {
								switch($_POST["category"]) {
									case 8:  $menutype = "news"; break;
									case 9:  $menutype = "articles"; break;
									case 10: $menutype = "events"; break;
									case 11: $menutype = "list"; break;
									case 12: $menutype = "imagegallery"; break;
									case 13: $menutype = "videogallery"; break;
									case 14: $menutype = "audiogallery"; break;
									case 15: $menutype = "poll"; break;
									case 16: $menutype = "catalog"; break;
									case 17: $menutype = "faq"; break;
								}
								$id = db_fetch('select max(id) as maxid from `'.c("table.menus").'`');
								$new_id = $id["maxid"]+1;
								foreach(c('languages.all') as $language) :
									$insert = db_insert(c("table.menus"), array(
												'title' => $menutype . $new_id,
												'items_per_page' => c('news.per_page'),
												'items_on_homepage' => c('news.per_page'),
												'id' => $new_id,
												'language' => $language,
												'type' => $menutype
											));
									db_query($insert);
								endforeach;
								$_POST['attached'] = $menutype . $new_id;
								$cur_id = db_retrieve('id', c("table.pages"), 'idx', get("idx", 0), ' LIMIT 1');
			                    $update = db_query("UPDATE `" . c("table.pages") ."` set `attached`='" . $menutype . $new_id . "', `category` = '" . $_POST["category"] . "' WHERE id = {$cur_id} ");
							}
						}
					}
// ADD TOPIC				
					$tabstop = $_POST["tabstop"];
					$pagetime = $_POST["pagetime"];
					$expiretime = $_POST["expiretime"];
					$_POST["pagedate"] .= ' ' . $pagetime;
					$_POST["expiredate"] .= ' ' . $expiretime;
                    $page = isset($_POST['page']) ? $_POST["page"] : '';
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 'true' : 'false';
					$_POST["visibility"] = $vis;
					$show = ((isset($_POST["homepage"])) && ($_POST["homepage"] == 'on')) ? 'true' : 'false';
					$_POST["homepage"] = $show;
                    unset($_POST['perform'], $_POST['attached1'], $_POST['idx'], $_POST["page"], $_POST["expiretime"], $_POST["pagetime"], $_POST["tabstop"]);
                    if (isset($_POST['level_num']))
                        unset($_POST['level_num']);
// CHANGE CHILDRESN SLUGS
//					$new_slug = $_POST['slug'];
					$new_slug = isset($_POST['slug']) ? $_POST['slug'] : '';
					$cur_slug = db_retrieve('slug', c("table.pages"), 'idx', get("idx", 0), ' LIMIT 1');
// CHANGE CHILDRESN SLUGS
                    $_POST['slug'] = new_slug((empty($_POST['slug']) ? $_POST['title'] : $_POST['slug']), $_GET['idx'], TRUE);
                    empty($_POST['pagedate']) AND $_POST['pagedate'] = date('Y-m-d');
                    $update = db_update(c("table.pages"), $_POST, "WHERE idx = {$_GET['idx']} LIMIT 1");
                    db_query($update);
// CHANGE CHILDRESN SLUGS
					if (strpos($cur_slug, '/') !== false) $cur_slug = substr(strrchr($cur_slug, '/'), 1);
					if($cur_slug!=$new_slug) $this->change_children_slugs(get("idx", 0));
// CHANGE CHILDRESN SLUGS
					$params["page"] = $page;
					if($tabstop == 'close') 
    	                redirect(ahref($this->action, 'show', $params));
					$params["tabstop"] = $tabstop;
   	                redirect(ahref($this->action, 'edit', $params));
                endif;
                $edit_data_sql = "SELECT * FROM `".c("table.pages")."` WHERE `idx` = {$_GET['idx']} LIMIT 1;";
                $tpl['edit'] = db_fetch($edit_data_sql);
                empty($tpl['edit']) AND $tpl['edit'] = array();
				$slugpos = strpos($tpl['edit']['slug'], '/');
				if ($slugpos !== false) {
					$tpl['edit']['slug'] = substr(strrchr($tpl['edit']['slug'], '/'), 1);
				}
                $tpl['subtitle'] = 'Edit record';
                $tpl['edit_mode'] = TRUE;
				$tpl["menuclass"] = db_retrieve('type', c("table.menus"), 'id', $_GET['menu'], ' LIMIT 1');
                $this->content = template($form_template, $tpl);
                break;
        endswitch;
    }
	
	public function change_children_slugs($idx) 
	{
		$children = db_fetch_all("SELECT * FROM `".c("table.pages")."` WHERE `masterid` = {$idx};");
		foreach($children as $child) :
			$slug = substr(strrchr($child['slug'], '/'), 1);
			$new_slug = new_slug($slug, $child['idx'], TRUE);
			$res = db_query("UPDATE `".c("table.pages")."` SET `slug` = '" . $new_slug . "' WHERE `idx` = '" . $child['idx'] . "';");
			$this->change_children_slugs($child['idx']);
		endforeach;
	}

//////////////////////////////////////////////////
///////////// DO NOT EDIT ABOVE !!! //////////////
//////////////////////////////////////////////////

    public function main()
    {
        $this->content = template('actions/main');
    }

    public function sitemap()
    {
        $this->_lists('position', 'false', 'sitemap');
    }

    public function news()
    {
        $this->_lists('pagedate DESC', 'true', 'newslist');
    }

    public function customnews()
    {
        $this->_lists('pagedate DESC', 'true', 'customnews');
    }

    public function events()
    {
        $this->_lists('pagedate DESC', 'true', 'eventlist');
    }

    public function articles()
    {
        $this->_lists('position', 'true', 'articlelist');
    }

    public function customlist()
    {
        $this->_lists('position', 'true', 'customlist', 'actions/_lists_document_forms', 'actions/_lists_document');
    }

    function banners()
    {
        $this->_lists('position', 'true', 'bannerlist', 'actions/_lists_banner_forms', 'actions/_lists_banner');
    }

    function faq()
    {
        $this->_lists('position', 'true', 'faq', 'actions/_lists_faq_forms', 'actions/_lists_faq');
    }

    function settings()
    {
        switch ($this->subaction):
            case 'show':
                $sql = db_fetch_all("SELECT * FROM `".c("table.settings")."` WHERE `deleted` = 0 AND `language` = '".l()."' order by id;");
                $data["settings"] = $sql;
                $data["section"] = "settings";
				$data["title"] = a('sitesettings');
                $this->content = template('actions/settings_list', $data);
                break;
            case 'delete':
                $sql = "UPDATE `".c("table.settings")."` SET `deleted` = 1 WHERE `key` = '{$_GET['key']}';";
                db_query($sql);
                redirect(ahref('settings', 'show'));
                break;
            case 'add':
                if (isset($_POST['settings_form_perform'])):
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.settings"), array(
									'key' => $_POST["key"], 
									'value' => $_POST["value"], 
									'title' => $_POST["title"], 
									'language' => $language 
								));
						db_query($insert);
					endforeach;
                    redirect(ahref('settings', 'show'));
                endif;
				$data["action"] = 'add';
				$data["title"] = a('addsetting');
                $data["section"] = "settings";
				$data["title"] = a('sitesettings');
                $this->content = template('actions/settings_forms', $data);
                break;
            case 'edit':
                if (isset($_POST['settings_form_perform'])):
					$data['value'] = $_POST["value"];
                    $update = db_update(c("table.settings"), $data, "WHERE `language` = '".l()."' AND `deleted` = 0 AND `key` = '{$_GET['key']}';");
                    db_query($update);
                    redirect(ahref('settings', 'show'));
                endif;
                $data["setting"] = db_fetch("SELECT * FROM `".c("table.settings")."` WHERE `language` = '".l()."' AND `deleted` = 0 AND `key` = '{$_GET['key']}';");
				$data["action"] = 'edit';
                $data["section"] = "settings";
				$data["title"] = $_GET['key'];
				$data["title"] = a('sitesettings');
                $this->content = template('actions/settings_forms', $data);
                break;
        endswitch;
    }
	
    function adminsettings()
    {
        switch ($this->subaction):
            case 'show':
                $sql = db_fetch_all("SELECT * FROM `".c("table.admin_settings")."` WHERE `deleted` = 0 AND `language` = '".l()."' ;");
                $data["settings"] = $sql;
                $data["section"] = "adminsettings";
				$data["title"] = a('adminsettings');
                $this->content = template('actions/settings_list', $data);
                break;
            case 'delete':
                $sql = "UPDATE `".c("table.admin_settings")."` SET `deleted` = 1 WHERE `key` = '{$_GET['key']}';";
                db_query($sql);
                redirect(ahref('adminsettings', 'show'));
                break;
            case 'add':
                if (isset($_POST['settings_form_perform'])):
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.admin_settings"), array(
									'key' => $_POST["key"], 
									'value' => $_POST["value"], 
									'title' => $_POST["title"], 
									'language' => $language 
								));
						db_query($insert);
					endforeach;
                    redirect(ahref('adminsettings', 'show'));
                endif;
				$data["action"] = 'add';
				$data["title"] = a('addsetting');
                $data["section"] = "adminsettings";
				$data["title"] = a('adminsettings');
                $this->content = template('actions/settings_forms', $data);
                break;
            case 'edit':
                if (isset($_POST['settings_form_perform'])):
					$data['value'] = $_POST["value"];
                    $update = db_update(c("table.admin_settings"), $data, "WHERE `language` = '".l()."' AND `deleted` = 0 AND `key` = '{$_GET['key']}';");
                    db_query($update);
                    redirect(ahref('adminsettings', 'show'));
                endif;
                $data["setting"] = db_fetch("SELECT * FROM `".c("table.admin_settings")."` WHERE `language` = '".l()."' AND `deleted` = 0 AND `key` = '{$_GET['key']}';");
				$data["action"] = 'edit';
				$data["title"] = $_GET['key'];
                $data["section"] = "adminsettings";
				$data["title"] = a('adminsettings');
                $this->content = template('actions/settings_forms', $data);
                break;
        endswitch;
    }
	
    function langdata()
    {
        switch ($this->subaction):
            case 'show':
                $sql = db_fetch_all("SELECT * FROM `".c("table.language_data")."` WHERE `deleted` = 0 AND `language` = '".l()."' order by id desc;");
                $data["sitelang"] = $sql;
                $this->content = template('actions/sitelang_list', $data);
                break;
            case 'delete':
                $sql = "UPDATE `".c("table.language_data")."` SET `deleted` = 1 WHERE `key` = '{$_GET['key']}';";
                db_query($sql);
                redirect(ahref('langdata', 'show'));
                break;
            case 'add':
                if (isset($_POST['sitelang_form_perform'])):
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.language_data"), array(
									'key' => $_POST["key"], 
									'value' => $_POST["value"], 
									'title' => $_POST["title"], 
									'language' => $language 
								));
						db_query($insert);
					endforeach;
                    redirect(ahref('langdata', 'show'));
                endif;
				$data["action"] = 'add';
				$data["title"] = a('addstring');
                $this->content = template('actions/sitelang_forms', $data);
                break;
            case 'edit':
                if (isset($_POST['sitelang_form_perform'])):
					$data['value'] = $_POST["value"];
                    $update = db_update(c("table.language_data"), $data, "WHERE `key` = '{$_GET['key']}' AND `deleted` = 0 AND `language` = '".l()."';");
                    db_query($update);
                    redirect(ahref('langdata', 'show'));
                endif;
                $data["sitelang"] = db_fetch("SELECT * FROM `".c("table.language_data")."` WHERE `language` = '".l()."' AND `deleted` = 0 AND `key` = '{$_GET['key']}';");
				$data["action"] = 'edit';
				$data["title"] = $_GET['key'];
                $this->content = template('actions/sitelang_forms', $data);
                break;
        endswitch;
    }

    function _gallery()
	{
        $par = array();
        if (isset($_GET['menu']))
        {
            $par['menu'] = $_GET['menu'];
        }
        if (isset($_GET['id']))
        {
            $par['id'] = $_GET['id'];
        }
        switch ($this->subaction):
            case 'show':
				$gallery = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = ". get("menu", 0));
                $sql = db_fetch_all("SELECT * FROM `".c("table.galleries")."` WHERE `deleted` = 0 and `language` = '".l()."' and `galleryid` = ". get("menu", 0) ." ORDER BY `position`;");
				$data["title"] = $gallery["title"];
                $data["images"] = $sql;
                $this->content = template('actions/' . $this->action . '_list', $data);
                break;
            case 'add':
                if (isset($_POST[$this->action . '_form_perform']) && !empty($_POST['title'])):
					if(!isset($_POST['file2'])) $_POST['file2'] = $_POST['file'];
					$id=db_fetch('select max(id) as maxid from `'.c("table.galleries").'`');
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 'true' : 'false';
					$newid=$id["maxid"]+1;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.galleries"), array(
									'galleryid' => $_GET['menu'],
									'file' => $_POST['file'],
									'file2' => $_POST['file2'],
									'id' => $newid,
									'position' => $newid,
									'title' => $_POST['title'],
									'visibility' => $vis,
									'itemlink' => post('itemlink', ''),
									'description' => post('text_description', ''),
									'postdate' => $_POST['postdate'].' '.$_POST['posttime'],
									'language' => $language
								));
						db_query($insert);
					endforeach;
                    redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                endif;
                $this->content = template('actions/' . $this->action . '_forms', array('menu' => $_GET["menu"], 'action' => $this->action, 'subaction' => $this->subaction));
                break;
            case 'edit':
                if (isset($_POST[$this->action . '_form_perform']) && !empty($_POST['title'])):
					$visibility = ((isset($_POST['visibility'])) && ($_POST['visibility'] == 'on')) ? 'true' : 'false';
					if(!isset($_POST['file2'])) $_POST['file2'] = $_POST['file'];
                    $data = array(
                        'galleryid' => $_GET['menu'],
                        'idx' => $_GET['idx'],
                        'file' => $_POST['file'],
                        'file2' => $_POST['file2'],
                        'title' => $_POST['title'],
						'itemlink' => post('itemlink', ''),
                        'description' => post('text_description', ''),
                        'visibility' => $visibility,
                        'postdate' => $_POST['postdate'].' '.$_POST['posttime'],
                        'language' => l()
                    );
                    $insert = db_update(c("table.galleries"), $data, "WHERE `idx` = {$_GET['idx']}");
                    db_query($insert);
                    redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                endif;
                $edit_data = db_fetch("SELECT * FROM `".c("table.galleries")."` WHERE `idx` = {$_GET['idx']};");
                $temp_keys = array();
                $edit = array(
                    'title' => a("editimage"),
                    'action' => $this->action,
                    'subaction' => $this->subaction,
                    'file' => $edit_data['file'],
                    'file2' => $edit_data['file2'],
                    'itemlink' => $edit_data['itemlink'],
                    'idx' => $edit_data['idx'],
                    'title' => $edit_data['title'],
                    'visibility' => $edit_data['visibility'],
                    'postdate' => $edit_data['postdate'],
					'menu' => $edit_data['galleryid'],
                    'description' => $edit_data['description']
                );
                $this->content = template('actions/' . $this->action . '_forms', $edit);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.galleries"), array('visibility' => $_GET['visibility']), "WHERE `idx` = {$_GET['idx']}");
                db_query($update);
                break;
            case 'delete':
                $delete_sql = "UPDATE `".c("table.galleries")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($delete_sql);
                redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                break;
            case 'move':
                $res = db_fetch("SELECT * FROM `".c("table.galleries")."` WHERE `idx` = {$_GET['idx']};");
                $pos1 = $res['position'];
                $idx1 = $_GET['idx'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `".c("table.galleries")."`.`position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `".c("table.galleries")."`.`position` ASC";
                        break;
                endswitch;
                $sql = "SELECT * FROM `".c("table.galleries")."` WHERE `".c("table.galleries")."`.`language` = '" . l() . "' AND `galleryid` = '{$_GET['menu']}' AND `".c("table.galleries")."`.`position` {$pos_sql} LIMIT 1;";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $idx2 = $res['idx'];
                $update1 = db_update(c("table.galleries"), array('position' => $pos2), "WHERE `idx` = {$idx1}");
                $update2 = db_update(c("table.galleries"), array('position' => $pos1), "WHERE `idx` = {$idx2}");
                db_query($update1);
                db_query($update2);
                redirect(ahref($this->action, 'show', $par));
                break;
        endswitch;
	}

	function imagegallery()
	{
		$this->_gallery();
	}

	function videogallery()
	{
		$this->_gallery();
	}

	function audiogallery()
	{
		$this->_gallery();
	}

    function users()
    {
        switch ($this->subaction):
            case 'show':
                $sql = db_fetch_all("SELECT * FROM `".c("table.users")."` WHERE `class` = 1 AND `deleted` = 0 ORDER BY `username` LIMIT " . get("start", 0) . ", " . a_s("users.per.page") . ";");
                $cnt = db_fetch("SELECT COUNT(*) AS cnt FROM `".c("table.users")."` WHERE `class` = 1 AND `deleted` = 0;");
                $data["users"] = $sql;
				$data["count"] = $cnt["cnt"];
                $this->content = template('actions/users_list', array('data' => $data));
                break;
            case 'delete':
                $sql = "UPDATE `".c("table.users")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($sql);
                redirect(ahref('users', 'show'));
                break;
            case 'add':
                if (isset($_POST['users_form_submit'])):
					$active = (isset($_POST["active"])) ? 1 : 0;
                    $insert = db_insert(c("table.users"), array(
								'firstname' => $_POST["firstname"], 
								'lastname' => $_POST["lastname"], 
								'username' => $_POST["username"], 
                                'userpass' => sha1(md5($_POST['password'])),
								'email' => $_POST["email"], 
								'usercat' => $_POST["usercat"], 
								'active' => $active					
		                    ));
                    db_query($insert);
                    redirect(ahref('users', 'show'));
                endif;
				$data["action"] = 'add';
				$data["title"] = a('adduser');
                $this->content = template('actions/users_forms', $data);
                break;
            case 'edit':
                if (isset($_POST['users_form_submit'])):
					$active = (isset($_POST["active"])) ? 1 : 0;
					$data['firstname'] = $_POST["firstname"];
				  	$data['lastname'] = $_POST["lastname"]; 
				  	$data['username'] = $_POST["username"]; 
				  	$data['email'] = $_POST["email"]; 
				  	$data['usercat'] = $_POST["usercat"]; 
				  	$data['active'] = $active;				
                    if (!($_POST['password']==''))
                    {
                        $data['userpass'] = sha1(md5($_POST['password']));
                    }
                    $update = db_update(c("table.users"), $data, "WHERE `id` = {$_GET['id']}");
                    db_query($update);
                    redirect(ahref('users', 'show'));
                endif;
                $data["user"] = db_fetch("SELECT * FROM `".c("table.users")."` WHERE `id` = {$_GET['id']};");
				$data["action"] = 'edit';
				$data["title"] = a('edituser');
                $this->content = template('actions/users_forms', $data);
                break;
            case 'activity':
                $update = db_update(c("table.users"), array('active' => $_GET['active']), "WHERE `id` = {$_GET['id']}");
                db_query($update);
                break;
        endswitch;
    }

    function _topics($type = "pages")
    {
        if (isset($_GET['menu']))
        {
            $par['menu'] = $_GET['menu'];
        }
		switch($type) {
			case 'categories':
				$titleshow = a("categories");
				$titleedit = a("editcategory");
				$titleadd = a("addcategory");
				$mtype = 'news';
				break;
			case 'lists':
				$titleshow = a("listtypes");
				$titleedit = a("editlisttype");
				$titleadd = a("addlisttype");
				$mtype = 'list';
				break;
			case 'gallerylist':
				$titleshow = a("gallerylist");
				$titleedit = a("editgallery");
				$titleadd = a("addgallery");
				$mtype = 'gallery';
				break;
			case 'bannergroups':
				$titleshow = a("banners");
				$titleedit = a("editbannergroups");
				$titleadd = a("addbannergroups");
				$mtype = 'banners';
				break;
			case 'polls':
				$titleshow = a("polls");
				$titleedit = a("editpolls");
				$titleadd = a("addpolls");
				$mtype = 'poll';
				break;
			case 'catalogs':
				$titleshow = a("catalogs");
				$titleedit = a("editcatalogs");
				$titleadd = a("addcatalogs");
				$mtype = 'catalog';
				break;
			case 'faqs':
				$titleshow = a("faqs");
				$titleedit = a("editfaqs");
				$titleadd = a("addfaqs");
				$mtype = 'faq';
				break;
			default:
				$titleshow = a("menulist");
				$titleedit = a("editmenu");
				$titleadd = a("addmenu");
				$mtype = 'pages';
				break;
		}
        switch ($this->subaction):
            case 'show':
				if($mtype == 'news') 		$filter = '`type` in ("news", "articles", "events")';
				elseif($mtype == 'list') 	$filter = '`type` = "list"';
				else 						$filter = '`type` like "%'.$mtype.'%"';
                $sql = db_fetch_all('select * from `'.c("table.menus").'` where '.$filter.' and deleted=0 and language="'.l().'" order by `title`;');
                $data["type"] = $type;
                $data["topics"] = $sql;
				$data["title"] = $titleshow;
				$data["add"] = $titleadd;
				$data["menutype"] = $mtype;
                $this->content = template('actions/topics_list', $data);
                break;
            case 'add':
                if (isset($_POST['topics_form_perform']) && !empty($_POST['title'])):
					$id=db_fetch('select max(id) as maxid from `'.c("table.menus").'`');
					$newid=$id["maxid"]+1;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.menus"), array(
									'title' => $_POST['title'],
									'items_per_page' => $_POST['items_per_page'],
									'items_on_homepage' => $_POST['items_on_homepage'],
									'id' => $newid,
									'language' => $language,
									'type' => $_POST['menutype']
								));
						db_query($insert);
					endforeach;
                    redirect(ahref($type, 'show', isset($_GET['menu']) ? $par : NULL));
                endif;
				$data["title"] = $titleadd;
				$data["action"] = 'add';
				$data["type"] = $type;
				$data["menutype"] = $mtype;
                $this->content = template('actions/topics_forms', $data);
                break;
            case 'edit':
                if (isset($_POST['topics_form_perform']) && !empty($_POST['title'])):
                    $data = array(
                        'title' => $_POST['title'],
						'items_per_page' => $_POST['items_per_page'],
						'items_on_homepage' => $_POST['items_on_homepage']
                    );
                    $update = db_update(c("table.menus"), $data, "WHERE `idx` = {$_GET['idx']}");
                    db_query($update);
                    redirect(ahref($type, 'show', isset($_GET['menu']) ? $par : NULL));
                endif;
                $edit_data = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `idx` = {$_GET['idx']};");
				$data["data"] = $edit_data;
				$data["title"] = $titleedit;
				$data["type"] = $type;
				$data["action"] = 'edit';
				$data["menutype"] = $mtype;
                $this->content = template('actions/topics_forms', $data);
                break;
            case 'delete':
                $sql = "UPDATE `".c("table.menus")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($sql);
                redirect(ahref($type, 'show'));
                break;
        endswitch;
    }

    function pages()
    {
		$this->_topics('pages');
	}

    function bannergroups()
    {
		$this->_topics('bannergroups');
	}

    function polls()
    {
		$this->_topics('polls');
	}

    function catalogs()
    {
		$this->_topics('catalogs');
	}

    function categories()
    {
		$this->_topics('categories');
	}

    function lists()
    {
		$this->_topics('lists');
	}

    function faqs()
    {
		$this->_topics('faqs');
	}

    function gallerylist()
    {
		$this->_topics('gallerylist');
	}

    function filemanager()
    {
       	$this->content = template('actions/filemanager', array('title' => ''));
	}

    function textconverter()
    {
       	$this->content = template('actions/textconverter', array('title' => ''));
	}

	function _zip_directory($directory, $zip) {
		if ($handle = opendir($directory)) {
		    while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(is_dir($directory . $file)) {
						$this->_zip_directory($directory . $file . '/', $zip);
					} else {
						$zip->addFile($directory . $file);
					}
				}
			}
			closedir($handle); 
		}
	}

    function backup()
    {
        switch ($this->subaction):
			case 'show':
		       	$this->content = template('actions/backup', array('title' => ''));
				break;
			case 'delete':
				unlink("backup/" . $_GET["file"]); 
                redirect(ahref('backup', 'show'));
				break;
			case 'create':
				$backup = '';
				$tablelist = db_fetch_all("show tables");
				foreach($tablelist as $table) :
					$t = $table["Tables_in_".c("database.name")];
					$createtable = db_fetch("show create table ".$t);
					$backup .= $createtable["Create Table"].';'."\n";
					$tablecontent = db_fetch_all("select * from ".$t);
					foreach($tablecontent as $records) :
						$fieldnames = "";
						$fieldvalues = "";
						foreach($records as $key=>$value) :
							$fieldnames .= $key.',';
							$fieldvalues .= '"'.$value.'",';
						endforeach;
						$fieldnames = str_lreplace(',','',$fieldnames);
						$fieldvalues = str_lreplace(',','',$fieldvalues);
						$backup .= 'insert into '.$t.'('.$fieldnames.') values ('.$fieldvalues.');'."\n";
					endforeach;
				endforeach;
				file_put_contents(c('folders.backup') . 'db_backup_'.date("Y-m-d_H.i.s").'.sql', $backup);
				$zip = new ZipArchive();
				if ($zip->open(c('folders.backup') . 'file_backup_'.date("Y-m-d_H.i.s").'.zip', ZIPARCHIVE::CREATE) === TRUE) {
					$this->_zip_directory(c('folders.upload'), $zip);
				}
				$zip->close();
                redirect(ahref('backup', 'show'));
				break;
			default:
		       	$this->content = template('actions/backup', array('title' => ''));
				break;
		endswitch;
	}

    function files()
    {
        $data = array();
        switch ($this->subaction):
            case 'add':
                if (isset($_POST['file_form_perform']))
                {
                    $pos_res = db_fetch("SELECT MAX(`position`) AS `pos` FROM " . c("table.attached") . " WHERE `page` = {$_GET['idx']};");
                    $pos = $pos_res['pos'] + 1;
                    $insert = db_insert(c("table.attached"), array(
                                'page' => $_GET['idx'],
                                'path' => $_POST['path'],
                                'title' => $_POST['title'],
                                'position' => $pos
                            ));
                    db_query($insert);
                    redirect(ahref('files', 'show', array('idx' => $_GET['idx'], 'menu'=> $_GET['menu'])));
                }
                $data['edit'] = false;
                break;
            case 'move':
                $sql = "SELECT id, position FROM `".c("table.attached")."` WHERE `id` = {$_GET['id']} LIMIT 1;";
                $result = db_fetch($sql);
				$pos1 = $result['position'];
                switch ($_GET['where']):
                    case 'up':
                        $pos_sql = "< {$result['position']} ORDER BY `position` DESC";
                        break;
                    case 'down':
                        $pos_sql = "> {$result['position']} ORDER BY `position`";
                        break;
                endswitch;
                $sql = "SELECT id, position FROM `".c("table.attached")."` WHERE `page` = {$_GET['idx']} AND `position` {$pos_sql} LIMIT 1;";
                $result = db_fetch($sql);
				$pos2 = $result['position'];
                $update1 = db_update(c("table.attached"), array('position' => $pos2), "WHERE `id` = {$_GET['id']} LIMIT 1;");
                db_query($update1);
                $update2 = db_update(c("table.attached"), array('position' => $pos1), "WHERE `id` = {$result['id']} LIMIT 1;");
                db_query($update2);
                redirect(ahref('files', 'show', array('idx' => $_GET['idx'], 'menu'=> $_GET['menu'])));
                break;
            case 'delete':
                $delete_sql = "DELETE FROM " . c("table.attached") . " WHERE `id` = {$_GET['id']};";
                db_query($delete_sql);
                redirect(ahref('files', 'show', array('idx' => $_GET['idx'], 'menu'=> $_GET['menu'])));
                break;
        endswitch;
        $data['files'] = db_fetch_all("SELECT * FROM " . c("table.attached") . " WHERE `page` = {$_GET['idx']} ORDER BY `position` ASC;");
		$data['idx'] = $_GET["idx"];
		$data['title'] = a('files.attached');
		$data['action'] = 'files';
		$data['menu'] = $_GET['menu'];
		$data['subaction'] = $this->subaction;
        $this->content = template('actions/files', $data);
    }
    
    function poll()
	{
        $par = array();
        if (isset($_GET['menu']))
        {
            $par['menu'] = $_GET['menu'];
        }
        if (isset($_GET['id']))
        {
            $par['id'] = $_GET['id'];
        }
        switch ($this->subaction):
            case 'show':
				$poll = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = ". get("menu", 0));
                $sql = db_fetch_all("SELECT * FROM `".c("table.pollanswers")."` WHERE `deleted` = 0 and `language` = '".l()."' and `pollid` = ". get("menu", 0) ." ORDER BY `position`;");
				$data["title"] = $poll["title"];
                $data["polls"] = $sql;
                $this->content = template('actions/' . $this->action . '_list', $data);
                break;
            case 'add':
                if (isset($_POST[$this->action . '_form_perform']) && !empty($_POST['answer'])):
					$id=db_fetch('select max(id) as maxid from `'.c("table.pollanswers").'`');
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 'true' : 'false';
					$newid=$id["maxid"]+1;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.pollanswers"), array(
									'pollid' => $_GET['menu'],
									'answer' => $_POST['answer'],
									'id' => $newid,
									'position' => $newid,
									'answercount' => $_POST['answercount'],
									'answercounttotal' => $_POST['answercounttotal'],
									'visibility' => $vis,
									'language' => $language
								));
						db_query($insert);
					endforeach;
                    redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                endif;
                $this->content = template('actions/' . $this->action . '_forms', array('menu' => $_GET["menu"], 'action' => $this->action, 'subaction' => $this->subaction));
                break;
            case 'edit':
                if (isset($_POST[$this->action . '_form_perform']) && !empty($_POST['answer'])):
					$visibility = ((isset($_POST['visibility'])) && ($_POST['visibility'] == 'on')) ? 'true' : 'false';
                    $data = array(
                        'pollid' => $_GET['menu'],
						'answer' => $_POST['answer'],
						'answercount' => $_POST['answercount'],
						'answercounttotal' => $_POST['answercounttotal'],
                        'language' => l() 
                    );
                    $insert = db_update(c("table.pollanswers"), $data, "WHERE `idx` = {$_GET['idx']}");
                    db_query($insert);
                    redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                endif;
                $edit_data = db_fetch("SELECT * FROM `".c("table.pollanswers")."` WHERE `idx` = {$_GET['idx']};");
                $temp_keys = array();
                $edit = array(
                    'title' => a("editimage"),
                    'action' => $this->action,
                    'subaction' => $this->subaction,
                    'answer' => $edit_data['answer'],
                    'answercount' => $edit_data['answercount'],
                    'idx' => $edit_data['idx'],
                    'answercounttotal' => $edit_data['answercounttotal'],
                    'visibility' => $edit_data['visibility'],
					'menu' => $edit_data['pollid']
                );
                $this->content = template('actions/' . $this->action . '_forms', $edit);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.pollanswers"), array('visibility' => $_GET['visibility']), "WHERE `idx` = {$_GET['idx']}");
                db_query($update);
                break;
            case 'delete':
                $delete_sql = "UPDATE `".c("table.pollanswers")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($delete_sql);
                redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                break;
            case 'move':
                $res = db_fetch("SELECT * FROM `".c("table.pollanswers")."` WHERE `idx` = {$_GET['idx']};");
                $pos1 = $res['position'];
                $idx1 = $_GET['idx'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `".c("table.pollanswers")."`.`position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `".c("table.pollanswers")."`.`position` ASC";
                        break;
                endswitch;
                $sql = "SELECT * FROM `".c("table.pollanswers")."` WHERE `".c("table.pollanswers")."`.`language` = '" . l() . "' AND `pollid` = '{$_GET['menu']}' AND `".c("table.pollanswers")."`.`position` {$pos_sql} LIMIT 1;";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $idx2 = $res['idx'];
                $update1 = db_update(c("table.pollanswers"), array('position' => $pos2), "WHERE `idx` = {$idx1}");
                $update2 = db_update(c("table.pollanswers"), array('position' => $pos1), "WHERE `idx` = {$idx2}");
                db_query($update1);
                db_query($update2);
                redirect(ahref($this->action, 'show', $par));
                break;
        endswitch;
	}

    function catalog()
	{
        $par = array();
        if (isset($_GET['menu']))
        {
            $par['menu'] = $_GET['menu'];
        }
        if (isset($_GET['id']))
        {
            $par['id'] = $_GET['id'];
        }
        switch ($this->subaction):
            case 'show':
				$catalog = db_fetch("SELECT * FROM `".c("table.menus")."` WHERE `language` = '".l()."' and `id` = ". get("menu", 0));
                $sql = db_fetch_all("SELECT * FROM `".c("table.catalogs")."` WHERE `deleted` = 0 and `language` = '".l()."' and `catalogid` = ". get("menu", 0) ." ORDER BY `position`;");
				$data["title"] = $catalog["title"];
                $data["catalogs"] = $sql;
                $this->content = template('actions/' . $this->action . '_list', $data);
                break;
            case 'add':
                if (isset($_POST[$this->action . '_form_perform']) && !empty($_POST['title'])):
					$id=db_fetch('select max(id) as maxid from `'.c("table.catalogs").'`');
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 'true' : 'false';
					$top25 = ((isset($_POST["top25"])) && ($_POST["top25"] == 'on')) ? '1' : '0';
					$hot = ((isset($_POST["hot"])) && ($_POST["hot"] == 'on')) ? '1' : '0';
					$duration = ((isset($_POST["duration"])) && ($_POST["duration"] == 'on')) ? '1' : '0';
					$price = ((isset($_POST["price"])) && ($_POST["price"] == 'on')) ? '1' : '0';
					$homepage = ((isset($_POST["homepage"])) && ($_POST["homepage"] == 'on')) ? '1' : '0';
					$bottomslider = ((isset($_POST["bottomslider"])) && ($_POST["bottomslider"] == 'on')) ? '1' : '0';
					$newid=$id["maxid"]+1;
//					$producttime = $_POST["producttime"];
//					$_POST["productdate"] .= ' ' . $producttime;
					$idx=0;
					foreach(c('languages.all') as $language) :
						$insert = db_insert(c("table.catalogs"), array(
									'id' => $newid,
									'catalogid' => $_GET['menu'],
									'position' => $newid,
									'title' => $_POST['title'],
									'description' => $_POST['description'],
									'content' => $_POST['content'],
//									'city' => $_POST['city'],
									'duration' => $_POST['duration'],
 							    	'price' => $_POST['price'],
//									'guide' => $_POST['guide'],
									//'fullname' => $_POST['fullname'],
									//'type' => $_POST['type'],
									'productdate' => $_POST["productdate"],
									'visibility' => $vis,
									'top25' => $top25,
									'hot' => $hot,
									'homepage' => $homepage,
									'photo1' => $_POST['photo1'],
									'photo2' => $_POST['photo2'],
									'photo3' => $_POST['photo3'],
									'photo4' => $_POST['photo4'],
									'photo5' => $_POST['photo5'],
									'photo6' => $_POST['photo6'],
									'video1' => $_POST['video1'],
									'video2' => $_POST['video2'],
									'mob1' => $_POST['mob1'],
//									'doc2' => $_POST['doc2'],
//									'size' => $_POST['size'],
									'review' => $_POST['review'],
									'content' => $_POST['content'],
									'description' => $_POST['description'],
									'meta_keys' => $_POST['meta_keys'],
									'street' => $_POST['street'],
									'language' => $language
									
								));
//							die($insert);
						db_query($insert);
						if($language==l())
							$idx = mysql_insert_id();
					endforeach;
					if($_POST["tabstop"] == 'close')
	                    redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
					else
	                    redirect(ahref($this->action, 'edit', array('menu'=>$_GET["menu"], 'idx'=>$idx)));
                endif;
                $this->content = template('actions/' . $this->action . '_forms', array('menu' => $_GET["menu"], 'action' => $this->action, 'subaction' => $this->subaction));
                break;
            case 'edit':
                if (isset($_POST[$this->action . '_form_perform']) && !empty($_POST['title'])):
					$vis = ((isset($_POST["visibility"])) && ($_POST["visibility"] == 'on')) ? 'true' : 'false';
					$top25 = ((isset($_POST["top25"])) && ($_POST["top25"] == 'on')) ? '1' : '0';
					$hot = ((isset($_POST["hot"])) && ($_POST["hot"] == 'on')) ? '1' : '0';
					$duration = ((isset($_POST["duration"])) && ($_POST["duration"] == 'on')) ? '1' : '0';
					$price = ((isset($_POST["price"])) && ($_POST["price"] == 'on')) ? '1' : '0';
					$homepage = ((isset($_POST["homepage"])) && ($_POST["homepage"] == 'on')) ? '1' : '0';
					$bottomslider = ((isset($_POST["bottomslider"])) && ($_POST["bottomslider"] == 'on')) ? '1' : '0';
                    $data = array(
                        'catalogid' => $_GET['menu'],
						'title' => $_POST['title'],
						'description' => $_POST['description'],
						'content' => $_POST['content'],
//						'city' => $_POST['city'],
						'duration' => $_POST['duration'],
     					'price' => $_POST['price'],
//						'guide' => $_POST['guide'],
						//'fullname' => $_POST['fullname'],
						//'type' => $_POST['type'],
						'productdate' => $_POST["productdate"],
						'visibility' => $vis,
						'top25' => $top25,
						'hot' => $hot,
						'homepage' => $homepage,
						'photo1' => $_POST['photo1'],
						'photo2' => $_POST['photo2'],
						'photo3' => $_POST['photo3'],
						'photo4' => $_POST['photo4'],
						'photo5' => $_POST['photo5'],
						'photo6' => $_POST['photo6'],
						'video1' => $_POST['video1'],
						'video2' => $_POST['video2'],
						'mob1' => $_POST['mob1'],
						'review' => $_POST['review'],
						'content' => $_POST['content'],
						'description' => $_POST['description'],
						'meta_keys' => $_POST['meta_keys'],
						'street' => $_POST['street'],
//						'doc2' => $_POST['doc2'],
//						'size' => $_POST['size'],
                        'language' => l() 
                    );
                    $insert = db_update(c("table.catalogs"), $data, "WHERE `idx` = {$_GET['idx']}");
                    db_query($insert);

//  update catalog identically

                    $data = array(
//						'price' => $_POST['price'],
						
						'photo1' => $_POST['photo1'],
						'photo2' => $_POST['photo2'],
						'photo3' => $_POST['photo3'],
						'photo4' => $_POST['photo4'],
						'photo5' => $_POST['photo5'],
						'photo6' => $_POST['photo6']
                    );
                    $id1 = db_retrieve('id', c("table.catalogs"), 'idx', $_GET['idx']);
                    $insert = db_update(c("table.catalogs"), $data, "WHERE `id` = {$id1}");
                    db_query($insert);


					if($_POST["tabstop"] == 'close')
	                    redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
					else
	                    redirect(ahref($this->action, 'edit', array('menu'=>$_GET["menu"], 'idx'=>$_GET["idx"])));
                endif;
                $edit_data = db_fetch("SELECT * FROM `".c("table.catalogs")."` WHERE `idx` = {$_GET['idx']};");
                $temp_keys = array();
                $edit = array(
                    'action' => $this->action,
                    'subaction' => $this->subaction,

                    'title' => $edit_data['title'],
					'description' => $edit_data['description'],
					'content' => $edit_data['content'],
					'duration' => $edit_data['duration'],
				'price' => $edit_data['price'],
//					'guide' => $edit_data['guide'],
					//'fullname' => $edit_data['fullname'],
					//'type' => $edit_data['type'],
					
					'saleprice' => $edit_data['saleprice'],
					
//					'street' => $edit_data['street'],
//					'streetnumber' => $edit_data['streetnumber'],
//					'city' => $edit_data['city'],
					'email' => $edit_data['email'],
					'fax' => $edit_data['fax'],
					'head' => $edit_data['head'],
					
					'xi' => $edit_data['xi'],
					'yi' => $edit_data['yi'],
	
					'address' => $edit_data['address'],
					
					'pid' => $edit_data['pid'],
					
					'bottomslider' => $edit_data["bottomslider"],

//					'review' => $edit_data['review'],
					'weight' => $edit_data['weight'],
//					'size' => $edit_data['size'],
					'sellcount' => $edit_data['sellcount'],
					'productdate' => $edit_data["productdate"],
					'visibility' => $edit_data["visibility"],
					'top25' => $edit_data["top25"],
					'hot' => $edit_data["hot"],
					'homepage' => $edit_data["homepage"],
					'photo1' => $edit_data['photo1'],
					'photo2' => $edit_data['photo2'],
					'photo3' => $edit_data['photo3'],
					'photo4' => $edit_data['photo4'],
					'photo5' => $edit_data['photo5'],
					'photo6' => $edit_data['photo6'],
					'mob1' => $edit_data['mob1'],
//					'doc2' => $edit_data['doc2'],
					'video1' => $edit_data['video1'],
					'video2' => $edit_data['video2'],
                    'idx' => $edit_data['idx'],
					'review' => $edit_data['review'],
					'content' => $edit_data['content'],
                    'description' => $edit_data['description'],
					'meta_keys' => $edit_data['meta_keys'],
					'street' => $edit_data['street'],
					'menu' => $edit_data['catalogid']
					
                );
                $this->content = template('actions/' . $this->action . '_forms', $edit);
                break;
            case 'visibility':
// AJAX CALL
                $update = db_update(c("table.catalogs"), array('visibility' => $_GET['visibility']), "WHERE `idx` = {$_GET['idx']}");
                db_query($update);
                break;
// AJAX CALL
            case 'delete':
                $delete_sql = "UPDATE `".c("table.catalogs")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($delete_sql);
                redirect(ahref($this->action, 'show', array('menu'=>$_GET["menu"])));
                break;
            case 'move':
                $res = db_fetch("SELECT * FROM `".c("table.catalogs")."` WHERE `idx` = {$_GET['idx']};");
                $pos1 = $res['position'];
                $idx1 = $_GET['idx'];
                switch ($_GET['where']):
                    case 'up': $pos_sql = "< {$pos1} ORDER BY `".c("table.catalogs")."`.`position` DESC";
                        break;
                    case 'down': $pos_sql = "> {$pos1} ORDER BY `".c("table.catalogs")."`.`position` ASC";
                        break;
                endswitch;
                $sql = "SELECT * FROM `".c("table.catalogs")."` WHERE `".c("table.catalogs")."`.`language` = '" . l() . "' AND `catalogid` = '{$_GET['menu']}' AND `".c("table.catalogs")."`.`position` {$pos_sql} LIMIT 1;";
                $res = db_fetch($sql);
                $pos2 = $res['position'];
                $idx2 = $res['idx'];
                $update1 = db_update(c("table.catalogs"), array('position' => $pos2), "WHERE `idx` = {$idx1}");
                $update2 = db_update(c("table.catalogs"), array('position' => $pos1), "WHERE `idx` = {$idx2}");
                db_query($update1);
                db_query($update2);
                redirect(ahref($this->action, 'show', $par));
                break;
        endswitch;
	}
	
    function siteusers()
    {
        switch ($this->subaction):
            case 'show':
                $sql = db_fetch_all("SELECT * FROM `".c("table.site_users")."` WHERE `deleted` = 0 ORDER BY `username` LIMIT " . get("start", 0) . ", " . a_s("siteusers.per.page") . ";");
                $cnt = db_fetch("SELECT COUNT(*) AS cnt FROM `".c("table.site_users")."` WHERE `deleted` = 0;");
                $data["users"] = $sql;
				$data["count"] = $cnt["cnt"];
                $this->content = template('actions/siteusers_list', array('data' => $data));
                break;
            case 'delete':
                $sql = "UPDATE `".c("table.site_users")."` SET `deleted` = 1 WHERE `id` = {$_GET['id']};";
                db_query($sql);
                redirect(ahref('users', 'show'));
                break;
            case 'add':
                if (isset($_POST['users_form_submit'])):
					$active = (isset($_POST["active"])) ? 1 : 0;
					$banned = (isset($_POST["banned"])) ? 1 : 0;
                    $insert = db_insert(c("table.site_users"), array(
								'firstname' => $_POST["firstname"], 
								'lastname' => $_POST["lastname"], 
								'username' => $_POST["username"], 
                                'userpass' => sha1(md5($_POST['password'])),
								'nickname' => $_POST["nickname"], 
								'companyname' => $_POST["companyname"], 
								'position' => $_POST["position"], 
								'mobile' => $_POST["mobile"], 
								'phone' => $_POST["phone"], 
								'personalid' => $_POST["personalid"], 
								'address' => $_POST["address"], 
								'avatar' => $_POST["avatar"], 
								'banned' => $banned, 
								'email' => $_POST["email"], 
								'usercat' => $_POST["usercat"], 
								'regdate' => $_POST["regdate"], 
								'birthdate' => $_POST["birthdate"], 
								'about' => $_POST["about"], 
								'active' => $active					
		                    ));
                    db_query($insert);
                    redirect(ahref('siteusers', 'show'));
                endif;
				$data["action"] = 'add';
				$data["title"] = a('adduser');
                $this->content = template('actions/siteusers_forms', $data);
                break;
            case 'edit':
                if (isset($_POST['users_form_submit'])):
					$active = (isset($_POST["active"])) ? 1 : 0;
					$data['firstname'] = $_POST["firstname"];
				  	$data['lastname'] = $_POST["lastname"]; 
				  	$data['username'] = $_POST["username"]; 
				  	$data['email'] = $_POST["email"]; 
				  	$data['usercat'] = $_POST["usercat"]; 
				  	$data['active'] = $active;	
					$data['nickname'] = $_POST["nickname"];
					$data['companyname'] = $_POST["companyname"];
					$data['position'] = $_POST["position"]; 
					$data['mobile'] = $_POST["mobile"]; 
					$data['phone'] = $_POST["phone"]; 
					$data['personalid'] = $_POST["personalid"]; 
					$data['address'] = $_POST["address"]; 
					$data['avatar'] = $_POST["avatar"]; 
					$data['regdate'] = $_POST["regdate"]; 
					$data['birthdate'] = $_POST["birthdate"]; 
					$data['about'] = $_POST["about"]; 
					$data['banned'] = (isset($_POST["banned"])) ? 1 : 0;
                    if (!empty($_POST['password']))
                    {
                        $data['userpass'] = sha1(md5($_POST['password']));
                    }
                    $update = db_update(c("table.site_users"), $data, "WHERE `id` = {$_GET['id']}");
                    db_query($update);
                    redirect(ahref('siteusers', 'show'));
                endif;
                $data["user"] = db_fetch("SELECT * FROM `".c("table.site_users")."` WHERE `id` = {$_GET['id']};");
				$data["action"] = 'edit';
				$data["title"] = a('edituser');
                $this->content = template('actions/siteusers_forms', $data);
                break;
            case 'activity':
                $update = db_update(c("table.site_users"), array('active' => $_GET['active']), "WHERE `id` = {$_GET['id']}");
                db_query($update);
                break;
            case 'ban':
                $update = db_update(c("table.site_users"), array('banned' => $_GET['banned']), "WHERE `id` = {$_GET['id']}");
                db_query($update);
                break;
        endswitch;
    }

    function log()
    {
        switch ($this->subaction):
            case 'show':
				$sql=db_fetch_all('SELECT * FROM ' . c('table.log') . ' ORDER BY visitdate DESC LIMIT ' . get('start', 0) . ', 50;');
				$cnt=db_fetch('SELECT COUNT(*) AS cnt FROM ' . c('table.log') . ' ORDER BY visitdate DESC;');
                $data["log"] = $sql;
				$data["count"] = $cnt["cnt"];
                $this->content = template('actions/log_list', array('data' => $data));
                break;
			case 'clear':
				$sql=db_query('DELETE FROM `' . c('table.log') . '`;');
                redirect(ahref('log', 'show'));
			break;
        endswitch;
	}

    function userrights()
    {
        switch ($this->subaction):
            case 'show':
				$sql=db_fetch_all('SELECT * FROM ' . c('table.user_access') . ' WHERE userid = "' . get('userid', 0) . '";');
                $data["user_access"] = $sql;
                $this->content = template('actions/user_access_list', $data);
                break;
			case 'save':
				$userid=post("userid",0);
				if($userid != 0) :
					$sql=db_query('DELETE FROM ' . c('table.user_access') . ' WHERE userid = "' . $userid . '";');
					unset($_POST["userid"], $_POST["userid"]);
					foreach($_POST as $key=>$value) :
						$sql=db_query('INSERT INTO ' . c('table.user_access') . ' (userid, action) VALUES("' . $userid . '", "' . $key . '");');
					endforeach;
				endif;
                redirect(ahref('userrights', 'show') . '&userid='.$userid);
			break;
        endswitch;
	}

    function help()
    {
       	$this->content = template('actions/help', array('title' => ''));
	}

    function about()
    {
       	$this->content = template('actions/about', array('title' => ''));
	}

    function terms()
    {
       	$this->content = template('actions/terms', array('title' => ''));
	}

    function privacy()
    {
       	$this->content = template('actions/privacy', array('title' => ''));
	}

    function uploadfiles()
    {
        switch ($this->subaction):
            case 'upload':
            	//die(count($_FILES['file']['name']));
				for($i=0; $i<count($_FILES['file']['name']); $i++) {
				  	$tmpFilePath = $_FILES['file']['tmp_name'][$i];
					$ext = strtolower(substr(strrchr($_FILES['file']['name'][$i], '.'), 1));
				  	if ($tmpFilePath != ""){
//				    	$newFilePath = $_POST["folder"] . '/' . md5($_FILES['file']['name'][$i]) . '.' . $ext;;
				    	$newFilePath = $_POST["folder"] . '/' . $_FILES['file']['name'][$i];
				    	move_uploaded_file($tmpFilePath, $newFilePath);
				  	}
				}            
            	break;
            case 'delete':
            	unlink('files/_tour_images/'.$_GET["folder"].'/'.$_GET["file"]);
            	break;
        endswitch;
        $data = array();
		$data['id'] = $_GET["id"];
		$data['action'] = 'uploadfiles';
		$data['menu'] = $_GET['menu'];
		$data['subaction'] = 'show';
        $this->content = template('actions/uploadfiles', $data);
	}

	function _update_slugs($idx) {
		$pages = db_fetch_all("select * from pages where menuid in (1,19,20) and masterid=".$idx);
		echo $idx;
		foreach($pages as $page) :
			if($page["level"]>1) {
				$slug = new_slug($page["title"], $idx, FALSE);
				db_query("update pages set slug='".$slug."' where idx=".$page["idx"]);
			}
			$this->_update_slugs($page["idx"]);
		endforeach;
	}

	function _update_slugs2() {
		$pages = db_fetch_all("select * from pages where language='ge'");
		foreach($pages as $page) :
			$en_slug = $pages = db_fetch("select slug from pages where language='en' and id=".$page["id"]);
			db_query("update pages set slug='".$en_slug["slug"]."' where idx=".$page["idx"]);
		endforeach;
	}

	function updateslug() {
//		$this->_update_slugs(0);
		$this->_update_slugs2();
	}

}
