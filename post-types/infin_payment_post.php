<?php 
 
    if(!class_exists('infin_payment_post'))
    {
        class infin_payment_post
        {
            const POST_TYPE = "infin_payment_post";
            private $_meta  = array('price');

            /**
            * The Constructor
            */
            public function __construct()
            {
                // register actions
                add_action('init', array(&$this, 'init'));
                add_action('admin_init', array(&$this, 'admin_init'));
            } 

            public function init()
            {
                // Initialize Post Type
                $this->create_post_type();
                add_action('save_post', array(&$this, 'save_post'));
            }  

            /**
            * Create the post type
            */
            public function create_post_type()
            {
                register_post_type(self::POST_TYPE,
                    array(
                        'labels'        => array(
                        'name'          => "Premium Posts",    
                        'singular_name' => "infin-Payment Post"
                        ),
                    'public'            => true,
                    'has_archive'       => true,
                    'description'       => __("Posts which should be visible only after paying with infin-Payment"),
                    'supports'          => array('title', 'editor', 'excerpt', 'thumbnail'),
                    )
                );
            }

            /**
            * Save the metaboxes for this custom post type
            */
            public function save_post($post_id)
            {
                // verify if this is an auto save routine. 
                // If it is our form has not been submitted, so we dont want to do anything
                if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                    return;

                if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
                {
                    foreach($this->_meta as $field_name)
                    {
                        // Update the post's meta field
                        update_post_meta($post_id, $field_name, $_POST[$field_name]);
                    }
                }
                else
                {
                    return;
                } 
            } 


            /**
            * hook into WP's admin_init action hook
            */
            public function admin_init()
            {           
                // Add metaboxes
                add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
            } 

            /**
            * hook into WP's add_meta_boxes action hook
            */
            public function add_meta_boxes()
            {
                // Add this metabox to every selected post
                add_meta_box( 
                sprintf('wp_plugin_template_%s_section', self::POST_TYPE),
                sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
                array(&$this, 'add_inner_meta_boxes'),
                self::POST_TYPE
                );                  

            } 

            /**
            * called off of the add meta box
            */     
            public function add_inner_meta_boxes($post)
            {       
                // Render the job order metabox
                include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));         
            } 
        }
    }        
    
 ?>