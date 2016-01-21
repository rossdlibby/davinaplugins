(function($) {

$.fn.wp_field_select_list = function(){
	
	jQuery(this).each(function(){
		
		var $FIELD = jQuery(this);
		var $VALUE = jQuery(this).find( '#' + jQuery(this).attr('wp-field-id') );
		
		$FIELD.find('ul li').bind('click', function(){
			
			if( ! jQuery(this).hasClass("disable") ) {
			
				$FIELD.find('ul li').removeClass("active");
				jQuery(this).addClass("active");
			
				$VALUE.val( jQuery(this).attr('val') ).change();
			
			}
			
		})

	});

}	
		
jQuery(document).ready(function(){

	$('body').find('.wp-field-select-list').wp_field_select_list();
	
});


}(jQuery));