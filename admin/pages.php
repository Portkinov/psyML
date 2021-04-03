<?php
namespace psyml\admin;
use \psyml\core\Hexaco as Hexaco;

//spin it
\psyml\admin\Pages::run();

class Pages extends \psyML_Wp{


    public static function run(){

        \add_action( 'init', array( get_class(), 'add_psyml' ), 1  );
        \add_action( 'init', array( get_class(), 'add_psyml_pages' ),2 );
        \add_action( 'admin_menu', array( get_class(), 'add_psyml_page_menu'));
        \add_filter('pre_get_posts', array( get_class(), 'psyml_pages_admin_order') );

        #add archive pages
        \add_filter( 'template_include', array( get_class(), 'psyml_archive_template' ));

    }

    public static function psyml_archive_template( $template ){

        if(\is_page( 'psyml-results') ){
            // Set this to the template file inside your plugin folder
            $template = self::get_plugin_path() .'theme/templates/hexaco-landing.php';
        }
        return $template;
    }
    private static function get_psyml_page_content( $key ){

        $content = Hexaco::ARCHETYPES[$key]['content'];
        $roles = Hexaco::ARCHETYPES[$key]['roles'];
        $story = Hexaco::ARCHETYPES[$key]['story'];
 

        $roleslist = explode(',', $roles);
        $rolestemplate = '';
        foreach($roleslist as $list){
            $rolestemplate.='<li>'.$list.'</li>';
        }

        $template= '<div class="psymlcontent">'.$content.'</div>';
        $template.= '<h4>'. Hexaco::ARCHETYPES[$key]['name'].' excels in roles like:</h4>';
        $template.= '<ul class="psymlroles">'.$rolestemplate.'</ul>';
        $template.= '<h4>Sample Story:</h4>';
        $template.= '<div class="psymlstory">'.$story.'</div>';
        $template.= '</div>';
        return $template;
    }
    private static function add_featured_image_to_page( $key, $post_id, $imgtype = '.jpg' ){
         // Add Featured Image to Post
    $image_path        = self::get_plugin_path() . 'dist/assets/'.$key.$imgtype; // Define the image path
    $image_name        = 'psyml-'.$key.$imgtype;
    $upload_dir        = \wp_upload_dir(); // Set upload folder
    $image_data        = file_get_contents($image_path); // Get image data

    if($image_data){
        $unique_file_name = \wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
        $filename         = basename( $unique_file_name ); // Create image file name

            // Check folder permission and define file location
        if( \wp_mkdir_p( $upload_dir['path'] ) ) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        // Create the image  file on the server
        file_put_contents( $file, $image_data );

        // Check image file type
        $wp_filetype = \wp_check_filetype( $filename, null );

        // Set attachment data
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => \sanitize_file_name( $filename ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        // Create the attachment
        $attach_id = \wp_insert_attachment( $attachment, $file, $post_id );

        // Include image.php
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Define attachment metadata
        $attach_data = \wp_generate_attachment_metadata( $attach_id, $file );

        // Assign metadata to attachment
        \wp_update_attachment_metadata( $attach_id, $attach_data );

        // And finally assign featured image to post
        \set_post_thumbnail( $post_id, $attach_id );

        }

    }

    public static function add_psyml_page_menu(){
        \add_submenu_page( 
            'psyml-settings',
            'psyML Pages', 
            'psyML Pages', 
            'administrator', 
            'edit.php?post_type=psyml',
        );
    }

    private static function add_page($slug, $title){
        $new_page_id = false;
        $content = '';
        $page_check = \get_page_by_path( $slug, OBJECT, 'page');
        $page = array(
            'post_type' => 'page',
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
            'post_name' => $slug
        );
        if( !isset($page_check->ID)){
            $new_page_id = \wp_insert_post($page);
        }
    }

    private static function add_psyml_page($key){
        $new_page_id = false;
        $title = Hexaco::ARCHETYPES[$key]['name'];;
        $content = self::get_psyml_page_content( $key );
        $page_check = \get_page_by_path('psyml_'.$key, OBJECT, 'psyml');
        $page = array(
                'post_type' => 'psyml',
                'post_title' => $title,
                'post_content' => $content,
                'post_status' => 'publish',
                'post_name' => 'psyml_'.$key
        );
        if( !isset($page_check->ID) ){
            $new_page_id = \wp_insert_post($page);
        }
        if($new_page_id) {

            #apparently this needs to be integer term id not slug
            $term = get_term_by('slug', strtolower($key), 'hexaco');

            $tagged = \wp_set_object_terms( $new_page_id, $term->term_id, 'hexaco', false);
            error_log('tagged');
            error_log(print_r($tagged,true));
            $featured_image = self::add_featured_image_to_page( $key, $new_page_id, '.jpg' );
        }
          
    }

    public static function add_psyml_pages(){

        foreach( Hexaco::HEXACO as $idx => $array ){
            $key = $array['Key'];
            self::add_psyml_page($key);
        }
        #then add archive
        self::add_page('psyml-results', 'Your psyML Analysis Results');
    }
    public static function psyml_pages_admin_order( $wp_query ) {
        if (\is_admin()) {
      
          // Get the post type from the query
          $post_type = $wp_query->query['post_type'];
      
          if ( $post_type == 'colorcontent') {
      
            $wp_query->set('orderby', 'title');
      
            $wp_query->set('order', 'ASC');
          }
        }
    }
    public static function add_psyml(){
        $psyml_labels = array(
            'name'               => _x( 'psyML', 'post type general name', self::text_domain ),
            'singular_name'      => _x( 'psyML Page', 'post type singular name', self::text_domain ),
            'menu_name'          => _x( 'psyML Pages', 'admin menu', self::text_domain ),
            'name_admin_bar'     => _x( 'psyML Page', 'add new on admin bar', self::text_domain ),
            'add_new'            => _x( 'New', 'psyML', self::text_domain ),
            'add_new_item'       => __( 'New psyML Page', self::text_domain ),
            'new_item'           => __( 'New psyML Page', self::text_domain ),
            'edit_item'          => __( 'Edit psyML Page', self::text_domain ),
            'view_item'          => __( 'View psyML Page', self::text_domain ),
            'all_items'          => __( 'psyML Pages', self::text_domain ),
            'search_items'       => __( 'Search psyML Content', self::text_domain ),
            'not_found'          => __( 'No psyML Page found.', self::text_domain ),
            'not_found_in_trash' => __( 'No psyML Page found in Trash.', self::text_domain )
        );
        
        $args = array(
            'labels'             => $psyml_labels,
            'description'        => __( 'Page content for psyML tagged content', self::text_domain ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => 'admin.php?page=psyml-settings',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'psyml' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_icon'          => 'dashicons-admin-post',
            'menu_position'      => 5,
            'show_in_rest'       => false,
          #  'rest_base'          => 'psyML',
          #  'rest_controller_class' => 'WP_REST_Posts_Controller',
            'supports'           => array( 'title', 'editor', 'post-thumbnails', 'page-attributes'),
            'taxonomies'         => array( 'hexaco')       
        );
    
        \register_post_type( 'psyml', $args );

    }
}