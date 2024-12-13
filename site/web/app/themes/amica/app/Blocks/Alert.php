<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\AlertBar;

class Alert extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Alert';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add an inline alert';

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
    <rect x="2" y="9" width="20" height="6" fill="black"/>
    <rect width="1" height="2" transform="matrix(-1 0 0 1 21 18)" fill="black"/>
    <rect width="1" height="1" transform="matrix(-1 0 0 1 21 21)" fill="black"/>
    <rect x="4" y="11" width="8" height="1" fill="white"/>
    <rect x="14" y="11" width="6" height="2" fill="white"/>
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
    'alert'          => true,
    'background'     => 'bedrock',
    'text'           => 'Alert Bar headline',
    'subtext'        => 'Subtext if you need to add more details and commentary to the alert.',
    'cta'       => [
      'url'   => '#',
      'title' => 'Button action',
      'target' => '_self',
    ],
  ];

  public function with()
  {
    return [
      'use'        => 'block',
      'alert'      => get_field('alert') ?: $this->example['alert'],
      'background' => get_field('alert_color') ?: $this->example['background'],
      'text'       => get_field('alert_text') ?: $this->example['text'],
      'subtext'    => get_field('alert_subtext'),
      'cta'        => get_field('alert_cta') ?: $this->example['cta'],
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $alert = new FieldsBuilder('alert');

    $alert
      ->addFields($this->get(AlertBar::class))
      ->modifyField('show_alert', [
        'wrapper' => [
            'class' => 'hidden',
        ],
        'default_value' => 'alert'
      ]
      );

    return $alert->build();
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
