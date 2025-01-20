<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Post;
use Filament\Forms\Components\ViewField;

class EditorButton extends ViewField
{
    public $record;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function render()
    {
        return view('components.editor-button', [
            'post' => $this->getRecord()
        ]);
    }
} 