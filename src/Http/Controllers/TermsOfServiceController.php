<?php

namespace HotwiredLaravel\Hotstream\Http\Controllers;

use HotwiredLaravel\Hotstream\Hotstream;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TermsOfServiceController
{
    public function show(): View
    {
        $termsFile = Hotstream::localizedMarkdownPath('terms.md');

        return view('terms', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
