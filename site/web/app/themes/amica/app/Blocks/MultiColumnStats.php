<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\FolderTab;
require_once __DIR__ . '/../../functions/definitions.php';

class MultiColumnStats extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Multi-Column Stats';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add up to 4 static columns of text with an eye-grabbing statistic above';

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
    <rect x="2" y="12" width="6" height="1" fill="black"/>
    <rect x="2" y="10" width="1" height="1" fill="black"/>
    <rect x="3" y="9" width="1" height="1" fill="black"/>
    <rect x="4" y="8" width="1" height="1" fill="black"/>
    <rect x="5" y="7" width="1" height="1" fill="black"/>
    <rect x="6" y="6" width="1" height="1" fill="black"/>
    <rect x="7" y="5" width="1" height="1" fill="black"/>
    <rect x="17" y="6" width="1" height="1" fill="black"/>
    <rect x="16" y="7" width="1" height="1" fill="black"/>
    <rect x="20" y="7" width="1" height="1" fill="black"/>
    <rect x="19" y="6" width="1" height="1" fill="black"/>
    <rect x="7" y="10" width="1" height="1" fill="black"/>
    <rect x="10" y="5" width="1" height="6" fill="black"/>
    <rect x="15" y="6" width="1" height="6" transform="rotate(90 15 6)" fill="black"/>
    <rect x="15" y="9" width="1" height="6" transform="rotate(90 15 9)" fill="black"/>
    <rect x="19" y="5" width="6" height="1" transform="rotate(90 19 5)" fill="black"/>
    <rect x="13" y="5" width="1" height="6" fill="black"/>
    <rect x="2" y="5" width="1" height="1" fill="black"/>
    <rect x="2" y="6" width="1" height="1" fill="black"/>
    <rect x="3" y="6" width="1" height="1" fill="black"/>
    <rect x="3" y="5" width="1" height="1" fill="black"/>
    <rect x="6" y="10" width="1" height="1" fill="black"/>
    <rect x="6" y="9" width="1" height="1" fill="black"/>
    <rect x="7" y="9" width="1" height="1" fill="black"/>
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
    'headline' => 'This is a headline',
    'columns'       => false,
    'columns_count' => false,
  ];

  public function with()
  {
    $columns = get_field('columns');
    return [
      'background'       => get_field('color') ?: $this->example['background'],
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
    $multi_column_stats = new FieldsBuilder('multi_column_stats');

    $multi_column_stats
      ->addTab('content')
        ->addFields($this->get(Copy::class))

      ->addTab('columns')
        ->addRepeater('columns', [
          'wpml_cf_preferences' => 3,
          'layout' => 'row',
          'min' => 2,
          'max' => 4,
        ])
          ->addText('stat', [
            'wpml_cf_preferences' => 2,
            'maxlength' => 6,
          ])
          ->addFields($this->get(Copy::class))
          ->removeField('headline')
          ->removeField('eyebrow')
        ->endRepeater()

      ->addTab('config')
        ->addSelect('color', COLOR_SELECT)
        ->addFields($this->get(FolderTab::class))
      ;

    return $multi_column_stats->build();
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
