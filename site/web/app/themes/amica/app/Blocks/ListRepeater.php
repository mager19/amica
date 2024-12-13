<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class ListRepeater extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'List Repeater';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'A block for listing a handful of short text items with an optional link for more info';

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
      <rect x="0.5" y="0.5" width="23" height="23" stroke="black"/>
      <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
      <rect x="3" y="4" width="5" height="1" fill="black"/>
      <rect x="3" y="14" width="5" height="1" fill="black"/>
      <rect x="9" y="4" width="12" height="1" fill="black"/>
      <rect x="9" y="14" width="12" height="1" fill="black"/>
      <rect x="9" y="6" width="12" height="1" fill="black"/>
      <rect x="9" y="16" width="12" height="1" fill="black"/>
      <rect x="9" y="9" width="6" height="2" fill="black"/>
      <rect x="9" y="19" width="6" height="2" fill="black"/>
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
      'background'  => 'white',
      'eyebrow'     => 'Eyebrow content',
      'headline'    => 'List Repeater Block',
      'subhead'     => 'A block for listing a handful of short text items with an optional link for more info',
      'copy'        => 'This block also has a decorative element on the side, or on the top on tablet and mobile.',
      'list'       => [
        [
          'headline' => "First item",
          'copy' => "Lorem ipsum dolor sit amet consectetur. A ipsum sollicitudin sagittis viverra adipiscing ipsum feugiat. Magna egestas bibendum dui eget turpis aliquet metus. Libero vel ut non integer arcu quis dui.",
          'cta' => false
        ]
      ],
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
          'background'       => get_field('background') ?:  $this->example['background'],
          'eyebrow'          => get_field('copy_eyebrow'),
          'headline'         => get_field('copy_headline'),
          'subhead'     => get_field('copy_subhead'),
          'copy'             => get_field('copy_copy'),
          'list'             => get_field('list_list_items') ?: $this->example['list'],
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
        $list_repeater = new FieldsBuilder('list_repeater');

        $list_repeater
          ->addTab('content')
            ->addSelect('background', COLOR_SELECT)
            ->addGroup('copy', [
              'wpml_cf_preferences' => 3,
              'layout'  => 'row',
            ])
              ->addFields($this->get(Copy::class))
                ->removeField('cta')
            ->endGroup()
            ->addTrueFalse('folder_tab', [
              'label' => 'Display tab?',
              'ui'  => 1,
            ])

          ->addTab('list items')
            ->addGroup('list', [
              'wpml_cf_preferences' => 3,
              'layout'  => 'row',
            ])
              ->addRepeater('list_items', [
                'wpml_cf_preferences' => 3,
                'min' => 1,
                'layout' => 'row',
                'collapsed' => 'headline'
              ])
                ->addFields($this->get(Copy::class))
                  ->modifyField('headline', [
                    'required' => true 
                  ])
                  ->removeField('eyebrow')
                  ->removeField('subhead')
              ->endRepeater()
            ->endGroup()
            
          ;

        return $list_repeater->build();
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
