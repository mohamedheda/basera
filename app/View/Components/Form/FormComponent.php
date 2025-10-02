<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormComponent extends Component
{
    public $route;

    public $method;

    public $data;

    public $enctype;

    public function __construct($route, $method = 'POST', $data = null, $enctype = 'multipart/form-data')
    {
        $this->route = $route;
        $this->method = strtoupper($method);
        $this->data = $data;
        $this->enctype = $enctype;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.form-component');
    }
}
