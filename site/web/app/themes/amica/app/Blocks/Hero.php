<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class Hero extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Hero';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add a hero block at the top of your page. Only one per page is allowed.';

  /**
   * The block category.
   *
   * @var string
   */
  public $category = 'basic-content';

  /**
   * The block icon.
   *
   * @var string|array
   */
  public $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
    <rect x="2" y="2" width="20" height="13" fill="black"/>
    <rect x="5" y="4" width="14" height="3" fill="white"/>
    <rect x="5" y="8" width="14" height="1" fill="white"/>
    <rect x="5" y="11" width="7" height="2" fill="white"/>
    <rect x="19" y="18" width="1" height="3" fill="black"/>
    <rect x="17" y="18" width="1" height="1" fill="black"/>
    <rect x="21" y="18" width="1" height="1" fill="black"/>
    <rect x="20" y="21" width="1" height="1" fill="black"/>
    <rect x="18" y="21" width="1" height="1" fill="black"/>
    <rect x="18" y="19" width="3" height="1" fill="black"/>
    <rect x="0.5" y="0.5" width="23" height="23" stroke="currentColor" fill="none"/>
  </svg>';

  /**
   * The block keywords.
   *
   * @var array
   */
  public $keywords = [];

  /**
   * The block post type allow list.
   *
   * @var array
   */
  public $post_types = ['page'];

  /**
   * The parent block type allow list.
   *
   * @var array
   */
  public $parent = [];

  /**
   * The default block mode.
   *
   * @var string
   */
  public $mode = 'preview';

  /**
   * The default block alignment.
   *
   * @var string
   */
  public $align = '';

  /**
   * The default block text alignment.
   *
   * @var string
   */
  public $align_text = '';

  /**
   * The default block content alignment.
   *
   * @var string
   */
  public $align_content = '';

  /**
   * The supported block features.
   *
   * @var array
   */
  public $supports = [
    'align' => false,
    'align_text' => false,
    'align_content' => false,
    'full_height' => false,
    'anchor' => false,
    'mode' => false,
    'multiple' => true,
    'jsx' => true,
  ];

  /**
   * The block styles.
   *
   * @var array
   */
  public $styles = [];

  /**
   * The block preview example data.
   *
   * @var array
   */
  public $example = [
    'layout'    => 'left',
    'background' => 'white',
    'image'     => [ 
      'ID'  => 1,
      'url' => '/app/uploads/2023/09/image.png'
    ],
    'eyebrow'     => null,
    'headline'    => null,
    'subhead'     => null,
    'copy'     => '',
    'cta'       => null
  ];

  public function with()
  {
    return [
      'layout'           => get_field('layout') ?: $this->example['layout'],
      'background'       => get_field('background') ?: $this->example['background'],
      'eyebrow'          => get_field('eyebrow') !== NULL ? get_field('eyebrow') : $this->example['eyebrow'],
      'headline'         => get_field('headline') !== NULL ? get_field('headline') : $this->example['headline'],
      'subhead'            => get_field('subhead') !== NULL ? get_field('subhead') : $this->example['subhead'],
      'copy'             => get_field('copy') !== NULL ? get_field('copy') : $this->example['subhead'],
      'cta'              => get_field('cta') !== NULL ? get_field('cta') : $this->example['cta'],
      'image'            => get_field('image') !== NULL ? get_field('image') : $this->example['image'],
      'folder_tab'      => get_field('folder_tab') !== NULL ? get_field('folder_tab') : false,
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $hero = new FieldsBuilder('hero');
    $hero
      ->addText('eyebrow', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 250
      ])
        ->conditional('layout', '==', 'left')
          ->or('layout', '==', 'right')
          ->or('layout', '==', 'contained')
      ->addText('headline', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 250
      ])
      ->addText('subhead', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 800
      ])
        ->conditional('layout', '!=', 'overlay-contained')
      ->addTextarea('copy', [
        'wpml_cf_preferences' => 2,
        'rows'  => 4,
        'new_lines' => 'wpautop'
      ])
        ->conditional('layout', '!=', 'left')
          ->and('layout', '!=', 'right')
          ->and('layout', '!=', 'contained')
      ->addLink('cta', [
        'wpml_cf_preferences' => 2,
        'label' => 'Call to Action',
      ])
        ->conditional('layout', '!=', 'overlay-contained')

      ->addRadio('layout', [
        'wpml_cf_preferences' => 1,
        'label' => 'Layout',
        'layout' => 'vertical',
        'choices' => [
          'left' => 'Text Left',
          'right' => 'Text Right',
          'contained' => 'Contained',
          'megatext' => 'Megatext',
          'folder' => 'Folder',
          'overlay-contained' => 'Overlay Contained',
          'overlay-full' => 'Overlay Full',
          'overlay-megatext' => 'Overlay Megatext',
        ],
        'default_value' => 'left',
      ])
      ->addSelect('background', COLOR_SELECT)
      ->addImage('image', [
        'wpml_cf_preferences' => 3,
        'mime_type' => 'jpg, webp',
        'instructions'  => 'Upload JPG or WebP images at 1280x1570 if Text Position is Left or Right, or 2880x2400 if Text Position is Full.',
        'preview_size' => 'thumbnail',
      ])
        ->conditional('layout', '!=', 'contained')
          ->and('layout', '!=', 'megatext')

      ->addTrueFalse('folder_tab', [
        'label' => 'Display tab?',
        'ui'  => 1,
      ])
        ->conditional('layout', '==', 'megatext')
          ->or('layout', '==', 'overlay-contained')
      ;

    return $hero->build();
  }

  /**
   * Assets to be enqueued when rendering the block.
   *
   * @return void
   */
  public function enqueue()
  {
    //
  }
}
