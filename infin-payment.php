<?php
/*
Plugin Name: infin-Payment
Plugin URI: http://www.infin.de/service/index.php?page=WP&mini=paymenten
Description: infin-Payment plugin
Version: 0.85
Author: Harald Singer
Author URI: http://www.infin.de
License: GPL2
*/
/*
Copyright 2014  infin - Ingenieurgesellschaft für Informationstechnologien  mbH & Co. KG (email : h.singer@infin.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//---------------------------------------------------------------------

	function payment_StartSession() 
	{
    	if(!session_id()) 
    	   	session_start();
	}

	function payment_EndSession() 
	{
    	session_destroy ();
	}


	if(!class_exists('infin_payment'))
	{
	    class infin_payment
	    {
	        /**
	         * Construct the plugin object
	         */
	        public function __construct()
	        {
	            add_action('admin_init', array(&$this, 'admin_init'));
				add_action('admin_menu', array(&$this, 'add_menu'));

				require_once(sprintf("%s/post-types/infin_payment_post.php", dirname(__FILE__)));
				$infinPaymentPost = new infin_payment_post();

				add_action('init', 'payment_StartSession', 1);
				add_action('wp_logout', 'payment_EndSession');
				add_action('wp_login', 'payment_EndSession');					

	        } 

	        /**
	         * Activate the plugin
	         */
	        public static function activate()
	        {
	        	//save the info about physical location of the wp_upload_dir/infin-payment-log-dir into options database				
	        	//this is not used at this time - because wordpress-q&a asked us politely not to put log files into plugin-folder.
	        	//so we decided to host these files on our payment servers and let the plugin ask for the relevant info over http
	        	//instead of saving them locally...
	        	/*
				$tempA = wp_upload_dir();
				$uploaddir = $tempA['basedir']."/infin-payment/";
				$uploadurl = $tempA['baseurl']."/infin-payment/";
				update_option('infin-payment-log-folder',$uploaddir);
				update_option('infin-payment-log-url',$uploadurl);				
				*/
	        } 

	        /**
	         * Deactivate the plugin
	         */     
	        public static function deactivate()
	        {
	            // Do nothing - yet
	        } 

	        public function admin_init()
			{
    			// Set up the settings for this plugin
    			$this->init_settings();    			
			} 

			public function init_settings()
			{
    			// register the settings for this plugin
    			register_setting('infin_payment-group', 'api_key');
    			register_setting('infin_payment-group', 'company');
    			register_setting('infin_payment-group', 'product');
				register_setting('infin_payment-group', 'buttontext');				
			} 

			/**
 			* add a menu
 			*/     
			public function add_menu()
			{
    			add_options_page('infin-Payment Settings', 'infin-Payment', 'manage_options', 'infin_payment', array(&$this, 'plugin_settings_page'));
			} 

			/**
 			* Menu Callback
 			*/     
			public function plugin_settings_page()
			{
    			if(!current_user_can('manage_options'))
    			{
        			wp_die(__('You do not have sufficient permissions to access this page.'));
    			}

    			// Render the settings template
    			include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
			} 
	    }	 
	} 

	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('infin_payment', 'activate'));
    register_deactivation_hook(__FILE__, array('infin_payment', 'deactivate'));

    // instantiate the plugin class
    $infin_payment_template = new infin_payment();

    if(isset($infin_payment_template))
	{
    	// Add the settings link to the plugins page
    	function plugin_settings_link($links)
    	{ 
        	$settings_link = '<a href="options-general.php?page=infin_payment">Settings</a>'; 
        	array_unshift($links, $settings_link); 
        	return $links; 
    	}
		
		function include_template_function( $template_path ) 
		{
			if ( get_post_type() == 'infin_payment_post' ) 
			{
				if ( is_single() ) 
				{
					// checks if the file exists in the theme first,
					// otherwise serve the file from the plugin
					if ( $theme_file = locate_template( array ( 'single-infin_payment_post.php' ) ) ) 
						$template_path = $theme_file;
					else 
						$template_path = plugin_dir_path( __FILE__ ) . '/single-infin_payment_post.php';
				}
			}

			return $template_path;
		}

    	$plugin = plugin_basename(__FILE__); 
    	add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
		add_filter("template_include", 'include_template_function', 1 );
	}

	function paymentShortcodeHandler( $atts )
	{

		//handles shortcodes - for example: [infin_payment_posts id=1714] or [infin_payment_posts id='all'] - displays the premium-content with the ID 1714 or all of them...

		require_once(plugin_dir_path(__FILE__)."infin_payment_post.php");

  	    $a = shortcode_atts( array('id' => 'all'), $atts );

  	    if($a['id']=='all')
    		$args = array( 'post_type' => 'infin_payment_post', 'posts_per_page' => 10 );
    	else
    		$args = array( 'post_type' => 'infin_payment_post', 'p' => $a['id'] );

		$loop = new WP_Query( $args );			

		if($loop->posts)
		{

			foreach($loop->posts as $P)	
			{
				            	                
	            $theid = $P->ID;
	            $title = $P->post_title;
	                
	            $meta  = get_post_custom($theid);

	            echo "<div class=premiumcontent><div class=titlepremium style='float: right'>&nbsp;Premium Content&nbsp;</div><br style='clear: both'><article id='post-$theid'>";
	            	
	            if(isset($meta['price'][0]))
	                $price = $meta['price'][0];
	            else
	                $price = "0.00";

	            if( (isset($_SESSION['unlocked'][$theid])) || $price=="0.00")
	                $unlocked[$theid] = true;
	            else
	                $unlocked[$theid] = false;

	            //----------------------------------
	            //see if just paid - i.e. checking the URL at payment-server:	        	            
	            
	            $responsearray=array();
	            $logurl = "http://zeta.infin-net.de:8010/infinpay/public/wp_callbacks/".session_id()."-".$theid.".php";
	            $http = @fopen($logurl,"r");
	            if($http)
	            {
	            	$response=fread($http,20000);
	            	fclose($http);
	            	$responsearray=unserialize($response);

	            	//var_dump($responsearray);

	            	if($responsearray['amount'] == $price)
	            	{
	            		$unlocked[$theid] = true;
	                	$_SESSION['unlocked'][$theid] = true;	
	                }
	            }

	            // Display Title and Author Name 
	            echo "<h1>$title</h1>";
	            echo "<p>";

	            if($unlocked[$theid])
	            {
	                $body   = $P->post_content; 
	                $button = "";
	                $class  = "paidorfree";
	            }
	            else
	            {
	                $body   = $P->post_excerpt;	                
	                $class  = "price";
                    $button = "<div class=paymentbutton onClick=\"openPaymentWindow('$url&amount=$price&postid=$theid','infin-Payment'); \">$button_text</div>";
                }

	            echo $body;

	            echo "</p>";

	            echo "<div class='$class' style='float: right'>$price &euro; $button</div><br style='clear: both'>";            
	     		echo "</article>";
	       		echo "</div>";
	       		echo "<br>";

        	}		
		}
	}

	add_shortcode( 'infin_payment_posts', 'paymentShortcodeHandler' );