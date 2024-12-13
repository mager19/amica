<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
require_once __DIR__ . '/../../functions/definitions.php';

class Video extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Video';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Video block.';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'formatting';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = 'video-alt3';

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
     * The block preview example data.
     *
     * @var array
     */
    public $example = [
        'video' => null,
        'background' => 'white',
        'headline' => 'Video Block Headline',
        'subhead' => null,
        'layout' => 'default',
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        $layout = get_field('layout') ?: $this->example['layout'];
        $video_file = get_field('video_file') ?: ['url' => false];
        $captions_file = get_field('captions_file') ?: ['url' => false];
        $poster_file = get_field('poster_file') ?: ['url' => false];
        return [
          'background'    => get_field('color') ?: $this->example['background'],
          'headline'      => get_field('headline') ?: null,
          'subhead'       => get_field('subhead') ?: null,
          'layout'        => $layout,
          'video_embed'   => get_field('video'),
          'video_file'    => $video_file['url'],
          'poster_file'   => $poster_file['url'],
          'captions_file' => $captions_file['url'],
          'settings'      => $this->plyrSettings($layout, !!get_field('video')),
          'is_headline_hidden'  => get_field('is_headline_hidden') !== NULL ? get_field('is_headline_hidden') : false,
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $video = new FieldsBuilder('video');

        $video
          ->addSelect('color', COLOR_SELECT)
          ->addText('headline', [
            'wpml_cf_preferences' => 2,
            'maxlength'           => 50,
            'required'            => true,
          ])
          ->addTrueFalse('is_headline_hidden', [
            'label' => 'Hide the headline?',
            'default_value' => false,
            'ui'  => 1,
          ])
          ->addText('subhead', [
            'wpml_cf_preferences' => 2,
            'maxlength'           => 50,
          ])
          ->addFile('video_file', [
              'wpml_cf_preferences' => 2,
              'mime_types'          => 'mp4',
          ])
          ->addFile('captions_file', [
            'wpml_cf_preferences' => 2,
          ])
          ->addImage('poster_file')
          ->addOembed('video', [
            'wpml_cf_preferences' => 2,
            'label'               => 'Link to fallback video',
          ])
          ->addRadio('layout', [
            'wpml_cf_preferences' => 1,
            'layout'              => 'horizontal',
            'choices'             => [
                'default'     => 'Embedded',
                'fullscreen'  => 'Fullscreen',
            ],
          ]);    //  Add image, file upload, and srt (caption) file upload.

        return $video->build();
    }

    public function plyrSettings($layout, $is_vimeo) {
    
        $type = false;

        if($layout === 'fullscreen') {
            $type = 'autoplay';
        }
        $settings = [
          // 'debug'     => true,
          'ratio'     => '16:9',
          'autoplay'  => false,
          'autopause' => $type !== 'autoplay',
          'loop'      => (object) array('active'  => $type === 'autoplay'),
          'controls'  => [
              'play', 'play-large', 'progress', 'mute', 'volume', 'captions',
          ],
          // 'muted' => $type == 'autoplay' ? true : false,
          // 'volume'    => $type === 'autoplay' ? 0 : 1
        ];
        if ($is_vimeo) {
          $settings['vimeo'] = [
            'controls' => false,
          ];
        }
        return $settings;
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
