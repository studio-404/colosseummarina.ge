<?php
defined('DIR') OR exit;
$basket = db_fetch("SELECT count(*) as cnt FROM cart WHERE pid='".$_GET["pid"]."' and session='".session_id()."'");

if($basket["cnt"]==0) {
	$qry = db_query("insert into cart (quantity,pid,session,price) values('".$_GET["amt"]."','".$_GET["pid"]."','".session_id()."','".$_GET["price"]."')");

} else {
	$qry = db_query("update cart set quantity=quantity+'".$_GET["amt"]."' where pid='".$_GET["pid"]."' and session='".session_id()."'");
}
echo 'OK';
?>
