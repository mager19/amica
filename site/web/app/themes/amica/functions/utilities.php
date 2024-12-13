<?php
/**
 * Useful utility functions used across the site
 */

/**
 * Return the items field.
 *
 * @return array
*/
function getBlockField($name, &$obj) {
    return get_field($name) ?: $obj->example[$name];
}


function getSvg($image, $attrs = []) {
  // Get the URL of the media attachment
  if ( is_array($image) && $image['ID'] ) $image = $image['ID'];
  $attachment_url = wp_get_attachment_url($image);

  $svg_content = null;

  if ( !$attachment_url ) {
    $svg_content = \Roots\asset('images/' . $image . '.svg')->contents();

    if ( !$svg_content ) return false;
  } else {
    $svg_content = @file_get_contents( $attachment_url );
  }

  if ( is_array($attrs) &&  count($attrs) > 0 ) {
    foreach($attrs as $key => $val) {
      $svg_content = str_replace('<svg', '<svg ' . $key . '="' . $val . '"', $svg_content);
    }
  } 
  return $svg_content;
}

function getFAIcon($slug) {
  if(!$slug) return false;
  switch ($slug) {
    case 'x':
      return "fab fa-x-twitter";
    case 'facebook':
      return "fab fa-facebook";
    case 'email':
      return "fa fa-envelope";
    default:
      return "fab fa-$slug";
  };
}

function extractPostCard($item) {
  $blank_return = [
    'image' => 0,
    'eyebrow' => "",
    'headline' => "",
    'copy' => "",
    'cta' => [
      'url' => "",
      'title' => "",
    ],
  ];

  if ( !$item ) return $blank_return;
  if ( is_string($item) ) $item = get_post($item);
  if ( !property_exists($item, 'post_content') ) return $blank_return;
  $post_type = $item->post_type;

  if ( $post_type == 'case' ) {
    $legal_categories = getPostTaxonomies($item, 'legal_category');
    $judges = getPostTaxonomies($item, 'judge');
    $published = $item->is_published ? __('Published', 'amica') : __('Unpublished', 'amica');
    $copy = $item->description . '<p class="body body-2 mb-0"><span class="font-medium">' .  __('Publication Status', 'amica') . ":</span> " . $published . "</p>";
    return [
      'judges' => $judges['slugs'],
      'legal_categories' => $legal_categories['slugs'],
      'eyebrow' => $legal_categories['names'],
      'headline' => wp_trim_words( $item->post_title, 10, '...'),
      'copy' => $copy,
      'cta' => [
        'url' => get_the_permalink($item->ID),
        'title' => __('Read more about ', 'amica') . $item->post_title,
        'cta_type'  => 'link',
        'cta_icon'  => 'arrow-right'
      ],
    ];
  } else {
    $terms =  getPostTaxonomies($item);

    if ( has_excerpt($item) ) {
      $text = wp_strip_all_tags( get_the_excerpt($item) , true );
    } else {
      $text = strip_shortcodes( $item->post_content );
      $text = apply_filters( 'the_content', $text );
      $text = str_replace(']]>', ']]&gt;', $text);
      $excerpt_length = apply_filters( 'excerpt_length', 20 );
      $text = wp_trim_words( $text, $excerpt_length);
    }

    $author = '';
    $date = '';

    if ($post_type == 'post') {
      $author = get_the_author_meta('display_name' , get_post_field ('post_author', $item->ID));
      $author = $author == 'no_author' ? null : $author . "–";
      $date = get_the_date('m/d/y', $item->ID);
    }

    $image = get_post_thumbnail_id($item->ID) ? ['ID' => get_post_thumbnail_id($item->ID)] : get_field('default_images_post_thumbnail', 'brand');

    return [
      'tags' => $terms['slugs'],
      'image' => $image,
      'eyebrow' => $terms['names'] . $author . $date,
      'headline' => wp_trim_words( $item->post_title, 10, '...'),
      'copy' => $text,
      'cta' => [
        'url' => get_the_permalink($item->ID),
        'title' => $post_type == 'story' ? __('Read ' . $item->post_title . "'s story", 'amica') 
                                        : __('Read this article', 'amica')
      ],
    ];
  }
}

function term_names($taxonomy_name) {
  $obj = get_terms($taxonomy_name);

  if(!$obj) return '';
  $terms = [];
  foreach($obj as $term) {
    if(isset($term->slug)) {
      $terms[$term->slug] = $term->name;
    }
  }
  return $terms;
}

/**
 * Queries and builds cards
 * $post_type String
 * $sort String|Array [key => sort order]
 */
function getCards($post_type = 'post', $sort = null) {
    $post_query = [
      'post_type' => $post_type,
      'posts_per_page' => -1,
    ];
    
    if (is_array($sort)) {
      foreach($sort as $key => $value) {
        $post_query['meta_query'][$key] = [
          'key'     => $key,
          'compare' => 'EXISTS',
        ];
        $post_query['orderby'][$key] = $value;
      }
    } else if ($sort) {
      $post_query['meta_key'] = $sort;
      $post_query['orderby'] = 'meta_value';
    };

    $item = get_posts($post_query);
    $cards = array_map('extractPostCard', $item);
    wp_reset_postdata();
    return $cards;
}

function getPostTaxonomies($item, $taxonomy = null, $display = 'block') {
  if (!$taxonomy) $taxonomy = get_post_taxonomies($item)[0];
  $terms = get_the_terms($item, $taxonomy);
  $term_slugs = [];
  $term_names = [];
  foreach ($terms as $term) {
    $term_slugs[] = $term->slug; 
    $term_names[] = $term->name;
  }
  $term_slugs = implode(',', $term_slugs);
  $term_names = implode(', ', $term_names);
  $term_names = $term_names == 'Uncategorized' 
    ? "" 
    : '<span class="' . $display . '">' . $term_names . '</span>';
  return [
    'slugs' => $term_slugs,
    'names' => $term_names,
  ];
}
  