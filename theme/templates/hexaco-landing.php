<?php
use psyml\admin\Content as Content;
/**
 * The template for displaying psyML analysis results
 *
 */

get_header();

$Key=$_GET['result'];
$subdimensions = array();
foreach($_GET as $k => $v) {
    if($v !== $Key){

        $dimension_text = Content::SUBDIMENSION[$k][$v];
        $dimension = str_replace('_', ' ', $k);
        array_push($subdimensions, array($dimension=>$dimension_text));
    }
}

#get page(s)
$args = array(
    'post_type' => 'psyml',
    'post_status' => 'publish',
    'numberposts' => -1,
     'tax_query' => array(
        array(
            'taxonomy' => 'hexaco',
            'field' => 'slug',
            'terms' => strtolower($Key),
            'include_children' => true
        )
    )
);
// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
    echo '<div class="psyml-topwrap">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<header class="entry-header alignwide">';
        ?>
        <div class="psyml-header-image" style="background:url(<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id() ), 'full'); echo $image[0];?>);"></div>
        <?php
        echo '<h1 class="entry-title">'. get_the_title() .  '</h1></header>';
        echo '<div class="entry-content">';
        the_content();
        echo '</div>';
    }
    echo '</main>';
} else {
    // no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
?>
<h2>How Your Writing Scores</h2>
<?php
error_log(print_r($subdimensions,true));
foreach($subdimensions as $row){
    foreach($row as $k=>$v){
    echo '<h4>'.$k.'</h4>';
    echo '<div class="dimension_score">'.$v.'</div>';
    }
}

#get posts
#get page(s)
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'numberposts' => 4,
     'tax_query' => array(
        array(
            'taxonomy' => 'hexaco',
            'field' => 'slug',
            'terms' => strtolower($Key),
            'include_children' => true
        )
    )
);
// The Query
$the_query = new WP_Query( $args );
// The Loop
if ( $the_query->have_posts() ) {
    echo '<div id="related"><h4>Posts Recommended for Your Archetype:</h4>';
    while ( $the_query->have_posts() ) {
        echo '<div class="postwrap">';
        $the_query->the_post();
        ?>
        <img class="post-thumbnail" src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($the_query->ID), 'full'); echo $image[0];?>" />
        <?php
        echo '<div class="postright"><a href="'.get_permalink().'"><h5>'. get_the_title() .  '</h5></a>';
        echo '<div class="excerpt">';
        the_excerpt();
        echo '</div></div></div>';
    }
    echo '</div>';
} else {
    // no posts found
}
/* Restore original Post Data */
wp_reset_postdata();


get_footer();