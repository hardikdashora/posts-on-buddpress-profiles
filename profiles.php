<?php
 
// hacks and mods will go here for showing my post in profile

function bp_content_setup_nav() {
global $bp;

bp_core_new_nav_item( array(
    'name'                  => __('My Posts', 'buddypress'),
    'slug'                  => 'my-posts',
    'screen_function'       => 'my_posts_screen_link',
    'position'              => 40,//weight on menu, change it to whatever you want
    'default_subnav_slug'   => 'my-posts-subnav'
) );

    bp_core_new_subnav_item( array(
        'name'                  => __( '', 'buddypress' ),
        'slug'                  => 'my-posts',
        'parent_url'            => trailingslashit( bp_loggedin_user_domain() . 'main-tab' ),
        'parent_slug'           => 'my-posts',
        'screen_function'       => 'my_posts_screen_link',
        'position'              => 10//again, weight but for submenu
    ) );
do_action( 'bp_content_setup_nav' );
}
add_action( 'bp_setup_nav', 'bp_content_setup_nav' );



function my_posts_screen_link() {
    add_action( 'bp_template_title', 'my_posts_screen_title' );
    add_action( 'bp_template_content', 'my_posts_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function my_posts_screen_title() {
    echo '';
}


function my_posts_screen_content() {
    get_template_part( 'directory-to-content-file' );
    $theuser = bp_displayed_user_id(); 
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	query_posts( array('posts_per_page'=>5, 'author'=>$theuser, 'cb_offset_loop' => $cb_offset_loop, 'paged' => $paged));
    if ( have_posts() ) : while ( have_posts() ) : the_post();
?>

<article id="post-<?php the_ID(); ?>" class="cb-blog-style-a clearfix<?php if (is_sticky()) echo ' sticky'; if ( $cb_category_color_style != NULL ) { echo ' ' . $cb_category_color_style; } ?>" role="article">

  <div class="cb-mask" style="background-color:<?php echo $cb_category_color; ?>;">

    <?php
        cb_thumbnail('300', '200');
        echo cb_review_ext_box( $cb_post_id, $cb_category_color );
        echo $cb_post_format_icon;
    ?>

  </div>

  <div class="cb-meta">

      <h2 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php echo cb_byline(); ?>
      <div class="cb-excerpt"><?php echo cb_clean_excerpt( 210, false ); ?></div>

  </div>

  
</article>
	
	
<?php
    endwhile;
    wp_reset_query(); // resets main query
	else: ?>
	<h1>Sorry...</h1>
    <p><?php _e('You have not posted any article.'); ?></p>
       <h4>  <a style="color: grey" href="<?php echo home_url(); ?>//add-new/"><?php esc_html_e("Add an article now", 'cubell'); ?></a></h4>
	<?php endif; 
}
	
?>