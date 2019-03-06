<?php defined('DIR') || exit;
function treeview ($parid=0, $lang, $link = null, $pl = null) {	// Tree View for Sitemap
	$qry = "SELECT " . c("table.pages") . ".id as dd," . c("table.pages") . ".* FROM " . c("table.pages") . "," . c("table.menus") . " WHERE " . c("table.pages") . ".menuid=" . c("table.menus") . ".id AND " . c("table.pages") . ".language='".$lang."' AND " . c("table.menus") . ".language='".$lang."' AND " . c("table.menus") . ".type='pages' AND " . c("table.pages") . ".visibility='true' AND " . c("table.pages") . ".menuid=1 AND " . c("table.pages") . ".deleted='0' AND " . c("table.pages") . ".masterid='".$parid."' order by position";
	$result = db_fetch_all($qry);
	if ($result) { 
		foreach($result as $row) {
			$level = $row["level"];
			$pad = ($level - 1) * 30;
?>
        <li style="margin-left:<?php echo $pad;?>px; width:300px;"> 
            <a href="<?php echo href($row["dd"]);?>"><?php echo $row["title"];?></a>
        </li>					
<?php 
			treeview ($row["idx"], $lang);
		}
	}
}
?>
<!--Breadcrumb Section-->
		<section id="breadcrumb-section" data-bg-img="<?php echo WEBSITE;?>/assets/img/testimonails.jpg">
			<div class="inner-container container">
				<div class="ravis-title">
					<div class="inner-box">
						<div class="title"><?php echo $title;?></div>
					</div>
				</div>

				<div class="breadcrumb">
					<ul class="list-inline">
                    	<?php echo location();?>
					</ul>
				</div>
			</div>
		</section>
		<!--End of Breadcrumb Section-->

		<!--Welcome Section-->
		<section id="welcome-section" class="has-user">
			<div class="inner-container container">
							<ul class="specific">
                            	<?php
                                    treeview (0, l());
                                ?>
							</ul>
			</div>
		</section>
		<!--End of Welcome Section-->