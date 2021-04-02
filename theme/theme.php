<?php
namespace psyml\theme;
use \psyml\core\View as View;

\psyml\theme\ThemeFunctions::get_instance();

class ThemeFunctions extends \psyML_Wp {
    private static $instance = null;
    public static function get_instance(){
        if (self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /* CONTRUCTOR */
    public function __construct() {

        \add_action('wp_enqueue_scripts', array(get_class(), 'theme_enqueue' ) );
        \add_shortcode( 'psyML-text', array(get_class(), 'psyml_textform' ));
    }
    
    public static function theme_enqueue() {
        \wp_enqueue_script(self::text_domain.'_theme-js', self::get_plugin_url('dist/js/theme.js'), array('jquery'), self::version, false);  
        \wp_enqueue_style(self::text_domain.'_theme-css', self::get_plugin_url('dist/css/theme.css'), array(), self::version, 'all');
        \wp_localize_script(self::text_domain.'_theme-js', 'props', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('do_personality_call')
        ));
    }

    public static function psyml_textform(){
        $form_view = new View('theme/templates/text_analysis_form.php');
        $form_view->id  = 1; //Can insert any needed variables into the form using the View class
        return $form_view->render();
    }
}