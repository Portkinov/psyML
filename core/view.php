<?php
namespace psyml\core;

/*
* The View Class allows a Template class to construct and render

* In familiar templated patterns. Uses PHP supersetter/getter functions

* to accept an object/class with any structure and render HTML 

* in <a href="<?php echo $this->link ?>">the link</a> fashion.
*/

class View extends \psyML_Wp{
    private $file;
    private $args = array();

    public function __construct( $file ) {
       # $this->file = self::get_plugin_path('/core/views/'.$file);
       $this->file = self::get_plugin_path().$file;
    }
    public function __set( $key, $val) {
        $this->args[$key] = $val;
    }
    public function __get( $key ){
        return (isset($this->args[$key]) ) ? $this->args[$key] : null;
    }
    public function render(){
        //buff
        ob_start();
        //bring params into local variables
        foreach($this->args as $k => $v) {
            $$k = $v;
        }
        //get template for view
        include( $this->file );

        $output_str = ob_get_contents();
        ob_end_clean();
        return $output_str;
    }
      
}