<?php

/*
**
**
** TWEETABLE_handyField
**
**
*/

class TWEETABLE_handyField {
    
    protected $options;
    
	protected $methode;
	protected $id;
    protected $name;
    protected $type;
    protected $target;
    protected $fields;
        
    public function __construct( $options ) {
        
    	$this->methode = $options['methode'];
    	$this->id = $options['id'];
        $this->name = $options['name'];
        $this->target = $options['target'];
        $this->parent = $options['parent'];
        $this->type = $options['type'];
        $this->fields = $options['fields'];
        
        //$this->body = $options['body'];
        
        $this->init_option();
        
    }
                
    public function init_option() {
    	
       add_action('admin_menu', array(&$this,'add_option') );
       
       $this->save_option();
       
    }
    
    public function add_option() {
		
		if ( $this->parent ){
			
			add_submenu_page( $this->parent, $this->name, $this->name, 'read', $this->id, array(&$this,'create_option') );
			
		
		} else {
		
			add_menu_page( $this->id, $this->name, 'read', $this->target, array(&$this,'create_option') , '', '2000' );
		
		}
	}
	
	public function create_option() {
			
		global $post_id;
		
		wp_enqueue_style( 'fields', TWEETABLE_URL . '/inc/fields/fields.css', false, false, 'screen' ); 
		wp_enqueue_script('fields', TWEETABLE_URL . '/inc/fields/fields.js', array('jquery'), '1.0', true );
		
		?>
		
		<div class="wrap field-option-wrap">
		
		<?php switch ($this->parent) {
			case 'themes.php':
				echo '<div id="icon-themes" class="icon32"><br></div>';
			break;
			
			case 'options-general.php':
				echo '<div id="icon-options-general" class="icon32"><br></div>';
			break;
			
			case 'tool.php':
				echo '<div id="icon-tools" class="icon32"><br></div>';
			break;
		} ?>
		
		<h2><?php echo $this->name ?></h2>
		
		<?php 
		if(isset($_REQUEST['message'])){
	    if ( 'success' == $_REQUEST['message'] ) echo '<div id="message" class="updated below-h2"><p><strong>TWEETABLE : Settings saved.</strong></p></div>';
		if ( 'error' == $_REQUEST['message'] )  echo '<div id="message" class="error below-h2"><p><strong>TWEETABLE : Settings not saved.</strong></p></div>';
		}
		?>
		
		<form id="post" method="post">
		
		<div id="field-option" class="postbox" style="visibility: hidden;">
		
			<style>
			
			#<?php echo $this->id ?>.postbox .inside h1,
			#<?php echo $this->id ?>.postbox .inside h2,
			#<?php echo $this->id ?>.postbox .inside h3,
			#<?php echo $this->id ?>.postbox .inside h4,
			#<?php echo $this->id ?>.postbox .inside h5,
			#<?php echo $this->id ?>.postbox .inside h6 {
				background-color: inherit!important;
				background-image: none!important;
				font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
				border-style: none!important;
				-moz-box-shadow: none!important;
				-webkit-box-shadow: none!important;
				box-shadow: none!important;
				cursor: default;
				display: block!important;
				margin-top: 0;
			}
			#<?php echo $this->id ?>.postbox .inside h1,
			#<?php echo $this->id ?>.postbox .inside h2,
			#<?php echo $this->id ?>.postbox .inside h3,
			#<?php echo $this->id ?>.postbox .inside h4,
			#<?php echo $this->id ?>.postbox .inside h5,
			#<?php echo $this->id ?>.postbox .inside h6 {
				margin-bottom: 0!important;
				margin-top: 5px!important;
			}
			
			#<?php echo $this->id ?>.postbox .inside h1.icon,
			#<?php echo $this->id ?>.postbox .inside h2.icon,
			#<?php echo $this->id ?>.postbox .inside h3.icon,
			#<?php echo $this->id ?>.postbox .inside h4.icon,
			#<?php echo $this->id ?>.postbox .inside h5.icon,
			#<?php echo $this->id ?>.postbox .inside h6.icon {
				padding-left: 25px!important;
				background: no-repeat 5px center!important;
			}
			
			#<?php echo $this->id ?> .inside{
				margin: 0;
				padding: 0;
			}
			
			</style>
			
			<div id="field-tab">
				
				<?php if ( count($this->fields) > 1 ) { ?>
				
				<ul id="field-tabs" class="ui-field-tabs">
					
					<?php foreach ( $this->fields as $key => $tab ) { ?>
					
					<?php if ( current_user_can($tab['tab-access']) ) { ?>

					<li target="#field-tab-<?php echo $key; ?>" class="active">
						<span><span><span>
							<span class="icon" <?php if( $tab['tab-icon'] ) { echo 'style="padding-left:25px;background-image: url(' . $tab['tab-icon'] . ');"'; } ?> ><?php echo $tab['tab-label']; ?></span>
						</span></span></span>
					</li>
					
					<?php } ?>

					<?php } ?>
					
				</ul>
				
				<?php } ?>
				
				<ul id="field-tabs-content" class="ui-field-tabs-content<?php if ( count($this->fields) > 1 ) echo ' notab'; ?>">
					
					<?php foreach ( $this->fields as $key => $tab ) { ?>
					
					<?php if ( current_user_can($tab['tab-access']) ) { ?>

					<li id="field-tab-<?php echo $key; ?>" class="active">
						
						<?php if ( $tab['tab-title'] || $tab['tab-desc'] ) { ?>
						<div class="field-tab-header">
							
							<?php if ( $tab['tab-title'] ) { ?>
							<div class="field-tab-header-title<?php if( $tab['tab-icon'] ) { echo ' icon'; } ?>" <?php if( $tab['tab-icon'] ) { echo 'style="background-image: url(' . $tab['tab-icon'] . ')!important;"'; } ?> ><?php echo $tab['tab-title']; ?></div>
							<?php } ?>
							
							<?php if ( $tab['tab-desc'] ) { ?>
							<div class="field-tab-header-desc"><?php echo $tab['tab-desc']; ?></div>
							<?php } ?>
							
						</div>
						<?php } ?>
						
						<div class="field-tab-options-padding">
							
							<ul class="field-tab-options">
								
								<?php foreach ( $tab['tab-meta'] as $key => $meta ) { ?>
								
									<?php 
										
									$field = $meta;
										
									if ( isset($field['id']) && get_option( $field['id'] ) != "" ) { 
										
										$field['value'] = stripslashes( get_option( $field['id'] ) ); 
											
									} else if ( isset($field['std']) && get_option( $field['std'] ) != "" ) {  
										
										$field['value'] = stripslashes( $field['std'] ); 
										
									} else {  
										
										$field['value'] = ""; 
											
									} 
										
									if ( file_exists( TWEETABLE_DIR . '/inc/fields/'.$field['type'].'/'.$field['type'].'.php' ) ) { 
									
										include TWEETABLE_DIR . '/inc/fields/' . $field['type'] . '/' . $field['type'] . '.php';
									
									} else {
									
										echo "Error field (" . $field['type'] . ").<br />";
									
									}
									
									?>
								
								<?php } ?>
								
							</ul>
						
						</div>
						
					</li>
					
					<?php } ?>

					<?php } ?>
				
				</ul>
				
			</div>
		
		</div>
		
		<input class="button-primary" name="save" type="submit" value="<?php _e('Save'); ?>" />
		<input type="hidden" name="action" value="save" />
			
		</form>
		
		</div>
		
		<?php
		
	}
    
    public function save_option(){
    
    	if ( isset($_GET['page']) && $_GET['page'] == $this->target ) {

			if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
			
				foreach ( $this->fields as $key => $tab ) {
				
					foreach ( $tab['tab-meta'] as $key => $meta ) {
						
						if ( isset( $meta['id'] ) ) {
						
							if ( isset( $_POST[$meta['id']] ) ) {
					
								update_option( $meta['id'], $_POST[$meta['id']] );
						
							}
						}
							
					}
				
				}
				
				$header_location = '';
				if ( $this->parent ) { 
					$header_location .= $this->parent . '?page=' . $this->target . '&message=success';
				} else {
					$header_location .= 'admin.php' . '?page=' . $this->target . '&message=success';
				}
				
				header("Location: " . $header_location );
    			die;
				
			}
			
		}
		
    }
        
}//end TWEETABLE_handyField


?>