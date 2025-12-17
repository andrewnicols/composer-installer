<?php

namespace Moodle\Composer;

abstract class DataProvider
{
    /**
     * A mapping of plugin type to installation location.
     *
     * @return array<string, string>
     */
    abstract function getData(): array;
}
