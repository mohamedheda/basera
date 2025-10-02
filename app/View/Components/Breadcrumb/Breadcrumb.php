<?php

namespace App\View\Components\Breadcrumb;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title;

    public $breadcrumbs;

    public function __construct($title, $breadcrumbs = [])
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render(): View|Closure|string
    {
        return view('components.breadcrumb.breadcrumb');
    }
}
