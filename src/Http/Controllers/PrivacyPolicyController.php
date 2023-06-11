<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Hotstream;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PrivacyPolicyController extends Controller
{
    public function show(): View
    {
        $policyFile = Hotstream::localizedMarkdownPath('policy.md');

        return view('policy', [
            'policy' => Str::markdown(file_get_contents($policyFile)),
        ]);
    }
}
