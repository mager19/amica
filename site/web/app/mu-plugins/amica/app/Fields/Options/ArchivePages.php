<?php
/**
 * NOT CURRENTLY WORKING
 */
namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use WP_Query;

class ArchivePages extends Field {
  public $name = 'Archive Pages';
  public $parent = 'site-options';
  public $title = 'Archive Pages | Site Options';
  public $redirect = false;
  public $description = 'Match Post Types with their archive pages';  
  public $capability = 'edit_posts';
  public $post = 'archive';

  /**
   * The option page field group.
   *
   * @return array
   */
  public function fields() {
    $choices = $this->getPages();
    $archive_pages = new FieldsBuilder('archive_pages');

    $archive_pages
      ->addSelect('about_us', [
        'choices' => $choices,
      ])
      ->addSelect('cases', [
        'choices' => $choices,
      ])
      ;

      return $archive_pages->build();
  }

  private function getPages() {
    $choices = array();
    $pages = new WP_Query(array(
      'post_type' => 'page',
      'post_per_page' => -1,
      'orderby' => 'post_title',
      'order' => 'ASC'
    ));
    if ($pages->have_posts()) {
      global $post;
      while ($pages->have_posts()) {
        $pages->the_post();
        $choices[$post->ID] = $post->post_title;
      }
      wp_reset_postdata();
    }
    return $choices;
  }
}
