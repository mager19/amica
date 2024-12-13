<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\TwoColumns as TwoColumnsPartial;

class TwoColumns extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Two Columns';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add content in two columns.';

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
    <rect x="2" y="6" width="9" height="3" fill="black"/>
    <rect x="2" y="10" width="9" height="1" fill="black"/>
    <rect x="2" y="12" width="9" height="1" fill="black"/>
    <rect x="2" y="14" width="9" height="1" fill="black"/>
    <rect x="2" y="16" width="5" height="2" fill="black"/>
    <rect x="12" y="6" width="10" height="12" fill="black"/>
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
    'image'     => [ 
      'ID'  => 1,
      'url' => '/app/uploads/2023/09/image.png'
    ],
    'eyebrow'     => 'Eyebrow content',
    'headline'    => 'This is a headline',
    'subhead'     => 'A sub head is a strong',
    'copy'        => 'Body copy goes here.',
    'cta'       => [
      'url'   => '#',
      'title' => 'Button action',
      'target' => '_self',
    ],
    'background'   => 'white',
  ];

  public function with()
  {
    return [
      'layout'           => get_field('layout') ?: $this->example['layout'],
      'background'       => get_field('background') ?:  $this->example['background'],
      // 'left_background'  => $this->get_background_for_half('left'),
      // 'right_background' => $this->get_background_for_half('right'),
      'eyebrow'          => get_field('text_eyebrow') !== NULL ? get_field('text_eyebrow') : $this->example['eyebrow'],
      'headline'         => get_field('text_headline') !== NULL ? get_field('text_headline') : $this->example['headline'],
      'subhead'          => get_field('text_subhead') !== NULL ? get_field('text_subhead') : $this->example['subhead'],
      'copy'             => get_field('text_copy') !== NULL ? get_field('text_copy') : $this->example['copy'],
      'cta'              => get_field('text_cta') !== NULL ? get_field('text_cta') : $this->example['cta'],
      'image'            => get_field('media_image') ?: $this->example['image'],
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $two_columns = new FieldsBuilder('two_columns');

    $two_columns
      ->addFields($this->get(TwoColumnsPartial::class));

    return $two_columns->build();
  }
  
  private function get_background_for_half($direction) {
    // logic for list repeater
    // if (!get_field('layout')) return $this->example[$direction . '_background'];
    // return get_field('layout') === $direction ? 'var-background-light' : 'var-background';
    $bg = 'var-background';

    return $bg;
    // return get_field('layout') === $direction ? 'var-background-light' : 'var-background';
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
