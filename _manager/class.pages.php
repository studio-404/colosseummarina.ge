<?php

defined('DIR') OR exit;

class Manager_Pages
{

    protected $storage;

    public function __construct()
    {
        $this->storage = Storage::instance();
        $this->storage->content = NULL;
    }

    function error()
    {
        $this->storage->title = l('error');
		if($this->storage->section["template"]=='') 
	        $this->storage->content =  template('error', array());
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function attached_images($idx)
    {
        if (empty($idx) OR $idx === FALSE)
        {
            return NULL;
        }
        $sql = "SELECT * FROM `".c("table.attached")."` WHERE `page` = {$idx} ORDER BY `position` ASC;";
        $res = db_fetch_all($sql);
        if (empty($res))
        {
            return NULL;
        }
        $images = array();
        foreach ($res as $file)
        {
            $ext = substr(strrchr($file['path'], '.'), 1);
            if (in_array($ext, c('thumbnail.exts')))
            {
                $file['ext'] = $ext;
                $images[] = $file;
            }
        }
        if (empty($images))
        {
            return NULL;
        }
        return template('attached_images', array('images' => $images));
    }

    function attached_files($idx)
    {
        if (empty($idx) || $idx === false)
        {
            return NULL;
        }
        $sql = "SELECT * FROM `".c("table.attached")."` WHERE `page` = {$idx} ORDER BY `position` ASC;";
        $res = db_fetch_all($sql);
        if (empty($res))
        {
            return NULL;
        }
        $files = array();
        foreach ($res as $file)
        {
            $ext = substr(strrchr($file['path'], '.'), 1);
            if (!in_array($ext, c('thumbnail.exts')))
            {
                $file['ext'] = $ext;
                $files[] = $file;
            }
        }
        if (empty($files))
        {
            return NULL;
        }
        return template('attached_files', array('files' => $files));
    }

    function attached_all_files($idx)
    {
        if (empty($idx))
            return NULL;
        $sql = "SELECT * FROM `".c("table.attached")."` WHERE page = {$idx} ORDER BY position ASC;";
        $tpl["files"] = db_fetch_all($sql);
        if (empty($tpl))
            return NULL;
        return template('all_files', array('all_files' => $tpl));
    }

    ///////////// DO NOT EDIT ABOVE !!! //////////////

    function text()
    {
        $this->storage->title = $this->storage->section['title'];
        $this->storage->attachments = $this->attached_all_files($this->storage->section['idx']);
		//$a= $this->storage->attachments;
        /*
          $this->storage->attachments = array();
          $this->storage->attachments['all'] = $this->attached_all_files($this->storage->section['idx']);
          $this->storage->attachments['files'] = $this->attached_files($this->storage->section['idx']);
          $this->storage->attachments['images'] = $this->attached_images($this->storage->section['idx']);
          $tpl['attachments_all'] = $this->attached_all_files($this->storage->section['idx']);
         */
//	  	$tpl['attachments_all'] = $this->attached_all_files($this->storage->section['idx']);
		$idx=$this->storage->section['idx'];
        $files = array();
        $images = array();
		$videos = array();
        $sql = "SELECT * FROM `".c("table.attached")."` WHERE page = {$idx} ORDER BY position ASC;";
		$res = db_fetch_all($sql);
        foreach ($res as $file)
        {
            $ext = substr(strrchr($file['path'], '.'), 1);
            if (!in_array($ext, c('thumbnail.exts')))
            {
				if(strstr($file['path'],"youtu.be")) {
					$file['path'] = str_replace('youtu.be','www.youtube.com/embed',$file['path']);
					$videos[] = $file;
				} else {
                    $file['ext'] = $ext;
                    $files[] = $file;
				}
            }
			else
            {
                $image['ext'] = $ext;
                $images[] = $file;
            }
        }
//		$menu=db_fetch("select * from ".c("table.menus")."` where `id`='".$this->storage->section['menuid']."' and `language`='".l()."'");
		$mtitle = db_retrieve('title', c("table.menus"), 'id', $this->storage->section['menuid'], ' and language = "'.l().'" LIMIT 1');
        $author = db_retrieve('title', c("table.pages"), 'attached', $mtitle, ' LIMIT 1');
        $newslistid = db_retrieve('id', c("table.pages"), 'attached', $mtitle, ' and language = "'.l().'" LIMIT 1');
		
        $tpl["files"] = $files; 
        $tpl["videos"] = $videos; 
        $tpl["images"] = $images; 
        $tpl["author"] = $author; 
        $tpl["newslistid"] = $newslistid; 
        $tpl['content'] = $this->storage->section['content'];
        $tpl['description'] = $this->storage->section['description'];
        $tpl['imagen'] = $this->storage->section['imagen'];
        $tpl['id'] = $this->storage->section['id'];
        $tpl['link'] = href($this->storage->section['id']);
        $tpl['idx'] = $this->storage->section['idx'];
        $tpl['menuid'] = $this->storage->section['menuid'];
		$tpl['title'] = $this->storage->section['title']; 
		$tpl['menutitle'] = $this->storage->section['menutitle']; 

		$tpl["page"] = $this->storage->section;

		$tpl['date'] = $this->storage->section['pagedate']; 
		$tpl['children'] = db_fetch_all("SELECT * FROM `".c("table.pages")."` WHERE masterid = {$this->storage->section['idx']} AND visibility='true' AND deleted=0 ORDER BY position ASC;"); 
		if($this->storage->section["template"]=='') {
			if(is_from_list($this->storage->section['menuid'])) {
				$menutype=db_fetch("select * from menus where language='".l()."' and id=".$this->storage->section['menuid']);
				if($menutype["type"]=="articles")
					$this->storage->content = template('articletext', $tpl);
				else
					$this->storage->content = template('newstext', $tpl);
			} else {
				$this->storage->content = template('text', $tpl);
			}
		} else {
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
		}
    }

    function feedback()
    {
        $this->storage->title = $this->storage->section['title'];
        $this->storage->attachments = $this->attached_all_files($this->storage->section['idx']);
		$tpl['section'] = $this->storage->section;
        $tpl['content'] = $this->storage->section['content'];
		$tpl['title'] = $this->storage->section['title']; 
        $tpl['idx'] = $this->storage->section['idx'];
        $tpl['imagen'] = $this->storage->section['imagen'];
		$tpl['date'] = $this->storage->section['pagedate']; 
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('contact', $tpl);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

 function search()
    {
        $this->storage->title = $this->storage->section['title'];
        $query = get("q");
//		return $this->storage->content = $query;
        if ($query === FALSE && !isset($_GET["tag"]))
            return ($this->storage->content = l('search_empty_query'));
			$sql = "
		
				
				SELECT title, id, productdate ,  description , meta_keys, photo1, catalogid
				from catalogs
				WHERE language = '" . l() . "' AND deleted = 0 AND visibility = 'true'
				AND
				(
					content LIKE '%{$query}%'
					OR description LIKE '%{$query}%'
					OR title LIKE '%{$query}%'
					OR meta_keys LIKE '%{$query}%'
				)
				order by id
			;";
			//echo  $sql;
		$data["m3char"] = 0;
		$data["noresult"] = 0;
        if (mb_strlen($query) < 3 && !isset($_GET["tag"]))
            $data["m3char"] = 1;
        $data['results'] = db_fetch_all($sql);
        if (empty($data['results']))
            $data["noresult"] = 1;
		$data['title'] = $this->storage->section['title']; 
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('search', $data);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $data);
    }









    function search3()
    {
        $this->storage->title = $this->storage->section['title'];
        $query = get("q");
//		return $this->storage->content = $query;
        if ($query === FALSE && !isset($_GET["tag"]))
            return ($this->storage->content = l('search_empty_query'));
			$sql = "
			select 
				CONVERT( title USING utf8 ) as title,id,  CONVERT( pagedate USING utf8 ) as pagedate, CONVERT( description USING utf8 ) as description
				FROM `".c("table.pages")."`
				WHERE language = '" . l() . "' AND deleted = 0 AND visibility = 'true'
				AND
				(
					content LIKE '%{$query}%'
					OR description LIKE '%{$query}%'
					OR title LIKE '%{$query}%'
				)
				
				
				UNION
				
				SELECT CONVERT(title USING utf8) as title, id, convert(productdate USING utf8)  as pagedate,  convert(description  USING utf8) as description
				from catalogs
				WHERE language = '" . l() . "' AND deleted = 0 AND visibility = 'true'
				AND
				(
					content LIKE '%{$query}%'
					OR description LIKE '%{$query}%'
					OR title LIKE '%{$query}%'
				)
				order by id
			;";
			//echo  $sql;
		$data["m3char"] = 0;
		$data["noresult"] = 0;
        if (mb_strlen($query) < 3 && !isset($_GET["tag"]))
            $data["m3char"] = 1;
        $data['results'] = db_fetch_all($sql);
        if (empty($data['results']))
            $data["noresult"] = 1;
		$data['title'] = $this->storage->section['title']; 
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('search', $data);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $data);
    }


    function search2()
    {
        $query = get("q");
        if ($query === FALSE)
            return ($this->storage->content = l('search_empty_query'));
        $query = str_replace('"','', str_replace("'", "", $query));
        $page = get('page', 1);
        $per_page = c('catalog.per_page');
        $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
        $sql = "SELECT * FROM `".c("table.pages")."` WHERE (`title` like '%".$query."%' OR `description` like '%".$query."%' OR `content` like '%".$query."%') AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' ORDER BY position {$limit} ;";
		$cnt = "SELECT count(*) as cnt FROM `".c("table.pages")."` WHERE (`title` like '%".$query."%' OR `description` like '%".$query."%' OR `content` like '%".$query."%') AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' ORDER BY position;";
		$pager = 0;
		$cattype = 2;
        $res = db_fetch_all($sql);
        $cres = db_fetch($cnt);
		$catalog["items"] = $res;
		$catalog["pager"] = $pager;
		$catalog['section'] = $this->storage->section;
        $count = empty($cres) ? 0 : $cres['cnt'];
        $max_page = ceil($count / $per_page);
        $catalog['count_sql'] = $cnt;
        $catalog['page_num'] = $page;
        $catalog['page_max'] = $max_page;
        $catalog['item_count'] = $count;
		
		$catalog["link"] = href($this->storage->section['id']);
		$catalog["cattype"] = $cattype;
		$catalog["id"] = $this->storage->section['id'];
		$catalog["idx"] = $this->storage->section['idx'];
		$catalog["title"] = $this->storage->section['title'];
        $this->storage->title = $this->storage->section['title'];

		$catalog["m3char"] = 0;
		$catalog["noresult"] = 0;
        if (mb_strlen($query) < 3)
            $catalog["m3char"] = 1;
        $catalog['results'] = db_fetch_all($sql);
        if (empty($catalog['results']))
            $catalog["noresult"] = 1;
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('search', $catalog);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $catalog);
    }



    function sitemap()
    {
        $this->storage->title = $this->storage->section['title'];
        $tpl['content'] = $this->storage->section['content'];
		$tpl['title'] = $this->storage->section['title']; 
		$tpl['date'] = $this->storage->section['pagedate']; 
        $tpl['idx'] = $this->storage->section['idx'];
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('sitemap', $tpl);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function home()
    {
        $this->storage->title = $this->storage->section['title'];
        $tpl['content'] = $this->storage->section['content'];
		$tpl['title'] = $this->storage->section['title']; 
		$tpl['date'] = $this->storage->section['pagedate']; 
        $this->storage->content = template('home', $tpl);
    }

    function wizard()
    {
        $this->storage->title = $this->storage->section['title'];
        $file = $this->storage->section['attached'];
        file_exists(c('folders.plugins').$file) AND require_once c('folders.plugins').$file;
    }

    function news()
    {
        $rss = (get('feed') == 'rss');
        $this->storage->title = $this->storage->section['title'];
        $all = (get('all') == 'show');
		$menu_sql = "SELECT id FROM " . c("table.menus") . " WHERE `deleted` = '0' AND `type` = 'news' AND `title` = '{$this->storage->section['attached']}'";
        $menu_array = db_fetch($menu_sql);
		$menu_id = $menu_array["id"];
        if (!$all AND (empty($menu_id) OR $menu_id == 'NULL'))
            return ($this->storage->content = NULL);
        $all_news = $all ? " AND menuid IN (SELECT id FROM `".c("table.menus")."` WHERE `deleted` = '0' AND type = 'news') " : " AND menuid = {$menu_id} ";
        //Pager: start
        $page = get('page', 1);
        $per_page = c('news.per_page');
        $limit = $rss ? ' LIMIT 10' : " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
        $count_sql = "SELECT COUNT(id) AS num FROM `".c("table.pages")."` WHERE language = '" . l() . "' {$all_news}AND visibility = 'true' AND deleted = 0 ORDER BY pagedate DESC;";
        $count_res = db_fetch($count_sql);
        $count = empty($count_res) ? 0 : $count_res['num'];
        $max_page = ceil($count / $per_page);
        $tpl['count_sql'] = $count_sql;
        $tpl['page_num'] = $page;
        $tpl['page_max'] = $max_page;
        $tpl['item_count'] = $count;
        $tpl['section'] = $this->storage->section;
        $tpl['all_par'] = $all ? '&all=show' : null;
		$tpl['menuid'] = $this->storage->section['menuid'];
        $tpl['idx'] = $this->storage->section['idx'];
        $tpl['id'] = $this->storage->section['id'];
        //Pager: end
        $sql = "SELECT * FROM `".c("table.pages")."` WHERE language = '" . l() . "' {$all_news}AND `deleted` = '0' AND visibility = 'true' ORDER BY pagedate DESC{$limit};";
        $res = db_fetch_all($sql);
//        if (empty($res))
//            return ($this->storage->content = NULL);
        if ($rss)
        {
            echo template('rss', array(
                'news' => $res,
                'section' => $this->storage->section['id']
            ));
            exit;
        }
	    $tpl['title'] = $this->storage->section['title'];
        $tpl['pposition'] = $this->storage->section['pposition'];
        $tpl['news'] = $res;
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('news', $tpl);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function lists()
    {
        $this->storage->title = $this->storage->section['title'];
        $all = (get('all') == 'show');
		$menu_sql = "SELECT id FROM " . c("table.menus") . " WHERE `deleted` = '0' AND `type` = 'list' AND `title` = '{$this->storage->section['attached']}'";
        $menu_array = db_fetch($menu_sql);
		$menu_id = $menu_array["id"];
        if (!$all AND (empty($menu_id) OR $menu_id == 'NULL'))
            return ($this->storage->content = NULL);
        $all_news = $all ? " AND menuid IN (SELECT id FROM `".c("table.menus")."` WHERE `deleted` = '0' AND type = 'list') " : " AND menuid = {$menu_id} ";
        //Pager: start
        $page = get('page', 1);
        $per_page = c('list.per_page');
        $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
		$filter = '';
		if(isset($_POST['search_submit'])) {
			if($_POST['date']<>'') $filter .= ' AND date_format(pagedate,"%Y-%m-%d")="' . $_POST['date'] . '" ';
			if($_POST['number']<>'') $filter .= ' AND item_number="' . $_POST['number'] . '" ';
			if($_POST['title']<>'') $filter .= ' AND title like "%' . $_POST['title'] . '%" ';
			if($_POST['content']<>'') $filter .= ' AND content like "%' . $_POST['content'] . '%" ';
		}
        $count_sql = "SELECT COUNT(id) AS num FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' {$all_news}{$filter}AND visibility = 'true' ORDER BY position;";
        $count_res = db_fetch($count_sql);
        $count = empty($count_res) ? 0 : $count_res['num'];
        $max_page = ceil($count / $per_page);
        $tpl['page_num'] = $page;
        $tpl['page_max'] = $max_page;
        $tpl['item_count'] = $count;
        $tpl['title'] = $this->storage->section["title"];
        $tpl['content'] = $this->storage->section["content"];
        $tpl['section'] = $this->storage->section;
        $tpl['all_par'] = $all ? '&all=show' : null;
        //Pager: end
        $sql = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' {$all_news}{$filter}AND visibility = 'true' ORDER BY position{$limit};";
        $res = db_fetch_all($sql);
//        if (empty($res))
//            return ($this->storage->content = NULL);
        $tpl['news'] = $res;
        $tpl['idx'] = $this->storage->section['idx'];
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('list', $tpl);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function events()
    {
        $this->storage->title = $this->storage->section['title'];
        $all = (get('all') == 'show');
		$menu_sql = "SELECT id FROM " . c("table.menus") . " WHERE `deleted` = '0' AND `type` = 'event' AND `title` = '{$this->storage->section['attached']}'";
        $menu_array = db_fetch($menu_sql);
		$menu_id = $menu_array["id"];
        if (!$all AND (empty($menu_id) OR $menu_id == 'NULL'))
            return ($this->storage->content = NULL);
        $all_news = $all ? " AND menuid IN (SELECT id FROM `".c("table.menus")."` WHERE `deleted` = '0' AND type = 'events') " : " AND menuid = {$menu_id} ";
        //Pager: start
        $page = get('page', 1);
        $per_page = c('pager.per_page');
        $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
        $count_sql = "SELECT COUNT(id) AS num FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' {$all_news}AND visibility = 'true' ORDER BY pagedate DESC;";
        $count_res = db_fetch($count_sql);
        $count = empty($count_res) ? 0 : $count_res['num'];
        $max_page = ceil($count / $per_page);
        $tpl['page_num'] = $page;
        $tpl['page_max'] = $max_page;
        $tpl['item_count'] = $count;
        $tpl['section'] = $this->storage->section;
        $tpl['all_par'] = $all ? '&all=show' : null;
        //Pager: end
        $sql = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' {$all_news}AND visibility = 'true' ORDER BY pagedate DESC{$limit};";
        $res = db_fetch_all($sql);
        if (empty($res))
            return ($this->storage->content = NULL);
        $tpl['news'] = $res;
        $tpl['idx'] = $this->storage->section['idx'];
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('events', $tpl);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function articles()
    {
        $rss = (get('feed') == 'rss');
        $this->storage->title = $this->storage->section['title'];
        $all = (get('all') == 'show');
		$menu_sql = "SELECT id FROM " . c("table.menus") . " WHERE `deleted` = '0' AND `type` = 'articles' AND `title` = '{$this->storage->section['attached']}'";
        $menu_array = db_fetch($menu_sql);
		$menu_id = $menu_array["id"];
        if (!$all AND (empty($menu_id) OR $menu_id == 'NULL'))
            return ($this->storage->content = NULL);
        $all_news = $all ? " AND menuid IN (SELECT id FROM `".c("table.menus")."` WHERE `deleted` = '0' AND type = 'list') " : " AND menuid = {$menu_id} ";
        //Pager: start
        $page = get('page', 1);
        $per_page = c('pager.per_page');
        $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";
		$filter = '';
		if(isset($_POST['search_submit'])) {
			if($_POST['date']<>'') $filter .= ' AND date_format(pagedate,"%Y-%m-%d")="' . $_POST['date'] . '" ';
			if($_POST['number']<>'') $filter .= ' AND item_number="' . $_POST['number'] . '" ';
			if($_POST['title']<>'') $filter .= ' AND title like "%' . $_POST['title'] . '%" ';
			if($_POST['content']<>'') $filter .= ' AND content like "%' . $_POST['content'] . '%" ';
		}
        $count_sql = "SELECT COUNT(id) AS num FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' {$all_news}{$filter}AND visibility = 'true' ORDER BY position;";
        $count_res = db_fetch($count_sql);
        $count = empty($count_res) ? 0 : $count_res['num'];
        $max_page = ceil($count / $per_page);
        $tpl['page_num'] = $page;
        $tpl['page_max'] = $max_page;
        $tpl['item_count'] = $count;
        $tpl['title'] = $this->storage->section["title"];
        $tpl['content'] = $this->storage->section["content"];
        $tpl['section'] = $this->storage->section;
        $tpl['all_par'] = $all ? '&all=show' : null;
        //Pager: end
        $sql = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' {$all_news}{$filter}AND visibility = 'true' ORDER BY position;";
        $res = db_fetch_all($sql);
//        if (empty($res))
//            return ($this->storage->content = NULL);
        if ($rss)
        {
            echo template('rss', array(
                'news' => $res,
                'section' => $this->storage->section['id']
            ));
            exit;
        }
        $tpl['news'] = $res;
        $tpl['idx'] = $this->storage->section['idx'];
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('articles', $tpl);
		else
	        $this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function photo()
    {
        $sql_c = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND `masterid` = '{$this->storage->section['idx']}' order by position;";
        $res_c = db_fetch_all($sql_c);

		if(!empty($res_c)) {
			$photos["title"] = $this->storage->section['title'];
			$photos["children"] = $res_c;
			$photos["idx"] = $this->storage->section['idx'];
			if($this->storage->section["template"]=='') 
				$this->storage->content = template('galleries', $photos);
			else
				$this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
			return;
		}
		
        $this->storage->title = $this->storage->section['title'];
        $sql_v = "SELECT * FROM `".c("table.menus")."` WHERE `deleted` = '0' AND `type` = 'imagegallery' AND `title` = '{$this->storage->section['attached']}';";
        $res_v = db_fetch($sql_v);
		$menu_id = $res_v["id"];
//        $menu_id = db_retrieve('id', c("table.menus"), 'visibility', 'TRUE', "AND `type` = 'imagegallery' AND `name` = '{$this->storage->section['attached']}'");
        if (empty($menu_id) OR $menu_id == 'NULL')
        {
            return ($this->storage->content = NULL);
        }
        $sql = "SELECT * FROM `".c("table.galleries")."` WHERE `galleryid` = {$menu_id} AND `deleted` = '0' AND `language` = '" . l() . "' ORDER BY `position`;";
        $res = db_fetch_all($sql);

		$photos["photos"] = $res;
		$photos["title"] = $this->storage->section['title'];
        $photos['section'] = $this->storage->section;

		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('photos', $photos);
		else
			$this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

   function video()
    {
        $this->storage->title = $this->storage->section['title'];
        $sql_v = "SELECT * FROM `".c("table.menus")."` WHERE `deleted` = '0' AND  `type` = 'videogallery' AND `title` = '{$this->storage->section['attached']}';";
        $res_v = db_fetch($sql_v);
        $menu_id = $res_v["id"];
//        $menu_id = db_retrieve('id', c("table.menus"), 'visibility', 'true', "AND `type` = 'videogallery' AND `title` = '{$this->storage->section['attached']}'");
/*
        if (empty($menu_id) OR $menu_id == 'NULL')
        {
            return ($this->storage->content = NULL);
        }
*/
        $sql = "SELECT * FROM `".c("table.galleries")."` WHERE `galleryid` = {$menu_id} AND `deleted` = '0' AND  `language` = '" . l() . "' ORDER BY `position`;";
        $res = db_fetch_all($sql);
        if (empty($res))
        {
            return ($this->storage->content = NULL);
        }
  $videos["videos"] = $res;
  $videos["title"] = $this->storage->section['title'];
  $videos["content"] = $this->storage->section['content'];
        $videos['idx'] = $this->storage->section['idx'];
  if($this->storage->section["template"]=='') 
         $this->storage->content = template('videos', $videos);
  else
   $this->storage->content = template('custom/'.$this->storage->section["template"], $videos);
    }

    function audio()
    {
        $this->storage->title = $this->storage->section['title'];
        $sql_v = "SELECT * FROM `".c("table.menus")."` WHERE `deleted` = '0' AND `type` = 'audiogallery' AND `title` = '{$this->storage->section['attached']}';";
        $res_v = db_fetch($sql_v);
		$menu_id = $res_v["id"];
//        $menu_id = db_retrieve('id', c("table.menus"), 'deleted', '0', "AND `type` = 'audiogallery' AND `name` = '{$this->storage->section['attached']}'");
        if (empty($menu_id) OR $menu_id == 'NULL')
        {
            return ($this->storage->content = NULL);
        }
        $sql = "SELECT * FROM `".c("table.galleries")."` WHERE `galleryid` = {$menu_id} AND `language` = '" . l() . "' ORDER BY `position`;";
        $res = db_fetch_all($sql);
        if (empty($res))
        {
            return ($this->storage->content = NULL);
        }
		$audios["audios"] = $res;
		$audios["title"] = $this->storage->section['title'];
        $audios['idx'] = $this->storage->section['idx'];
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('audios', $audios);
		else
			$this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

    function poll()
    {
        $this->storage->title = $this->storage->section['title'];
        $sql_v = "SELECT * FROM `".c("table.menus")."` WHERE `deleted` = '0' AND `type` = 'poll' AND `title` = '{$this->storage->section['attached']}';";
        $res_v = db_fetch($sql_v);
		$menu_id = $res_v["id"];
		
		if(isset($_GET["vote_form_perform"])) {
			$ip = get_ip() . '-' . $_SERVER['REMOTE_ADDR'];
			$ippresent=db_fetch("select count(*) as cnt from pollips where votedate='".date("Y-m-d")."' and ip='".$ip."' and pollid='".$menu_id."' ");
			if($ippresent["cnt"]==0) {
				db_query("insert into `".c("table.pollips")."` (votedate, ip, pollid) values('".date("Y-m-d")."','".$ip."','".$menu_id."')");
				db_query("update `".c("table.pollanswers")."` set answercounttotal=answercounttotal+1 where id='".$_GET["pollanswers"]."'");
				db_query("update `".c("table.pollanswers")."` set answercount=answercount+1 where id='".$_GET["pollanswer"]."' and language='".l()."'");
			}
		}
        if (empty($menu_id) OR $menu_id == 'NULL')
        {
            return ($this->storage->content = NULL);
        }
        $sql = "SELECT * FROM `".c("table.pollanswers")."` WHERE `pollid` = {$menu_id} AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' ORDER BY `position`;";
        $res = db_fetch_all($sql);
        if (empty($res))
        {
            return ($this->storage->content = NULL);
        }
		$poll["answers"] = $res;
		$poll["pollid"] = $res_v["id"];
		$poll["id"] = $this->storage->section['id'];
		$poll["title"] = $this->storage->section['title'];
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('poll', $poll);
		else
			$this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

     function catalog()
    {
        $this->storage->title = $this->storage->section['title'];
        $sql_c = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND `visibility`='true' AND `masterid` = '{$this->storage->section['idx']}' order by position;";
        $res_c = db_fetch_all($sql_c);

		if(isset($_GET["product"])) {
	        $sql_p = "SELECT * FROM `".c("table.catalogs")."` WHERE `id` = {$_GET['product']} AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "';";
	        $res_p = db_fetch($sql_p);
			$product["id"] = $_GET["product"];
			$product["product"] = $res_p;
			$product["title"] = $this->storage->section['title'];
			$product["description"] = $this->storage->section['description'];
			$product["idx"] = $this->storage->section['idx'];
			$this->storage->content = template('product', $product);
			return;
		}

		if(!empty($res_c)) {
			$catalog["title"] = $this->storage->section['title'];
			$catalog["children"] = $res_c;
			$catalog["idx"] = $this->storage->section['idx'];
			$this->storage->content = template('catalogs', $catalog);
			return;
		} else {
		}
		
        $sql_v = "SELECT * FROM `".c("table.menus")."` WHERE `deleted` = '0' AND `type` = 'catalog' AND `title` = '{$this->storage->section['attached']}';";
        $res_v = db_fetch($sql_v);
		$menu_id = $res_v["id"];
        if (empty($menu_id) OR $menu_id == 'NULL')
        {
            return ($this->storage->content = NULL);
        }
		
		$category=get('category', '');
		$filter =  ($category!='') ? " AND Categories like  '%".$category."%'" : "";		
		if(isset($_GET["perform"])) {
			if(get('brand',0)>0) $filter .= " AND doc1 = '".get('brand',0)."'";
			$filter .= " AND price >= '".get('price1',0)."'";
			$filter .= " AND price <= '".get('price2',0)."'";
		}
		$orderfield='price';
		if(get('sort1', 1) == 2) $orderfield='productdate';
		if(get('sort1', 1) == 3) $orderfield='title';
		$orderdir='asc';
		if(get('sort2', 1) == 2) $orderdir='desc';
		$order = $orderfield.' '.$orderdir;
		
        $page = get('page', 1);
        $per_page = 150;
        $limit = " LIMIT " . (($page - 1) * $per_page) . ", {$per_page}";

        $sql = "SELECT * FROM `".c("table.catalogs")."` WHERE `catalogid` = {$menu_id} AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' {$filter} ORDER BY ".$order." {$limit};";
        //die($sql);
		$cnt = "SELECT count(*) as cnt FROM `".c("table.catalogs")."` WHERE `catalogid` = {$menu_id} AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "'  {$filter} ORDER BY ".$order.";";
		$pager = 1;
		$cattype = 1;
		
		if(isset($_POST['search'])) {
	        $sql = "SELECT * FROM `".c("table.catalogs")."` WHERE `title` like '%".$_POST['search']."%' AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' ORDER BY `".get('order', 'position')."` {$limit};";
			$cnt = "SELECT count(*) as cnt FROM `".c("table.catalogs")."` WHERE `title` like '%".$_POST['search']."%' AND `deleted`=0 AND `visibility`='true' AND `language` = '" . l() . "' ORDER BY `".get('order', 'position')."`;";
			$pager = 0;
			$cattype = 2;
		}
        $res = db_fetch_all($sql);
        $cres = db_fetch($cnt);

        $count = empty($cres) ? 0 : $cres['cnt'];
        $max_page = ceil($count / $per_page);
        $catalog['page_num'] = $page;
        $catalog['page_max'] = $max_page;
        $catalog['item_count'] = $count;

		$catalog["items"] = $res;
		$catalog["totalcount"] = $cres["cnt"];
		$catalog["count"] = get('count', '15');
		$catalog["start"] = get('start', '0');
		$catalog["catalogid"] = $res_v["id"];
		$catalog["pager"] = $pager;
		$catalog["link"] = href($this->storage->section['id']);
		$catalog["cattype"] = $cattype;
		$catalog["id"] = $this->storage->section['id'];
		$catalog["idx"] = $this->storage->section['idx'];
		$catalog["title"] = $this->storage->section['title'];
		if($this->storage->section['template']==2) 
			$this->storage->content = template('catalog2', $catalog);
		else
			$this->storage->content = template('catalog', $catalog);
	}

    function faq()
    {
        $this->storage->title = $this->storage->section['title'];
		$menu_sql = "SELECT id FROM " . c("table.menus") . " WHERE `deleted` = '0' AND `type` = 'faq' AND `title` = '{$this->storage->section['attached']}'";
        $menu_array = db_fetch($menu_sql);
		$menu_id = $menu_array["id"];
        if (empty($menu_id) OR $menu_id == 'NULL')
            return ($this->storage->content = NULL);
        $sql = "SELECT * FROM `".c("table.pages")."` WHERE `deleted` = '0' AND language = '" . l() . "' AND menuid='".$menu_id."' AND visibility = 'true' ORDER BY position;";
        $res = db_fetch_all($sql);
	    $tpl['title'] = $this->storage->section['title'];
	    $tpl['content'] = $this->storage->section['content'];
        $tpl['news'] = $res;
        $this->storage->content = $sql;
		if($this->storage->section["template"]=='') 
	        $this->storage->content = template('faq', $tpl);
		else
			$this->storage->content = template('custom/'.$this->storage->section["template"], $tpl);
    }

}
