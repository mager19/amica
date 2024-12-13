<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'partials.page-header',
    'partials.content',
    'partials.content-*',
  ];

  /**
   * Data to be passed to view before rendering, but after merging.
   *
   * @return array
   */
  public function override()
  {
    return [
      'byline' => $this->byline(),
      'title' => $this->title(),
      'post_image' => $this->image(),
    ];
  }

  /**
   * Returns the post title.
   *
   * @return string
   */
  public function title()
  {
    if ($this->view->name() !== 'partials.page-header') {
      return get_the_title();
    }

    if (is_home()) {
      if ($home = get_option('page_for_posts', true)) {
        return get_the_title($home);
      }

      return __('Latest Posts', 'sage');
    }

    if (is_archive()) {
      return get_the_archive_title();
    }

    if (is_search()) {
      return sprintf(
        /* translators: %s is replaced with the search query */
        __('Search Results for %s', 'sage'),
        get_search_query()
      );
    }

    if (is_404()) {
      return __('Not Found', 'sage');
    }

    return get_the_title();
  }

  /**
   * Returns the post byline.
   *
   * @return string
   */
  public function byline()
  {
    global $post;
    if ( $this->view->name() == 'partials.page-header' ) {
      $post_type = get_post_type();
      if ( $post_type === 'case' ) {
        $terms = get_the_terms($post, 'legal_category');
        $url = '/legal-resources/4th-circuit-cases/?case-categories=';
      } else {
        $terms = get_the_terms($post, get_post_taxonomies($post)[0]);
        $url = '/news-and-stories/' . ($post_type == 'post' ? 'news' : 'stories-of-impact') . '/?categories=' ;
      }
      $term_names = [];
      if(isset($terms)) {
        foreach ($terms as $term) {
          if ( $term->name != 'Uncategorized' ) {
            $term_names[] = '<a href="'
            . $url 
            . $term->slug . '">' 
            . $term->name 
            . '</a>'; 
          }
        }
      }
      $term_names = count($term_names) > 0 ? '<span class="block">' . implode(', ', $term_names) . '</span>' : '';

      if ( $post_type == 'post' ) {
        $author = get_the_author_meta('user_nicename') == 'no_author' ? null : get_the_author() . "–";
        $date = get_the_date('m/d/y');

        return $term_names . $author . $date;
      } else if ( $post_type == 'story' || $post_type == 'case' ) {
        return $term_names;
      }
    }
    return null;
  }

  /**
   * Returns the post image.
   *
   * @return string
   */
  public function image()
  {
    global $post;
    if ($this->view->name() == 'partials.page-header') {
      $id = get_post_thumbnail_id($post->id);
      
      if ( $id ) {
        $alt = get_post_meta ( $id, '_wp_attachment_image_alt', true );
        return ['ID' => $id, 'alt' => $alt];
      }
      return false;
    }

    return null;
  }
}
