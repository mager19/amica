<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\FolderTab;
require_once __DIR__ . '/../../functions/definitions.php';

class MultiColumn extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Multi-Column';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add up to 4 static columns of text with an optional image above';

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
    <rect x="2" y="4" width="6" height="7" fill="black"/>
    <rect x="9" y="4" width="6" height="7" fill="black"/>
    <rect x="16" y="4" width="6" height="7" fill="black"/>
    <rect x="2" y="12" width="6" height="1" fill="black"/>
    <rect x="9" y="12" width="6" height="1" fill="black"/>
    <rect x="16" y="12" width="6" height="1" fill="black"/>
    <rect x="2" y="14" width="6" height="1" fill="black"/>
    <rect x="9" y="14" width="6" height="1" fill="black"/>
    <rect x="16" y="14" width="6" height="1" fill="black"/>
    <rect x="2" y="16" width="6" height="1" fill="black"/>
    <rect x="9" y="16" width="6" height="1" fill="black"/>
    <rect x="16" y="16" width="6" height="1" fill="black"/>
    <rect x="2" y="18" width="3" height="2" fill="black"/>
    <rect x="9" y="18" width="3" height="2" fill="black"/>
    <rect x="16" y="18" width="3" height="2" fill="black"/>
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
  public $mode = 'auto';

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
    'background'    => false,
    'has_image'     => false,
    'has_border'     => false,
    'headline'      => 'This is a headline',
    'columns'       => false,
    'columns_count' => false,
  ];

  public function with()
  {
    $columns = get_field('columns');
    return [
      'background'       => get_field('color') ?: $this->example['background'],
      'has_image'        => get_field('has_image') ?: $this->example['has_image'],
      'has_border'       => get_field('has_border') ?: $this->example['has_border'],
      'eyebrow'          => get_field('eyebrow'),
      'headline'         => get_field('headline'),
      'subhead'          => get_field('subhead'),
      'copy'             => get_field('copy'),
      'cta'              => get_field('cta'),
      'columns'          => $columns ?: $this->example['columns'],
      'columns_count'    => is_array($columns) ? count($columns) : 0,
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
    $multi_column = new FieldsBuilder('multi_column');

    $multi_column
      ->addTab('content')
        ->addFields($this->get(Copy::class))

      ->addTab('columns')
        ->addRepeater('columns', [
          'wpml_cf_preferences' => 3,
          'collapsed' => 'headline',
          'layout' => 'row',
          'min' => 2,
          'max' => 4,
        ])
          ->addImage('image', [
            'wpml_cf_preferences' => 3,
            'mime_type' => 'jpg, webp',
            'instructions'  => 'Upload JPG or WebP images at 8x5.',
            'preview_size'  => 'thumbnail',
          ])
            ->conditional('has_image', '==', 1)
          ->addFields($this->get(Copy::class))
          ->removeField('eyebrow')
        ->endRepeater()

      ->addTab('config')
        ->addSelect('color', COLOR_SELECT)
        ->addFields($this->get(FolderTab::class))
        ->addTrueFalse('has_image', [
          'wpml_cf_preferences' => 1,
          'label' => 'With Images?',
          'ui' => 1,
        ])
        ->addTrueFalse('has_border', [
          'wpml_cf_preferences' => 1,
          'label' => 'Add divider?',
          'ui' => 1,
          'default_value' => 0
        ])
          ->conditional('has_image', '==', 0)
      ;

    return $multi_column->build();
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
