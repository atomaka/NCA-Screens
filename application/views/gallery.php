<?php echo $pagination; ?>

		<div id="imageContainer" style="width: 960px;margin: auto;">
<?php foreach($uploads as $upload) { ?>
			<div id="galleryContainer">
				<img src="<?php echo base_url('/thumbs/' . $upload->id . $upload->extension); ?>" />
			</div>
<?php } ?>
		</div>