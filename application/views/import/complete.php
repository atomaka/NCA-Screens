<div id="message">
	<table width="100%" id="uploadTable">
		<tr>
			<th>File Name</th>
			<th>New ID</th>
			<th>Dimensions</th>
			<th>File Size</th>
			<th>Hash</th>
			<th>Extension</th>
		</tr>
<?php foreach($uploads as $upload) { ?>
		<tr>
			<td>
				<span class"<?php echo array_key_exists('error',$upload) ? 'error' : 'success'; ?>">
					<?php echo $upload['old']; ?>
				</span>
			</td>
	<?php if(array_key_exists('error',$upload)) { ?>
			<td colspan="5">
				<?php echo $upload['error']; ?>
			</td>
	<?php } else { ?>
			<td><?php echo $upload['new_id']; ?></td>
			<td><?php echo $upload['width']; ?>x<?php echo $upload['height']; ?></td>
			<td><?php echo $upload['file_size']; ?>kb</td>
			<td><?php echo $upload['hash']; ?></td>
			<td><?php echo $upload['extension']; ?></td>
	<?php } ?>
		</tr>
<?php } ?>
	</table>
</div>