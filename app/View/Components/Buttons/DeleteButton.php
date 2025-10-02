<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteButton extends Component
{
    public string $route;

    public string $itemId;

    public function __construct(string $route, string $itemId)
    {
        $this->route = $route;
        $this->itemId = $itemId;
    }

    public function render(): View|Closure|string
    {
        return view('components.buttons.delete-button');
    }
}
