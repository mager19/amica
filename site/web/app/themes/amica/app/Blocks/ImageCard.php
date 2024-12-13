<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class ImageCard extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Image Card';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Cards with image block.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'action-modules';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
    <rect x="13" y="3" width="8" height="13" fill="black"/>
    <rect x="16" y="18" width="5" height="3" fill="black"/>
    <rect x="3" y="3" width="8" height="13" fill="black"/>
    <rect x="14" y="12" width="6" height="1" fill="white"/>
    <rect x="4" y="12" width="6" height="1" fill="white"/>
    <rect x="14" y="14" width="6" height="1" fill="white"/>
    <rect x="4" y="14" width="6" height="1" fill="white"/>
    <rect x="18" y="19" width="1" height="1" fill="white"/>
    <rect x="19" y="17" width="1" height="1" fill="black"/>
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
        'background'            => false,
        'headline'              => 'This is a headline',
        'is_image_background'   => false,
        'image_background'      => false,
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'is_image_background'   => get_field('is_image_background'),
            'image_background'      => get_field('image_background'),
            'background'            => get_field('color') ?: $this->example['background'],
            'eyebrow'               => get_field('eyebrow'),
            'headline'              => get_field('headline'),
            'block_headline'        => get_field('headline') ?: get_field('card')['headline'],
            'card'                  => get_field('card'),
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $imageCard = new FieldsBuilder('image_card', [
            'label_placement'   => 'left'
        ]);

        $imageCard
            ->addTab('outer_content')
                ->addSelect('color', COLOR_SELECT)
                ->addFields($this->get(Copy::class))
                    ->removeField('subhead')
                    ->removeField('copy')
                    ->removeField('cta')
                ->addTrueFalse('is_image_background', [
                    'wpml_cf_preferences' => 1,
                    'label' => 'Background with image',
                    'ui' => 1,
                ])
                ->addImage('image_background', [
                    'wpml_cf_preferences' => 3,
                    'mime_type' => 'jpg, webp',
                    'instructions'  => 'Upload JPG or WebP images at 2880x2400.',
                    'preview_size' => 'medium',
                ])
                    ->conditional('is_image_background', '==', 1)
            ->addTab('inner_content')
                ->addGroup('card', [
                    'layout'    => 'row'
                ])
                    ->addFields($this->get(Copy::class))
                        ->removeField('subhead')
                        ->modifyField('headline', [
                            'required' => true,
                            'default_value' => ""
                        ])
                    ->addImage('image_foreground', [
                        'wpml_cf_preferences' => 3,
                        'mime_type' => 'jpg, webp',
                        'instructions'  => 'Upload JPG or WebP images at 1280x1420.',
                        'preview_size' => 'thumbnail',
                    ])
                ->endGroup()
            ;

        return $imageCard->build();
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
