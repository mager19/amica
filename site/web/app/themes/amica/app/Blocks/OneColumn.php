<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\FolderTab;
require_once __DIR__ . '/../../functions/definitions.php';

class OneColumn extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'One Column';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add some eye-grabbing text in one column';

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
  public $icon =  '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
    <rect x="6" y="7" width="12" height="3" fill="black"/>
    <rect x="2" y="11" width="20" height="1" fill="black"/>
    <rect x="5" y="13" width="14" height="1" fill="black"/>
    <rect x="4" y="15" width="16" height="1" fill="black"/>
    <rect x="9" y="17" width="6" height="2" fill="black"/>
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
    'layout'     => 'left',
    'image'      => [ 'ID' => 1 ],
    'eyebrow'    => 'Eyebrow',
    'headline'   => 'Headline',
    'subhead'    => 'Subhead',
    'copy'       => 'Copy',
    'cta'        => [
      'url'    => '#',
      'title'  => 'Button Action',
      'target' => '_self',
    ],
    'background' => 'white',
  ];

  public function with()
  {
    return [
      'layout'           => get_field('layout') ?: $this->example['layout'],
      'background'       => get_field('text_color') !== NULL ? get_field('text_color') : $this->example['background'],
      'eyebrow'          => get_field('text_eyebrow') !== NULL ? get_field('text_eyebrow') : $this->example['eyebrow'],
      'headline'         => get_field('text_headline') !== NULL ? get_field('text_headline') : $this->example['headline'],
      'subhead'          => get_field('text_subhead') !== NULL ? get_field('text_subhead') : $this->example['subhead'],
      'copy'             => get_field('text_copy') !== NULL ? get_field('text_copy') : $this->example['copy'],
      'cta'              => get_field('text_cta') !== NULL ? get_field('text_cta') : $this->example['cta'],
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
    $one_column = new FieldsBuilder('one_column');

    $one_column
      ->addRadio('layout', [
        'wpml_cf_preferences' => 1,
        'label' => 'Text Position',
        'layout' => 'horizontal',
        'choices' => [
          'left' => 'Left',
          'center' => 'Center',
        ]
      ])
      ->addSelect('text_color', COLOR_SELECT)
      ->addGroup('text', [
        'wpml_cf_preferences' => 3,
      ])
        ->addFields($this->get(Copy::class))
      ->endGroup()

      ->addFields($this->get(FolderTab::class))
     
      ;

    return $one_column->build();
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
