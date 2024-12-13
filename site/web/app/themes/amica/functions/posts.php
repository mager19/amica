<?php
/**
 * Improve continue link at the end of exepts
 */
function custom_excerpt_more($more) {
   global $post;
   $more_text = 'continue reading <span class="sr-only">' . get_the_title($post->ID) . '</span>';
   return '… <a href="'. get_permalink($post->ID) . '">' . $more_text . '</a>';
}
add_filter('excerpt_more', 'custom_excerpt_more');

function short_get_the_excerpt( $post = null ) {
	if ( is_bool( $post ) ) {
		_deprecated_argument( __FUNCTION__, '2.3.0' );
	}

	$post = get_post( $post );
	if ( empty( $post ) ) {
		return '';
	}

	if ( post_password_required( $post ) ) {
		return __( 'There is no excerpt because this is a protected post.' );
	}

	/**
	 * Filters the retrieved post excerpt.
	 *
	 * @since 1.2.0
	 * @since 4.5.0 Introduced the `$post` parameter.
	 *
	 * @param string  $post_excerpt The post excerpt.
	 * @param WP_Post $post         Post object.
	 */
	$excerpt = get_the_excerpt($post);
	$newExerpt = has_excerpt($post) ? $excerpt : excerpt_from_html($post->post_content, $post->ID);
   
	return apply_filters( 'get_the_excerpt', $newExerpt, $post );
}

function excerpt_from_html($str, $id) {
   $re = '/(<p>\X*?<\/p>)\X*?(<p>\X*?<\/p>)/u';
   preg_match($re, $str, $matches);
   $link = get_permalink($id);
   $title = get_the_title($id);
	//  $continueText = "... <a href='$link'>continue reading <span class='sr-only'>$title</span></a>";
	 $continueText = "... <span class='sr-only'>continue reading $title</span>";
	 $copy = isset($matches[1]) ? $matches[1] : $str;
   return substrwords(strip_tags($copy), 100, $continueText);

}

function substrwords($text, $maxchar, $end = '') {
	if (strlen($text) > $maxchar || $text == '') {
		$words = preg_split('/\s/', $text);      
		$output = '';
		$i = 0;
		while (1) {
			if (isset($words[$i])) {
				$length = strlen($output) + strlen($words[$i]);
				if ($length > $maxchar) {
					break;
				} 
				else {
					$output .= " " . $words[$i];
					++$i;
				}
			} else break;
		}
		$output .= $end;
	} 
	else $output = $text;
	return $output;
}

function get_post_count($slug, $type) {
    $args = array(
      'post_status'   => 'publish',
      'posts_per_page' => -1,
    );

    if ( $type == 'projects' ) {
        $args['post_type'] = 'any';
        $args['meta_query'][] = array(
            'key' => 'project',
            'value' => "i:\d;s:\d:\"$slug\"", 
            'compare' => 'REGEXP'
        );
    }
    if ( $type == 'type' ) {
        $args['post_type'] = $slug === 'event' ? 'tribe_events' : $slug;
    }
    if ( $type == 'issue' ) {
        $args['post_type'] = 'any';
        $args['tax_query'] = array(
            array(
            'taxonomy' => 'post_tag',
            'field' => 'slug',
            'terms' => array( $slug )
            ),
        );
    }
    $count_posts = new WP_Query( $args );
    return (int)$count_posts->post_count;
}


function searchfilter($query) {
    if ( ! is_admin() && $query->is_search() && $query->query_vars["s"] === "") {
        $query->query_vars["s"] = " ";
        $limit = isset($_GET['limit']) ? abs( (int) $_GET['limit'] ) : null;
        if ( ! empty( $limit ) && $limit >= 1 ) {
            $query->set( 'posts_per_page', $limit );
        } elseif ( $limit === 0 ) {
            $query->set( 'posts_per_page', -1 );
        }
    }
    
    return $query;
}
add_filter('pre_get_posts','searchfilter');