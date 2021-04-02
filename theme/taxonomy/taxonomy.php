<?php
namespace psyml\theme;
use \psyml\core\Hexaco as Hexaco;
use \psyml\admin\Setup as Setup;
//spin it
\psyml\theme\PsyMLTaxonomy::run();

class PsyMLTaxonomy extends \psyML_Wp {

  public static function run(){

    //Add color taxonomy
    \add_action( 'init', array( get_class(), 'add_taxonomy' ));

  }

  public static function add_taxonomy() {
          //get post type options
    $types = \get_post_types( '','names');
    $types = Setup::unset_nonsense($types);
    \register_taxonomy( 'hexaco', array( $types ), array(
      'hierarchical' => true,
      'labels' => array(
        'name' => _x( 'Hexaco', 'taxonomy general name' ),
        'singular_name' => _x( 'Color', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Dimensions' ),
        'all_items' => __( 'All Dimensions' ),
        'edit_item' => __( 'Edit Dimension' ),
        'update_item' => __( 'Update Dimension' ),
        'add_new_item' => __( 'Add New Dimension' ),
        'new_item_name' => __( 'New Dimension' ),
        'menu_name' => __( 'Hexaco Dimensions' ),
      ),
      // Control the slugs used for this taxonomy
      'rewrite' => array(
        'slug' => 'hexaco', // This controls the base slug that will display before each term
        'with_front' => false,
        'hierarchical' => true
        
      ),
      'capabilities' => array(
        'manage_terms' => 'administrator',
        'edit_terms' => 'administrator',
        'delete_terms' => '',
        'assign_terms' => ''
      ),
      'show_in_rest' => false,
      'query_var' => true,
      'public' => false,
      'show_ui' => false,
      'show_in_menu' => false,
      'show_admin_column' => true
      ));
    
    self::add_hexaco_terms();
  }

  private static function insert_parent_term($name){
    $newparent = \wp_insert_term($name, 'hexaco', array(
      'slug' => strtolower($name),
    ));
    if( \is_wp_error($newparent) ){

      return false;
    } else {
      return $newparent['term_id'];
    }
  }
  private static function check_term_key($name){
    $term = \get_term_by( 'name', $name, 'hexaco', ARRAY_A,'raw' );
    if($term){
      return $term['term_id'];
    } else {
      return false;
    }
  }
  private static function add_hexaco_terms(){

    $terms = \get_terms( array(
      'taxonomy' => 'hexaco',
      'hide_empty' => false,
    ) );

    //Check Hexaco Master Object
    $newparent_terms = array();
    foreach(Hexaco::HEXACO as $dimension){
      $key = $dimension['Key'];
      $parent = $dimension['Dimension'];
      //returns false or term id
      $termexists = self::check_term_key($parent);
      if(!$termexists){
        $parentid = self::insert_parent_term($parent);
      } else {
        $parentid = $termexists;
      }
      if($parentid){
        $keyexists = self::check_term_key($key);
        if(!$keyexists){
          \wp_insert_term($key, 'hexaco', array(
            'slug' => strtolower($key),
            'parent' => $parentid
          ));
        }
      }
    }

  }
  //Hexaco Taxonomy should always be populated matching our master Hexaco object
  //But old terms are not deleted for BC concerns & data preservation

}