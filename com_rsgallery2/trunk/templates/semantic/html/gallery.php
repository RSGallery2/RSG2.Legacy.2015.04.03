<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php

global $ItemId;

//Show My Galleries link
if ($rsgConfig->get('show_mygalleries')) {
	echo $this->showRsgHeader();
}


//Show introduction text
?>
<div class="intro_text"><?php echo $rsgConfig->get('intro_text');?></div>
<?php
//Show limitbox
if( $this->pageNav ):
?>
	<div class="rsg2-pagenav-limitbox">
		<?php //TODO: replace "limit" with "glimit" to sepparate image and gallery navigation
		echo $this->pageNav->writeLimitBox("index.php?option=com_rsgallery2&amp;Itemid=$ItemId"); 
		?>
	</div>
<?php
endif;

foreach( $this->kids as $kid ):
?>
<div class="rsg_galleryblock">
	<div class="rsg2-galleryList-status"><?php echo $kid->status;?></div>
	<div class="rsg2-galleryList-thumb">
		<?php echo $kid->thumbHTML; ?>
	</div>
	<div class="rsg2-galleryList-text">
		<?php echo $kid->galleryName;?>
		<span class='rsg2-galleryList-newImages'>
			<sup><?php if( $this->gallery->hasNewImages() ) echo _RSGALLERY_NEW; ?></sup>
		</span>
		<?php echo $this->_showGalleryDetails( $kid );?>
		<div class="rsg2-galleryList-description"><?php echo $kid->description;?>
		</div>
	</div>
	<div class="rsg_sub_url_single">
		<?php $this->_subGalleryList( $kid ); ?>
	</div>
</div>
<?php
endforeach;
?>
<div class="rsg2-clr"></div>
<?php
//Show block with random images 
$this->showImages("random", 3);
//Show block with latest images
$this->showImages("latest", 3);

if( $this->pageNav ):
?>

<div class="rsg2-pageNav">
	<?php //TODO: replace "limit" with "glimit" to sepparate image and gallery navigation
		echo $this->pageNav->writePagesLinks("index.php?option=com_rsgallery2&amp;ItemId=$ItemId");
		echo "<br>".$this->pageNav->writePagesCounter(); ?>
</div>
<div class='rsg2-clr'>&nbsp;</div>
<?php endif; ?>
