<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class ShowNumbers extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $folderTab = Builder::make('show_numbers');

        $folderTab
            ->addTrueFalse('show_numbers', [
                'label' => 'Show index number?',
                'ui'  => 1,
            ])
            ;

        return $folderTab;
    }
}
