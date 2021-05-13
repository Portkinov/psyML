<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option = self::text_domain . '-version';
\delete_option( $option );

$delete = \get_option( 'psyml_deleteposts');
#delete pages
if($delete){
    $psyml= get_posts( array('post_type'=>'psyml','numberposts'=>-1) );
    foreach ($psyml as $post) {
        wp_delete_post( $post->ID, true );
    }
    $subdimensions = get_posts( array('post_type' => 'psyml-subdimension', 'numberposts' => -1));
    foreach ($subdimensions as $post) {
        wp_delete_post( $post->ID, true );
    }
}
\delete_option( 'psyml_deleteposts');