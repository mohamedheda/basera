<?php

namespace App\View\Components\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageCard extends Component
{
    public $header;

    public $footer;

    public function __construct($header = null, $footer = null)
    {
        $this->header = $header;
        $this->footer = $footer;
    }

    public function render(): View|Closure|string
    {
        return view('components.cards.page-card');
    }
}
