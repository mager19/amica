<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BrandOptions extends Field {
  public $name = 'Brand';
  public $slug = 'brand-options';
  public $parent = 'site-options';
  public $title = 'Brand | Site Options';
  public $redirect = false;
  public $description = 'Use this page to set brand values.';
  public $capability = 'edit_posts';
  public $post = 'brand';

  /**
   * The option page field group.
   *
   * @return array
   */
  public function fields() {
    $brand_options = new FieldsBuilder('brand_options');

    $brand_options
      ->addGroup('default_images', [
          'wpml_cf_preferences' => 3,
          'layout'    => 'row'
      ])
        ->addImage('post_thumbnail', [
          'wpml_cf_preferences' => 2,
          'mime_type' => 'jpg, webp',
        ])
      ->endGroup()
      ->addGroup('socials', [
            'wpml_cf_preferences' => 3,
            'layout'    => 'row'
          ])
          ->addUrl('Instagram', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://www.instagram.com/username',
          ])
          ->addUrl('TikTok', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://tiktok.com/@username',
          ])
          ->addUrl('LinkedIn', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://www.linkedin.com/in/username',
          ])
          ->addUrl('Facebook', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://www.facebook.com/username',
          ])
          ->addUrl('Threads', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://threads.net/@username',
          ])
          ->addUrl('Twitter', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://twitter.com/username',
              'instructions'  => 'Twitter Bird logo',
          ])
          ->addUrl('X', [
              'wpml_cf_preferences' => 1,
              'label'         => 'X',
              'placeholder'   => 'https://twitter.com/username',
              'instructions'  => 'X logo',
          ])
          ->addUrl('YouTube', [
              'wpml_cf_preferences' => 1,
              'placeholder'   => 'https://youtube.com/@username',
          ])
          ->addRepeater('other', [
              'wpml_cf_preferences' => 3,

          ])
              ->addText('name', [
                  'wpml_cf_preferences' => 2,
              ])
              ->addUrl('url', [
                  'wpml_cf_preferences' => 2,
              ])
              ->addText('icon', [
                  'wpml_cf_preferences' => 2,
                  'instructions' => 'Find values on <a href="https://fontawesome.com/icons">fontawesome.com/icons</a>. Use <code>fas</code> for fa-solid and <code>fab</code> for fa-brand.<br>e.g. <code>fas fa-sailboat</code>'
              ])
          ->endRepeater()
      ->endGroup();


    return $brand_options->build();
  }
}
