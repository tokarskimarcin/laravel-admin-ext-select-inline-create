<?php

namespace Encore\SelectInlineCreate;

use Encore\Admin\Extension;

class SelectInlineCreate extends Extension
{
    public $name = 'select-inline-create';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $translations = __DIR__ . '/../resources/lang';


    /**
     * Get the path of translation files.
     *
     * @return string
     */
    public function translations(){
        return $this->translations;
    }
}
