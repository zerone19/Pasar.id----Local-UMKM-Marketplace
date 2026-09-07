<?php

namespace App\View\Components;

use App\Models\Store;
use Illuminate\View\Component;
use Illuminate\View\View;

class SellerLayout extends Component
{
    public ?Store $store;

    public function __construct()
    {
        $this->store = Store::where('user_id', auth()->id())->first();
    }

    public function render(): View
    {
        return view('layouts.seller');
    }
}
