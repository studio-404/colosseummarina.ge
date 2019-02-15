<?php
defined('DIR') OR exit;
if(isset($_GET["action"])) :
	if($_GET["action"]=='add') {
		$qry = db_query("update cart set quantity=quantity+1 where pid='".$_GET["pid"]."' and session='".session_id()."'");
	}
	if($_GET["action"]=='sub') {
		$qry = db_query("update cart set quantity=quantity-1 where pid='".$_GET["pid"]."' and session='".session_id()."'");
	}
	if($_GET["action"]=='del') {
		$qry = db_query("update cart set quantity=0 where pid='".$_GET["pid"]."' and session='".session_id()."'");
	}
//	redirect(href($this->storage->section['id']));
endif;

$basket = db_fetch_all("SELECT cart.price as prc, cart.quantity, cart.pid, catalogs.* FROM catalogs, cart WHERE catalogs.id=cart.pid and catalogs.language='".l()."' and session='".session_id()."' and quantity>0");

$data["message"] = 'Basket';
$data["basket"] = $basket;
$data["title"] = $this->storage->section['title'];
$data["id"] = $this->storage->section['id'];
$data["content"] = $this->storage->section['content'];
$this->storage->content = plugin_template('_basket', $data);
?>
