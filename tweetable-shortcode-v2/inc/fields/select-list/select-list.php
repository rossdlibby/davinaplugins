<?php

wp_enqueue_style( 'field-select-list', TWEETABLE_URL . '/inc/fields/select-list/select-list.css', false, false, 'screen' ); 
wp_enqueue_script('field-select-list', TWEETABLE_URL . '/inc/fields/select-list/select-list.js', array('jquery'), '1.0', true );
	
?>

<li class="wp-field wp-field-select-list <?php echo $field['column']; ?>" wp-field-id="<?php echo $field['id']; ?>" style="display: none;">
	
	<?php if ( $field['title'] ) { ?><div class="field-title" ><?php echo $field['title']; ?></div><?php } ?>	
	
	<?php 

		$select_list_class = 'list';
		$select_list_style = 'display:block;';

		if ( $field['display'] == 'inline'){
			
			$select_list_class = 'inline';		
			//$select_list_style = 'display:inline-block;width:'.(100/(count($field['custom']))) . '%'.';';

			$select_list_style = 'display:inline-block;';

		} 

	?>

	<ul class="<?php echo $select_list_class; ?>">	
		
		<?php foreach ( $field['custom'] as $item ) { ?><!--
			
			--><li val="<?php echo $item['id']; ?>" class="<?php if( $item['disable'] && $item['id'] != $field['value'] ){ echo 'disable'; } else { echo 'enable'; }; ?><?php if( $item['id'] == $field['value'] ){ echo ' active'; }; ?>" style="<?php echo $select_list_style; ?>"><!--
				--><span><!--
				--><div class="name"><?php echo $item['name']; ?></div><!--
				--><div class="desc"><?php echo $item['desc']; ?></div><!--
				--></span><!--
			--></li><!--
				
		--><?php } ?>		
	
	</ul>
	
	<div class="field-input" style="<?php if ( $field['show-input'] == false ) { echo 'display: none;'; } ?>">
		<input style="margin-top:3px;" type="text" id="<?php echo $field['id']; ?>" id-multiple="<?php echo $field['id_multiple']; ?>" class="wp-field-value meta-field" name="<?php echo $field['id']; ?>" value="<?php echo $field['value']; ?>" />
	</div>

	<div class="field-description" ><?php echo $field['desc']; ?></div>
	
</li>