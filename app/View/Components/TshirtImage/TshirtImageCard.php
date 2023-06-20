<?php

namespace App\View\Components\TshirtImage;

use Illuminate\View\Component;

class TshirtImageCard extends Component
{
    public $tshirtImage;

    public function __construct($tshirtImage)
    {
        $this->tshirtImage = $tshirtImage;
    }
    
    public function render()
    {
        
        return view('components.tshirtImages.tshirtImage-card');
    }
}
