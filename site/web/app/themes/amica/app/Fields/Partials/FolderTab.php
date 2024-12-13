<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Partial;

class FolderTab extends Partial
{
    /**
     * The partial field group.
     */
    public function fields(): Builder
    {
        $folderTab = Builder::make('folder_tab');

        $folderTab
            ->addTrueFalse('folder_tab', [
                'label' => 'Display folder tab above section?',
                'ui'  => 1,
            ])
            ;

        return $folderTab;
    }
}
