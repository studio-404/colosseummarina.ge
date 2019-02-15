<?php defined('DIR') || exit;

    if (!empty($results)):
        foreach ($results as $r):
?>

    <a href="<?=href($r['id'], l())?>" style="color:#305867;font-weight:bold"><?=$r['title']?></a><br />
    <?=$r['description']?>
    <br /><br />

<?php
        endforeach;
    endif;
?>