		<div id="message" class="pagination">
<?php echo $pagination; ?>
		</div>

		<div id="imageContainer" style="width: 960px;margin: auto;">
<?php foreach($uploads as $upload) { ?>
			<div id="galleryContainer">
				<img src="<?php echo base_url('/thumbs/' . $upload->id . $upload->extension); ?>" />
			</div>
<?php } ?>
		</div>
		<div style="clear:both;"></div>

		<div id="message" class="pagination">
<?php echo $pagination; ?>
		</div>