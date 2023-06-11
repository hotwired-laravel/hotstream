<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Hotstream;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TermsOfServiceController extends Controller
{
    public function show(): View
    {
        $termsFile = Hotstream::localizedMarkdownPath('terms.md');

        return view('terms', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
