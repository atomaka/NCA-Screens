<?php if($prev != 0) { ?>
		<script type="text/javascript">
			$(document).keydown(function(e) {
				var key = e.keyCode || e.which;
				if(key == 37) {
					document.location.href = $('#left>a').attr('href');
				}
			});
		</script>
		<div id="left">
			<a href="<?php echo base_url($prev); ?>" class="navigation"></a>
		</div>
<?php } ?>
<?php if($next != 0) { ?>
		<script type="text/javascript">
			$(document).keydown(function(e) {
				var key = e.keyCode || e.which;
				if(key == 39) {
					document.location.href = $('#right>a').attr('href');
				}
			});
		</script>
		<div id="right">
			<a href="<?php echo base_url($next); ?>" class="navigation"></a>
		</div>
<?php } ?>
<?php if($original == 'lost') { ?>
		<div id="message">
			Image has been lost.
		</div>
<?php } else { ?>
		<div id="imageContainer">
			<a href="<?php echo base_url('/uploads/' . $image); ?>"><img src="<?php echo base_url('/uploads/' . $image); ?>" class="image" /></a>
		</div>

		<div id="message">
			<span class="label">Uploaded on:<br/>Original name:<br/>Views:<br/>Dimensions:<br/>Size:</span>
			<span class="info"><?php echo $created; ?><br/><?php echo $original; ?><br/><?php echo $views; ?><br/><?php echo $width; ?>x<?php echo $height; ?><br/><?php echo $size; ?>kb</span>
		</div>
<?php } ?>