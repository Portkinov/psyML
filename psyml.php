<?php

/* 
 * psyML for Wordpress Plugin
 *
 * @package         psyML
 * @author          psyML Development
 * @license         @ToDo
 * @link            https://psyml.co/
 * @copyright       2021 psyML
 *
 * @wordpress-plugin
 * Plugin Name:     psyML for Wordpress
 * Plugin URI:      https://psyml.co/solutions/
 * Description:     Provides deep semantic analysis and classification of your content based on our industry-leading psychometrics.
 * Version:         1.0.3
 * Author:          psyML
 * Author URI:      https://ben-toth.com/
 * License:         @ToDo
 * Copyright:       psyML 
 * Class:           psyML_Wp
 * Text Domain:     psyml
 * Domain Path:     /languages
 * GitHub Plugin URI: https://github.com/zimaben/psyML_starter
*/

defined( 'ABSPATH' ) OR exit;

if ( ! class_exists( 'psyML_Wp' ) ) {

    register_activation_hook( __FILE__, array ( 'psyML_Wp', 'register_activation_hook' ) );    
    add_action( 'plugins_loaded', array ( 'psyML_Wp', 'get_instance' ), 5 );
    
    class psyML_Wp {
 
        private static $instance = null;

        // Plugin Settings
        const version = '1.0.3';
        static $debug = true; //turns PHP and javascript logging on/off
        const text_domain = 'psyml'; // for translation & namespacing ##
        const nice_name = 'psyML'; //should match text_domain except capitalization & whitespace

        //Plugin Options

        /**
         * Returns a singleton instance
         */
        public static function get_instance() 
        {

            if ( 
                null == self::$instance 
            ) {

                self::$instance = new self;

            }

            return self::$instance;

        }
        
        private function __construct() {

            // actvation ##
            \register_activation_hook( __FILE__, array ( get_class(), 'register_activation_hook' ) );

            // deactvation ##
            \register_deactivation_hook( __FILE__, array ( get_class(), 'register_deactivation_hook' ) );

            // set text domain ##
            \add_action( 'init', array( get_class(), 'load_plugin_textdomain' ), 1 );

            #execute deactivation options
            \add_action( 'wp_ajax_deactivate', array( get_class(), 'deactivate_callback') );

            // load libraries ##
            self::load_libraries();

            // enqueue scripts & styles


        }
        
        private static function load_libraries() {

            // Taxonomy set/scrub needs to happen first even though it lives in the View neighborhood
            require_once self::get_plugin_path( 'theme/taxonomy/taxonomy.php');

            // Admin - All "Back End" Files Associated with the Wordpress Admin View
            require_once self::get_plugin_path( 'admin/setup.php'); //Setup Page
            require_once self::get_plugin_path( 'admin/pages.php'); //Create Content and Landing Pages for psyML Content
            require_once self::get_plugin_path( 'admin/content.php');
            require_once self::get_plugin_path( 'admin/functions.php' ); 

            // View - This class loads templates
            require_once self::get_plugin_path( 'core/view.php' ); 
            require_once self::get_plugin_path( 'core/hexaco.php'); //Translates HEXACO table

            // Theme - All "Front End" Files Associated with the Frontend Views/Templates
            require_once self::get_plugin_path( 'theme/template.php' ); //setup frontend files (wp-load, enqueue, image register)
            require_once self::get_plugin_path( 'theme/theme.php');      

        }

        /* UTILITY FUNCTIONS */

        public static function register_activation_hook() {

            $option = self::text_domain . '-version';
            \update_option( $option, self::version );     
        }


        public static function register_deactivation_hook() {
            
            $option = self::text_domain . '-version';
            \delete_option( $option );
        }

        public static function load_plugin_textdomain() 
        {
            
            // set text-domain ##
            $domain = self::text_domain;
            
            // The "plugin_locale" filter is also used in load_plugin_textdomain()
            $locale = apply_filters('plugin_locale', get_locale(), $domain);

            // try from global WP location first ##
            load_textdomain( $domain, WP_LANG_DIR.'/plugins/'.$domain.'-'.$locale.'.mo' );
            
            // try from plugin last ##
            load_plugin_textdomain( $domain, FALSE, plugin_dir_path( __FILE__ ).'library/language/' );
            
        }

        public static function get_plugin_url( $path = '' ) 
        {

            return plugins_url( $path, __FILE__ );

        }
        
        public static function get_plugin_path( $path = '' ) 
        {

            return plugin_dir_path( __FILE__ ).$path;

        }

    }

}