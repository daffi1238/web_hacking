<?php

/*********************
LAUNCH voce
Let's get everything up and running.
*********************/

function voce_ahoy() {

  $GLOBALS['content_width'] = apply_filters( 'voce_content_width', 680 );

  //Allow editor style.
  add_editor_style( get_template_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'voce', get_template_directory() . '/translation' );

  // A better title
  add_theme_support( "title-tag" ); 

  // launching this stuff after theme setup
  voce_theme_support();

} /* end voce ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'voce_ahoy' );


/************* THEME CUSTOMIZE *********************/


  function voce_theme_customizer($wp_customize) {

    $wp_customize->add_setting( 'theme_color' , array(
      'default' => '#0e94ec',
      'sanitize_callback' => 'sanitize_hex_color',
      ));

    $wp_customize->add_control( new WP_Customize_Color_Control( 
      $wp_customize, 
      'theme_color_control', 
      array(
        'label'      => __( 'Theme Color', 'voce' ),
        'section'    => 'colors',
        'settings'   => 'theme_color',
        'priority'   => 1
        )
      ));

    $wp_customize->add_section( 'social' , array(
      'title'      => __('Social','voce'),
      'description'   => __( 'Instructions.<br /> Visit http://fontawesome.io/icons/ to see the full list of fa-icon names available for you to use.', 'voce' ),
      'priority'   => 999,
      ));

    $wp_customize->add_setting( 'voce_social_icon_1' , array('default'   => 'fa-facebook', 'sanitize_callback' => 'voce_santise_html',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_1_control',
     array('label'      => __( 'Social Icon 1', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_1','context'    => 'social_icon_1_context','priority'   => 99 )));
    $wp_customize->add_setting( 'voce_social_icon_1_link' , array('default'   => 'https://facebook.com/profile', 'sanitize_callback' => 'esc_url_raw',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_1_link_control',
     array('label'      => __( 'Social Icon 1 Link', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_1_link','context'    => 'social_icon_1_link_context','priority'   => 99 )
     ));

    $wp_customize->add_setting( 'voce_social_icon_2' , array('default'   => 'fa-twitter', 'sanitize_callback' => 'voce_santise_html',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_2_control',
     array('label'      => __( 'Social Icon 2', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_2','context'    => 'social_icon_2_context','priority'   => 99 )));
    $wp_customize->add_setting( 'voce_social_icon_2_link' , array('default'   => 'https://www.twitter.com/profile', 'sanitize_callback' => 'esc_url_raw',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_2_link_control',
     array('label'      => __( 'Social Icon 2 Link', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_2_link','context'    => 'social_icon_2_link_context','priority'   => 99 )
     ));

    $wp_customize->add_setting( 'voce_social_icon_3' , array('default'   => 'fa-snapchat', 'sanitize_callback' => 'voce_santise_html',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_3_control',
     array('label'      => __( 'Social Icon 3', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_3','context'    => 'social_icon_3_context','priority'   => 99 )));
    $wp_customize->add_setting( 'voce_social_icon_3_link' , array('default'   => 'https://snapchat.com', 'sanitize_callback' => 'esc_url_raw',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_3_link_control',
     array('label'      => __( 'Social Icon 3 Link', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_3_link','context'    => 'social_icon_3_link_context','priority'   => 99 )
     ));

    $wp_customize->add_setting( 'voce_social_icon_4' , array('default'   => '', 'sanitize_callback' => 'voce_santise_html',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_4_control',
     array('label'      => __( 'Social Icon 4', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_4','context'    => 'social_icon_4_context','priority'   => 99 )));
    $wp_customize->add_setting( 'voce_social_icon_4_link' , array('default'   => '', 'sanitize_callback' => 'esc_url_raw',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_4_link_control',
     array('label'      => __( 'Social Icon 4 Link', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_4_link','context'    => 'social_icon_4_link_context','priority'   => 99 )
     ));

    $wp_customize->add_setting( 'voce_social_icon_5' , array('default'   => '', 'sanitize_callback' => 'voce_santise_html',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_5_control',
     array('label'      => __( 'Social Icon 5', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_5','context'    => 'social_icon_5_context','priority'   => 99 )));
    $wp_customize->add_setting( 'voce_social_icon_5_link' , array('default'   => '', 'sanitize_callback' => 'esc_url_raw',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_5_link_control',
     array('label'      => __( 'Social Icon 5 Link', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_5_link','context'    => 'social_icon_5_link_context','priority'   => 99 )
     ));

    $wp_customize->add_setting( 'voce_social_icon_6' , array('default'   => '', 'sanitize_callback' => 'voce_santise_html',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_6_control',
     array('label'      => __( 'Social Icon 6', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_6','context'    => 'social_icon_6_context','priority'   => 99 )));
    $wp_customize->add_setting( 'voce_social_icon_6_link' , array('default'   => '', 'sanitize_callback' => 'esc_url_raw',));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'social_icon_6_link_control',
     array('label'      => __( 'Social Icon 6 Link', 'voce' ),'section'    => 'social','settings'   => 'voce_social_icon_6_link','context'    => 'social_icon_6_link_context','priority'   => 99 )
     ));

  }

  add_action( 'customize_register', 'voce_theme_customizer' );

  function voce_santise_html( $value ){
    $retval = sanitize_html_class ($value, "<empty>");
    return $retval;
  }


  function voce_customize_css()
  {
    wp_enqueue_style('voce-custom-style', get_template_directory_uri() . '/library/css/custom_script.css');
    $color = sanitize_hex_color(get_theme_mod('theme_color'));
    $custom_css = "
      time{ color: $color; }
      article.post .post-categories:after, .post-inner-content .cat-item:after { background: $color; }
      .current-cat a, .current-menu-item a{color: $color !important;}
      .navbar-default .navbar-nav > .active > a,
      .navbar-default .navbar-nav > .active > a:hover,
      .navbar-default .navbar-nav > .active > a:focus,
      .navbar-default .navbar-nav > li > a:hover,
      .navbar-default .navbar-nav > li > a:focus,
      .navbar-default .navbar-nav > .open > a,
      .navbar-default .navbar-nav > .open > a:hover,
      .navbar-default .navbar-nav > .open > a:focus {
        color: $color;
        background-color: transparent;
      }
      a:hover,
      a:focus {
        color: $color;
        text-decoration: none;
      }
      article.post .post-categories a:hover,
      .entry-title a:hover,
      .entry-meta a:hover,
      .entry-footer a:hover,
      .read-more a:hover,
      .flex-caption .post-categories a:hover,
      .flex-caption .read-more a:hover,
      .flex-caption h2:hover,
      .comment-meta.commentmetadata a:hover,
      .post-inner-content .cat-item a:hover  {
        color: $color;
      }";
      wp_add_inline_style( 'voce-custom-style', $custom_css );
    
  }

  add_action( 'wp_enqueue_scripts', 'voce_customize_css', 999 );

// loading modernizr and jquery, and reply script
function voce_scripts_and_styles() {

    // modernizr (without media query polyfill)
  wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr-custom.min.js', array( 'jquery' ), '3.5.0', false );
  //adding scripts file in the footer
  wp_enqueue_script( 'voce-js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );
  // comment reply script for threaded comments   
  if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {    
    wp_enqueue_script( 'comment-reply' );    
  }
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/library/js/bootstrap.min.js', array( 'jquery' ), '3.3.6', false );
  wp_enqueue_script( 'voce-functions', get_template_directory_uri() . '/library/js/functions.js', array( 'jquery' ), '1.0.0', false );

  // ie-only style sheet
  wp_enqueue_style( 'voce-ie-only', get_template_directory_uri() . '/library/css/ie.css', array(), '' );
  wp_style_add_data(  'voce-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/library/css/bootstrap.min.css');  

  wp_enqueue_style( 'voce-lora', '//fonts.googleapis.com/css?family=Lora:400italic,700italic,400,700', array());
  wp_enqueue_style( 'voce-mavenpro', '//fonts.googleapis.com/css?family=Maven+Pro:400,700', array());
  wp_enqueue_style( 'voce-montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700', array());

  wp_enqueue_style( 'voce-style', get_stylesheet_uri());
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/library/css/font-awesome.min.css');

}

// enqueue base scripts and styles
add_action( 'wp_enqueue_scripts', 'voce_scripts_and_styles', 998 );

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function voce_theme_support() {

  add_theme_support( 'custom-background',   
      array(  
      'default-color' => '',    // background color default (dont add the #)    
      'wp-head-callback' => '_custom_background_cb',    
      'admin-head-callback' => '',    
      'admin-preview-callback' => ''    
      )   
  );

  add_theme_support('automatic-feed-links');

  add_theme_support( 'custom-logo' );

  // registering wp3+ menus
  register_nav_menus(
    array(
      'main-nav' => __( 'The Main Menu', 'voce' ),   // main nav in header
      'footer-links' => __( 'Footer Links', 'voce' ) // secondary nav in footer
    )
  );

  // Enable support for HTML5 markup.
  add_theme_support( 'html5', array(
    'comment-list',
    'comment-form'
  ) );


} /* end voce theme support */


// This removes the annoying […] to a Read More link
function voce_excerpt_more($more) {
  global $post;
  // edit here if you like
  return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ', 'voce' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;', 'voce' ) .'</a>';
}

// cleaning up excerpt
add_filter( 'excerpt_more', 'voce_excerpt_more' );


/* DON'T DELETE THIS CLOSING TAG */ ?>
