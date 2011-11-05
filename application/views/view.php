<?php if($prev != 0) { ?>
		<div id="left">
			<a href="<?php echo base_url('/view/specific/' . $prev); ?>" class="navigation"></a>
		</div>
<?php } ?>
<?php if($next != 0) { ?>
		<div id="right">
			<a href="<?php echo base_url('/view/specific/' . $next); ?>" class="navigation"></a>
		</div>
<?php } ?>

		<div id="imageContainer">
			<a href="<?php base_url('/uploads/' . $image); ?>"><img src="<?php echo base_url('/uploads/' . $image); ?>" class="image" /></a>
		</div>

		<div id="message">
			Uploaded on: <?php echo $created; ?><br/>
			Original name: <?php echo $original; ?><br/>
			Views: <?php echo $views; ?><br/>
		</div>