<?php

namespace App\View\Components\Editor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Summernote extends Component
{
    public $id;

    public $label;

    public $name;

    public $value;

    public function __construct($id = 'summernote', $label = 'note', $name = 'content', $value = '')
    {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
    }

    public function render(): View|Closure|string
    {
        return view('components.editor.summernote');
    }
}
