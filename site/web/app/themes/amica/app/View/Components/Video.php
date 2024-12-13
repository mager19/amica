<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Video extends Component
{

    public $video_embed;
    public $video_file;
    public $poster_file;
    public $captions_file;
    public $label;
    public $settings;

    public function __construct(
        $videoEmbed = null,
        $videoFile = null,
        $posterFile = null,
        $captionsFile = null,
        $label = null,
        $settings = [
            'ratio'       => '1920:1080',
            'controls'    => ['play-large', 'progress', 'mute'],
            'fullscreen'  => [
                'enabled' => false,
            ],
            'vimeo'       => [
                'controls' => false,
            ]
        ]
    )
    {
        $this->video_file = $videoFile;
        $this->poster_file = $posterFile;
        $this->captions_file = $captionsFile;
        $this->video_embed = $videoEmbed;
        $this->label = $label;
        $this->settings = $settings;
    }

    public function render()
    {
        return $this->view('components.video');
    }
}
