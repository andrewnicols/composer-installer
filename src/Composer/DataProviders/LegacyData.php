<?php

namespace Moodle\Composer\DataProviders;

class LegacyData extends \Moodle\Composer\DataProvider
{
    /**
     * {@inheritDoc}
     */
    function getData(): array
    {
        return [
            // Legacy plugin and subplugin types which may be installed manually.
            'atto'               => '{$prefix}{$public}lib/editor/atto/plugins/{$name}/',
            'assignment'         => '{$prefix}{$public}mod/assignment/type/{$name}/',
            'tinymce'            => '{$prefix}{$public}lib/editor/tinymce/plugins/{$name}/',
        ];
    }
}
