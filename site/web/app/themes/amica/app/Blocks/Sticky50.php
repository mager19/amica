<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\FolderTab;
use App\Fields\Partials\ShowNumbers;
require_once __DIR__ . '/../../functions/definitions.php';

class Sticky50 extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Sticky 50';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Two column layout with an item list in one column and a general description in the other.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'interactive-content';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
      <rect x="1" y="1" width="12" height="22" fill="black"/>
      <rect x="2" y="6" width="9" height="3" fill="white"/>
      <rect x="2" y="10" width="9" height="1" fill="white"/>
      <rect x="2" y="12" width="9" height="1" fill="white"/>
      <rect x="14" y="4" width="8" height="1" fill="black"/>
      <rect x="14" y="11" width="8" height="1" fill="black"/>
      <rect x="14" y="18" width="8" height="1" fill="black"/>
      <rect x="14" y="2" width="1" height="1" fill="black"/>
      <rect x="14" y="9" width="1" height="1" fill="black"/>
      <rect x="14" y="16" width="1" height="1" fill="black"/>
      <rect x="2" y="14" width="9" height="1" fill="white"/>
      <rect x="14" y="6" width="8" height="1" fill="black"/>
      <rect x="14" y="13" width="8" height="1" fill="black"/>
      <rect x="14" y="20" width="8" height="1" fill="black"/>
      <rect x="2" y="16" width="5" height="2" fill="white"/>
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
        'align' => false,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => true,
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
      'layout'      => 'left',
      'background'  => 'white',
      'left_background' => 'white',
      'right_background' => 'white',
      'image'     => [ 
        'ID'  => 1,
        'url' => '/app/uploads/2023/09/image.png'
      ],
      'eyebrow'     => 'Eyebrow content',
      'headline'    => 'This is a headline',
      'card_subhead'     => 'A sub head is a strong',
      'copy'        => 'Lorem ipsum dolor sit amet consectetur. Ut tempus sit quam pellentesque justo viverra.',
      'cta'       => [
        'url'   => '#',
        'title' => 'Button action',
        'target' => '_self',
      ],
      'list'       => [],
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
          'layout'           => get_field('layout') ?: $this->example['layout'],
          'background'       => get_field('background') ?:  $this->example['background'],
          'left_background'  => $this->get_background_for_half('left'),
          'right_background' => $this->get_background_for_half('right'),
          'eyebrow'          => get_field('copy_eyebrow'),
          'headline'         => get_field('copy_headline'),
          'subhead'          => get_field('copy_subhead'),
          'copy'             => get_field('copy_copy'),
          'cta'              => get_field('copy_cta'),
          'list'             => get_field('list_list_items') ?: $this->example['list'],
          'show_numbers'     => get_field('show_numbers'),
          'folder_tab'       => get_field('folder_tab') !== NULL ? get_field('folder_tab') : false,
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $sticky50 = new FieldsBuilder('sticky50');

        $sticky50
          ->addTab('content side')
              ->addGroup('copy', [
                'wpml_cf_preferences' => 3,
                'layout'  => 'row',
              ])
                ->addFields($this->get(Copy::class))
              ->endGroup()

          ->addTab('list side')
            ->addGroup('list', [
              'wpml_cf_preferences' => 3,
              'layout'  => 'row',
            ])
              ->addRepeater('list_items', [
                'wpml_cf_preferences' => 3,
                'min' => 1,
                'layout' => 'row',
                'collapsed' => 'subhead'
              ])
                ->addImage('image', [
                  'wpml_cf_preferences' => 3,
                  'mime_type' => 'jpg, webp',
                  'instructions'  => 'Upload JPG or WebP images at 1280x640',
                  'preview_size' => 'wide',
                ])
                ->addFields($this->get(Copy::class))
                  ->removeField('eyebrow')
                  ->removeField('headline')
              ->endRepeater()
            ->endGroup()
          ->addTab('config')
            ->addRadio('layout', [
              'wpml_cf_preferences' => 1,
              'label' => 'Content Position',
              'layout' => 'horizontal',
              'choices' => [
                'left' => 'Left',
                'right' => 'Right',
              ]
            ])
            ->addSelect('background', COLOR_SELECT)
            ->addFields($this->get(FolderTab::class))
            ->addFields($this->get(ShowNumbers::class))

          ;

        return $sticky50->build();
    }

    private function get_background_for_half($direction) {
      if (!get_field('layout')) return $this->example[$direction . '_background'];
      return get_field('layout') === $direction ? 'var-background' : 'var-background-light';
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
