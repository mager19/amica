<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;

class CampaignHero extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Campaign Hero';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Campaign Hero block for the top of the Home page only.';

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
        'background' => 'white',
        'image'     => [ 
            'ID'  => 1,
            'url' => '/app/uploads/2023/09/image.png'
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
            'background'       => get_field('background') ?: $this->example['background'],
            'image'            => get_field('image') !== NULL ? get_field('image') : $this->example['image'],
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $campaignHero = new FieldsBuilder('campaign_hero');
        $campaignHero
            ->addSelect('background', COLOR_SELECT)
            ->addImage('image', [
                'wpml_cf_preferences' => 3,
                'mime_type' => 'jpg, webp',
                'instructions'  => 'Upload JPG or WebP images at 1280x1570 if Text Position is Left or Right, or 2880x2400 if Text Position is Full.',
                'preview_size' => 'thumbnail',
            ]);
        return $campaignHero->build();
    }

    /**
     * Return the items field.
     *
     * @return array
     */
    public function items()
    {
        return get_field('items') ?: $this->example['items'];
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
