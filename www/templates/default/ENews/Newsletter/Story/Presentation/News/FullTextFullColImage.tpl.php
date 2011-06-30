<?php

if ($file = $context->getFileByUse('originalimage')) {
    $description = $file->name;
    $width = $context->getColFromSort() == 'twocol' ? 690 : 336;
    if (!empty($file->description)) {
        $description = $file->description;
    }
    echo '<img src="'.$file->getURL()
         . '" style="margin-bottom:5px;width:'. $width .'px;" class="frame" alt="'.$description.'" />';
}
?>
<h4>
    <?php echo $context->title; ?>
</h4>
<p>
<?php
echo nl2br($context->full_article);
?>
<?php if (isset($context->ics)): ?>
	<a href="<?php echo $context->ics ?>" class="icsformat">Add to my calendar (.ics)</a>
<?php endif; ?>
</p>
<?php
if (($context->website)) { ?>

More details at: <a href="<?php echo $context->website; ?>" title="Go to the supporting webpage"><?php echo $context->website; ?></a>
<?php
}
?>