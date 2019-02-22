<?php
function pagetitle($title){
	$ttl = "SELECT title FROM pages WHERE id='".$title."' AND language='".l()."' AND deleted=0 AND visibility='true'";
	$title_pages = db_fetch($ttl);
	$out = '';
	$out .=''.$title_pages['title'].'';
	return $out;
}
function cat_title($title){
	$ttl = "SELECT title FROM ".c("table.catalogs")." WHERE catalogid='".$title."' AND language='".l()."' AND deleted=0 AND visibility='true'";
	$title_cat = db_fetch($ttl);
	$out = '';
	$out .=''.$title_cat['title'].'';
	return $out;
}
function gallery_info(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id = 55;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = '
                        <div class="title">'.$newshome["menutitle"].'</div>
						<div class="sub-title">'.$newshome["description"].'</div>
			';
    return $out;
	}
function ProductSlide()
{
	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.catalogs") . " WHERE  language = '" . l() . "' AND deleted=0  AND visibility = 'true' AND `hot`=1" );

	if( $slides )
	{
		$i = 0;
		foreach($slides as $promo)
		{
		$result1 = mysql_query("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$promo['catalogid']."'");
		$item1 = mysql_fetch_array($result1);

		$result2 = mysql_query("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
		$item2 = mysql_fetch_array($result2);
			
			if($promo["description"] == "")
				$promo["description"] = "javascript:";
            
			$out .= '<div class="list">';
			
			$out .= '<div class="name"><a href="'.$item2["slug"]."?product=".$promo["id"].'"">'.$promo["title"].'</a></div>';
			
			$out .= '<div class="img"><a href="'.$item2["slug"]."?product=".$promo["id"].'""><img src="crop.php?img='.$promo["photo1"].'&width=127&height=85" width="127" height="85" alt="" /></a></div>';
				
				$out .= '<div class="bot fix">';
				
		if($promo['saleprice']!=''){
					$out .= '<div class="price">'.$promo["price"].' '.l('val').'</div>	';
					$out .= '<div class="sale">'.$promo['saleprice'].' '.l('val').'</div>	';	
		} else {
					$out .= '<div class="sale">'.$promo['price'].' '.l('val').'</div>	';	
				}
				$out .= '</div>';
			
				
			$out .= '</div>';
			
			$i++;
		}
								
	}

	return $out;
}

function ProductSimilarSlide12($catalogid=0)
{
	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.catalogs") . " WHERE ".(($catalogid==0) ? '' : 'catalogid='.$catalogid.' AND ')." language = '" . l() . "' AND deleted=0  AND visibility = 'true'" );

	if( $slides )
	{
		
		$i = 0;
		foreach($slides as $promo)
		{
		$result1 = mysql_query("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$promo['catalogid']."'");
		$item1 = mysql_fetch_array($result1);

		$result2 = mysql_query("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
		$item2 = mysql_fetch_array($result2);
			
			if($promo["description"] == "")
				$promo["description"] = "javascript:";
            
			$out .= '<div class="list fix">';
			
			$out .= '<div class="name"><a href="'.$item2["slug"]."?product=".$promo["id"].'"">'.$promo["title"].'</a></div>';
			
			$out .= '<div class="img"><a href="'.$item2["slug"]."?product=".$promo["id"].'""><img src="crop.php?img='.$promo["photo1"].'&width=127&height=85" width="127" height="85" alt="" /></a></div>';
				
				$out .= '<div class="bot fix">';
				
		if($promo['saleprice']!=''){
					$out .= '<div class="price">'.$promo["price"].' '.l('val').'</div>	';
					$out .= '<div class="sale">'.$promo['saleprice'].' '.l('val').'</div>	';	
		} else {
					$out .= '<div class="sale">'.$promo['price'].' '.l('val').'</div>	';	
				}
					
				$out .= '</div>';
			
				
			$out .= '</div>';
			
			$i++;
		}
								
	}

	return $out;
}

function ProductSimilarSlide($id=0, $productid=0)
{
	if($id!=0) {
		$q1 = db_fetch("select * from pages where language='".l()."' and id=".$id);
		$q2 = db_fetch("select * from menus where language='".l()."' and title='".$q1["attached"]."'");
		$id = $q2["id"];
	}


	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.catalogs") . " WHERE ".(($id==0) ? '' : 'catalogid='.$id.' AND ')." id<>".$productid." and language = '" . l() . "' AND deleted=0 AND visibility = 'true'");
	if( $slides )
	{
		
		$i = 0;
		foreach($slides as $promo)
		{
		$item1 = db_fetch("SELECT * FROM ".c("table.menus")." WHERE language = '" . l() . "' AND id='".$promo['catalogid']."'");
		$item2 = db_fetch("SELECT * FROM ".c("table.pages")." WHERE language = '" . l() . "' AND attached='".$item1['title']."'");
			
			if($promo["description"] == "")
				$promo["description"] = "javascript:";
            
			$out .= '<div class="tour fix">';

			$out .= '<div class="img left"><a href="'.href($item2["id"])."?product=".$promo["id"].'""><img src="crop.php?img='.$promo["photo1"].'&width=210&height=130" width="210" height="130" alt="" /></a></div>';
			
			$out .= '<div class="tour-ttl">
						<h4><a href="'.href($item2["id"])."?product=".$promo["id"].'"">'.$promo["title"].'</a></h4>
					</div>';
				
			$out .= '<div class="tour-txt">'.$promo["description"].'</div>';

			if($promo["duration"]!='' || $promo["price"]!=''){

				if($promo["duration"]!=''){
				$out .= '<div class="offer fix">
					<div class="left"><span>'.((l()=='ge') ? 'ხანგრძლივობა:':'Duration:').'</span> '.$promo["duration"].'</div>';
				}

				if($promo["price"]!=''){
				$out .= '<div class="right"><span>'.((l()=='ge') ? 'ფასი:':'Price:').'</span> <span class="price">'.$promo["price"] . ' USD</span> ' .((l()=='ge') ? '/ ერთ პიროვნებაზე':'/ per person').'</div>
				</div>';	
				}
			}

			$out .= '</div>';
			
			$i++;
		}
								
	}

	return $out;
}

function getMainSlideImages_old_()
{
    global $lang_id;
    $sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 3 AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position;";
    $out  = '';
 $promos = db_fetch_all($sql); 
 $content = array();
 if( count($promos) > 0 )
 { 
  $i = 0;
  foreach($promos as $promo)
  {    
     $i++;
     $lnk = ($promo["itemlink"]!='') ? $promo["itemlink"] : "#";
   
   $content[] = '{
				<div class="items">
					<div class="img-container" data-bg-img="'.$promo["file"].'"></div>
					<!-- Change the URL section based on your image\'s name -->
					<div class="slide-caption">
						<div class="inner-container clearfix">
							<div class="up-sec">'.$promo["title"].'</div>
							<div class="down-sec">'.$promo["description"].'</div>
						</div>
					</div>
				</div>
   }';
     $i++;
  }  
    $out .= implode(',', $content);
 } 
 return $out; 
}

function getPageSlideImages($id)
{
	$p = db_fetch("select * from pages where language='".l()."' and id=".$id);
	$idx=$p["idx"];
    global $lang_id;
    $sql = "SELECT * FROM " . c("table.attached") . " WHERE page = ".$idx." ;";
    $out  = '';
 $promos = db_fetch_all($sql); 
 $content = array();
 $lnk = "";
  $content[] = '{
    "title" : "'.$p["title"].'",
    "image" : "'.$p["imagen"].'",
    "url" : "'.$lnk.'",
    "firstline" : "'.$p["title"].'",
    "secondline" : "'.((l()=='ge') ? 'სრულად ნახვა' : 'Read More').'",
	"href" : "'.$lnk.'"
   }';
 { 
  $i = 0;
  foreach($promos as $promo)
  {    
     $i++;
     $lnk = "";
   
   $content[] = '{
    "title" : "'.$promo["title"].'",
    "image" : "'.$promo["path"].'",
    "url" : "'.$lnk.'",
    "firstline" : "'.$promo["title"].'",
    "secondline" : "'.((l()=='ge') ? 'სრულად ნახვა' : 'Read More').'",
	"href" : "'.$lnk.'"
   }';
   $i++;
  }
 } 
 $out .= implode(',', $content);
 return $out; 
}

function slogd()
{
	$out = '';
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND deleted = 0 AND level = 2 AND visibility = 'true' ORDER BY position LIMIT 1;";
    $sections = db_fetch_all($sql);
	if (empty($sections))
        return NULL;
		
		
    foreach ($sections AS $slog) {
		$out .= ''.$slog["id"].''."\n";
		$out .= ''.$slog["menutitle"].''."\n";
		
	}
    return $out;
}

function slog()
{
    $storage = Storage::instance();
	$out = '';
    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id = '".c("section.home")."' LIMIT 1;");
	$segment = '';
    if (is_numeric($storage->segments[count($storage->segments) - 1])) {
	    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id = '{$storage->segments[count($storage->segments) - 2]}' LIMIT 1;");
		$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
	
	} else {
		for($i=0; $i<count($storage->segments); $i++) :
			$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
			$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE level = 2 AND language = '" . l() . "' AND slug = '{$segment}' LIMIT 1;");
			$title = $page['menutitle'];
			$out .= '' . $title . ''."\n";
		endfor;
	}
    return $out;
}


function faq_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 2 order by pagedate ASC limit 0, 4;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '<div class="list">
				 <div class="question"><a href="'.$link.'">'.$newhome['title'].'</a></div>
				 </div>';
		}								
										
    return $out;
	}

function ourteam_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid =5 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	echo '<div class="block-title"><h2><a href="'.href(5).'"> '.((l()=='ge') ? 'ჩვენი გუნდი':'our team').'</a></h2></div>';

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '
				<div class="member fix">
				<div class="bor">';
				$out .= '<a href="' . $link . '">' . $newhome['title'] . '</a>
						<p>' . $newhome['description'] . '</p>
						 </div></div>';
				}	
		
    return $out;
	}
 
function welcome_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id = 16;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = '
				<div class="col-xs-12 col-sm-12 col-md-6 col-centered center-block">
					<div class="row">
						<div class="title">
							<h6>'.$newshome["title"].'</h6>
							<h3>'.$newshome["menutitle"].'</h3>
							<div class="col-xs-6 col-sm-4 col-md-4 cap col-centered center-block">
								<span><img alt="" src="'.WEBSITE.'/images/cap.png" class="img-responsive"></span>
							</div>
							'.$newshome["description"].'
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="left-welcome">
							'.$newshome["content"].'
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="right-welcome">
							<div id="promovid">
							<img src="'.$newshome["imagen"].'" class="img-responsive" alt="'.$newshome["menutitle"].'" title="'.$newshome["menutitle"].'">
							</div>
						</div>
					</div>
				</div>	
			';
    return $out;
	}
	
function about_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id = 16;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = '
                <div class="l-sec col-md-7">
					<div class="ravis-title-t-1">
						<div class="title"><span>'.$newshome["menutitle"].'</span></div>
						<div class="sub-title">'.$newshome["title"].'</div>
					</div>
					<div class="content">
						'.$newshome["content"].'
					</div>
				</div>
				<div class="r-sec col-md-5">
					<img src="'.$newshome["imagen"].'" alt="'.$newshome["title"].'">
				</div>
			';
    return $out;
	}
	
function about_home_footer(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id = 16;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = '
				
						<h4 class="title">
							'.$newshome["menutitle"].''.$newshome["title"].'
						</h4>
						<div class="widget-content text-widget">
							'.$newshome["content"].'
						</div>
			';
    return $out;
	}
	
function rooms_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id = 3;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = '
							<h3>'.$newshome["title"].'</h3>
							<div class="col-xs-4 col-sm-4 col-md-4 cap col-centered center-block">
								<span><img class="img-responsive" src="'.WEBSITE.'/images/cap.png" alt=""></span>
							</div>
							'.$newshome["content"].'
			';
    return $out;
	}
	
function room_home($idx)
{
	global $storage;
    $sql = "SELECT level, title, idx, redirectlink, menutitle, template, masterid, menuid FROM " . c("table.pages") . " WHERE visibility = 'true' AND deleted='0' AND idx=".$idx.";";
	$lvl = db_fetch($sql);
	
	if($lvl["level"] == 1) $master = $idx ; else $master=$lvl["masterid"];
    $sql = "SELECT title FROM " . c("table.pages") . " WHERE idx=".$master.";";
	$main = db_fetch($sql);
	$out = '';
 //   $out .= '<div class="title fix"><h2>'.$main["title"].'</h2></div>'."\n";
	
	$sql = "SELECT id, title, idx, redirectlink, menutitle, meta_desc, imagen, template FROM " . c("table.pages") . " WHERE visibility = 'true' AND deleted='0' AND language='".l()."' AND masterid=".$master." ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return $out;

	for ($idx = 0, $num = count($sections); $idx < $num; $idx++)
    {
		$link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		$out .= '
			<div class="room-boxes col-sm-5 col-md-707">
				<a href="' . $link . '" class="inner-container" data-bg="'.$sections[$idx]['imagen'].'">
					<span class="ravis-title">
						<span class="inner-box">
							<span class="title">'.$sections[$idx]['title'].'</span>
						</span>
					</span>
				</a>
			</div>
				'."\n"; 
	}
	return $out;
}

function product_home()
{
    $sql = "SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND hot=1 order by rand() limit 0, 4;";
    $homepage = db_fetch_all($sql);
    if (empty($homepage))
        return NULL;
    $out = NULL;
	$i=0;
    foreach ($homepage AS $home) {
		$cat=db_fetch("select * from menus where language='".l()."' and id=".$home["catalogid"]);
		$catpage=db_fetch("select * from pages where language='".l()."' and attached='".$cat["title"]."'");
        $i++;
		$out .= '
        		<article class="tour1 left">
				<div class="img">
						<a href="'.href($catpage["id"]).'/'.$home['id'].'"><img src="'.$home['photo1'].'" width="220" height="220" alt="" /></a>
					</div>
	        	 <header class="title">
                        <h2>'.$home["title"].'</h2>
                        <div class="price">'.$home["price"].'$</div>
                    </header>
               
					
					
				  </article>'."\n";

	}
    return $out;
}

            
function product_home2()
{
    $sql = "SELECT * FROM ".c("table.catalogs")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND top25=1 order by rand() limit 0, 6;";
    $homepage = db_fetch_all($sql);
    if (empty($homepage))
        return NULL;
    $out = NULL;
	$i=0;
    foreach ($homepage AS $home) {
		$cat=db_fetch("select * from menus where language='".l()."' and id=".$home["catalogid"]);
		$catpage=db_fetch("select * from pages where language='".l()."' and attached='".$cat["title"]."'");
        $i++;
		$out .= '
        		  <article class="tour left">
                        <div class="img">
                            <a href="'.href($catpage["id"]).'/'.$home['id'].'"><img src="'.$home['photo1'].'" height="130" width="300" alt=""></a>
                        </div>
                           <header class="title">
                            <hgroup>
                           
                               <a href="'.href($catpage["id"]).'/'.$home['id'].'">  <h2>'.$home['street'].'</h2><h3>'.$home['title'].'</h3></a>
                            </hgroup>
                            <div class="price">'.$home['price'].'$</div>
                            <div class="more">
                                <a href="'.href($catpage["id"]).'/'.$home['id'].'"><img src="_website/images/more.png" height="19" width="19" alt=""></a>
                            </div>
                        </header>
                
                    </article>      '."\n";

	}
    return $out;
}
function text_home($id)
{
    $text = db_fetch("SELECT idx FROM ".c("table.pages")." WHERE id='".$id."' AND language='".l()."' AND deleted=0");
	$hometext = db_fetch_all("SELECT * from ".c("table.pages")." where language='".l()."' and masterid=".$text["idx"]." AND visibility='true' and deleted=0 ORDER by position limit 0,6;");
    if (empty($hometext))
        return NULL;
    $out = NULL;
	$last = NULL;
	$i=0;
    foreach ($hometext AS $home) {
		$link = href($home["id"]);
        $i++;
		if ($i == 3) {$last = " last"; $i=0;} else {$last=NULL;}
			$out .= '<div class="block left'.$last.'">
                        <div class="img">
							<a href="'.$link.'"><img src="crop.php?img='.$home['imagen'].'&width=300&height=110" width="300" height="110" alt="" title="" /></a>
                        </div>
                        <!-- .img -->
                        <div class="title">
                            <div class="more right"><a href="'.$link.'">'.l('more').'</a></div>
                            <h3>'.$home["title"].'</h3>
                            '.$home["description"].'
                        </div>
                        <!-- .title -->
                    </div>
                    <!-- .block left -->'."\n";
	}
    return $out;
}

function links($idx) {
//	$sql = db_fetch("SELECT idx, id from pages where id = ".$storage->section["id"]." and language = '" . l() . "'");
	$cat = db_fetch_all("SELECT * from pages where masterid = ".$idx." and language = '" . l() . "' AND deleted = 0 AND visibility='true' order by position");
    if (empty($cat))
        return NULL;
    $out = NULL;
    $last = NULL;
	$i=0;
	foreach($cat as $s) :
		$link = href($s['id']);
		$i++;
		if ($i == 3) {$last = " last"; $i=0;} else {$last=NULL;}
			$out .= '<div class="block left'.$last.'">
                        <div class="img">
                            <a href="'.$link.'"><img src="crop.php?img='.$s['imagen'].'&width=300&height=110" width="300" height="110" alt=""></a>
                        </div>
                        <!-- .img -->
                        <div class="title">
                            <div class="more right"><a href="'.$link.'">More</a></div>
                            <h3>'.$s["title"].'</h3>
                            '.$s["description"].'
                        </div>
                        <!-- .title -->
                    </div>
                    <!-- .block left -->'."\n";
		
	endforeach;
	return $out;	
}


function contact_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND id =5;";
	$newshome = db_fetch($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;
	$link = href($newshome['id']);
    $out = $newshome["description"];
    return $out;
	}


function getMainSlideImages_old(){
	$out  = '';	
	$slides = db_fetch_all("SELECT * FROM " . c("table.galleries") . " WHERE  language = '" . l() . "' AND deleted=0 AND galleryid=3 AND visibility = 'true' limit 6" );
	if( $slides ) {
		foreach($slides as $gal) {
			$out.='
				<div class="items">
					<div class="img-container" data-bg-img="'.$gal["file"].'"></div>
					<!-- Change the URL section based on your image\'s name -->
					<div class="slide-caption">
						<div class="inner-container clearfix">
							<div class="up-sec">'.$gal["title"].'</div>
							<div class="down-sec">'.$gal["description"].'</div>
						</div>
					</div>
				</div>
				';
		}
	}
    return $out;
	}

function video_home(){
	$out  = '';	
	$slides = db_fetch("SELECT * FROM " . c("table.galleries") . " WHERE  language = '" . l() . "' AND deleted=0 AND galleryid=11 AND visibility = 'true' order by position desc limit 1" );
	$vid = str_replace('http://www.youtube.com/watch?','',str_replace('http://youtu.be/','',$slides['file']));
	$out.='
					<object width="320" height="175">
						<param name="movie" value="http://www.youtube.com/v/'.$vid.'?version=3&amp;hl=en_US"></param>
						<param name="allowFullScreen" value="true"></param>
						<param name="allowscriptaccess" value="always"></param>
						<param name="wmode" value="transparent"></param>
						<embed src="http://www.youtube.com/v/'.$vid.'?version=3&amp;hl=en_US" type="application/x-shockwave-flash" width="320" height="175" wmode="transparent" allowscriptaccess="always" allowfullscreen="true"></embed>
					</object>';      
    return $out;
	}


function banners($banner_num)
{
	$sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = '".$banner_num."' AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position LIMIT 0,3;";
    $banners = db_fetch_all($sql);
    if (empty($banners))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($banners AS $banner) {
			if ($banner["itemlink"] == '') {
				$banner["itemlink"] = "javascript:;";
			}
           	$out .= '<div class="img">
						<a href="'.$banner["itemlink"].'" target="_blank"><img src="crop.php?img='.$banner['file'].'&width=214&height=54" width="214" height="54" alt="'.$banner['title'].'" /></a>
                    </div>
                    <!-- .img -->'."\n";
	}
    return $out;
}

function left_menu()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 5 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = '<script>visible=0;</script>', $num = count($sections); $idx < $num; $idx++)
    {
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 5 AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
	        $out .= '<li' . ($idx == ($num - 1) ? ' class="last"' : '') . '>'."\n";
	        $out .= '<a id="href'.$sections[$idx]['id'].'" href="javascript:leftmenu('.$sections[$idx]['id'].');" ' . (($idx == 0) ? ' class="first"' : '') . '>' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		} else {
	        $out .= '<li ' . ($idx == ($num - 1) ? ' class="last"' : '') . '>'."\n";
	        $out .= '<a id="href'.$sections[$idx]['id'].'" href="' . $link . '" ' . (($idx == 0) ? ' class="first"' : '') . '>' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		}
		if(count($sections_in) > 0) {
			$out .= '<ul class="sub leftsub" style="display:none;" id="sub'.$sections[$idx]['id'].'">'."\n";
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
				if($storage->section["id"]==$sections_in[$idx_in]['id'])
					$out .= '<script>
						visible = '.$sections[$idx]['id'].';
						$("#sub'.$sections[$idx]['id'].'").show();
						$("#href'.$sections[$idx]['id'].'").addClass("active");
					</script>';
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 4 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<div class="sub">'."\n";
					$out .= '</div>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
            $out .= '</ul>'."\n";
		} else {
	        $out .= ''."\n";
		}
        $out .= '</li>'."\n";
    }
    return $out;
}

function left_menu2()
{
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND masterid=0 AND deleted = 0 AND visibility = 'true' ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
	foreach($sections as $section) :
		$out .= '<div id="lmenu">';
		if($section['id']==19){
		$out .= '	<div class="female-title">'.$section['menutitle'].'</div>';
		}
		else if($section['id']==20){
		$out .= '	<div class="male-title">'.$section['menutitle'].'</div>';
		}
		else{
		$out .= '	<div class="fm-title">'.$section['menutitle'].'</div>';
		}
//		$out .= '	<div class="part">';
//		$out .= '		<div class="l-menu">';
		$out .= '			<ul>';
		$sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND deleted = 0 AND masterid = " . $section['idx'] . " AND visibility = 'true' ORDER BY position;";	
		$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
			{
				$link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
				$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '">' . $sections_in[$idx_in]['title'] . '</a>'."\n";
				$out .= '</li>'."\n";
				
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 6 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++) {
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li class="sub">'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['title'] . '</a>'."\n";
						$out .= '</li>'."\n";
					}
				}
			}
		}
		$out .= '			</ul>';
//		$out .= '		</div>';
//		$out .= '	</div>';				
		$out .= '	<div class="bot"></div>';
		$out .= '</div>';
	endforeach;
    return $out;
}

function bottom_menu() 
{
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND homepage = 'true' AND visibility = 'true' ORDER BY position LIMIT 0, 4;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$out .= '<div class="list"><ul>'."\n";
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
        $out .= '<li class="title"><a href="' . $link . '">' . ((l()=='ge') ? $sections[$idx]['title'] : $sections[$idx]['title']) . '</a></li>'."\n";
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$out .= '</li>'."\n";
			}
		}
		$out .= '</ul></div>'."\n";
	}
    return $out;
}

function home() 
{
	return template('home', array());
}

function getPromoImages()
{
    global $lang_id;
    $sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 11 AND language = '" . l() . "' AND deleted=0 AND visibility = 'true' ORDER BY position;";
    $out  = '';
	$promos = db_fetch_all($sql);	
	if( count($promos) > 0 )
	{	
		$i = 0;
		foreach($promos as $promo)
		{		  
		  	$i++;
		  	if($i==1) {
				$content = '<div id="center" class="center"><div class="img"><img src="' . $promo["file"] . '" width="920" height="380" alt="" class="pngfix" id="img'.$i.'"/></div>';
				$content .= '<div class="title"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["title"] . '</a></div></div>';
				$content .= '<div class="percent"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["description"] . '</a></div></div></div>';
				$content .= '<div id="center'.$i.'" style="display:none"><div class="img"><img src="' . $promo["file"] . '" width="920" height="380" alt="" class="pngfix" id="img'.$i.'"/></div>';
				$content .= '<div class="title"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["title"] . '</a></div></div>';
				$content .= '<div class="percent"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["description"] . '</a></div></div></div>';
			} else {
				$content = '<div id="center'.$i.'" style="display:none"><div class="img"><img src="' . $promo["file"] . '" width="920" height="380" alt="" class="pngfix" id="img'.$i.'"/></div>';
				$content .= '<div class="title"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["title"] . '</a></div></div>';
				$content .= '<div class="percent"><div><a href="' . $promo["itemlink"] . '" class="pngfix">' . $promo["description"] . '</a></div></div></div>';
			}
		  	$out .= $content;
		}		
	}	
	$out .= '<script language="javascript">maxnum='.$i.';</script>';
	return $out;	
}

function gallery()
{
	$sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 6 AND language = '" . l() . "' AND deleted=0  AND visibility = 'true' ORDER BY position;";
    $banners = db_fetch_all($sql);
    if (empty($banners))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($banners AS $banner) {
		$i++;
		$out .= '
						<li class="item col-xs-6 col-md-4 lobby">
							<figure>
								<img src="'.$banner['file'].'" alt="'.$banner["title"].'"/>
								<a href="'.$banner['file'].'" class="more-details"
								   data-title="'.$banner["title"].'">'.$banner["title"].'</a>
								<figcaption>
									<h4>'.$banner["title"].'</h4>
								</figcaption>
							</figure>
						</li>		
				 '."\n";
	}
    return $out;
}

function is_text()
{
    return in_array(Storage::instance()->page_type, array('text', 'about', 'sitemap'));
}


function content($content = NULL)
{
    if (empty($content))
        return NULL;
    $content = str_replace('&nbsp;', ' ', $content);
    return html_entity_decode($content);
}

function contact_info()
{
    $language = l();
    $contact_info = db_retrieve('description', c("table.pages"), 'id', c('section.contact'), "AND language = '{$language}' LIMIT 1");
    return empty($contact_info) ? NULL : $contact_info;
}

function location()
{
    $storage = Storage::instance();
	$out = '';
    $page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id= '".c("section.home")."' AND deleted= '0' LIMIT 1;");
	if($storage->section["id"]!=1)
		$out .= '<li><a href="' . href(c("section.home")) . '">' . $page["title"] . '</a></li>'."\n";
	$segment = '';
    if (is_numeric($storage->segments[count($storage->segments) - 1])) {
		if($storage->section["category"]==16) {
			for($i=0; $i<count($storage->segments)-2; $i++) :
				$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
				$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' AND deleted= '0'  LIMIT 1;");
				$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
				$title = $page['title'];
				$out .= '<li><a href="' . $link . '">' . $title . '</a></li>'."\n";
			endfor;
			$product = db_fetch("select * from catalogs where language='".l()."' and id=".db_escape($_GET["product"]));
			$cat=db_fetch("SELECT * from menus where language='".l()."' and id=".$product["catalogid"]);
			$catpage=db_fetch("SELECT * from pages where language='".l()."' and attached='".$cat["title"]."'");
			$out .= '<li class="current"><a href="'.href($catpage["id"], array(), l(), $product['id']).'">' . $product["title"] . '</a></li>'."\n";
		} else {
			$menu = db_fetch("SELECT * FROM " . c("table.menus") . " WHERE language = '" . l() . "' AND id = '".$storage->section['menuid']."' LIMIT 1;");
			$group = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND attached = '".$menu['title']."' AND deleted= '0'  LIMIT 1;");
			$segments = explode("/", $group["slug"]);
			for($i=0; $i<count($segments); $i++) :
				$segment .= (($segment!='') ? '/' : '').$segments[$i];
				$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' AND deleted= '0'  LIMIT 1;");
				$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
				$title = $page['title'];
				$out .= '<li><a href="' . $link . '">' . $title . '</a></li>'."\n";
			endfor;
			$link = (($storage->section['redirectlink'] == '') || ($storage->section['redirectlink'] == 'NULL')) ? href($storage->section['id']) : $storage->section['redirectlink'];
			$title = $storage->section['title'];
			$out .= '<li class="current"><a href="' . $link . '">' . $title . '</a></li>'."\n";
		}
	} else {
		for($i=0; $i<count($storage->segments); $i++) :
			$segment .= (($segment!='') ? '/' : '').$storage->segments[$i];
			$page = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND slug = '{$segment}' AND deleted= '0'  LIMIT 1;");
			$link = (($page['redirectlink'] == '') || ($page['redirectlink'] == 'NULL')) ? href($page['id']) : $page['redirectlink'];
			$title = $page['title'];
			$out .= '<li'.(($i==count($storage->segments)-1) ? ' class="active"' : '').'><a href="' . $link . '">' . $title . '</a></li>'."\n";
		endfor;
	}
    return $out;
}

function calendar() 
{
    $storage = Storage::instance();
    $day=date("d");	 	if (isset($_GET['day']))    { $day = $_GET['day']; }    
    					if (isset($_POST['day']))   { $day = $_POST['day']; }
    $month=date("m");  	if (isset($_GET['month']))  { $month = $_GET['month']; }    
    					if (isset($_POST['month'])) { $month = $_POST['month']; }
    $year=date("Y");    if (isset($_GET['year']))   { $year = $_GET['year']; }      
    					if (isset($_POST['year']))  { $year = $_POST['year']; }
    $month=intval($month);
    $year=intval($year);
    $day=intval($day);
	
	$daysinmonth=date("t", mktime(0, 0, 0, $month, 1, $year));
	$daynumber=date("w", mktime(0, 0, 0, $month, 1, $year)); 
//	if ($daynumber==0) { $daynumber=7; }	
	$rows=ceil(($daysinmonth+$daynumber-1)/7);
	$yearp = $year;
	$monthp = $month - 1; if($monthp == 0) { $monthp = 12; $yearp = $year - 1; } 
	$dimp = date("t", mktime(0, 0, 0, $monthp, 1, $yearp));
	$yearn = $year;
	$monthn = $month + 1; if($monthn == 13) { $monthn = 1; $yearn = $year + 1; } 
	$dimn = 1;
	$out = '';

	$monthnames = c('month.names');
	$out .= '<ul class="arrow-part fix">';
	$out .= '	<li class="arrow"><a href="'.href(18, array('year'=>$yearp,'month'=>$monthp,'day'=>$dimp), l()).'"><img src="' . WEBSITE . '/images/l-arrow.png" width="6" height="9" alt="" /></a></li>';
	$out .= '	<li class="month">'.$monthnames[$month][l()].' '.$year.'</li>';
	$out .= '	<li class="arrow"><a href="'.href(18, array('year'=>$yearn,'month'=>$monthn,'day'=>$dimn), l()).'"><img src="' . WEBSITE . '/images/r-arrow.png" width="6" height="9" alt="" /></a></li>';
	$out .= '</ul>';
	$out .= '<table border="1" cellpadding="0" cellspacing="0" class="table">';
	$daytodisplay=1;
	for ($i=1; $i<=$rows; $i++) {
		$out .= '<tr>';
  		for ($j=1; $j<=7; $j++) {
			if (($i==1) && ($j<$daynumber)) {
				$out .= '<td></td>';
			} else {
				if ($daytodisplay>$daysinmonth) {
					$out .= '<td></td>';
				} else {
					$d1 = $year . '-' . $month . '-' . $daytodisplay . ' 23:59:59';
					$d2 = $year . '-' . $month . '-' . $daytodisplay . ' 00:00:00';
					$cnt= db_fetch("select count(*) as cnt from ".c("table.pages")." where menuid=6 and deleted=0 and visibility='true' and language='".l()."' and pagedate<='".$d1."' and pagedate>='".$d2."'");
                	$out .= '<td '.(($daytodisplay == $day) ? 'class="active"':'').' ><a href="'.href(18, array('year'=>$year,'month'=>$month,'day'=>$daytodisplay), l()).'" '.(($cnt["cnt"]>0) ? 'style="color:red;"' : '').' >'.$daytodisplay.'</a></td>';
				}
				$daytodisplay = $daytodisplay +1;
			}
		}
		$out .= '</tr>';
	}
	$out .= '</table>';
	return $out;
}

function home_news()
{
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 'true' AND menuid = 2 AND `deleted` = '0' ORDER BY pagedate DESC LIMIT 5;";
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$i = 0;
    foreach ($news AS $item)
    {
		$i++;
        $link = href($item['id']);
        
        $out .= '	<div class="news">';

					if($item['imagen']!=''){
					$out .= '<div class="img left"><a href="' . $link . '"><img src="crop.php?img='.$item['imagen'].'&width=140&height=90" alt="' . $item['title'] . '" width="140" height="90" /></a></div>';
					}
		$out .= '	<div class="date">' . convert_date($item["pagedate"]) . '</div>';

		$out .= ' 	<div class="title">
						<h3><a href="' . $link . '">' . $item['title'] . '</a></h3>
					</div>
					<div class="text">' . $item['description'] . '</div>
				</div>';
    }
    return $out;
}

function home_news2()
{
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 'true' AND menuid = 5 AND `deleted` = '0' ORDER BY pagedate DESC LIMIT 4;";
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$i = 0;
    foreach ($news AS $item)
    {
		$i++;
        $link = href($item['id']);
        
        $out .= '	<div class="project">';

					if($item['imagen']!=''){
					$out .= '<div class="img"><a href="' . $link . '"><img src="crop.php?img='.$item['imagen'].'&width=220&height=90" alt="' . $item['title'] . '" width="220" height="90" /></a></div>';
					}
		$out .= ' 	<div class="ttl">
						<h3><a href="' . $link . '">' . $item['title'] . '</a></h3>
					</div>
				</div>';
    }
    return $out;
}

function home_actions()
{
    $sql = "SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND visibility = 'true' AND menuid IN (SELECT id FROM `".c("table.menus")."` WHERE `deleted` = '0' AND type = 'events') AND `deleted` = '0' ORDER BY pagedate DESC LIMIT 2;";
    $news = db_fetch_all($sql);
    if (empty($news))
        return NULL;
    $out = NULL;
	$i = 0;
    foreach ($news AS $item)
    {
		$i++;
        $link = href($item['id']);
		$out .= '<div class="list">';
		$out .= '	<div class="name"><a href="' . $link . '">' . $item['title'] . '</a></div>';
		$out .= '	<div class="date">' . convert_date($item['pagedate']) . '</div>';
		$out .= '	<div class="text">' . $item['description'] . '</div>';
		$out .= '</div>';
    }
    return $out;
}

function home_poll_ge()
{
    $storage = Storage::instance();
	
// vote //
	$idx = 0;
	
    $ttl = db_fetch("SELECT * FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND masterid = 1400 and visibility='true' and deleted=0 order by position;");
	$poll = db_fetch("SELECT * FROM " . c("table.menus") . " WHERE language = '" . l() . "' AND type = 'poll' and deleted=0 and title = '".$ttl["attached"]."';");
	$ip = get_ip() . '-' . $_SERVER['REMOTE_ADDR'];
	$ippresent=db_fetch("select count(*) as cnt from pollips where votedate='".date("Y-m-d")."' and ip='".$ip."' and pollid='".$poll["id"]."' ");
//	$voted=0;
	$voted=($ippresent["cnt"]>0) ? 1:0;
	if(isset($_GET["vote_form_perform"])) {
		if($ippresent["cnt"]==0) 
		{
	
			db_query("insert into pollips (votedate, ip, pollid) values('".date("Y-m-d")."','".$ip."','".$poll["id"]."')");
			db_query("update pollanswers set answercounttotal=answercounttotal+1 where id='".$_GET["poll"]."'");
			db_query("update pollanswers set answercount=answercount+1 where id='".$_GET["poll"]."' and language='".l()."'");
		}
	}
	$out = '';
	$out .= '<div class="question">'.$ttl['title'].'</div>';
    $sql = "SELECT * FROM " . c("table.pollanswers") . " WHERE language = '" . l() . "' AND visibility='true' AND deleted=0 AND pollid = ".$poll["id"].";";
//	return $sql;
    $ans = db_fetch_all($sql);
	if((isset($_GET["results"]))||($voted!=0)) {
		$max = 0;
		foreach($ans as $a) :
			if($a["answercounttotal"]>$max) $max=$a["answercounttotal"];
		endforeach;
		foreach($ans as $a) :
			$w = ($max==0) ? 0:$a["answercounttotal"] * 180 / $max;
			$out .= '<div class="list fix">';
			$out .= '<div class="radio" style="">'.$a['answer'].'</div><br />';
			$out .= '<div style="float:left; width:40px; color:black; padding:5px 0 0 5px;">'.$a['answercounttotal'].'</div><div style="width:'.$w.'px; height:20px; background-color:#e03c80"></div>';
			$out .= '</div>';
		endforeach;
		$out .= '<div class="line"></div>';
	} else {
		$out .= '<form action="'.href($storage->section["id"], array(), l()).'" name="poll">';
		$out .= '<input type="hidden" name="vote_form_perform" value="1">';
		$out .= '<input type="hidden" name="results" value="1">';
		$n=0; $i=0;
		foreach($ans as $a) :
			$n=$n+1; $i++;
			$out .= '<div class="list fix">';
			$out .= '<div class="radio"><input type="radio"  name="poll" value="'.$a['id'].'" '.(($i==1) ? ' checked ':'').' /></div>';
			$out .= '<div class="answer">'.$a['answer'].'</div>';
			$out .= '</div>';
		endforeach;
		$out .= '<div class="line"></div>';
		$out .= '</form>';
	}
	if($voted==0) {$out .='<div class="button fix">';
		$out .= '<div class="result"><a href="'.href($storage->section["id"], array('results'=>1), l()).'" >შედეგები</a></div>';
		
		if(isset($_GET["results"])) 
			$out .= '<a href="'.href($storage->section["id"], array(), l()).'" class="send"><input type="submit" name="" value="ხმის მიცემა" /></a>';
		else
			$out .= '<a href="javascript:document.poll.submit();" class="send"><input type="submit" name="" value="ხმის მიცემა" /></a>';
		$out .='</div>';
	}
    return $out;
}



function timeDown($id){	
    $sql = "SELECT * FROM catalogs WHERE idx='".$id."'";
	$selectDate = mysql_query($sql);
	$fetches = mysql_fetch_array($selectDate);
	$f = $fetches['productdate'];
	$pe = explode(" ",$f);	
	$count = '<script language="JavaScript"  src="_website/countdown.php?timezone=Asia/Tbilisi&countto='.$pe[0]." ".$pe[1].'&do=t&data=დასრულდა"></script>';
	 
	return $count;
} 





/******************************************************* HELLOGEORGIA ************************************************/

function home_products($idx) {
	$products = db_fetch_all("select * from catalogs where language='" . l() . "' and visibility='true' and deleted=0 and hot=1 order by rand() limit 0,4");
	foreach($products as $p) :
		$q1=db_fetch("select * from menus where id=".$p["catalogid"]);
		$q2=db_fetch("select * from pages where attached='".$q1["title"]."'");
		$link=href($q2["id"]).'?product='.$p["id"];
?>
		<div class="list left">
			<div class="img">
				<a href="<?php echo $link; ?>"><img src="crop.php?img=<?php echo $p["photo1"]; ?>&width=210&height=130" width="210" height="130" alt="<?php echo $p["title"]; ?>" title=""></a>
			</div>
			<!-- img end -->
			<div class="list-ttl">
				<h3><a href="<?php echo $link; ?>"><?php echo $p["title"]; ?></a></h3>
			</div>
			<!-- list-ttl end -->
			<div class="list-txt">
				<div class="descr"><?php echo $p["description"]; ?></div>
			</div>
			<!-- list-txt end -->
		</div>
<?php
	endforeach;
}


function entityname($id) {
	$entity=db_fetch("select * from pages where id=".$id." and language='".l()."'");
	return $entity["pposition"];
}

function entity($id) {
	$entity=db_fetch("select * from pages where id=".$id." and language='".l()."'");
	return $entity;
}

function get_entity_field($id, $field) {
// get_entity_field(2, "description");
	$entity=db_fetch("select * from pages where id=".$id." and language='".l()."'");
	return $entity[$field];
}

function home_pages($page_num){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' AND deleted=0 AND id = '".$page_num."'; ";
    $newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
    $i=0;

    foreach($newshome AS $newhome) {
    $link1 = href($newhome['id']);
 $out .='<div class="block left">
		    <div class="img bxs">
		        <a href="'.$link1.'"><img src="'.$newhome['imagen'].'" width="214" height="154" alt="" /></a>
		    </div>
		    <!-- .img -->
		    <div class="title">
		        <h3><a href="'.$link1.'">'.$newhome['title'].'</a></h3>
		    </div>
		    <!-- .title -->
		</div>
		<!-- .block -->';
            }
    return $out;
}


//----------------------------------------- NEW ------------------------------------------------------

function main_menu()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND   menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' AND id != 1 AND id != 2 AND id != 14 ORDER BY position asc;"; 
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$aa = $storage->section["id"];
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		$out .= '<li '.(($sections[$idx]["id"] == $aa) ? 'class="active"':'').'>'."\n";
		
//		menu-selected
//		if($storage->section["id"]==12) $aa = 10;
		if($storage->section["level"]>1) $aa = db_retrieve('id', c("table.pages"), 'idx', $storage->section["masterid"], " LIMIT 1");
//		if($storage->section["menuid"]==6) $aa = 3;
//		if($storage->section["menuid"]==7) $aa = 4;
		
        $out .= '<a href="' . $link . '">' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		if($sections[$idx]['category']!=12) { 
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			$out .= '<ul>'."\n";
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<ul>'."\n";
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)
					{
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li>'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";
						$sql_in3 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 11 AND deleted = 0 AND masterid = " . $sections_in2[$idx_in2]['idx'] . " AND visibility = 'true' ORDER BY position;";	
					$sections_in3 = db_fetch_all($sql_in3);
						if(count($sections_in3) > 0) {
							$out .= '<ul>'."\n";
							for ($idx_in3 = 0, $num_in3 = count($sections_in3); $idx_in3 < $num_in3; $idx_in3++)
							{
								$link_in3 = (($sections_in3[$idx_in3]['redirectlink'] == '') || ($sections_in3[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in3[$idx_in3]['id']) : $sections_in3[$idx_in3]['redirectlink'];
								$out .= '<li>'."\n";
								$out .= '<a href="' . $link_in3 . '">' . $sections_in3[$idx_in3]['menutitle'] . '</a>'."\n";
								$out .= '</li>'."\n";
							}
							$out .= '</ul>'."\n";
						} else {
							$out .= ''."\n";
						}
						$out .= '</li>'."\n";
					}
					$out .= '</ul>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
            $out .= '</ul>'."\n";
		} else {
	        $out .= ''."\n";
		}
        }
		$out .= '</li>'."\n";
    }
    return $out;
}

function footer_menu2($id)
{
    $sql = "SELECT level, title, idx, redirectlink, menutitle, template, masterid FROM " . c("table.pages") . " WHERE id=".$id." and language='".l()."';";
	$lvl = db_fetch($sql);
	if($lvl["level"] == 1) $master = $lvl["idx"] ; else $master=$lvl["masterid"];
    $sql = "SELECT title FROM " . c("table.pages") . " WHERE idx=".$master.";";
	$main = db_fetch($sql);
	
	$out = '';

	$out .= '<h2>'.$main["title"].'</h2><ul>'."\n";
    $sql = "SELECT id, title, idx, redirectlink, menutitle, template FROM " . c("table.pages") . " WHERE masterid=".$master." ORDER BY position;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return $out;
    for ($idx = 0, $num = count($sections); $idx < $num; $idx++)
    {
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
        $out .= '<li><a href="' . $link . '" >'.(($sections[$idx]['menutitle']!='') ? $sections[$idx]['menutitle']:$sections[$idx]['title']).'</a></li>'."\n";
    }
	$out .= '</ul>';
    return $out;
}

function footer_menu()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id = 37 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$aa = $storage->section["id"];
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		$out .= '<div class="foot-list left">'."\n";
		
//		menu-selected
		if($storage->section["id"]==12) $aa = 10;
		if($storage->section["level"]>1) $aa = db_retrieve('id', c("table.pages"), 'idx', $storage->section["masterid"], " LIMIT 1");
		if($storage->section["menuid"]==6) $aa = 3;
		if($storage->section["menuid"]==7) $aa = 4;
		
        $out .= '<h2>' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</h2>'."\n";
		if($sections[$idx]['category']!=12) { 
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			$out .= '<ul>'."\n";
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
//				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<ul>'."\n";
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)
					{
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li class="left" style="width:120px;">'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";
					}
					$out .= '</ul>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
            $out .= '</ul>'."\n";
		} else {
	        $out .= ''."\n";
		}
        }
		$out .= '</div>'."\n";
    }
    return $out;
}

function tripadvisor(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 5 order by pagedate desc limit 0, 10;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
	$date = date_create($newhome['pagedate']);
	
		$i++;
		$out .= '		
                    <div class="item">
						<div class="guest">
							<div class="ravis-title">
								<div class="inner-box">
									<div class="title">' . $newhome['title'] . '</div>
								</div>
							</div>
						</div>
						<div class="text">
							' . $newhome['content'] . '
						</div>
					</div>
				';
		}								
	return $out;
	}
	
function news_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 4 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
	$date = date_create($newhome['pagedate']);
	
		$i++;
		$out .= '
								<li class="clearfix">
									<div class="img-container col-xs-4">
										<a href="' . $link . '">
											<img src="' . $newhome['imagen'] . '" alt="' . $newhome['title'] . '">
										</a>
									</div>
									<div class="desc-box col-xs-8">
										<a href="' . $link . '" class="title">' . $newhome['title'] . '</a>
										<div class="desc">' . $newhome['description'] . '</div>
										<a href="' . $link . '" class="read-more">' . l('more') . '</a>
									</div>
								</li>
				';
		}								
	return $out;
	}


function Announcements_home(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 24 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '
                <div class="news fix">
                    <div class="date left"><span>'.date("d", strtotime($newhome['pagedate'])).'</span> '.date("M", strtotime($newhome['pagedate'])).'</div>
                    <!-- .date left -->
                    <div class="info">
                        <div class="title">
                            <h3><a href="'.$link.'">' . $newhome['title'] . '</a></h3>
                        </div>
                        <!-- .title -->
                        <div class="text">'. strip_tags($newhome['description']) .'</div>
                        <!-- .text -->
                    </div>
                    <!-- .info -->
                </div>
				';
		}								
	return $out;
	}

function features(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 23 order by pagedate desc limit 0, 3;";
	$newshome = db_fetch_all($sql);
    if (empty($newshome))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($newshome AS $newhome) {
	$link = href($newhome['id']);
		$i++;
		$out .= '
                <div class="news fix">';
				if($newhome['imagen']!='NULL'){
                    $out .= '<div class="img left">
					 <a href="'.$link.'"><img src="crop.php?img='.$newhome['imagen'].'&width=115&height=75" width="115" height="75" alt="'.$newhome["title"].'" title="'.$newhome["title"].'"></a>
                    </div>';
				}
                    $out .= '<div class="info">
                        <div class="title">
                            <h3><a href="'.$link.'">' . $newhome['title'] . '</a></h3>
                        </div>
                        <!-- .title -->
                        <div class="text">'. strip_tags($newhome['description']) .'</div>
                        <!-- .text -->
                    </div>
                    <!-- .info -->
                </div>
				';
		}								
	return $out;
	}

function getMainSlideImages()
{
	$sql = "SELECT * FROM " . c("table.galleries") . " WHERE galleryid = 3 AND language = '" . l() . "' AND deleted=0  AND visibility = 'true' ORDER BY position;";
    $banners = db_fetch_all($sql);
    if (empty($banners))
        return NULL;
    $out = NULL;
	$i=0;
	foreach ($banners AS $banner) {
		$i++;
		$out .= '
				<li>
					<img src="'.$banner['file'].'" alt=""/>
					<div class="flex-caption">
						<div class="row">
							<div class="col-md-12">
								<h1>'.$banner["title"].'</h1>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								'.$banner["description"].'
							</div>
						</div>
					</div>
				</li>
				 '."\n";
	}
    return $out;
}

function Alumni(){
    $sql = "SELECT * FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and deleted=0 AND menuid = 55 order by position limit 0, 1;";
	$Alumni = db_fetch_all($sql);
    if (empty($Alumni))
        return NULL;
    $out = NULL;
	$i=0;

	foreach ($Alumni AS $Alumn) {
	$link = href($Alumn['id']);
		$i++;
		$out .= '
				<div class="inner fix">';
				if($Alumn['imagen']!='NULL'){
                    $out .= '
						<div class="img left">
							<a href="'.$link.'"><img src="crop.php?img='.$Alumn['imagen'].'&width=125&height=150" width="125" height="150" alt="'.$Alumn["title"].'"></a>
						</div>';
				}
                    $out .= '
						<div class="title">
							<h3>' . $Alumn['title'] . '</h3>
						</div>
						<!-- .title -->
						<div class="text">'. $Alumn['description'] .'</div>
						<!-- .text -->
				</div>
				';
		}								
	return $out;
	}

function main_menu2()
{
	global $storage;
	$out = '';
    $sql = "SELECT id, title, idx, redirectlink, menutitle, level, menuid, category, masterid FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND id=8 AND menuid = 1 AND deleted = 0 AND masterid = 0 AND visibility = 'true' ORDER BY position asc;";
    $sections = db_fetch_all($sql);
    if (empty($sections))
        return NULL;
    for ($idx = 0, $out = NULL, $num = count($sections); $idx < $num; $idx++)
    {
		$aa = $storage->section["id"];
        $link = (($sections[$idx]['redirectlink'] == '') || ($sections[$idx]['redirectlink'] == 'NULL')) ? href($sections[$idx]['id']) : $sections[$idx]['redirectlink'];
		$out .= '<li '.(($sections[$idx]["id"] == $aa) ? 'class="active"':'').'>'."\n";
		
//		menu-selected
		if($storage->section["id"]==12) $aa = 10;
		if($storage->section["level"]>1) $aa = db_retrieve('id', c("table.pages"), 'idx', $storage->section["masterid"], " LIMIT 1");
		if($storage->section["menuid"]==6) $aa = 3;
		if($storage->section["menuid"]==7) $aa = 4;
		
//        $out .= '<a href="' . $link . '" >' . ((l()=='ge') ? $sections[$idx]['menutitle'] : $sections[$idx]['menutitle']) . '</a>'."\n";
		if($sections[$idx]['category']!=12) { 
	    $sql_in = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections[$idx]['idx'] . " AND visibility = 'true' ORDER BY position;";	
    	$sections_in = db_fetch_all($sql_in);
		if(count($sections_in) > 0) {
			for ($idx_in = 0, $num_in = count($sections_in); $idx_in < $num_in; $idx_in++)
    		{
		        $link_in = (($sections_in[$idx_in]['redirectlink'] == '') || ($sections_in[$idx_in]['redirectlink'] == 'NULL')) ? href($sections_in[$idx_in]['id']) : $sections_in[$idx_in]['redirectlink'];
            	$out .= '<li>'."\n";
				$out .= '<a href="' . $link_in . '" class="suba">' . $sections_in[$idx_in]['menutitle'] . '</a>'."\n";
				$sql_in2 = "SELECT id, title, idx, redirectlink, menutitle FROM " . c("table.pages") . " WHERE language = '" . l() . "' AND menuid = 1 AND deleted = 0 AND masterid = " . $sections_in[$idx_in]['idx'] . " AND visibility = 'true' ORDER BY position;";	
				$sections_in2 = db_fetch_all($sql_in2);
				if(count($sections_in2) > 0) {
					$out .= '<div class="sub s1"><ul>'."\n";
					for ($idx_in2 = 0, $num_in2 = count($sections_in2); $idx_in2 < $num_in2; $idx_in2++)
					{
						$link_in2 = (($sections_in2[$idx_in2]['redirectlink'] == '') || ($sections_in2[$idx_in2]['redirectlink'] == 'NULL')) ? href($sections_in2[$idx_in2]['id']) : $sections_in2[$idx_in2]['redirectlink'];
						$out .= '<li>'."\n";
						$out .= '<a href="' . $link_in2 . '">' . $sections_in2[$idx_in2]['menutitle'] . '</a>'."\n";
						$out .= '</li>'."\n";
					}
					$out .= '</ul></div>'."\n";
				} else {
					$out .= ''."\n";
				}
				$out .= '</li>'."\n";
			}
		} else {
	        $out .= ''."\n";
		}
        }
		$out .= '</li>'."\n";
    }
    return $out;
}

function selectOffers(){
	$sql = "SELECT id,title,meta_desc,imagen,slug FROM  ".c("table.pages")." WHERE language = '" . l() . "' AND visibility = 'true' and homepage='true' and deleted=0 and menuid = 4;";
	$offers = db_fetch_all($sql);

	return $offers;
}