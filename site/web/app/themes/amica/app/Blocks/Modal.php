<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CTAFull as CTAFullPartial;

class Modal extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Modal';
  
  /**
   * The block title.
   *
   * @var string
   */
  public $title = 'Modal';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'An intrusive popup to be used as a last resort.';

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
    <rect x="2" y="3" width="20" height="18" fill="black"/>
    <rect x="5" y="10" width="14" height="1" fill="white"/>
    <rect width="1" height="2" transform="matrix(-1 0 0 1 21 4)" fill="white"/>
    <rect width="1" height="1" transform="matrix(-1 0 0 1 21 7)" fill="white"/>
    <rect x="4" y="12" width="16" height="1" fill="white"/>
    <rect x="9" y="14" width="6" height="2" fill="white"/>
    <rect x="0.5" y="0.5" width="23" height="23" fill="none" stroke="black"/>
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
    'align' => true,
    'align_text' => false,
    'align_content' => false,
    'full_height' => false,
    'anchor' => false,
    'mode' => false,
    'multiple' => false,
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
    'background_type' => 'color',
    'height'          => 'auto',
    'background'      => 'white',
    'eyebrow'         => 'Eyebrow',
    'headline'        => 'Headline',
    'subhead'         => 'Subhead type copy goes here.',
    'cta'             => [
      'url'    => '#',
      'title'  => 'Button action',
      'target' => '_self',
    ],
  ];

  public function with()
  {
    return [
      'background_type'  => get_field('background_type') ?: $this->example['background_type'],
      'height'           => get_field('height') ?: $this->example['height'],
      'video'            => get_field('background_type') === 'video' ? get_field('video') : false,
      'image'            => get_field('background_type') === 'image' ? get_field('image') : false,
      'background'       => get_field('color'),
      'eyebrow'          => get_field('eyebrow'),
      'headline'         => get_field('headline'),
      'subhead'          => get_field('subhead'),
      'type'             => 'onload',
      'cta'              => null,
      'alt_cta'          => get_field('cta'),
      'confirm_cta'      => get_field('confirm_cta'),
      'settings'         => $this->plyrSettings(),
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $modal = new FieldsBuilder('modal');

    $modal
      ->addFields($this->get(CTAFullPartial::class))
        ->modifyField('cta', [
          'label' => 'Fallback Call to Action'
        ])
      ->addText('confirm_cta', [
        'label' => 'Confirmation button',
        'default_value' => 'I am not',
        'required' => true
      ])
      ;
    return $modal->build();
  }

  public function plyrSettings() {
    return [
        'autoplay'  => true,
        'ratio'     => '',
        'controls'  => [],
        'loop'      => (object) array('active'  => true),
        'vimeo'     => [
            'controls' => false,
        ]
    ];
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
