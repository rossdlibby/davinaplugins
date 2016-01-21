<?php

/**
*
* SETTINGS PAGE
*
**/
$this->TWEETABLE_settings_arg = array(
	
	"methode"=> "page",
	"id"=> "tweetable_settings",
	"name"=> "Tweetable",
	"type"=> "option",
	"pos"=> 200,
	"target"=> "tweetable_settings",
	"parent"=> "options-general.php",
	"fields"=> array(
		
		array(
	  		"tab-label"=> "General",
	    	"tab-title"=> "Twitter",
	    	"tab-desc"=> "",
	    	"tab-icon"=> "",
	    	"tab-access"=>"level_0",
	    	"tab-color"=> "",
	    	"tab-meta"=> array(
	    		
	    		array(
	        		"id"=> "TWEETABLE_username",
	        		"title"=> 'Twitter @username at the end of the tweet::',
	        		//"desc"=> '<i>Adding "via @username" at the end of the tweet</i>',
	        		"type"=> "text",
	        		"column"=> "col-100"
	      		),

	    		array(
	        		"id"=> "TWEETABLE_add_postlink",
	        		"title"=> 'Add Post link at the end of the tweet:',
	        		//"desc"=> '<i>Add Current post URL </i>',
	        		"type"=> "select-list",
	        		"column"=> "col-100",
	        		"custom"=> array(
	        			array("id" => "full", "name" => "Yes<i>, add full URL</i>", "desc" => ""),
						array("id" => "short", "name" => "Yes<i>, add shortened URL (need bit.ly API)</i>", "desc" => ""),
					  	array("id" => "", "name" => "No", "desc" => ""),
					),
	        		"display"=>"list"
	      		),

	      		array(
	        		"id"=> "TWEETABLE_content_shorturl",
	        		"title"=> 'Shorten link in content:',
	        		//"desc"=> '<i>Convert link to Short URL in the content of the tweet</i>',
	        		"type"=> "select-list",
	        		"column"=> "col-100",
	        		"custom"=> array(
						array("id" => "tweet", "name" => "Yes<i>, only on twitter (need bit.ly API)</i>", "desc" => ""),
						array("id" => "both", "name" => "Yes<i>, on twitter and also on my site (need bit.ly API)</i>", "desc" => ""),
					  	array("id" => "", "name" => "No", "desc" => ""),
					),
	        		"display"=>"list"
	      		),

	    		
	      		
	      		
	    	),
	  	
	  	),
	
		array(
	  		"tab-label"=> "Style",
	    	"tab-title"=> "Customize the tweetable link",
	    	//"tab-desc"=> 'Create and account on <a href="https://bitly.com/a/sign_up">bitly.com</a> to add the current post link in the tweet.',
	    	"tab-icon"=> "",
	    	"tab-access"=>"level_0",
	    	"tab-color"=> "",
	    	"tab-meta"=> array(
	    		
	    		array(
	        		"id"=> "TWEETABLE_css",
	        		"title"=> 'Default style:',
	        		//"desc"=> '<i>customize the style of the link</i>',
	        		"type"=> "css",
	        		"output"=> "css",
	        		"column"=> "col-50"
	      		),

	      		array(
	        		"id"=> "TWEETABLE_css_hover",
	        		"title"=> 'Mouse over style:',
	        		//"desc"=> '<i>customize the style of the link</i>',
	        		"type"=> "css",
	        		"output"=>"css",
	        		"column"=> "col-50-last"
	      		),

	      		
	      		
	    	),
	  	
	  	),

		array(
	  		"tab-label"=> "Bit.ly API",
	    	"tab-title"=> "Bit.ly URL Shortener",
	    	"tab-desc"=> 'Create and account on <a href="https://bitly.com/a/sign_up">bitly.com</a> to add the current post link in the tweet.',
	    	"tab-icon"=> "",
	    	"tab-access"=>"level_0",
	    	"tab-color"=> "",
	    	"tab-meta"=> array(
	    		
	    		array(
	        		"id"=> "TWEETABLE_bitly_username",
	        		"title"=> "Bit.ly username",
	        		"desc"=> '',
	        		"type"=> "text",
	        		"column"=> "col-100"
	      		),
				
				array(
	        		"id"=> "TWEETABLE_bitly_api",
	        		"title"=> "Bit.ly API",
	        		"desc"=> '',
	        		"type"=> "text",
	        		"column"=> "col-100"
	      		),

	      		
	      		
	    	),
	  	
	  	),

	  	array(
	  		"tab-label"=> "Admin",
	    	"tab-title"=> "Administration",
	    	"tab-desc"=> "",
	    	"tab-icon"=> "",
	    	"tab-access"=>"level_10",
	    	"tab-color"=> "",
	    	"tab-meta"=> array(
	    		
	    		array(
	        		"id"=> "TWEETABLE_admin_access",
	        		"title"=> "Admin panel level access",
	        		"desc"=> '<i>User Level allowed to view and edit tweetable settings</i>',
	        		"type"=> "select-list",
	        		"column"=> "col-100",
	        		"custom"=> array(
						array("id" => "", "name" => "Administrator", "desc" => ""),
						//array("id" => "level_9", "name" => "Administrator", "desc" => ""),
						//array("id" => "level_8", "name" => "Administrator", "desc" => ""),
						array("id" => "level_7", "name" => "Editor", "desc" => ""),
						//array("id" => "level_6", "name" => "Editor", "desc" => ""),
						//array("id" => "level_5", "name" => "Editor", "desc" => ""),
						//array("id" => "level_4", "name" => "Editor", "desc" => ""),
						//array("id" => "level_3", "name" => "Editor", "desc" => ""),
						array("id" => "level_2", "name" => "Author", "desc" => ""),
						array("id" => "level_1", "name" => "Contributor", "desc" => ""),
					  	array("id" => "level_0", "name" => "Subscriber", "desc" => ""),
					),
	        		"display"=>"inline"
	      		),
	      		
	    	),
	  	
	  	),
	  	
	  		  
	),

);




	
?>