<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputField extends Component
{
    public $name;

    public $type;

    public $label;

    public $placeholder;

    public $value;

    public $class;

    public $id;

    public $required;

    public $wrapperClass;

    public function __construct($name, $type = 'text', $label = '', $placeholder = '', $value = '', $class = '', $id = '', $required = false, $wrapperClass = 'col-md-6 mb-3')
    {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->class = $class;
        $this->id = $id;
        $this->wrapperClass = $wrapperClass;
        $this->required = $required;
    }

    public function render(): View|Closure|string
    {
        return view('components.input.input-field');
    }
}
