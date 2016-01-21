<li class="wp-field wp-field-text <?php echo $field['column']; ?>" style="display: block;">

	<div class="field-title" ><?php echo $field['title']; ?></div>	
		
	<div class="field-input">
		<input style="width:100%;height:<?php echo $field['height']; ?>;font-size: <?php echo $field['font-size']; ?>;" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" id-multiple="<?php echo $field['id_multiple']; ?>" class="wp-field-value meta-field" type="text" value="<?php echo $field['value']; ?>" />
	</div>
	
	<div class="field-description" ><?php echo $field['desc']; ?></div>

</li>
