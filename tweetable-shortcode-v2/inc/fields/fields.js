(function( $ ){

	var methods = {
	
		init : function( params ) { 
		  
			var $this = jQuery(this);
		  
		  	var params = jQuery.extend({
				
				tab_li : null,
				content_li : null,
				open : 0,
				activeID : "active",
				
			},params);
			
			this.data('params', params );
				
			create_tabs();
					
			function create_tabs(){
				
				$this.find( params.content_li ).css('overflow','hidden');
				$this.find( params.content_li ).css('display','block');
				
				$this.on('click', params.tab_li, function(){
					
					var $activeTab = jQuery( this ).attr("target");
					
					$this.find( params.tab_li ).removeClass(params.activeID);
					$this.find( params.content_li ).css('height','0px');
					
					jQuery( this ).addClass(params.activeID);
					$this.find( $activeTab ).css('height','100%');
				
				})
				
				$this.find( params.tab_li ).eq(params.open).click();
				
			}
			
		},
		
		open : function( id ) { 
		
			var $this = jQuery(this);
			var params = this.data('params');
			$this.find( params.tab_li ).eq(id).click();
		
		}
		
	};
		
	$.fn.field_ui_tab = function( method ) {
		
		if ( methods[method] ) {
		  return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
		  return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist on jQuery.tpleditor_tab' );
		}    
	
	};
		
	jQuery(document).ready(function(){
	
		jQuery("#field-tab").field_ui_tab({
		
			tab_li : '#field-tabs > li',
			content_li : '#field-tabs-content > li',
		
		});
		
		jQuery('#field-option').css('visibility', 'visible');
	
	});

})( jQuery );