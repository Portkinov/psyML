<?php
namespace psyml\admin;

\psyml\admin\Options::get_instance();

class Options extends \psyML_Wp {
    private static $instance = null;
    public static function get_instance(){
        if (self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /* CONTRUCTOR */
    public function __construct() {

        \add_action( 'admin_menu', array( get_class(), 'add_options_page' ) );
        \add_action( 'admin_init', array( get_class(), 'register_theme_settings' ) );
 
    }
    
    public static function add_options_page() {
        
        error_log( 'class: '.get_class() );
        error_log( 'get class method exists: ');
        error_log( 'method exists: '. method_exists( get_class(), 'theme_settings_page'));

        //create settings menu under Settings
        \add_submenu_page( 
            'options-general.php', //parent
            self::nice_name . ' Settings', //Page title
            self::nice_name  . ' Settings', //Menu title
            'manage_options', 
            strtolower(self::text_domain) .'-options', 
            array(get_class(), 'theme_settings_page'), 
            99
        );
    }
    public static function register_theme_settings() {
        #Make API section separate from main Option Group
       # \add_settings_section(
       #     'psyML_developer_info',
       #     'psyML Developer Information',

       #     strtolower(self::text_domain) .'-options'
       # );

        \add_settings_section(
            strtolower(self::text_domain) .'-options',
            ucfirst(strtolower(self::nice_name)) . ' Options',
            array(get_class(), 'print_section_info'),
            strtolower(self::text_domain) .'-options'
        );


        #Plugin Settings Extra
       # \register_setting( 'psyML_developer_info', 'api_key');
        \register_setting( strtolower(self::text_domain).'-options', 'psyml_api_key');
        \register_setting( strtolower(self::text_domain).'-options', 'spacer');

        #Plugin Settings Main
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_use_descriptions');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Hh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Hh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Hl');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Hl');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Eh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Eh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_El');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_El');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Xh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Xh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Xl');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Xl');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Ah');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Ah');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Al');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Al');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Ch');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Ch');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Cl');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Cl');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Oh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Oh');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_link_Ol');
        \register_setting( strtolower(self::text_domain).'-options', 'addlink_desc_Ol');

        $optionclass= 'formrow';
        $optionclasshidden = 'formrow theme_admin_hidden';

       \add_settings_field( 'psyml_api_key', 'API Key:', array(get_class(), 'do_password_psyml_api_key'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'psyml_api_key') );

        \add_settings_field( 'spacer', '', array(get_class(), 'do_spacer'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options' );

        
        \add_settings_field( 'addlink_use_descriptions', 'Set Descriptions for HEXACO Scores?', array(get_class(), 'do_checkbox_addlink_use_descriptions'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_use_descriptions') );
        \add_settings_field( 'addlink_link_Hh', 'Full link for Hh result', array(get_class(), 'do_input_addlink_link_Hh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Hh') );
        \add_settings_field( 'addlink_desc_Hh', 'Text description for Hh result', array(get_class(), 'do_editor_addlink_desc_Hh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Hh') );    
        \add_settings_field( 'addlink_link_Hl', 'Full link for Hl result', array(get_class(), 'do_input_addlink_link_Hl'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Hl') );    
        \add_settings_field( 'addlink_desc_Hl', 'Text description for Hh result', array(get_class(), 'do_editor_addlink_desc_Hl'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Hl') ); 
        \add_settings_field( 'addlink_link_Eh', 'Full link for Eh result', array(get_class(), 'do_input_addlink_link_Eh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Eh') );    
        \add_settings_field( 'addlink_desc_Eh', 'Text description for Eh result', array(get_class(), 'do_editor_addlink_desc_Eh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Eh') ); 
        \add_settings_field( 'addlink_link_El', 'Full link for El result', array(get_class(), 'do_input_addlink_link_El'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_El') );    
        \add_settings_field( 'addlink_desc_El', 'Text description for El result', array(get_class(), 'do_editor_addlink_desc_El'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_El') ); 
        \add_settings_field( 'addlink_link_Xh', 'Full link for Xh result', array(get_class(), 'do_input_addlink_link_Xh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Xh') );    
        \add_settings_field( 'addlink_desc_Xh', 'Text description for Xh result', array(get_class(), 'do_editor_addlink_desc_Xh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Xh') ); 
        \add_settings_field( 'addlink_link_Xl', 'Full link for Xl result', array(get_class(), 'do_input_addlink_link_Xl'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Xl') );    
        \add_settings_field( 'addlink_desc_Xl', 'Text description for Xl result', array(get_class(), 'do_editor_addlink_desc_Xl'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Xl') ); 
        \add_settings_field( 'addlink_link_Ah', 'Full link for Ah result', array(get_class(), 'do_input_addlink_link_Ah'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Ah') );    
        \add_settings_field( 'addlink_desc_Ah', 'Text description for Ah result', array(get_class(), 'do_editor_addlink_desc_Ah'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Ah') ); 
        \add_settings_field( 'addlink_link_Al', 'Full link for Al result', array(get_class(), 'do_input_addlink_link_Al'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Al') );    
        \add_settings_field( 'addlink_desc_Al', 'Text description for Al result', array(get_class(), 'do_editor_addlink_desc_Al'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Al') ); 
        \add_settings_field( 'addlink_link_Ch', 'Full link for Ch result', array(get_class(), 'do_input_addlink_link_Ch'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Ch') );    
        \add_settings_field( 'addlink_desc_Ch', 'Text description for Ch result', array(get_class(), 'do_editor_addlink_desc_Ch'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Ch') ); 
        \add_settings_field( 'addlink_link_Cl', 'Full link for Cl result', array(get_class(), 'do_input_addlink_link_Cl'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Cl') );    
        \add_settings_field( 'addlink_desc_Cl', 'Text description for Cl result', array(get_class(), 'do_editor_addlink_desc_Cl'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Cl') ); 
        \add_settings_field( 'addlink_link_Oh', 'Full link for Oh result', array(get_class(), 'do_input_addlink_link_Oh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Oh') );    
        \add_settings_field( 'addlink_desc_Oh', 'Text description for Oh result', array(get_class(), 'do_editor_addlink_desc_Oh'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Oh') ); 
        \add_settings_field( 'addlink_link_Ol', 'Full link for Ol result', array(get_class(), 'do_input_addlink_link_Ol'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclass, 'label_for' => 'addlink_link_Ol') );    
        \add_settings_field( 'addlink_desc_Ol', 'Text description for Ol result', array(get_class(), 'do_editor_addlink_desc_Ol'), strtolower(self::text_domain) .'-options', strtolower(self::text_domain) .'-options', array('class' => $optionclasshidden, 'label_for' => 'addlink_desc_Ol') ); 
        
    }

    public static function print_section_info(){
        echo '<p>'.self::nice_name.': version '.self::version.'</p>';
        echo 'Enter your developer credentials to use psyML API:';
    }
    public static function do_input_addlink_link_Hh(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Hl(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Eh(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_El(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Xh(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Xl(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Ah(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Al(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Ch(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Cl(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Oh(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_input_addlink_link_Ol(){
        //INPUT
        $fieldname = str_replace("do_input_", "", __FUNCTION__);
        printf(
            '<input type="text" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }

    public static function do_editor_addlink_desc_Hh(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Hl(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Eh(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_El(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Xh(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Xl(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Ah(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Al(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Ch(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Cl(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Oh(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_editor_addlink_desc_Ol(){
        $fieldname = str_replace("do_editor_", "", __FUNCTION__);
        $content = \get_option($fieldname);
        wp_editor( $content, $fieldname, $settings = array('textarea_rows'=> '10') );

    }
    public static function do_password_psyml_api_key(){
        //Password
        $fieldname = str_replace("do_password_", "", __FUNCTION__);
        printf(
            '<input type="password" id="'.$fieldname.'" name="'.$fieldname.'" value="%s" />',
            ( \get_option($fieldname) ) ? esc_attr( \get_option($fieldname) ) : '');
    }
    public static function do_spacer(){

        printf('<br><hr>');
    }

    //replace "option_name" with the name of your option and add settings field
    public static function do_checkbox_addlink_use_descriptions(){
        //CHECKBOX
        $fieldname = str_replace("do_checkbox_", "", __FUNCTION__);
        printf(
            '<input onclick="doConditionalLogic(event);" type="checkbox" id="'.$fieldname.'" name="'.$fieldname.'" value="yes" %s/>',
            ( \get_option($fieldname) && \get_option($fieldname) == "yes") ? 'checked': ''
        );
    }

    public static function theme_settings_page() {
        self::print_page_header();
        ?>

        <div class="psyml-wrap">
        <h1><?php self::nice_name?>  Settings</h1>
        <style> .theme_admin_hidden{display:none !important;}</style>

        <script>
        let admin_ajax = "<?php echo \get_site_url() . '/wp-admin/admin-ajax.php' ?>";
        /* set form conditional logic here */
        /* currently only booleans like checkboxes or radios are supported but can be expanded */
        let condition_terms = [ 'true', 'false', 'empty', 'notempty', 'checked'];
        let conditions = [
            { 
                'id': 'addlink_desc_Hh',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Hl',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Eh',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_El',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Xh',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Xl',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Ah',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Al',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Ch',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Cl',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Oh',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            },
            { 
                'id': 'addlink_desc_Ol',
                'dependency': 'addlink_use_descriptions',
                'condition': 'checked',
                'checkvalue': null
            }
        
        ];

        function doConditionalLogic(event){
            let thisID = event.target.id;
            
            conditions.forEach(function(condition) {
                if(condition.dependency === thisID){
                    //run condition
                    if(condition_terms.indexOf(condition.condition) !== -1){
                        switch(condition.condition){
                            case 'true': 
                                if( condition.checkvalue){
                                    if(event.target.value.trim().toLowerCase() == condition.checkvalue.trim().toLowerCase() ){
                                        let target = document.getElementById(condition.id);
                                        if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                                    } else {
                                        let target = document.getElementById(condition.id);
                                        if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                    }
                                } else {
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                }
                                break;
                            case 'false':
                                if( condition.checkvalue){
                                    if(event.target.value !== condition.checkvalue){
                                        let target = document.getElementById(condition.id);
                                        if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                                    } else {

                                        let target = document.getElementById(condition.id);
                                        if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                        }
                                } else {
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                }
                                break;
                            case 'empty':
                                if(event.target.value = null || event.target.value == '' || !event.target.value ){
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                                } else {
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                }
                            break;
                            case 'notempty':
                                if(event.target.value = null || event.target.value == '' || !event.target.value ){
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                } else {
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                                }
                            break;
                            case 'checked':
                                if(event.target.checked){
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');      
                                } else {
                                    let target = document.getElementById(condition.id);
                                    if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                }
                            default: return false;
                        } //end switch
                    }
                } 
            });

        }
        doConditionalLogic(); //do once on page load
        </script>
        
            <form method="post" action="options.php">

            <?php \settings_fields( strtolower(self::text_domain) .'-options' ); ?>
            <?php \do_settings_sections( 'psyML_developer_info' );?>

            <?php \do_settings_sections( strtolower(self::text_domain).'-options' ); ?>             
            <?php submit_button(); ?>
        
        </form>

        </div>
        <div class="psyML footer">
        <span>powered by <a href="https://psyml.co/" target="_blank">psyML Inc</a>.</span>
        </div>
<?php 
    }
    public static function print_page_header(){
        $header = '<header class="psyml-admin-header">';
        $header.= '<img _ngcontent-c1="" class="logo" src="';
        $header.= 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6CAYAAACI7Fo9AAAgAElEQVR4nO2dCZgcZ3nn/9V3z4xmRjOj0X0flizJOm3LGBkbDAaMiTHHLizhCE5gCeFYiPHBGSAcTiDEsMByLyFAwh3CsSQEY2xjW/J9yJJ1jGwdlmQdc/VV3bXPW/UOM5qvqrp7urqmq+r9PU89I33V3TPdXf/6vu89IQiCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAihQgvDm7nwPa9QxiJMCkAHgHYAswAsATCb/90PoBdAN4AZ/';
        $header.= 'Jg0H/S8OH9sBoAygDyAUQBn+DgB4BCApwDsB7APwCAf+bB+5Hf93feVsaCRCPw7EOYDWABgGYBzAawEsBTAYhZ4MykA2ANgN4AHANzH4qcjF/lvpoUQoQePhQA2AzgPwFoA61ng0wGtBNbxcQ3//lMA7gGwg4V/J68ChGlEhB4MSEhXADgfwEYA57TwXz0TwAv4IB4DcDeA3wH4IYDTyjOEpiNCb11oOf56AC/kZfm8gL6PNXzQe3k3z/LfAPAfyiOFpiFCby06ATwbwFt5eT7Xx7/O4GMMrQnG2nP5eCkb874I4Lu83BeaiAi9NVjBM/';
        $header.= 'fb2JgW8/CvIov4CFvPhwAcZuv5IP9/7FyeLe1lFngSQJat87Qc7+Ebz3we6+RjKsxgG8P/BvB+AF8C8D0AuwL6/bU8IvTphfbeVwK4iS/+RiG31xH++Thbv/ezuI8COOnB76BrZhFb9s/hZflqtvKvmMIqgG4eHwJwI4BPAfgRgHuVRwkNf2mC/5BQ/hzAWwD0NfDb9/Oe9xEADwJ4lMXdTJ+2PsGF9p8TxskbsGWCwfBiAF3Ks50hP/77ALwTwGcAfBXAgOOjhboQofvPDQDeAGDVFH/zb9mQdR/P2nuVR0wPT/LxY956bGTXH1nfX1XHtdbBy/';
        $header.= 'n/DuDrAD4xyXYgTAERun9cDuCTbGSrB7rI/8BGq9t4Jj3T4u+1wstvOr4F4G8BXMSrmAuUR9uzkp/333hZ/3PbRwk1IUJvPt28B72WQ05rweDZ8YfsitrPxrMgUuGtBR3/ylZ3Wp4/t8ZtywYA3+cb3fUAjimPEKripXVXULmE97HvqFHkZY4o+0s2cr2LQ0uDKvLJnOFIOZqlt9axDyfr/xsB3AHgT5SzQlVE6M2DgkNurWOp/m8AXsvGrC+wyyvMDPAqh26Gn2bPQDWWsw3gc7xSEmpEhO49GQDfBvB3Nb7yv7Ph6aW8PI0aB/mmeAULvhZoxfMLSlyM4Oc1JUTo3kK+5f8C8JoaXvUJXo5ezcEiUedhFvylAH5Ww2exjW+Sf6acERRE6N5B1uRf8QXoRpln+0vZ0Ka7PDaK3Mp7+GtrWM5Tbv1XAHx0Qi69YIMI3RsuZgv5yiqvRpbn5wH4a0nddGWUDXV08/';
        $header.= 'xOFT+6xpGF32AfvGCDCL1xtrLbaH6VV6IL8Vk8Y7UkmqZhtAQMFoHhovbHY8j8v+Un85lDvA16G4fwuvFaDp9tdrGNQCJ+9MYgK/BPqmSZ0ez0HraktxyaBpTKwFBJQ7liYO1sAzMyBsoTVa0B5YqGx45qKFVoetXQkTCQSgCG21zrHZT8cjt/hhe5vOrlbKS7mo18AiNCnzqUH/7/quSJP8nhrr9RzrQApOVTOWD+DODCZUWMFGM4d3ERMzJF6JXxxR7dDCoVDTM7MiiXNWSSFew6nMSB00BP1rdl4QMsZIqD/wvl7Dib+Hu5soXCg6cdEfrUyLILbZnLs+nC/B+8L28ZSNw0C5cNIB0HXrC6hJ7OCub15lE2YsgVEjgzkjLFPZm1i/PQNAOJWAW9nRmsGY7j/oEEhgsaknHDD8HT6ujNbKH/rEumHGXV/RrAiyX11UKEPjU+yVZzJ+5h3/g+h/';
        $header.= 'PTAombBEzq2LZUx5weHd0zdHNZfmYkbYoYPIPbkStYhm3D0NA1o4y+7iI6Minc/ngaRR3I65bgE7GmL+lv4bDgb7kEzpCr8184PuGAcjZiiDGufii19K9cnvUQG4ZaSuRDJetYN6+MV2wbwbL5JcxoL5viLZZifxR5LdBjSyUNo/kE+rrLuGrrCC5YrqMrY23sC2Xnm4WH/IzDYd28F5Q9900AbcqZiCFCrw9KLf24yzMOsch3K2emARKbZUXXML8T2Lakgo0rctBiMZTLMAXeKLpOS4QYFvaX8IqLh7FpkY68Dpz2p8r779jw5jZjU4jtd7liTmSRpXvtJKrEWFNZpldyAYhphQROs+ozOWD9bKC/U8d5y/Pmkn00H/d8tq2whX4kl8T6pXnE4xkcORXH3hMaOlJNX8bvYMPbT9kLYsdVAP4RwP+0ORcJROi1Q8v157s8+lrOzJp2yPfd32HgwqUlLOwvY2ZHHkO5tCm4Zi6paUk/';
        $header.= 'Uojj3MU5rF1iIPtIB3Y8GUNXCkjGmyp4qqzzEk4MWqGctXgLG/E+r5yJALJ0r43lXPXEiVvY8DNt0KSqV2Aum3vbDFy2LocNy0eQTlVwZiTjl7+bVw0JFEsJbF2VxzWbC1jcY+BMwTIGNpFdHDr7pMuv+DTnwUcOmdFr411cCdWOO6rcBJoKRbMVygbScQ1taQNbl5Uwc4aO9mwFp4cz5ixbj6HNK4q6hngMWDCriFndOkrlNhwd1FCsAKnmTS9U0eZNHMSUVc5adek+z/v248rZECMzenXWu2RI0UR63XSUdjKDWKisa94wg1m2rSjgqvNHMLevhEzaQKFYnyXd87+P9+4j+YR5M9q+Lo+XbMlhVjsZCLVmbiF+zct0J6hi7c0O50KLCL0673KYHcD1yG9XRn2ArNoUurqq18Al55SwbF4B5UrMtIKblvAWQWPLPG0dOtoMXLo+Z9oPjo1Yf3+TBP9/OdbBidfzzB8ZQpHat+BZTesxeB6HXNq5Zg5x5NuwcqaJkDAowWT1bANr5pVx8doRzGirmBFtrQ4F5rSlK5jbXUF7HBgtxjBY0JBuzp/+G46Ld7LEX8Rut6plug7d8agyFjRkRnfnL12CLT5bQ0aVZ5DAydj2TE7D+vkVXLZhGOcuyWFwNFl3wMt0oXF0XVu2gmevG8Jz1+XRkbIMdU3IjKtwnoFTvPssvolHAjHGOUMNCV7mcHYXC90Xxqzp5/';
        $header.= 'QbOGd+Hj3dBkplimjTHIO9G2ANv+9NnHqb4RZO+7ie/M8bqWdHNyRayp8cyqKnU8cLN+bxzGAcd+9LQa8YSHj7hqhrzdu5Eo0dL2cfvNP50CBCd+ZVfNe342tkWLYZ95xiGUjFgeV9wLY1o8gkDeRLcRQrnot8MddRfyH3WbPjDSyemzgHv2TzmJogwY8W4uhsL5uCTyUM3LorhQJlxyUML92BdGO6xSVs+QNcLz8slXZtkaW7PZpLWWFyy/yzMurlL9csgZ/Ma6aV+srNeWxfnzO/LhIHWbM9FvmLuUnEa1xETqQBLOHMva81WtGF3gNtO3L5OBbPLuI5q61754ncWAKOZ+/yb13CkqmKzauV0ZAhQrfnAm4pZMcPqiRSNARd21ThpTMDbJpfxva1eXS0lVHWx0NNPeYlHD46p86XfS2Xz6q1KYUjNHlTRN3iOQVctqaIc/sNZJMwl/IecZRXIU5cF/bKNCJ0e17g0t3028qIR9AMNlIC2pPApWtzeN7GM0inDBQ8SD5xYD2vTqbqfXk+x5A3jMax8gv7i7jy/';
        $header.= 'NNmqmvB27KZ3+fDDqor8Dqb8dAgQleha267MmpxbzNb+hbLBmZmgSs35tHTWTYNVk1Ypk/kH1xuaLVCwUQv8uKPoX07LeXP5NLYsLiIjrTn1viPuAQ3/a8prGoCgwhdZSXPdHY0ZHGuhm5YS/be7pIZL95kl9nlVYpnPMWz9Y1cxtrtj3m3MtIAVNhiYb+OmOZ5IsyDXFXWjjk11uMPJCJ0lQ0ud/bblBEvMSiIBCjpvvjFX+ny/X+PW0m9g/Pvr2aDlVNw0FZ2x3lGoaihPdWU902pxqeUUYs3ssExdDh90VHmPIf3PsD9yJsC2Z3IjTZ7RsWc0ZpM3KV98X2ccjsx6SPP4n+H8miLLu4Z5wlGBaZtYtuqplSveMRlr76ac9dDhwj9bOLc1teOh5tpbaf5uz0NbD0nf1YF1iaxkMVpx1dcZu4fcCspO5bYjDVEpXk3vC/wzWsyCfYmhA4R+tnM5nJRdtzvdfsk019esWLXR4rAaMFasvpAJ0e82eFWD50CZB5TRi2C1CXlPnYN2vFcFxtNYJHIuLPp5+qhdnhatpkCQqgDyupZBlbPLyJfjCEeB2JUQdU7/7ETpx1mNLi8f3A+t1MFF6dVQEPQ5xRvXoabnfFtBocAP6ScCTAyo59Nn0MASM6LZftYYspISUNPG/DyzQWcv7KA+bOKZprpon5fomrBzQud3EyvdVnWv4pj4e1wWwnUDcXDd3fouHCZVWyyCdzlUt/';
        $header.= 'veWGbBEXoZ+M0m51oNFONRJ4raWbE16LuCp61Oo/+mTrSacMszkBZXTSr+wRJZ6fDr7qAY8MndqChZf41AD6lPNpimENoPYPWNMmEgRnZCpq0wDnNNgc7NoZt+S5L97PpVUYsGhL6WA55mxnxljdLKxVK48KepjIR33cpvvCnHDREUYAnuTnky5VHjfMA2zA8hbwPlMPeRH7FZcAm66CT89Xva+Yv9xOZ0c/GKd55aKp70DGRpxMaXrRhFP1mMEy8WXHr9UD9yX7v8vglHB/+91VEDk4aCSKPcFcdOy4LU891Efo4msvedAhTjMak+urdGQprzaG3W8dwPulHF5NaqHAfs9MNvs43OGIwiAxzEwg7ttbQCjswiNDHSfGSzY4TNmNVIYsxVUOd2W5gTk/BTNqItVYlmEc5OKasnKmNX3Lv8qbhQ4TgXcqIxRIXD0PgEKGPk3LpwuIUMukKNS2Y12lg87IChnLJVi339AMOh62n/LHBdezJCj+inPUAMsQN52K4+4kUMnYV+7zjQY7rt8MpSjJwiNDHSbsIva7lLS3NqQ7ahct1vHDLCGa0+xLW2gg/Ymv7j6usXkq8Cngrd4sdUh7hEWTDOH46gaGC1uyLdJ9LQ8z1YdGICH2clMse3cnnrDAm8v4OmH5g03feQuWXXTjAgSJXsaXdjn+iNukAvlglm60htBjMenh37UsiEWv6Ksjg8GY7VnuQxtsSiNDHiTsEy6CeemLUI3zuDOCKjTnM7NDNRgoB4w8ubY2cfO+eQspry1SQ9s/';
        $header.= 'm7RTWu8rl5h8oROjjtDvUS9NrXaJShRgKa13SV0ZvZx6jhUSrWNjrocOlYYVT6WtPScYM3PtE1mz57NPnt8ehzkBfWCzvIvRx+hxykXO1GuNGSgZW9BhYPreAM6PpQNRad2Ba/3DyTAw8EzNLSfl0gQ642GE8z8qbDkTo4zgt0XIue9Y/UmFHfN+MCro6dFTK8tFOFbrLZBOGWWHGJw47zOjEXGUkgMjVOI7dsp0o1GKMo9mnOwtsWZXDcOu60gKB2dFF15oV427HoMt33KeMBBAR+jhOXygJ/RlldAI0m1P/sCW9ZRjTFbkeIqjgxOLeivmZ+hgpfEQZsehXRgKICH0cpxl9yOVub0IFDEneG5fnoZdF6I1SqmjYvCJnJgF5XBzSDaftmdOWLlCI0C00lzv3M9WMU3pFw8ZFulkCypj+ZJXAQ1/GaD7m59IdLhF+vngamo0I3SLhUvn1aWWEIdcPNVzYukTH+qU597uB0Oo4Vf1wKrkVKEToFjGX8NdjyghDSStUSGJ2t46yzOZBx6mOTShqNojQLdIubhRbHzrN5sdGYfYqn9Nb8LM6jCDUjVydFr0OS/eyU2YT5Zkv7gJmdelmwwUh8DgF3DrN9IFCSklZzHUI+yzalZCiUNfTBWDNnDKWzR0xe6S5+M0v5sywZWzZJyv+fk6P/IXyaGG6cEqGnXIP+FZChG6xwGF1U+CoqbPI6waWdgOr5hUxmHMMdaViiu/kVEe7/X+B66x9m4sxCtOLXfjz2PcUeOwu7igy3+GzGJ1c5rnCy/';
        $header.= 'be9gpmzSxCV5ftlO76ZRbwdgeRgy+sC7mR4U/DVLbICxJxCoH1NSbBybruZI0PFMpVGlGcEhcOTQ6kIN/uil4Dm1cUMTSqhLpmWeDXulw4dlzFRR8W2JyLHCTvMyNx6P460u22bnDxrwcKEbrFImXEYmBiUcixUNdtqwtIJm19aTQ7v0IZrQ0qRvhNlyVkZEjEK2YJKWpT1aQuLXY4RUY2pQON34jQrTu5U22w/ZMHRosaSpRwodYb/xOeyRuB+n7d4PUbDCI+CnwMJ6E7hcYGChG61QrYqUPLoxP/Q3XMNi7UkU2XJwfH0L78Q8qzz4aqs3wdwH8pZ87mLyZ1SRGaT4dLqKtTnnqgiLrQ1wF4t0OzFPKh3ztxgBIsls4pIZU0Joe7ktFtg/IKFqMs3hcD+DMAVwN4oUv74bn8GME/Zrvs0UXoIeADLump5OPeNfafsRbHI7mYXUbVcxxuFmAX25cnhNIOciugN7gYep6jjAjNZKaL8dQxBDpIRFnoz3MxnJW5zdAfXSvUBbUnC6STtqWblymvYPEHbs9rx+0AvmszTix0idQSvGeuS393x6SmIBFVoZNSP+YyC38WwJ0TByhLbcuyImZ1l0xj3CScVgU7qwRcOLXtbXfxvwveM89hRj8pM3qweT0Hq9hx1K5pIH1Q1NnToYJMThmxcGraOIaTmEsuy3rBe5yClY661JILFFEUOt29b1ZGx/ng5NJR5v68bAndVuaWv92OK9jgZ0c7dzuxg7ql5G3Gheaw0uFVD4rQg8u7XJba1FnzK5MHh4saNi0wsGhWATn7dNSdDlVoqMvHV20i3iiB4nMA1ijPsHBq5St4D7lGFzu86v6wrKyiltSyCcBblFELmkE/';
        $header.= 'atcemUIxuzsq6GjTMTiaspvV/5P3cnZL9QvY8PZlbqxPhrvXcSScHU9z40PBH+a4lBFzWqkFjqgJ/a9drKv/CuDXyihb7HQdZhUZG5GDM9woGOZ65YwFhdh+RBm15yhntUUS8mikEmUk4vCrZtxylz26U6xD4LBdh4aUy7iJoB2n2ArfCP/g0pWzHtZ68LcElkSigoNPZzCY15Dw5+pc5mBxL4nQgwftiW90+EKJzwB4XBmtj6e5X7ht6ak6SPDf6mYwDC3pZBkPHUzi2AiQ8ifgfbMyYrErLK41REjoLwFwuTJqsRvAF5TRCdAKMh63eoJVWU3u5N9lW36qTt4D4OMevE6goKU7FdxMxujfVT7txmnjwiB2PGZXXSioREHoMzie3YmbqzT/R0cKePBgHANHM8ikFFvdZO7g8lH/VEO9sWoutOvZQCg0h8Uuno/HHTwpgSQKQr+ShWfHHWyEcyUR03AqD+SKGuL2ZaMmQ/7XNwJ4FoBPs7vsEC8FD3NE3Oc4PfbtyrPP5ia7AB7BE9a4uFrvU0YCTNit7u1VZvPP1NJAkZaQtF1syxjQYhUYiDtZ3yeis8DHfOKzOHlieFIduj1sO/iU8grj3MCx7+9VzoQIy+Kum2WkKmo+QTN4lsNr0k35IWU0wIRd6Fe7+Kt/A+BnyqgDVFlm4FgC3R0Jy/VTf7OG43zYcTN78T5pc26M6/hnaMVOVXueOp7BieEYUs1P6aEt3aXKqMVuu6IjQSbMS/d2F792kcVVc5hpJgHc/1QMpwYTSMab0pLlUzWI+LqwLuNpNu/IFHHweAp7T2nm591kzqW+mA6/4k7OYAwNYRb6K13izCkw5pfKqAtkAG5PWtVJm2ih+dSEmduJG8JooKOqPfuPZPHEsRj6MoZdzr/';
        $header.= 'XXO6QCjxaQxWgwBFWodN88FfKqEWB01CnRDzmkL/mHTfXUDcudAY6cl2eGEyY/vOknfy8Jc1VfuwY4DoCoSKsQn+Zy7Lst06hrrUwmIubbZKbzCdqEPsNYRE7uSxPnEni/oNxs7iHD7M5+c4vUkYt/hCWyq8TCavQr3V5b59RRmqEgmbu2Zc081ZjTq/uHST291V5tcCLXYsBBV3DoWcSZndany7IaxyW7Qhrm6wwCp1i2i9RRi1+zfXapgyVlNr3VBKZVNmupJTXfIzz4924Icix8WTzKJc17DwY92PJDra2X6OMWjzR6PXRqoRR6G+uEtM+ZWLcqeV3exJ4bCCD9qzuh9j/hotYunFjUA10elnDwwfSZsirTxcjuVzPUUYtfsrFO0NH2IS+GsCLlFGLO9l33hB0QaYSwG93j4m91GzjHDjFtdoy/ia+KQQLWiEdj5krJZ94k8uv+aEyEhLCJvSXA+hURi2+WaVQY02QoSgdBzJx4NY9CTx6IItsRvdjz07L8/cro2fz/jry3qcVsre1ZXTs2JNGXteQ8udKpDLa25RRi9s5KSmUhCkyrpOFbsf+eqLgqmGKPQFQ3Myde6222ucuySFXTEzu4OI1H2WNuC3T38dpuU7BQi0BudMGh+NmFJwPVvYxrnXpbff1MNfpC9OMfiGXirLjR5PbHzcKXZwU/55JGLhzLy3js8imqiWreUItBrr3tnKKK9k1utsLePjJLA4NWp+hD2ziFGI7KK34JzbjoSEsQte49bAduWbXYKM9+21soKPlqE8Gumq93q5v1WV8KlnGwNNZHDujoS3pWzfFt7qU1/5itVTloBMWoc90iXS6o9mRTvQhUhLGrbuT2HXQMtD5MEd9mA833lfD7O8r9LnQyufIyST2nfJtNt/';
        $header.= 'OBTntoOIS37IZDxVh2aNvdqjNTTvm79hVdvUaKntE6ay3Pp4yZ/Q1i33Zs3+IteM2u3+IVzxuj/GNbKqCJ49nsOtoHH3+RMHRnvx6Lutsx1e5fkCoCYvQn62MWFS45/gCnnhznLk2Jj+NP4Mkd9Okcs3/PpX9Gok8ndAAzcBte5Lmz+Vziygj1uzZfWxWdxPyBzkSrJrVvumQsJ8ZTOBkDpiZ8UzoXVy2eQlX+R3mPP8jbKB9sfIMi8PsjQk9YRG6k8uE3t9rlFF3ilM1zJDYyU1EVWh+vyeJWV0V9HaWkCs0PeTrw3zzcvOjv49vdjcpZ3wilaxgaDSOnQfi6E57IvLFXEHoDWxsm3g9j2WhrVKeNc7X+IYQesIi9HnKyNRp2MVC1ngqVTxwLGkKnXzsUyhUUS8f4RWK2779Rv7pu9jpD6PmlPSZeMQ1HOm4yOHl2vgm4MReAJ93Ohk2wmKMe0wZmTqemIFpZt9xIIZ797SZJYx9sMSDZ/Rqxrcb+fD1Jk/JK/liDPcdjHsRXHQ9e1KcRF4LHwtTlddqhEXoH6+l9pvfUNniHQNx7NyTNZNgfKIWsf85eyp8JZUwzOIdDfJ2D2IEqC/9N5TREBMWod/PFUN+z3vsRvAs6oWW8DENePKZGGIxw0xz9SkI7G/4cPp1g37P6PT+796dQU5v6KLbzum7jfI9l88mlIQpBHYHtyleylFyZISZC6CXAyXa+NDYAr3QweXi6W66LWng5KiG2x5qx/b1I4jFYiiWHNsve8kH2Vj1epvXLPvhcpzMqRHNLNoRj09JYxr3zssqZ8YZYot7u0vOA/FazlTz/TOYLsJWBZYsrY/';
        $header.= 'wMRmNhZ7jnz/nGcLucZ5CkXOPHCXXWzsuWT8MDTEUSo4NG71kp4PQfWWsjHM62ZCpc5tL1VbwLE0trx8FsIK75r5aeZTFS7nW/23KmZASpW6qxoRe1xUWvC/QUrUrw2JHB7avG0EyYUDXmy71lvh+qXHigaMZjBTIGzHlFfPzuWiEHZ+clMRzmHvdH3SorJvkSMrICD1K3VQnEvP7vZPPuCsNPHpUw+8fbodetizRUSCdKOOhgSSeGUUjHVLdeqQ5BQLdxF1x7HB6vVASVaFPC2bJ6BSw94SGQtGXpXtrvG9oyKYMU+RTDJKJsa3Fjp9zi2M7yhzpaMccm7HQIkKfBtqs+pJCfTh9YlPdC/hToa5FEKELTUeDgULJqrc3RcimctLhqRe7FJOAS6HQI8pIiBGhC02HXGpzuitmAFED/qxdyojFRS6NNK93aaS4WxkJMSJ0Faclone/QAPas5Fx4aJQTGDLylH0tsM0Qk6RX7nsxT/G3Xcu4q61F3LHm4+7fJ+hrN/uhAhdpakKpA88rwMP7stYMfDKI8KHphkoluONJvbcXqUn2tv5ZjBWu/89yiPGucOLisBBQoSu4jRreAZZnu/eH8PO3W1oS5cj42ZrYI8OtqB/skrIDfnZN3B+uhsfDFu31GqI0FWclnqeQTHwZHm/5yCJPYtsUjfDQsM8u1cqGi5YWbR6yytna+Y33HG2Eehm8R8+vvWWQIQ+TZBPmTK5dh5MYMeednMZn5haDHhg6OrQ0dfe8F9LlXT+XhmtjVsm5ORHChH6NEIze0fKwI6DMex43BK7D40gpgXan1Oa6uZlRQwVtEbiCAzef7+jjlpvh1ngb49SIstEROgtQGeKZvYYduy2ilSEFXKzZdNlrOmvoND42/xHzlakWfoB5azFg1xF5opWrnPvB1FKamlZyDjXxkUqYlobNq0Y9aPOnO9Q19TuDh0r5pXw0NEU+toarhu3i2fpOdx3r58NcpSq+jSfj0wVGTdE6C0CFajIJoC7DlCLoiw2r8yhUGrYJdVS0Gp9JB/HrK4SNi1I4tEjGjrsKgLUz1ERtDuydG8hyEDXlgDuHojjXrP8lD7VIg0tS8XQ0JYpY3aXbt7cIrlhngZE6C3GmDXerDXHe/Z4iFbxNKsP55I4Z1EOS/uAM3lJ8PEDEbrKtF92ljWeDHRx3Lu7HemEDi0WLjXoegwLe3SziYOPvdEjiwhdxZeWqLVAM/s9AzHc+0QbMklfmjf6Rr6YwLqlw+jOGsiVZEpvNiJ0lZbyb1HG110H4rh/bxbtmWm/B3n2B1D8+1AujXWLSujKGihHqiar/';
        $header.= '4jQVVpqejHDZRPAH/bHce8TWbSl9ekMqulRRhqgXAEW9JfMlYsPzRYjjQg9ACTjltjvOZCwlvHTZ41fqow0gGaKXcOW5QVzRpetevMQoQcAmu1M1xuFyw4k/tjmaRpmds+3NVRPbkkInZkAAAoFSURBVEZbBXM6DZnVm4gIPUDQl2XGxg/EcZ85s/tuTvBcimUd6MiWsXFJCacLCG2s/3QjH6tKS5uAadYjA93d++N44ImsGTsedGt8UY+bYj9vjoGRplcDiCZRFXqSu7XYUbAZaynoS8skgDv2xfHAXstAF2R0HZjZUcLifh2jIvSmEFWhuy1B+5SRFoQMdBRSdvhUzKzcEuQ5nSLjhvMJzOsrYMNcA4NFiZbzmqgKnbKbjimjFpuUkRaElvCdKQMHT2t4ZCCLjrZioJfwFAOfSRno7yojHYf41T0mqkLXXcoHb+Na4YGAImOfPhPD6eEkEongqsPMbMslsHbJKOZ3AYMFmtVlWveKKBvjbldGLNqCVKSAYuIfPBrDkZMptKeDPasTlJq7dNZYDLxM614RZaHf6tKAbzsXEWx5aAnfkzGw53AcT59KIZkIdthJsRTHmiUjmJGGF1VoBCbKQqem+V9VRse5DsAXACxSzrQYtKfde0rD0GgciXiwhU4x8COFJDYsKaI9qUm0nEdEvcLMlwC8EcBG5YwFNdO/mtv33APgcQADEyqa5Hm/X+aj4lPxwRh/d/SzYBgwaKm780AKne0GOtrKfvRebxq0/Zjbq6MjncLpXKtHNgSDqAu9wH27fkaJYspZizl8jDXrGxP0aQAn+KB/D7I1f4R/0k2ALtMi3wxKE24IZb58K/zvBP8/xl0+4zxG/v4UHxn+G9v46GU3ITX6f4KeOJy3EkWCjlGxPomty4v42f1p0w5hSHxsQ0Rd6OCmAO/k2b0WxoQ4i4/pZGSiLYHi4cMy+VHDh/ZMGQu7DRwftrL4hKkjIbAW/4dnxqAxWqVFUWChqjPU8GH94iJO5iSAplFE6ONQq5/XATijnGltQikBjbuwdrXr2DRfYuAbRYR+Nt8CcAEv5e+vEiorNBm9rKGrvYR5PWUUxdXWELJHV9nNxzcBLOZe21sArOPCC2QQS/MhN8omYrra8kksnZPHuSfa8egxzQykEbtc/YjQnTnNx8R2Pz3sV18IYC53BpkNoJs7hPTyzyQf8QmusDGrut3NweCjMuHnmHV+iH/vYuVZEYBcbdR8sr+7jAOnkma0nBjm6keEXh8n+bi/yrPS7AJLs+DTk9xmEy/ViQIf88nr7PorsfvuRQB+rvyWiECz+nnLRjFwvBMDp4GutMzq9SJCbw4Fj/';
        $header.= 'PaQ2lZrxVawucKCaycq+NMPoFSWdxt9WK3jBRaD286lAWYkh7DygV5sz+dNHyoHxG6EAhoVs8X49i8vIhkTCrG1osIXQgUfZ1ls+GDUB8idCEwUAvpdKqCzUtLGCpItFw9iNCFQEFBNFQxdnmvIfnqdSBCFwIFCb2ns4TV83WckpbLNSNCFwIF6Xq0kMSsriI2zTPMJbxQHRG6EDjKZQ2pFHDZeSNYNNPAcFG+w2qI0IXAQa62QikGLVbBnO6KWRpaykO7I0IXAolVHjqJDcvy2LKoYqaxim/dGQmBFQJNvhjD+atGEdPa8NiREJXY8RiZ0YXAUzZiWLu4AL0iVWOdEKELgYdcbrFYBecv0VHUNTMWXgR/NiJ0IfCYVWMRw/plo6bYqce6IQa6sxChC6GAwmPzxQRWLSzildtGsHqOZaATsVuI0IXQQGKnw9Di2Loqh80LKjhTgCn4qEfQidVdCB1GxTCt8VtW5dCeSePp03E8+HQMmXh0p3cRuhBaiqUYNiwfwXAuhf7uFJJTFPpjykjwEKELoWZwJI1E0sD6paOBbyndCCJ0IdRQuGxZB0b1aF/qYowThAggQheECCBCF4QIIEIXhAggQheECCBCF4QIIEIPBm4OYLdzgmAiQg8GbQ5/5SwAGWW0MeLSAip8SMBMMHgYwM0T2iuDb9IjAA56/A5GARzmXvBCSBChB4PdAK6r9pdSSqYHaRvUqvmQMioEGlm6hwBKwaRUzK1LdXR16ND1hrftMgGEDBF6CKDSSR0pzWxAGPfmGxUDX8gQoQccms2P5zSsX6hjdk8RhaJ8pYKKXBUBp6ADy7oNzOrUzfxrQbBDrowAQ7P56aKGhb0VLJo9imIpHvWPRHBAhB5gRkoals80sHJuHkO5tJl7LQh2iNADClU4LpWBvhkV9HSSpV2+SsEZuToCymgRWN1fweYVBQzlkjKbC66I0AMG7csHi8CKPgPb1+e8CJARIoAIPUCQyKlO+YpeA5duGDW7kRjSe0ioARF6QDBFngeW9wKXbxoxK5qWGo+AEyKChDpWocIdQKabvG4t15+7YQQVQzMDY2RfLtSKCN0FM0nEADoz09uds6gD87sNXLKO9uQaCoW4iFyoCxG6DbRMHi5qKFYMbJxXwQWr89O6TKZ9eDwOcybXS1o9Ipe1vWAiQreBkkSW9Bjoaa9gw4q8Ka5pNWZwG2Cj/';
        $header.= 'kl8pjJiMZcLTAgRQYRuQ0HXsHlZDnN7czgz4nUBF1+5HcB3OMe8wkUr0gD2AxgO8hsT6kOEbkNMA3KFGPKlwFdU+iUfQsQR95ogRAARuiBEABG6IEQAEbogRAARuiBEABG6IEQAEbogRAARuiBEABH6JMxmCLqBckWDFt2yDk5Rc4PKiBAIQhEZRxVXvCKnA6t6gO4OHaVyJO+DWwBsVEYttgFYD+Ah5YzQ0oRC6Jes1JWxqVIoaVgxr4SObAW5aKWD9gH4BICrAfQqZy3OB/ArAD8A8F5uyCgEgFAIfe3inDI2VbQYiT0eNZE/B8CXAJyjnFGhzLe38XPeCGCn8gih5QiF0EcL3r+NCIn82QB+DKBbOeMOLeF/BOAqAA+4PlKYdsQYF21ouf6FKYh8jIX8/KxyRmgpROjR5sMA1jX4CVwE4EZlVGgpJB89uiwF8GqXd38UwLcAHAcwH8CfAuhRHmXxBgC3ADimnBFaAhF6dHm5S6mp37LB7ZEJY98A8EUAFyqPBhbwXv2ryhmhJZCle3TZ6vDODwF4/SSRE/cDuBbAaeUZFk6vJ7QAIvRoQtVhlzm8858AOKiMWjzMfnQ7nF5PaAFE6NGEvnenqpf7lZGz2auMWLQrI0LLIEKPJmWXePZzlZGzWaOMWAwpI0LLIEKPLrsd3vnLAGxQRi0uAfAiZdTiMWVEaBlE6NHlDth3murmWPbtk8avAPBthyU/JRvcpYwKLYO416LLvwH4CIB+m09gOYCfAvg978lXsfA7lEdaPAXgF8qo0DKI0KPLEfaLf8DhE6CZ/SXKqD23SK56ayNL92jzaQD3NvgJUHDN55VRoaUQoUebMwBe5+I3r8bjAN5EafxVHidMMyJ04RE2tN1a5ydBe/LnA9innBFaDhG6QOwC8FIA7wRwuMonQgE1b2Y33JPKWaElEWOcMAYZ0z7LrrXz2We+hCPehtn6fivv6avdDARBEARBEARBEARBEARBEARBEARBEARBEARBEARBEJoFgP8PqAZeh3mHGDUAAAAASUVORK5CYII=">';
        $header.= '<h3 class="psyml-admin-header-title">psyML</h3></header>';
        echo $header;
    }
}
