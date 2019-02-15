<?php
	defined('DIR') OR exit;

	$i = 0;
	foreach(c('languages.all') as $language):
		$active = ((l() == $language) ? null : '_r');
		$color = ((l() == $language) ? 'color:#fff;' : 'color:#999;' );
		$cursor = ((l() == $language) ? null : 'cursor:pointer;' );
		if($i == 1) :
?>
<div style="float:left;">&nbsp; | &nbsp;</div>
<?php
		endif;
		$i = 1;
		$action = Storage::instance()->action;
		$subaction = Storage::instance()->subaction;
		$params = generate_params();
?>

<div id="lng_<?php echo $language; ?>" style="float:left;">
<?php if(l() != $language) { ?>
	<a style=" <?php echo $color;?>" href="<?php echo ahref($action, $subaction, $params, $language);?>"><?php echo l_long($language); ?></a>
<?php } else { ?>
	<span style=" <?php echo $color;?>"><?php echo l_long($language); ?></span>
<?php } ?>
</div> 
<?php
	endforeach;
?>
