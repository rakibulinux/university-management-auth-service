<?php

/////////////////////////////////////
// Theme Setup
/////////////////////////////////////

if ( ! function_exists( 'mvp_setup' ) ) {
function mvp_setup(){
	load_theme_textdomain('the-league', get_template_directory() . '/languages');

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );
}
	
	
	

	
	/* =====================
	
	Start Sports Site Code Area 
	
	======================== */

function create_play_post_type() {	
	register_post_type( 'play-list',
        array(
            'labels' => array(
                'name' => __( 'Play List'),
				'add_new_item' => __( 'Add New Play List' ),
				),
				'public' => true,
				'supports'           => array('thumbnail','title')

			)
	);
}
add_action( 'init', 'create_play_post_type' );	
	
	
	function play_themes_taxonomy() {
    register_taxonomy(
        'play_categories',
        'play-list',
        array(
            'hierarchical' => true,
            'label' => 'Play List Category',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'themes',  
                'with_front' => false 
            )
        )
    );
}
add_action( 'init', 'play_themes_taxonomy');
	
	
	
	/* Custom Meta box */
	
	function custom_meta_box_add(){
	  add_meta_box(
		'play_country_flag',
		'Type your Country Nmae',
		'custom_meta_box_er_output',
		'play-list'
	  );
		
	}
	add_action('add_meta_boxes', 'custom_meta_box_add');

	function custom_meta_box_er_output($post){ ?>
		<div class="form-group">
		
		<label class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Play Time:</label>
		<input type="time" name="play_date_time" value="<?php echo get_post_meta($post->ID, 'play_date_time', true); ?>" class="form-control" id="time">
		<br>
		<br>
		<label for="usr11" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Play Name:</label>
		<input type="text" name="play_name" value="<?php echo get_post_meta($post->ID, 'play_name', true); ?>" class="form-control" id="usr11" style="width:50%; float:left">
		<br>
		<br>
		<label for="usr10" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Play Name Link:</label>
		<input type="text" name="play_link" value="<?php echo get_post_meta($post->ID, 'play_link', true); ?>" class="form-control" id="usr10" style="width:50%; float:left">
		<br>
		<br>
		<label for="usr3" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">VS:</label>
		<input type="text" name="vs" value="<?php echo get_post_meta($post->ID, 'vs', true); ?>" class="form-control" id="usr3" style="width:50%; float:left">
		<br>
		<br>
		<label for="usr12" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Play Name Two:</label>
		<input type="text" name="play_name_2" value="<?php echo get_post_meta($post->ID, 'play_name_2', true); ?>" class="form-control" id="usr12" style="width:50%; float:left">
		<br>
		<br>
		<label for="usr14" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Play Link Two:</label>
		<input type="text" name="play_link2" value="<?php echo get_post_meta($post->ID, 'play_link2', true); ?>" class="form-control" id="usr14" style="width:50%; float:left">
		<br>
		<br>
		<label for="usr15" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Watch Button Link:</label>
		<input type="text" name="watch_link2" value="<?php echo get_post_meta($post->ID, 'watch_link2', true); ?>" class="form-control" id="usr15" style="width:50%; float:left">
		<br>
		<br>
		<label for="usr17" class="cus-from-stl" style="width:15%; float:left;margin-bottom:5px;padding-top: 5px;">Embade Text Show:</label>
			<textarea name="embed_text" value="<?php echo get_post_meta($post->ID, 'embed_text', true); ?>" class="form-control" id="usr16" style="width:84%;"></textarea>
		</div>
	<?php }
	function custom_meta_box_save($post_id){
		update_post_meta($post_id, 'play_date_time', $_POST['play_date_time']);
		update_post_meta($post_id, 'play_name', $_POST['play_name']);
		update_post_meta($post_id, 'play_link', $_POST['play_link']);
		update_post_meta($post_id, 'play_name_2', $_POST['play_name_2']);
		update_post_meta($post_id, 'play_link2', $_POST['play_link2']);
		update_post_meta($post_id, 'play_type_icon', $_POST['play_type_icon']);
		update_post_meta($post_id, 'watch_link2', $_POST['watch_link2']);
		update_post_meta($post_id, 'embed_text', $_POST['embed_text']);
		update_post_meta($post_id, 'vs', $_POST['vs']);
	}
	add_action('save_post', 'custom_meta_box_save');

// Custom Meta Box for images upload.

	function aw_custom_meta_boxes( $post_type, $post ) {
		add_meta_box( 
			'aw-meta-box',
			__( 'Live GIF Image' ),
			'render_aw_meta_box',
			'play-list'

		);
	}
	add_action( 'add_meta_boxes', 'aw_custom_meta_boxes', 10, 2 );
	 
	function render_aw_meta_box($post) {
		$image = get_post_meta($post->ID, 'aw_custom_image', true);
		?>
		<table>
			<tr>
				<td><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Live GIf Image'); ?></a></td>
				<td><input type="text" name="aw_custom_image" id="aw_custom_image" value="<?php echo $image; ?>" style="width:100%;" /></td>
			</tr>
		</table>
		<?php
	}
	
	function aw_save_postdata($post_id)
	{
		if (array_key_exists('aw_custom_image', $_POST)) {
			update_post_meta(
				$post_id,
				'aw_custom_image',
				$_POST['aw_custom_image']
			);
		}
	}
	add_action('save_post', 'aw_save_postdata');

	function aw_include_script() {
	 
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
	  
		wp_enqueue_script( 'clickmag', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), null, false );
	}
	add_action( 'admin_enqueue_scripts', 'aw_include_script' );	

	/* ==============
	 Short Code Register
	 =============== */
	function all_play_list() { 
	$post_date = current_time( 'mysql' ); 
	$datetime = date('j F Y',strtotime($post_date));
    $posts_per_page = 40;
	$args = array(
	  'post_type'   => 'play-list',
	  'post_status' => 'publish',
	  'showposts'=> $posts_per_page,
	  'meta_key'=>'play_date_time',
	  'orderby'=>'play_date_time',
	  'order'=>'asc',
	  'tax_query' => array(
			array(
			'taxonomy' => 'play_categories',   // taxonomy name
			'field' => 'slug',
			'terms' => 'today'
			)
			)
	 );
	$play_list = new WP_Query( $args );
	if( $play_list->have_posts() ) :

	$play_list_output .='<div>
						<form class="examples">
						<input type="text" class="search-stle" id="myInput" onkeyup="myFunction()" placeholder="Search stream for your fav games.."> 
						<button type="submit"><i class="fa fa-search"></i></button>
						</form>
						<br>
					<div class="section_head">
						<h2 class="titile_icon">
TODAY

 </h2>
					</div>
						  <table id="myTable" class="table table-hover" style="width:100%">
					
								  ';
	while( $play_list->have_posts() ) :
		   $play_list->the_post();

	$country_names = get_post_meta(get_the_ID(), 'contry_name', true);
	$featured_image = get_the_post_thumbnail();
	$play_names = get_post_meta(get_the_ID(), 'play_name', true);
	$play_link = get_post_meta(get_the_ID(), 'play_link', true);
	$vs = get_post_meta(get_the_ID(), 'vs', true);
	$play_names_2 = get_post_meta(get_the_ID(), 'play_name_2', true);
	$play_link2 = get_post_meta(get_the_ID(), 'play_link2', true);
	$aw_custom_image = get_post_meta(get_the_ID(), 'aw_custom_image', true);
	$watch_link2 = get_post_meta(get_the_ID(), 'watch_link2', true);
	$embed_text = get_post_meta(get_the_ID(), 'embed_text', true);
	$embed_link = get_post_meta(get_the_ID(), 'embed_link', true);
	
	$play_date_time = get_post_meta(get_the_ID(), 'play_date_time', true);
	$time = date('H:i',strtotime($play_date_time));
	
	$play_list_output .='<tr>
						<td style="width:8%"><div class="play_icon_style">'.$featured_image.'</div></td>
						<td style="width:8%">'.$time.'</td>
						
						<td style="width:16%"><a href="'.$play_link.'" target="_blank">'.$play_names.'</a></td>
						<td style="width:10%">'.$vs.'</td>
						<td style="width:16%"><a href="'.$play_link2.'" target="_blank">'.$play_names_2.'</a></td>
						<td style="width:6%"><img src="'.$aw_custom_image.'" style="width:20px; margin:0 auto;"></td>
						<td style="width:10%"><a href="'.$watch_link2.'"  target="_blank"" class="watch_button">Watch</a></td>
						<td style="width:10%"><span class="embaded">Embed</span></td>
					  </tr>
					<tr class="embed-source myHide">
						<td colspan="10"><textarea class="embaded_text">'.$embed_text.'</textarea></td>
					</tr>
					  ';			  
	endwhile;
	wp_reset_postdata();

	$play_list_output .='</table>
						 </div>';

	else :
	
	endif;
	return $play_list_output;

	} 
	add_shortcode('play_lists', 'all_play_list');


	
	
	
	/* ==============
	 Short Code Register   Upcoming Section
	 =============== */
	function all_play_list2() { 
	$post_date = current_time( 'mysql' ); 
	$datetime = date('j F Y',strtotime($post_date));
    $posts_per_page = 40;
	$args = array(
	  'post_type'   => 'play-list',
	  'post_status' => 'publish',
	  'showposts'=> $posts_per_page,
	  'meta_key'=>'play_date_time',
	  'orderby'=>'play_date_time',
	  'order'=>'asc',
	  'tax_query' => array(
			array(
			'taxonomy' => 'play_categories',   // taxonomy name
			'field' => 'slug',
			'terms' => 'upcoming'
			)
			)
	 );
	$play_list = new WP_Query( $args );
	if( $play_list->have_posts() ) :

	$play_list_output .='<div>
						
						<br>
					<div class="section_head">
						<h2 class="titile_icon">
UPCOMING

 </h2>
					</div>
						  <table id="myTable" class="table table-hover" style="width:100%">
					
								  ';
	while( $play_list->have_posts() ) :
		   $play_list->the_post();

	$country_names = get_post_meta(get_the_ID(), 'contry_name', true);
	$featured_image = get_the_post_thumbnail();
	$play_names = get_post_meta(get_the_ID(), 'play_name', true);
	$play_link = get_post_meta(get_the_ID(), 'play_link', true);
	$vs = get_post_meta(get_the_ID(), 'vs', true);
	$play_names_2 = get_post_meta(get_the_ID(), 'play_name_2', true);
	$play_link2 = get_post_meta(get_the_ID(), 'play_link2', true);
	$aw_custom_image = get_post_meta(get_the_ID(), 'aw_custom_image', true);
	$watch_link2 = get_post_meta(get_the_ID(), 'watch_link2', true);
	$embed_text = get_post_meta(get_the_ID(), 'embed_text', true);
	$embed_link = get_post_meta(get_the_ID(), 'embed_link', true);
	
	$play_date_time = get_post_meta(get_the_ID(), 'play_date_time', true);
	$time = date('H:i',strtotime($play_date_time));
	
	$play_list_output .='<tr>
						<td style="width:8%"><div class="play_icon_style">'.$featured_image.'</div></td>
						<td style="width:8%">'.$time.'</td>
						
						<td style="width:16%"><a href="'.$play_link.'" target="_blank">'.$play_names.'</a></td>
						<td style="width:10%">'.$vs.'</td>
						<td style="width:16%"><a href="'.$play_link2.'" target="_blank">'.$play_names_2.'</a></td>
						<td style="width:6%"><img src="'.$aw_custom_image.'" style="width:20px; margin:0 auto;"></td>
						<td style="width:10%"><a href="'.$watch_link2.'"  target="_blank"" class="watch_button">Watch</a></td>
						<td style="width:10%"><span class="embaded">Embed</span></td>
					  </tr>
					<tr class="embed-source myHide">
						<td colspan="10"><textarea class="embaded_text">'.$embed_text.'</textarea></td>
					</tr>
					  ';			  
	endwhile;
	wp_reset_postdata();

	$play_list_output .='</table>
						 </div>';

	else :
	
	endif;
	return $play_list_output;

	} 
	add_shortcode('play_lists2', 'all_play_list2');
}
add_action('after_setup_theme', 'mvp_setup');

/////////////////////////////////////
// Theme Options
/////////////////////////////////////

require_once get_template_directory() . '/admin/admin-functions.php';
require_once get_template_directory() . '/admin/admin-interface.php';
require_once get_template_directory() . '/admin/theme-settings.php';

if ( !function_exists( 'mvp_fonts_url' ) ) {
function mvp_fonts_url() {

$mvp_featured_font = get_option('mvp_featured_font');
$mvp_title_font = get_option('mvp_title_font');
$mvp_heading_font = get_option('mvp_heading_font');
$mvp_content_font = get_option('mvp_content_font');
$mvp_menu_font = get_option('mvp_menu_font');
$font_url = '';

    if ( 'off' !== _x( 'on', 'Google font: on or off', 'the-league' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Advent Pro:700|Roboto:300,400,500,700,900|Oswald:300,400,700|Lato:300,400,700|Work Sans:200,300,400,500,600,700,800,900|Open Sans:400,700,800|' .  $mvp_featured_font . ':100,200,300,400,500,600,700,800,900|' .  $mvp_title_font . ':100,200,300,400,500,600,700,800,900|' .  $mvp_heading_font . ':100,200,300,400,500,600,700,800,900|' .  $mvp_content_font . ':100,200,300,400,500,600,700,800,900|' .  $mvp_menu_font . ':100,200,300,400,500,600,700,800,900' ), "//fonts.googleapis.com/css" );
    }
    return $font_url . "&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese";
}
}

if ( !function_exists( 'mvp_styles_method' ) ) {
function mvp_styles_method() {
    wp_enqueue_style(
        'mvp-custom-style',
        get_stylesheet_uri()
    );
	$wallad = get_option('mvp_wall_ad');
	$primarytheme = get_option('mvp_primary_theme');
	$topnavbg = get_option('mvp_top_nav_bg');
	$topnavtext = get_option('mvp_top_nav_text');
	$topnavhover = get_option('mvp_top_nav_hover');
	$link = get_option('mvp_link_color');
	$linkhover = get_option('mvp_link_hover');
	$featured_font = get_option('mvp_featured_font');
	$title_font = get_option('mvp_title_font');
	$heading_font = get_option('mvp_heading_font');
	$content_font = get_option('mvp_content_font');
	$menu_font = get_option('mvp_menu_font');
	$mvp_customcss = get_option('mvp_customcss');
        $mvp_theme_options = "

#mvp-wallpaper {
	background: url($wallad) no-repeat 50% 0;
	}

a,
a:visited,
.post-info-name a,
ul.mvp-author-info-list li.mvp-author-info-name span a,
.woocommerce .woocommerce-breadcrumb a {
	color: $link;
	}

#mvp-comments-button a,
#mvp-comments-button span.mvp-comment-but-text,
a.mvp-inf-more-but,
.sp-template a,
.sp-data-table a {
	color: $link !important;
	}

#mvp-comments-button a:hover,
#mvp-comments-button span.mvp-comment-but-text:hover,
a.mvp-inf-more-but:hover {
	border: 1px solid $link;
	color: $link !important;
	}

a:hover,
.mvp-feat4-sub-text h2 a:hover,
span.mvp-widget-head-link a,
.mvp-widget-list-text1 h2 a:hover,
.mvp-blog-story-text h2 a:hover,
.mvp-side-tab-text h2 a:hover,
.mvp-more-post-text h2 a:hover,
span.mvp-blog-story-author a,
.woocommerce .woocommerce-breadcrumb a:hover,
#mvp-side-wrap a:hover,
.mvp-post-info-top h3 a:hover,
#mvp-side-wrap .mvp-widget-feat-text h3 a:hover,
.mvp-widget-author-text h3 a:hover,
#mvp-side-wrap .mvp-widget-author-text h3 a:hover,
.mvp-feat5-text h2 a:hover {
	color: $linkhover !important;
	}

#mvp-main-nav-wrap,
#mvp-fly-wrap,
ul.mvp-fly-soc-list li a:hover {
	background: $topnavbg;
	}

ul.mvp-fly-soc-list li a {
	color: $topnavbg !important;
	}

#mvp-nav-menu ul li a,
span.mvp-nav-soc-head,
span.mvp-nav-search-but,
span.mvp-nav-soc-but,
nav.mvp-fly-nav-menu ul li.menu-item-has-children:after,
nav.mvp-fly-nav-menu ul li.menu-item-has-children.tog-minus:after,
nav.mvp-fly-nav-menu ul li a,
span.mvp-fly-soc-head {
	color: $topnavtext;
	}

ul.mvp-fly-soc-list li a:hover {
	color: $topnavtext !important;
	}

.mvp-fly-but-wrap span,
ul.mvp-fly-soc-list li a {
	background: $topnavtext;
	}

ul.mvp-fly-soc-list li a:hover {
	border: 2px solid $topnavtext;
	}

#mvp-nav-menu ul li.menu-item-has-children ul.sub-menu li a:after,
#mvp-nav-menu ul li.menu-item-has-children ul.sub-menu li ul.sub-menu li a:after,
#mvp-nav-menu ul li.menu-item-has-children ul.sub-menu li ul.sub-menu li ul.sub-menu li a:after,
#mvp-nav-menu ul li.menu-item-has-children ul.mvp-mega-list li a:after,
#mvp-nav-menu ul li.menu-item-has-children a:after {
	border-color: $topnavtext transparent transparent transparent;
	}

#mvp-nav-menu ul li:hover a,
span.mvp-nav-search-but:hover,
span.mvp-nav-soc-but:hover,
#mvp-nav-menu ul li ul.mvp-mega-list li a:hover,
nav.mvp-fly-nav-menu ul li a:hover {
	color: $topnavhover !important;
	}

#mvp-nav-menu ul li:hover a {
	border-bottom: 1px solid $topnavhover;
	}

.mvp-fly-but-wrap:hover span {
	background: $topnavhover;
	}

#mvp-nav-menu ul li.menu-item-has-children:hover a:after {
	border-color: $topnavhover transparent transparent transparent !important;
	}

ul.mvp-score-list li:hover {
	border: 1px solid $primarytheme;
	}

.es-nav span:hover a,
ul.mvp-side-tab-list li span.mvp-side-tab-head i {
	color: $primarytheme;
	}

span.mvp-feat1-cat,
.mvp-vid-box-wrap,
span.mvp-post-cat,
.mvp-prev-next-text a,
.mvp-prev-next-text a:visited,
.mvp-prev-next-text a:hover,
.mvp-mob-soc-share-but,
.mvp-scores-status,
.sportspress h1.mvp-post-title .sp-player-number {
	background: $primarytheme;
	}

.sp-table-caption {
	background: $primarytheme !important;
	}

.woocommerce .star-rating span:before,
.woocommerce-message:before,
.woocommerce-info:before,
.woocommerce-message:before {
	color: $primarytheme;
	}

.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce span.onsale,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce #respond input#submit.alt:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover {
	background-color: $primarytheme;
	}

span.mvp-sec-head,
.mvp-authors-name {
	border-bottom: 1px solid $primarytheme;
	}

.woocommerce-error,
.woocommerce-info,
.woocommerce-message {
	border-top-color: $primarytheme;
	}

#mvp-nav-menu ul li a,
nav.mvp-fly-nav-menu ul li a,
#mvp-foot-nav ul.menu li a,
#mvp-foot-menu ul.menu li a {
	font-family: '$menu_font', sans-serif;
	}

body,
.mvp-feat1-text p,
.mvp-feat4-main-text p,
.mvp-feat2-main-text p,
.mvp-feat3-main-text p,
.mvp-feat4-sub-text p,
.mvp-widget-list-text1 p,
.mvp-blog-story-text p,
.mvp-blog-story-info,
span.mvp-post-excerpt,
ul.mvp-author-info-list li.mvp-author-info-name p,
ul.mvp-author-info-list li.mvp-author-info-name span,
.mvp-post-date,
span.mvp-feat-caption,
span.mvp-feat-caption-wide,
#mvp-content-main p,
#mvp-author-box-text p,
.mvp-more-post-text p,
#mvp-404 p,
#mvp-foot-copy,
#searchform input,
span.mvp-author-page-desc,
#woo-content p,
.mvp-search-text p,
#comments .c p,
.mvp-widget-feat-text p,
.mvp-feat5-text p {
	font-family: '$content_font', sans-serif;
	}

span.mvp-nav-soc-head,
.mvp-score-status p,
.mvp-score-teams p,
.mvp-scores-status p,
.mvp-scores-teams p,
ul.mvp-feat2-list li h3,
.mvp-feat4-sub-text h3,
.mvp-widget-head-wrap h4,
span.mvp-widget-head-link,
.mvp-widget-list-text1 h3,
.mvp-blog-story-text h3,
ul.mvp-side-tab-list li span.mvp-side-tab-head,
.mvp-side-tab-text h3,
span.mvp-post-cat,
.mvp-post-tags,
span.mvp-author-box-name,
#mvp-comments-button a,
#mvp-comments-button span.mvp-comment-but-text,
span.mvp-sec-head,
a.mvp-inf-more-but,
.pagination span, .pagination a,
.woocommerce ul.product_list_widget span.product-title,
.woocommerce ul.product_list_widget li a,
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta,
.woocommerce .related h2,
.woocommerce div.product .woocommerce-tabs .panel h2,
.woocommerce div.product .product_title,
#mvp-content-main h1,
#mvp-content-main h2,
#mvp-content-main h3,
#mvp-content-main h4,
#mvp-content-main h5,
#mvp-content-main h6,
#woo-content h1.page-title,
.woocommerce .woocommerce-breadcrumb,
.mvp-authors-name,
#respond #submit,
.comment-reply a,
#cancel-comment-reply-link,
span.mvp-feat1-cat,
span.mvp-post-info-date,
.mvp-widget-feat-text h3,
.mvp-widget-author-text h3 a,
.sp-table-caption {
	font-family: '$heading_font', sans-serif !important;
	}

.mvp-feat1-text h2,
.mvp-feat1-text h2.mvp-stand-title,
.mvp-feat4-main-text h2,
.mvp-feat4-main-text h2.mvp-stand-title,
.mvp-feat1-sub-text h2,
.mvp-feat2-main-text h2,
.mvp-feat2-sub-text h2,
ul.mvp-feat2-list li h2,
.mvp-feat3-main-text h2,
.mvp-feat3-sub-text h2,
.mvp-feat4-sub-text h2 a,
.mvp-widget-list-text1 h2 a,
.mvp-blog-story-text h2 a,
.mvp-side-tab-text h2 a,
#mvp-content-main blockquote p,
.mvp-more-post-text h2 a,
h2.mvp-authors-latest a,
.mvp-widget-feat-text h2 a,
.mvp-widget-author-text h2 a,
.mvp-feat5-text h2 a,
.mvp-scores-title h2 a {
	font-family: '$featured_font', sans-serif;
	}

h1.mvp-post-title,
.mvp-cat-head h1,
#mvp-404 h1,
h1.mvp-author-top-head,
#woo-content h1.page-title,
.woocommerce div.product .product_title,
.woocommerce ul.products li.product h3 {
	font-family: '$title_font', sans-serif;
	}

	";

	$mvp_infinite_scroll = get_option('mvp_infinite_scroll');
	if ($mvp_infinite_scroll == "true") {
	if (isset($mvp_infinite_scroll)) {
	$mvp_infinite_scroll_css = "
	.mvp-nav-links {
		display: none;
		}
		";
	}
	}

	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") {
	global $post; if (!empty( $post )) {
	$mvp_post_layout = get_option('mvp_post_layout');
	$mvp_post_temp = get_post_meta($post->ID, "mvp_post_template", true);
	if( ( ! $mvp_post_temp && $mvp_post_layout == 'Template 2' ) || ( ! $mvp_post_temp && $mvp_post_layout == 'Template 6' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 2' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 6' ) || $mvp_post_temp == "temp2" || $mvp_post_temp == "temp6" ) {
	$mvp_post_side_css = "
	.mvp-post-content-out {
		margin-left: -72px !important;
		}
	.mvp-post-content-in {
		margin-left: 72px !important;
		}
	#mvp-post-content {
		text-align: center;
		}
	.mvp-content-box {
		margin: 0 auto;
		max-width: 872px;
		position: relative;
		text-align: right;
		}
		";
	}
	}
	} else {
	global $post; if (!empty( $post )) {
	$mvp_post_layout = get_option('mvp_post_layout');
	$mvp_post_temp = get_post_meta($post->ID, "mvp_post_template", true);
	if( ( ! $mvp_post_temp && $mvp_post_layout == 'Template 2' ) || ( ! $mvp_post_temp && $mvp_post_layout == 'Template 6' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 2' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 6' ) || $mvp_post_temp == "temp2" || $mvp_post_temp == "temp6" ) {
	$mvp_post_side_css = "
	.mvp-post-content-out {
		margin-right: -72px !important;
		}
	.mvp-post-content-in {
		margin-right: 72px !important;
		}
	#mvp-post-content {
		text-align: center;
		}
	.mvp-content-box {
		margin: 0 auto;
		max-width: 872px;
		position: relative;
		text-align: left;
		}
		";
	}
	}
	}

	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") {
	global $post; if (!empty( $post )) {
	$mvp_post_layout = get_option('mvp_post_layout');
	$mvp_post_temp = get_post_meta($post->ID, "mvp_post_template", true);
	if( ( ! $mvp_post_temp && $mvp_post_layout == 'Template 4' ) || ( ! $mvp_post_temp && $mvp_post_layout == 'Template 8' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 4' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 8' ) || $mvp_post_temp == "temp4" || $mvp_post_temp == "temp8" ) {
	$mvp_post_side2_css = "
	.mvp-post-content-out,
	.mvp-post-content-in {
		margin-left: 0 !important;
		}
	#mvp-post-content {
		text-align: center;
		}
	.mvp-content-box {
		margin: 0 auto;
		max-width: 800px;
		position: relative;
		text-align: right;
		}
		";
	}
	}
	} else {
	global $post; if (!empty( $post )) {
	$mvp_post_layout = get_option('mvp_post_layout');
	$mvp_post_temp = get_post_meta($post->ID, "mvp_post_template", true);
	if( ( ! $mvp_post_temp && $mvp_post_layout == 'Template 4' ) || ( ! $mvp_post_temp && $mvp_post_layout == 'Template 8' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 4' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 8' ) || $mvp_post_temp == "temp4" || $mvp_post_temp == "temp8" ) {
	$mvp_post_side2_css = "
	.mvp-post-content-out,
	.mvp-post-content-in {
		margin-right: 0 !important;
		}
	#mvp-post-content {
		text-align: center;
		}
	.mvp-content-box {
		margin: 0 auto;
		max-width: 800px;
		position: relative;
		text-align: left;
		}
		";
	}
	}
	}

	global $post; if (!empty( $post )) {
	$mvp_post_layout = get_option('mvp_post_layout');
	$mvp_post_temp = get_post_meta($post->ID, "mvp_post_template", true);
	if( ( ! $mvp_post_temp && $mvp_post_layout == 'Template 5' ) || ( ! $mvp_post_temp && $mvp_post_layout == 'Template 6' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 5' ) || ( $mvp_post_temp == "global" && $mvp_post_layout == 'Template 6' ) || $mvp_post_temp == "temp5" || $mvp_post_temp == "temp6" ) {
	$mvp_video_wide_css = "
	#mvp-video-embed {
		margin-bottom: 0;
		}
		";
	}
	}

	$mvp_show_scoreboard = get_option('mvp_show_scoreboard');
	if ($mvp_show_scoreboard == "true" && ! is_404()) {
	$mvp_scoreboard_css = "
 	#mvp-wallpaper {
		top: 166px;
		}
	#mvp-main-wrap {
		margin-top: 166px;
		}
	.mvp-score-up {
		position: fixed !important;
		-webkit-transform: translate3d(0,-72px,0) !important;
	 	   -moz-transform: translate3d(0,-72px,0) !important;
	   	    -ms-transform: translate3d(0,-72px,0) !important;
	   	     -o-transform: translate3d(0,-72px,0) !important;
			transform: translate3d(0,-72px,0) !important;
		z-index: 9999;
		}
	.mvp-wall-up {
		-webkit-transform: translate3d(0,-72px,0) !important;
	 	   -moz-transform: translate3d(0,-72px,0) !important;
	   	    -ms-transform: translate3d(0,-72px,0) !important;
	   	     -o-transform: translate3d(0,-72px,0) !important;
			transform: translate3d(0,-72px,0) !important;
		}
	@media screen and (max-width: 1003px) and (min-width: 600px) {
		#mvp-main-wrap {
			margin-top: 122px !important;
			}
		}
		";
	}

	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") {
	$socialbox = get_option('mvp_social_box');
	if ($socialbox !== "true") {
	$mvp_post_soc_css = "
	.mvp-post-soc-out,
	.mvp-post-soc-in {
		margin-right: 0;
		}
		";
	}
	} else {
	$socialbox = get_option('mvp_social_box');
	if ($socialbox !== "true") {
	$mvp_post_soc_css = "
	.mvp-post-soc-out,
	.mvp-post-soc-in {
		margin-left: 0;
		}
		";
	}
	}

	if( is_single() ); {
	$mvp_show_trend = get_option('mvp_show_trend');
	if ($mvp_show_trend == "true") {
	$mvp_show_trend_css = "
	.single #mvp-foot-wrap {
		padding-bottom: 70px;
		}
		";
	}
	}

	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") {
	if ( post_type_exists( 'scoreboard' ) ) {
	$mvp_score_skin = get_option('mvp_score_skin');
	if ($mvp_score_skin == "Light") {
	$mvp_score_skin_css = "
	#mvp-score-wrap {
		background: #eee;
		}
	ul.mvp-score-list li {
		background: #fff;
		border: 1px solid #ddd;
		}
	.mvp-score-teams p,
	.es-nav span a {
		color: #555;
		}
	.mvp-score-nav-menu select {
		background: #fff;
		color: #555;
		}
	.es-nav span.es-nav-prev,
	.es-nav span.es-nav-next {
		background: #eee;
		}
	.es-nav span.es-nav-prev:after {
		background-image: -moz-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -ms-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -o-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -webkit-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		left: -10px;
		}

	.es-nav span.es-nav-next:after {
		background-image: -moz-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -ms-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -o-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -webkit-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		right: -10px;
		}
		";
	}
	}
	} else {
	if ( post_type_exists( 'scoreboard' ) ) {
	$mvp_score_skin = get_option('mvp_score_skin');
	if ($mvp_score_skin == "Light") {
	$mvp_score_skin_css = "
	#mvp-score-wrap {
		background: #eee;
		}
	ul.mvp-score-list li {
		background: #fff;
		border: 1px solid #ddd;
		}
	.mvp-score-teams p,
	.es-nav span a {
		color: #555;
		}
	.mvp-score-nav-menu select {
		background: #fff;
		color: #555;
		}
	.es-nav span.es-nav-prev,
	.es-nav span.es-nav-next {
		background: #eee;
		}
	.es-nav span.es-nav-prev:after {
		background-image: -moz-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -ms-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -o-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -webkit-linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: linear-gradient(to left,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		right: -10px;
		}

	.es-nav span.es-nav-next:after {
		background-image: -moz-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -ms-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -o-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: -webkit-linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		background-image: linear-gradient(to right,rgba(0,0,0,0) 0, rgba(0,0,0,0.06) 50%, rgba(0,0,0,.12) 100%);
		left: -10px;
		}
		";
	}
	}
	}

	if ($mvp_customcss) {
	$mvp_customcss_css = "
 	$mvp_customcss
		";
	}

        wp_add_inline_style( 'mvp-custom-style', $mvp_theme_options );
	if (isset($mvp_infinite_scroll_css)) { wp_add_inline_style( 'mvp-custom-style', $mvp_infinite_scroll_css ); }
	if (isset($mvp_post_side_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_post_side_css )); }
	if (isset($mvp_post_side2_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_post_side2_css )); }
	if (isset($mvp_video_wide_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_video_wide_css )); }
	if (isset($mvp_scoreboard_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_scoreboard_css )); }
	if (isset($mvp_post_soc_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_post_soc_css )); }
	if (isset($mvp_show_trend_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_show_trend_css )); }
	if (isset($mvp_score_skin_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_score_skin_css )); }
	if (isset($mvp_customcss_css)) { wp_kses_post(wp_add_inline_style( 'mvp-custom-style', $mvp_customcss_css )); }
}
}
add_action( 'wp_enqueue_scripts', 'mvp_styles_method' );

/////////////////////////////////////
// Enqueue Javascript/CSS Files
/////////////////////////////////////

if ( ! function_exists( 'mvp_scripts_method' ) ) {
function mvp_scripts_method() {
	global $wp_styles;
	wp_enqueue_style( 'mvp-reset', get_template_directory_uri() . '/css/reset.css' );
	wp_enqueue_style( 'fontawesome', get_stylesheet_directory_uri() . '/font-awesome/css/font-awesome.css' );
	wp_enqueue_style( 'mvp-iecss', get_stylesheet_directory_uri() . '/css/iecss.css', array( 'mvp-style' )  );
	wp_enqueue_style( 'mvp-fonts', mvp_fonts_url(), array(), null );
	$wp_styles->add_data( 'mvp-iecss', 'conditional', 'lt IE 10' );
	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") { if (isset($mvp_rtl)) {
	wp_enqueue_style( 'mvp-rtl', get_template_directory_uri() . '/css/rtl.css' );
	} }
	$mvp_respond = get_option('mvp_respond'); if ($mvp_respond == "true") { if (isset($mvp_respond)) {
	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") { if (isset($mvp_rtl)) {
	wp_enqueue_style( 'mvp-media-queries', get_template_directory_uri() . '/css/media-queries-rtl.css' );
	} } else {
	wp_enqueue_style( 'mvp-media-queries', get_template_directory_uri() . '/css/media-queries.css' );
	} } }
	wp_register_script('mvp-custom', get_template_directory_uri() . '/js/mvpcustom.js', array('jquery'), '', true);
	wp_register_script('clickmag', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '', true);
	wp_register_script('retina', get_template_directory_uri() . '/js/retina.js', array('jquery'), '', true);
	wp_register_script('elastislide', get_template_directory_uri() . '/js/jquery.elastislide.js', array('jquery'), '', true);
	wp_register_script('elastislide-rtl', get_template_directory_uri() . '/js/jquery.elastislide-rtl.js', array('jquery'), '', true);
	wp_register_script('flexslider', get_template_directory_uri() . '/js/flexslider.js', array('jquery'), '', true);
	wp_register_script('infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'), '', true);

	wp_enqueue_script('mvp-custom');
	wp_enqueue_script('clickmag');
	wp_enqueue_script('retina');
	if ( post_type_exists( 'scoreboard' ) ) {
	$mvp_rtl = get_option('mvp_rtl'); if ($mvp_rtl == "true") { if (isset($mvp_rtl)) {
	wp_enqueue_script('elastislide-rtl');
	} } else {
	wp_enqueue_script('elastislide');
	}
	}
	if ( is_single() ) wp_enqueue_script( 'flexslider' );
	$mvp_infinite_scroll = get_option('mvp_infinite_scroll'); if ($mvp_infinite_scroll == "true") { if (isset($mvp_infinite_scroll)) {
	wp_enqueue_script('infinitescroll');
	} }

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	if ( is_single() ) {
	wp_add_inline_script( 'mvp-custom', '
	jQuery(document).ready(function($) {
	$(window).load(function(){
	var aboveHeight = $("#mvp-top-head-wrap").outerHeight();
	$(window).scroll(function(event){
	    	if ($(window).scrollTop() > aboveHeight){
	    		$("#mvp-top-head-wrap").addClass("mvp-score-up");
			$("#mvp-wallpaper").addClass("mvp-wall-up");
			$("#mvp-post-trend-wrap").addClass("mvp-post-trend-down");
			$(".mvp-fly-top").addClass("mvp-to-top");
	    	} else {
	    		$("#mvp-top-head-wrap").removeClass("mvp-score-up");
			$("#mvp-wallpaper").removeClass("mvp-wall-up");
			$("#mvp-post-trend-wrap").removeClass("mvp-post-trend-down");
	    		$(".mvp-fly-top").removeClass("mvp-to-top");
	    	}
	});
	});
	});
	' );
	} else {
	wp_add_inline_script( 'mvp-custom', '
	jQuery(document).ready(function($) {
	$(window).load(function(){
	var aboveHeight = $("#mvp-top-head-wrap").outerHeight();
	$(window).scroll(function(event){
	    	if ($(window).scrollTop() > aboveHeight){
	    		$("#mvp-top-head-wrap").addClass("mvp-score-up");
			$("#mvp-wallpaper").addClass("mvp-wall-up");
			$(".mvp-fly-top").addClass("mvp-to-top");
	    	} else {
	    		$("#mvp-top-head-wrap").removeClass("mvp-score-up");
			$("#mvp-wallpaper").removeClass("mvp-wall-up");
	    		$(".mvp-fly-top").removeClass("mvp-to-top");
	    	}
	});
	});
	});
	' );
	}

	wp_add_inline_script( 'mvp-custom', '
	jQuery(document).ready(function($) {
	// Main Menu Dropdown Toggle
	$(".mvp-fly-nav-menu .menu-item-has-children a").click(function(event){
	  event.stopPropagation();
	  location.href = this.href;
  	});

	$(".mvp-fly-nav-menu .menu-item-has-children").click(function(){
    	  $(this).addClass("toggled");
    	  if($(".menu-item-has-children").hasClass("toggled"))
    	  {
    	  $(this).children("ul").toggle();
	  $(".mvp-fly-nav-menu").getNiceScroll().resize();
	  }
	  $(this).toggleClass("tog-minus");
    	  return false;
  	});

	// Main Menu Scroll
	$(window).load(function(){
	  $(".mvp-fly-nav-menu").niceScroll({cursorcolor:"#888",cursorwidth: 7,cursorborder: 0,zindex:999999});
	});
	});
	' );

	$mvp_infinite_scroll = get_option('mvp_infinite_scroll');
	if ($mvp_infinite_scroll == "true") { if (isset($mvp_infinite_scroll)) {
	wp_add_inline_script( 'mvp-custom', '
	jQuery(document).ready(function($) {
	$(".infinite-content").infinitescroll({
	  navSelector: ".mvp-nav-links",
	  nextSelector: ".mvp-nav-links a:first",
	  itemSelector: ".infinite-post",
	  errorCallback: function(){ $(".mvp-inf-more-but").css("display", "none") }
	});
	$(window).unbind(".infscr");
	$(".mvp-inf-more-but").click(function(){
   		$(".infinite-content").infinitescroll("retrieve");
        	return false;
	});
	$(window).load(function(){
		if ($(".mvp-nav-links a").length) {
			$(".mvp-inf-more-but").css("display","inline-block");
		} else {
			$(".mvp-inf-more-but").css("display","none");
		}
	});
	});
	' );
	}
	}

	if ( is_single() ) {
	global $post; $mvp_show_gallery = get_post_meta($post->ID, "mvp_post_gallery", true);
	if ($mvp_show_gallery == "show") {
	wp_add_inline_script( 'mvp-custom', '
	jQuery(document).ready(function($) {
	$(window).load(function() {
	  $(".mvp-post-gallery-bot").flexslider({
	    animation: "slide",
	    controlNav: false,
	    animationLoop: true,
	    slideshow: false,
	    itemWidth: 80,
	    itemMargin: 10,
	    asNavFor: ".mvp-post-gallery-top"
	  });

	  $(".mvp-post-gallery-top").flexslider({
	    animation: "fade",
	    controlNav: false,
	    animationLoop: true,
	    slideshow: false,
	    	  prevText: "&lt;",
	          nextText: "&gt;",
	    sync: ".mvp-post-gallery-bot"
	  });
	});
	});
	' );
	}
	}

}
}
add_action('wp_enqueue_scripts', 'mvp_scripts_method');

/////////////////////////////////////
// Register Widgets
/////////////////////////////////////

if ( !function_exists( 'mvp_sidebars_init' ) ) {
	function mvp_sidebars_init() {

		register_sidebar(array(
			'id' => 'homepage-widget',
			'name' => esc_html__( 'Homepage Widget Area', 'the-league' ),
			'description'   => esc_html__( 'The widgetized area in the main content area of the homepage.', 'the-league' ),
			'before_widget' => '<section id="%1$s" class="mvp-body-sec-wrap left relative %2$s"><div class="mvp-body-sec-cont left relative">',
			'after_widget' => '</div></section>',
			'before_title' => '<h4 class="mvp-sec-head"><span class="mvp-sec-head">',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'id' => 'mvp-home-sidebar-widget',
			'name' => esc_html__( 'Homepage Sidebar Widget Area', 'the-league' ),
			'description'   => esc_html__( 'The widgetized sidebar on the homepage.', 'the-league' ),
			'before_widget' => '<section id="%1$s" class="mvp-side-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="mvp-sec-head"><span class="mvp-sec-head">',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'id' => 'mvp-sidebar-widget',
			'name' => esc_html__( 'Default Sidebar Widget Area', 'the-league' ),
			'description'   => esc_html__( 'The default widgetized sidebar.', 'the-league' ),
			'before_widget' => '<section id="%1$s" class="mvp-side-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="mvp-sec-head"><span class="mvp-sec-head">',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'id' => 'mvp-sidebar-widget-post',
			'name' => esc_html__( 'Post/Page Sidebar Widget Area', 'the-league' ),
			'description'   => esc_html__( 'The widgetized sidebar on posts and pages.', 'the-league' ),
			'before_widget' => '<section id="%1$s" class="mvp-side-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="mvp-sec-head"><span class="mvp-sec-head">',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'id' => 'mvp-sidebar-woo-widget',
			'name' => esc_html__( 'WooCommerce Sidebar Widget Area', 'the-league' ),
			'description'   => esc_html__( 'The widgetized sidebar on your WooCommerce pages.', 'the-league' ),
			'before_widget' => '<section id="%1$s" class="mvp-side-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="mvp-sec-head"><span class="mvp-sec-head">',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'id' => 'mvp-sidebar-sp-widget',
			'name' => esc_html__( 'SportsPress Sidebar Widget Area', 'the-league' ),
			'description'   => esc_html__( 'The widgetized sidebar on your SportsPress pages.', 'the-league' ),
			'before_widget' => '<section id="%1$s" class="mvp-side-widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h4 class="mvp-sec-head"><span class="mvp-sec-head">',
			'after_title' => '</span></h4>',
		));

	}
}
add_action( 'widgets_init', 'mvp_sidebars_init' );

include( get_template_directory() . '/widgets/widget-ad.php');
include( get_template_directory() . '/widgets/widget-authors.php');
include( get_template_directory() . '/widgets/widget-catfeat.php');
include( get_template_directory() . '/widgets/widget-home-catlist.php');
include( get_template_directory() . '/widgets/widget-home-taglist.php');
include( get_template_directory() . '/widgets/widget-facebook.php');
include( get_template_directory() . '/widgets/widget-tabber.php');
include( get_template_directory() . '/widgets/widget-tagfeat.php');

/////////////////////////////////////
// Register Custom Menus
/////////////////////////////////////

if ( !function_exists( 'register_menus' ) ) {
function register_menus() {
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Main Menu', 'the-league' ),
			'mobile-menu' => esc_html__( 'Fly-Out Menu', 'the-league' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'the-league' ))
	  	);
	  }
}
add_action( 'init', 'register_menus' );

/////////////////////////////////////
// Register Mega Menu
/////////////////////////////////////

add_filter( 'walker_nav_menu_start_el', 'mvp_walker_nav_menu_start_el', 10, 4 );

function mvp_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	global $wp_query;
    // The mega dropdown only applies to the main navigation.
    // Your theme location name may be different, "main" is just something I tend to use.
    if ( 'main-menu' !== $args->theme_location )
        return $item_output;

    // The mega dropdown needs to be added to one specific menu item.
    // I like to add a custom CSS class for that menu via the admin area.
    // You could also do an item ID check.
    if ( in_array( 'mvp-mega-dropdown', $item->classes ) ) {
        global $wp_query;
        global $post;
        $subposts = get_posts( 'numberposts=5&cat=' . $item->object_id );
	$item_output .= '<div class="mvp-mega-dropdown"><div class="mvp-main-box-cont"><ul class="mvp-mega-list">';
            foreach( $subposts as $post ) :
                setup_postdata( $post );
		if ( has_post_format( 'video' )) {
                $item_output .= '<li><a href="'. get_permalink( $post->ID ) .'"><div class="mvp-mega-img">';
		$item_output .= get_the_post_thumbnail( $post->ID, 'mvp-mid-thumb' );
		$item_output .= '<div class="mvp-vid-box-wrap"><i class="fa fa-play fa-3"></i></div></div>';
		$item_output .= get_the_title( $post->ID );
                $item_output .= '</a></li>';
		} else if ( has_post_format( 'gallery' )) {
                $item_output .= '<li><a href="'. get_permalink( $post->ID ) .'"><div class="mvp-mega-img">';
		$item_output .= get_the_post_thumbnail( $post->ID, 'mvp-mid-thumb' );
		$item_output .= '<div class="mvp-vid-box-wrap"><i class="fa fa-camera fa-3"></i></div></div>';
		$item_output .= get_the_title( $post->ID );
                $item_output .= '</a></li>';
		} else {
                $item_output .= '<li><a href="'. get_permalink( $post->ID ) .'"><div class="mvp-mega-img">';
		$item_output .= get_the_post_thumbnail( $post->ID, 'mvp-mid-thumb' );
		$item_output .= '</div>';
		$item_output .= get_the_title( $post->ID );
                $item_output .= '</a></li>';
		}
            endforeach; wp_reset_postdata();
	$item_output .= '</ul></div></div>';

    }

    return $item_output;
}

/////////////////////////////////////
// Register Custom Background
/////////////////////////////////////

$custombg = array(
	'default-color' => 'ffffff',
);
add_theme_support( 'custom-background', $custombg );

/////////////////////////////////////
// Register Thumbnails
/////////////////////////////////////

if ( function_exists( 'add_theme_support' ) ) {
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 1000, 600, true );
add_image_size( 'mvp-post-thumb', 1000, 600, true );
add_image_size( 'mvp-mid-thumb', 400, 240, true );
add_image_size( 'mvp-small-thumb', 80, 80, true );
}

/////////////////////////////////////
// Title Meta Data
/////////////////////////////////////

add_theme_support( 'title-tag' );

function mvp_filter_home_title(){
if ( ( is_home() && ! is_front_page() ) || ( ! is_home() && is_front_page() ) ) {
    $mvpHomeTitle = get_bloginfo( 'name', 'display' );
    $mvpHomeDesc = get_bloginfo( 'description', 'display' );
    return $mvpHomeTitle . " - " . $mvpHomeDesc;
}
}
add_filter( 'pre_get_document_title', 'mvp_filter_home_title');

/////////////////////////////////////
// Add Custom Meta Box
/////////////////////////////////////

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'mvp_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'mvp_post_meta_boxes_setup' );

/* Meta box setup function. */
if ( !function_exists( 'mvp_post_meta_boxes_setup' ) ) {
function mvp_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'mvp_add_post_meta_boxes' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'mvp_save_video_embed_meta', 10, 2 );
	add_action( 'save_post', 'mvp_save_featured_headline_meta', 10, 2 );
	add_action( 'save_post', 'mvp_save_photo_credit_meta', 10, 2 );
	add_action( 'save_post', 'mvp_save_post_template_meta', 10, 2 );
	add_action( 'save_post', 'mvp_save_featured_image_meta', 10, 2 );
	add_action( 'save_post', 'mvp_save_post_gallery_meta', 10, 2 );
}
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
if ( !function_exists( 'mvp_add_post_meta_boxes' ) ) {
function mvp_add_post_meta_boxes() {

	add_meta_box(
		'mvp-video-embed',			// Unique ID
		esc_html__( 'Video/Audio Embed', 'the-league' ),		// Title
		'mvp_video_embed_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'normal',				// Context
		'high'					// Priority
	);

	add_meta_box(
		'mvp-featured-headline',			// Unique ID
		esc_html__( 'Featured Headline', 'the-league' ),		// Title
		'mvp_featured_headline_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'normal',				// Context
		'high'					// Priority
	);

	add_meta_box(
		'mvp-photo-credit',			// Unique ID
		esc_html__( 'Featured Image Caption', 'the-league' ),		// Title
		'mvp_photo_credit_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'normal',				// Context
		'high'					// Priority
	);

	add_meta_box(
		'mvp-post-template',			// Unique ID
		esc_html__( 'Post Template', 'the-league' ),		// Title
		'mvp_post_template_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'side',					// Context
		'core'					// Priority
	);

	add_meta_box(
		'mvp-featured-image',			// Unique ID
		esc_html__( 'Featured Image Show/Hide', 'the-league' ),		// Title
		'mvp_featured_image_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'side',					// Context
		'core'					// Priority
	);

	add_meta_box(
		'mvp-post-gallery',			// Unique ID
		esc_html__( 'Post Gallery Show/Hide', 'the-league' ),		// Title
		'mvp_post_gallery_meta_box',		// Callback function
		'post',					// Admin page (or post type)
		'side',					// Context
		'core'					// Priority
	);
}
}

/* Display the post meta box. */
if ( !function_exists( 'mvp_featured_headline_meta_box' ) ) {
function mvp_featured_headline_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( 'mvp_save_featured_headline_meta', 'mvp_featured_headline_nonce' ); ?>

	<p>
		<label for="mvp-featured-headline"><?php esc_html_e( "Add a custom featured headline that will be displayed in the featured slider.", 'the-league' ); ?></label>
		<br />
		<input class="widefat" type="text" name="mvp-featured-headline" id="mvp-featured-headline" value="<?php echo esc_html( get_post_meta( $object->ID, 'mvp_featured_headline', true ) ); ?>" size="30" />
	</p>

<?php }
}

/* Display the post meta box. */
if ( !function_exists( 'mvp_video_embed_meta_box' ) ) {
function mvp_video_embed_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( 'mvp_save_video_embed_meta', 'mvp_video_embed_nonce' ); ?>

	<p>
		<label for="mvp-video-embed"><?php esc_html_e( "Enter your video or audio embed code.", 'the-league' ); ?></label>
		<br />
		<input class="widefat" type="text" name="mvp-video-embed" id="mvp-video-embed" value="<?php echo esc_html( get_post_meta( $object->ID, 'mvp_video_embed', true ) ); ?>" />
	</p>

<?php }
}

/* Display the post meta box. */
if ( !function_exists( 'mvp_photo_credit_meta_box' ) ) {
function mvp_photo_credit_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( 'mvp_save_photo_credit_meta', 'mvp_photo_credit_nonce' ); ?>

	<p>
		<label for="mvp-photo-credit"><?php esc_html_e( "Add a caption and/or photo credit information for the featured image.", 'the-league' ); ?></label>
		<br />
		<input class="widefat" type="text" name="mvp-photo-credit" id="mvp-photo-credit" value="<?php echo esc_html( get_post_meta( $object->ID, 'mvp_photo_credit', true ) ); ?>" size="30" />
	</p>

<?php }
}

/* Display the post meta box. */
if ( !function_exists( 'mvp_post_template_meta_box' ) ) {
function mvp_post_template_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( 'mvp_save_post_template_meta', 'mvp_post_template_nonce' ); $selected = esc_html( get_post_meta( $object->ID, 'mvp_post_template', true ) ); ?>

	<p>
		<label for="mvp-post-template"><?php esc_html_e( "Select a template for your post.", 'the-league' ); ?></label>
		<br /><br />
		<select class="widefat" name="mvp-post-template" id="mvp-post-template">
			<option value="global" <?php selected( $selected, 'global' ); ?>>Use Global Setting</option>
			<option value="temp1" <?php selected( $selected, 'temp1' ); ?>>Template 1</option>
			<option value="temp2" <?php selected( $selected, 'temp2' ); ?>>Template 2</option>
			<option value="temp3" <?php selected( $selected, 'temp3' ); ?>>Template 3</option>
			<option value="temp4" <?php selected( $selected, 'temp4' ); ?>>Template 4</option>
			<option value="temp5" <?php selected( $selected, 'temp5' ); ?>>Template 5</option>
			<option value="temp6" <?php selected( $selected, 'temp6' ); ?>>Template 6</option>
			<option value="temp7" <?php selected( $selected, 'temp7' ); ?>>Template 7</option>
			<option value="temp8" <?php selected( $selected, 'temp8' ); ?>>Template 8</option>
        	</select>
	</p>
<?php }
}

/* Display the post meta box. */
if ( !function_exists( 'mvp_featured_image_meta_box' ) ) {
function mvp_featured_image_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( 'mvp_save_featured_image_meta', 'mvp_featured_image_nonce' ); $selected = esc_html( get_post_meta( $object->ID, 'mvp_featured_image', true ) ); ?>

	<p>
		<label for="mvp-featured-image"><?php esc_html_e( "Select to show or hide the featured image from automatically displaying in this post.", 'the-league' ); ?></label>
		<br /><br />
		<select class="widefat" name="mvp-featured-image" id="mvp-featured-image">
            		<option value="show" <?php selected( $selected, 'show' ); ?>>Show</option>
            		<option value="hide" <?php selected( $selected, 'hide' ); ?>>Hide</option>
        	</select>
	</p>
<?php }
}

/* Display the post meta box. */
if ( !function_exists( 'mvp_post_gallery_meta_box' ) ) {
function mvp_post_gallery_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( 'mvp_save_post_gallery_meta', 'mvp_post_gallery_nonce' ); $selected = esc_html( get_post_meta( $object->ID, 'mvp_post_gallery', true ) ); ?>

	<p>
		<label for="mvp-post-gallery"><?php esc_html_e( "Select to show or hide the built-in gallery feature for this post.", 'the-league' ); ?></label>
		<br /><br />
		<select class="widefat" name="mvp-post-gallery" id="mvp-post-gallery">
            		<option value="hide" <?php selected( $selected, 'hide' ); ?>>Hide</option>
            		<option value="show" <?php selected( $selected, 'show' ); ?>>Show</option>
        	</select>
	</p>
<?php }
}

/* Save the meta box's post metadata. */
if ( !function_exists( 'mvp_save_video_embed_meta' ) ) {
function mvp_save_video_embed_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['mvp_video_embed_nonce'] ) || !wp_verify_nonce( $_POST['mvp_video_embed_nonce'], 'mvp_save_video_embed_meta' ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['mvp-video-embed'] ) ? balanceTags( $_POST['mvp-video-embed'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'mvp_video_embed';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} }

/* Save the meta box's post metadata. */
if ( !function_exists( 'mvp_save_featured_headline_meta' ) ) {
function mvp_save_featured_headline_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['mvp_featured_headline_nonce'] ) || !wp_verify_nonce( $_POST['mvp_featured_headline_nonce'], 'mvp_save_featured_headline_meta' ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['mvp-featured-headline'] ) ? balanceTags( $_POST['mvp-featured-headline'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'mvp_featured_headline';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} }

/* Save the meta box's post metadata. */
if ( !function_exists( 'mvp_save_photo_credit_meta' ) ) {
function mvp_save_photo_credit_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['mvp_photo_credit_nonce'] ) || !wp_verify_nonce( $_POST['mvp_photo_credit_nonce'], 'mvp_save_photo_credit_meta' ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['mvp-photo-credit'] ) ? balanceTags( $_POST['mvp-photo-credit'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'mvp_photo_credit';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} }

/* Save the meta box's post metadata. */
if ( !function_exists( 'mvp_save_post_template_meta' ) ) {
function mvp_save_post_template_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['mvp_post_template_nonce'] ) || !wp_verify_nonce( $_POST['mvp_post_template_nonce'], 'mvp_save_post_template_meta' ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['mvp-post-template'] ) ? balanceTags( $_POST['mvp-post-template'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'mvp_post_template';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} }

/* Save the meta box's post metadata. */
if ( !function_exists( 'mvp_save_featured_image_meta' ) ) {
function mvp_save_featured_image_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['mvp_featured_image_nonce'] ) || !wp_verify_nonce( $_POST['mvp_featured_image_nonce'], 'mvp_save_featured_image_meta' ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['mvp-featured-image'] ) ? balanceTags( $_POST['mvp-featured-image'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'mvp_featured_image';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} }

/* Save the meta box's post metadata. */
if ( !function_exists( 'mvp_save_post_gallery_meta' ) ) {
function mvp_save_post_gallery_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['mvp_post_gallery_nonce'] ) || !wp_verify_nonce( $_POST['mvp_post_gallery_nonce'], 'mvp_save_post_gallery_meta' ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['mvp-post-gallery'] ) ? balanceTags( $_POST['mvp-post-gallery'] ) : '' );

	/* Get the meta key. */
	$meta_key = 'mvp_post_gallery';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
} }

/////////////////////////////////////
// Comments
/////////////////////////////////////

if ( !function_exists( 'mvp_comment' ) ) {
function mvp_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div class="comment-wrapper" id="comment-<?php comment_ID(); ?>">
			<div class="comment-inner">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 46 ); ?>
				</div>
				<div class="commentmeta">
					<p class="comment-meta-1">
						<?php printf( esc_html__( '%s ', 'the-league'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</p>
					<p class="comment-meta-2">
						<?php echo get_comment_date(); ?> <?php esc_html_e( 'at', 'the-league'); ?> <?php echo get_comment_time(); ?>
						<?php edit_comment_link( esc_html__( 'Edit', 'the-league'), '(' , ')'); ?>
					</p>
				</div>
				<div class="text">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="waiting_approval"><?php esc_html_e( 'Your comment is awaiting moderation.', 'the-league' ); ?></p>
					<?php endif; ?>
					<div class="c">
						<?php comment_text(); ?>
					</div>
				</div><!-- .text  -->
				<div class="clear"></div>
				<div class="comment-reply"><span class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span></div>
			</div><!-- comment-inner  -->
		</div><!-- comment-wrapper  -->
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php esc_html_e( 'Pingback:', 'the-league' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'the-league' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
}

if ( !function_exists( 'mvpClickCommmentButton' ) ) {
function mvpClickCommmentButton($disqus_shortname){
    global $post;
    echo '
    <script type="text/javascript">
	jQuery(document).ready(function($) {
  	  $(".comment-click-'.$post->ID.'").on("click", function(){
  	    $(".com-click-id-'.$post->ID.'").show();
	    $(".disqus-thread-'.$post->ID.'").show();
  	    $(".com-but-'.$post->ID.'").hide();
	  });
	});
    </script>';
}
}

/////////////////////////////////////
// Popular Posts
/////////////////////////////////////

if ( !function_exists( 'getCrunchifyPostViews' ) ) {
function getCrunchifyPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
}

if ( !function_exists( 'setCrunchifyPostViews' ) ) {
function setCrunchifyPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
}

if ( !function_exists( 'mvp_post_views' ) ) {
function mvp_post_views(){
	$post_id = get_the_ID();
	$count_key = 'post_views_count';
	$n = get_post_meta($post_id, $count_key, true);
	if ($n > 999999999) {
		$n_format = number_format($n / 1000000000, 1) . 'B';
	} else if ($n > 999999) {
		$n_format = number_format($n / 1000000, 1) . 'M';
	} else if ($n > 999) {
        	$n_format = number_format($n / 1000, 1) . 'K';
	} else {
		$n_format = $n;
   	}

	echo $n_format;
}
}

/////////////////////////////////////
// Pagination
/////////////////////////////////////

if ( !function_exists( 'pagination' ) ) {
function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>".__( 'Page', 'the-league' )." ".$paged." ".__( 'of', 'the-league' )." ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; ".__( 'First', 'the-league' )."</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; ".__( 'Previous', 'the-league' )."</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">".__( 'Next', 'the-league' )." &rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__( 'Last', 'the-league' )." &raquo;</a>";
         echo "</div>\n";
     }
}
}

/////////////////////////////////////
// Disqus Comments
/////////////////////////////////////

$disqus_id = get_option('mvp_disqus_id'); if (isset($disqus_id)) {
if ( !function_exists( 'mvp_disqus_embed' ) ) {
function mvp_disqus_embed($disqus_shortname) {
    global $post;
    wp_enqueue_script('disqus_embed','//'.$disqus_shortname.'.disqus.com/embed.js');
    echo '<div id="disqus_thread" class="disqus-thread-'.$post->ID.'"></div>
    <script type="text/javascript">
        var disqus_shortname = "'.$disqus_shortname.'";
        var disqus_title = "'.$post->post_title.'";
        var disqus_url = "'.get_permalink($post->ID).'";
        var disqus_identifier = "'.$disqus_shortname.'-'.$post->ID.'";
    </script>';
}
}
}

/////////////////////////////////////
// Remove Pages From Search Results
/////////////////////////////////////

if ( !is_admin() ) {

function mvp_SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

add_filter('pre_get_posts','mvp_SearchFilter');

}

/////////////////////////////////////
// Miscellaneous
/////////////////////////////////////

// Place Wordpress Admin Bar Above Main Navigation

if ( is_user_logged_in() ) {
	if ( is_admin_bar_showing() ) {
	function mvp_admin_bar() {
		echo "
			<style type='text/css'>
			#mvp-top-head-wrap {top: 32px !important;}
			</style>
		";
	}
	add_action( 'wp_head', 'mvp_admin_bar' );
	}
}

// Set Content Width
if ( ! isset( $content_width ) ) $content_width = 1000;

// Add RSS links to <head> section
add_theme_support( 'automatic-feed-links' );

add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
}

// Prevents double posts on second page

add_filter('redirect_canonical','pif_disable_redirect_canonical');

function pif_disable_redirect_canonical($redirect_url) {
    if (is_singular()) $redirect_url = false;
return $redirect_url;
}

/////////////////////////////////////
// Google AMP
/////////////////////////////////////

$mvp_enable_amp = get_option('mvp_amp'); if ($mvp_enable_amp == "true") {

add_filter( 'amp_post_template_file', 'mvp_amp_set_custom_template', 10, 3 );
function mvp_amp_set_custom_template( $file, $type, $post ) {
	if ( 'single' === $type ) {
		$file = dirname( __FILE__ ) . '/amp-single.php';
	}
	return $file;
}

add_action( 'amp_post_template_head', 'isa_remove_amp_google_fonts', 2 );
function isa_remove_amp_google_fonts() {
    remove_action( 'amp_post_template_head', 'amp_post_template_add_fonts' );
}

add_action('amp_post_template_head','mvp_amp_google_font');
 function mvp_amp_google_font( $amp_template ) {
	$mvp_featured_font = get_option('mvp_featured_font');
	$mvp_amp_featured_font = preg_replace("/ /","+",$mvp_featured_font);
	$mvp_title_font = get_option('mvp_title_font');
	$mvp_amp_title_font = preg_replace("/ /","+",$mvp_title_font);
	$mvp_heading_font = get_option('mvp_heading_font');
	$mvp_amp_heading_font = preg_replace("/ /","+",$mvp_heading_font);
	$mvp_content_font = get_option('mvp_content_font');
	$mvp_amp_content_font = preg_replace("/ /","+",$mvp_content_font);
	$mvp_menu_font = get_option('mvp_menu_font');
	$mvp_amp_menu_font = preg_replace("/ /","+",$mvp_menu_font);
 ?>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Advent Pro:700|Open Sans:700|<?php echo $mvp_amp_featured_font; ?>:100,200,300,400,500,600,700,800,900|<?php echo $mvp_amp_title_font; ?>:100,200,300,400,500,600,700,800,900|<?php echo $mvp_amp_heading_font; ?>:100,200,300,400,500,600,700,800,900|<?php echo $mvp_amp_content_font; ?>:100,200,300,400,500,600,700,800,900|<?php echo $mvp_amp_menu_font; ?>:100,200,300,400,500,600,700,800,900&subset=arabic,latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese">
 <?php
 }

add_action( 'amp_post_template_css', 'mvp_amp_my_additional_css_styles' );
function mvp_amp_my_additional_css_styles( $amp_template ) {
	$wallad = get_option('mvp_wall_ad');
	$primarycolor = get_option('mvp_primary_theme');
	$topnavbg = get_option('mvp_top_nav_bg');
	$topnavtext = get_option('mvp_top_nav_text');
	$topnavhover = get_option('mvp_top_nav_hover');
	$botnavbg = get_option('mvp_bot_nav_bg');
	$botnavtext = get_option('mvp_bot_nav_text');
	$botnavhover = get_option('mvp_bot_nav_hover');
	$link = get_option('mvp_link_color');
	$link2 = get_option('mvp_link_hover');
	$featured_font = get_option('mvp_featured_font');
	$title_font = get_option('mvp_title_font');
	$heading_font = get_option('mvp_heading_font');
	$content_font = get_option('mvp_content_font');
	$menu_font = get_option('mvp_menu_font');
	$mvp_customcss = get_option('mvp_customcss');
	?>
#mvp-foot-copy a {
	color: <?php echo $link; ?>;
	}

#mvp-content-main p a,
.mvp-post-add-main p a {
	box-shadow: inset 0 -4px 0 <?php echo $link; ?>;
	}

#mvp-content-main p a:hover,
.mvp-post-add-main p a:hover {
	background: <?php echo $link; ?>;
	}

a,
a:visited,
.post-info-name a {
	color: <?php echo $link2; ?>;
	}

#mvp-side-wrap a:hover {
	color: <?php echo $link2; ?>;
	}

.mvp-fly-top:hover,
.mvp-vid-box-wrap,
ul.mvp-soc-mob-list li.mvp-soc-mob-com {
	background: <?php echo $primarycolor; ?>;
	}

nav.mvp-fly-nav-menu ul li.menu-item-has-children:after,
.mvp-feat1-left-wrap span.mvp-cd-cat,
.mvp-widget-feat1-top-story span.mvp-cd-cat,
.mvp-widget-feat2-left-cont span.mvp-cd-cat,
.mvp-widget-dark-feat span.mvp-cd-cat,
.mvp-widget-dark-sub span.mvp-cd-cat,
.mvp-vid-wide-text span.mvp-cd-cat,
.mvp-feat2-top-text span.mvp-cd-cat,
.mvp-feat3-main-story span.mvp-cd-cat,
.mvp-feat3-sub-text span.mvp-cd-cat,
.mvp-feat4-main-text span.mvp-cd-cat,
.woocommerce-message:before,
.woocommerce-info:before,
.woocommerce-message:before {
	color: <?php echo $primarycolor; ?>;
	}

#searchform input,
.mvp-authors-name,
span.mvp-widget-home-title {
	border-bottom: 1px solid <?php echo $primarycolor; ?>;
	}

.mvp-fly-top:hover {
	border-top: 1px solid <?php echo $primarycolor; ?>;
	border-left: 1px solid <?php echo $primarycolor; ?>;
	border-bottom: 1px solid <?php echo $primarycolor; ?>;
	}

ul.mvp-feat1-list-buts li.active span.mvp-feat1-list-but,
span.mvp-post-cat,
span.mvp-feat1-pop-head {
	background: <?php echo $primarycolor; ?>;
	}

#mvp-main-nav-top,
#mvp-fly-wrap,
.mvp-soc-mob-right,
#mvp-main-nav-small-cont {
	background: <?php echo $topnavbg; ?>;
	}

#mvp-main-nav-small .mvp-fly-but-wrap span,
#mvp-main-nav-small .mvp-search-but-wrap span,
.mvp-nav-top-left .mvp-fly-but-wrap span,
#mvp-fly-wrap .mvp-fly-but-wrap span {
	background: <?php echo $topnavtext; ?>;
	}

.mvp-nav-top-right .mvp-nav-search-but,
span.mvp-fly-soc-head,
.mvp-soc-mob-right i,
#mvp-main-nav-small span.mvp-nav-search-but,
#mvp-main-nav-small .mvp-nav-menu ul li a,
nav.mvp-fly-nav-menu ul li a {
	color: <?php echo $topnavtext; ?>;
	}

#mvp-main-nav-small .mvp-nav-menu ul li.menu-item-has-children a:after {
	border-color: <?php echo $topnavtext; ?> transparent transparent transparent;
	}

#mvp-nav-top-wrap span.mvp-nav-search-but:hover,
#mvp-main-nav-small span.mvp-nav-search-but:hover {
	color: <?php echo $topnavhover; ?>;
	}

#mvp-nav-top-wrap .mvp-fly-but-wrap:hover span,
#mvp-main-nav-small .mvp-fly-but-wrap:hover span,
span.mvp-woo-cart-num:hover {
	background: <?php echo $topnavhover; ?>;
	}

#mvp-main-nav-bot-cont {
	background: <?php echo $botnavbg; ?>;
	}

#mvp-nav-bot-wrap .mvp-fly-but-wrap span,
#mvp-nav-bot-wrap .mvp-search-but-wrap span {
	background: <?php echo $botnavtext; ?>;
	}

#mvp-nav-bot-wrap span.mvp-nav-search-but,
#mvp-nav-bot-wrap .mvp-nav-menu ul li a {
	color: <?php echo $botnavtext; ?>;
	}

#mvp-nav-bot-wrap .mvp-nav-menu ul li.menu-item-has-children a:after {
	border-color: <?php echo $botnavtext; ?> transparent transparent transparent;
	}

.mvp-nav-menu ul li:hover a {
	border-bottom: 5px solid <?php echo $botnavhover; ?>;
	}

#mvp-nav-bot-wrap .mvp-fly-but-wrap:hover span {
	background: <?php echo $botnavhover; ?>;
	}

#mvp-nav-bot-wrap span.mvp-nav-search-but:hover {
	color: <?php echo $botnavhover; ?>;
	}

body,
.mvp-author-info-text,
span.mvp-post-excerpt,
nav.mvp-fly-nav-menu ul li a,
.mvp-ad-label,
span.mvp-feat-caption,
.mvp-post-tags a,
.mvp-post-tags a:visited,
span.mvp-author-box-name a,
#mvp-author-box-text p,
.mvp-post-gallery-text p,
ul.mvp-soc-mob-list li span,
#comments,
h3#reply-title,
h2.comments,
#mvp-foot-copy p,
span.mvp-fly-soc-head,
.mvp-post-tags-header,
.mvp-post-tags a,
span.mvp-prev-next-label,
span.mvp-post-add-link-but,
#mvp-comments-button a,
#mvp-comments-button span.mvp-comment-but-text,
span.mvp-cd-cat,
span.mvp-cd-date,
span.mvp-widget-home-title2,
.wp-caption,
#mvp-content-main p.wp-caption-text,
.gallery-caption,
.mvp-post-add-main p.wp-caption-text,
.protected-post-form input {
	font-family: '<?php echo $content_font; ?>', sans-serif;
	}

.mvp-blog-story-text p,
span.mvp-author-page-desc,
#mvp-404 p,
.mvp-widget-feat1-bot-text p,
.mvp-widget-feat2-left-text p,
.mvp-flex-story-text p,
.mvp-search-text p,
#mvp-content-main p,
.mvp-post-add-main p,
.rwp-summary,
.rwp-u-review__comment,
.mvp-feat5-mid-main-text p,
.mvp-feat5-small-main-text p {
	font-family: '<?php echo $para_font; ?>', sans-serif;
	}

.mvp-nav-menu ul li a,
#mvp-foot-menu ul li a {
	font-family: '<?php echo $menu_font; ?>', sans-serif;
	}

#mvp-content-main blockquote p,
.mvp-post-add-main blockquote p,
.mvp-related-text p,
.mvp-post-more-text p {
	font-family: '<?php echo $featured_font; ?>', sans-serif;
	}

h1.mvp-post-title,
h1.mvp-post-title-wide,
#mvp-404 h1 {
	font-family: '<?php echo $title_font; ?>', sans-serif;
	}

span.mvp-feat1-pop-head,
.mvp-feat1-pop-text:before,
span.mvp-feat1-list-but,
span.mvp-widget-home-title,
.mvp-widget-feat2-side-more,
span.mvp-post-cat,
span.mvp-page-head,
h1.mvp-author-top-head,
.mvp-authors-name,
#mvp-content-main h1,
#mvp-content-main h2,
#mvp-content-main h3,
#mvp-content-main h4,
#mvp-content-main h5,
#mvp-content-main h6 {
	font-family: '<?php echo $heading_font; ?>', sans-serif;
	}
					
	<?php
}
	
}

/////////////////////////////////////
// WooCommerce
/////////////////////////////////////

add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/////////////////////////////////////
// SportsPress
/////////////////////////////////////

add_theme_support( 'sportspress' );

function sportspress_pro_url_theme_27( $url ) { 
return add_query_arg( 'theme', '27', $url ); 
} 
add_filter( 'sportspress_pro_url', 'sportspress_pro_url_theme_27' );

/////////////////////////////////////
// Demo Import
/////////////////////////////////////

function ocdi_import_files() {
  return array(
    array(
      'import_file_name'             => 'The League Demo Import',
      'local_import_file'            => trailingslashit( get_template_directory() ) . 'import/theleague.xml',
      'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'import/theleague.wie',
      'import_preview_image_url'     => trailingslashit( get_template_directory() ) . 'screenshot.png',
      'preview_url'                  => 'http://www.mvpthemes.com/theleague',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );

function ocdi_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'main-menu' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );

/////////////////////////////////////
// Bundled Plugins
/////////////////////////////////////

require_once get_template_directory() . '/plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'zox_register_required_plugins' );

function zox_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'               => 'MVP Themes Social Fields',
			'slug'               => 'mvp-social-fields',
			'source'             => get_template_directory() . '/plugins/mvp-social-fields.zip',
			'required'           => true,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
		),

		array(
			'name'               => 'One Click Demo Import',
			'slug'               => 'one-click-demo-import',
			'source'             => get_template_directory() . '/plugins/one-click-demo-import.zip',
			'required'           => false,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
		),
		
		array(
			'name'               => 'Google AMP',
			'slug'               => 'mvp-social-buttons',
			'source'             => get_template_directory() . '/plugins/amp.zip',
			'required'           => false,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
		),

		array(
			'name'               => 'MVP Scoreboard',
			'slug'               => 'mvp-scoreboard',
			'source'             => get_template_directory() . '/plugins/mvp-scoreboard.zip',
			'required'           => false,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
		),

		array(
			'name'               => 'Theia Post Slider',
			'slug'               => 'theia-post-slider',
			'source'             => get_template_directory() . '/plugins/theia-post-slider.zip',
			'required'           => false,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
		),

		array(
			'name'               => 'Theia Sticky Sidebar',
			'slug'               => 'theia-sticky-sidebar',
			'source'             => get_template_directory() . '/plugins/theia-sticky-sidebar.zip',
			'required'           => false,
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
		),


	);

	$config = array(
		'id'           => 'the-league',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'the-league' ),
			'menu_title'                      => __( 'Install Plugins', 'the-league' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'the-league' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'the-league' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'the-league' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'the-league'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'the-league'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'the-league'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'the-league'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'the-league'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'the-league'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'the-league'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'the-league'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'the-league'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'the-league' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'the-league' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'the-league' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'the-league' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'the-league' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'the-league' ),
			'dismiss'                         => __( 'Dismiss this notice', 'the-league' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'the-league' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'the-league' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}
?>