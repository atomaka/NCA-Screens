		<div id="message" class="pagination">
<?php echo $pagination; ?>
		</div>

		<div id="imageContainer" style="width: 960px;margin: auto;">
<?php 
foreach($uploads as $upload) { 
	$extension = (preg_match('/guild/',$_SERVER['HTTP_HOST']) != 0 && $upload->id <= 927)
		? '.jpg' : $upload->extension;
?>
			<div id="galleryContainer">
				<a href="<?php echo base_url($upload->id); ?>"><img src="<?php echo base_url('/thumbs/' . $upload->id . $extension); ?>" /></a>
			</div>
<?php } ?>
		</div>
		<div style="clear:both;"></div>

		<div id="message" class="pagination">
<?php echo $pagination; ?>
		</div>