<?php

namespace HotwiringLaravel\Hotstream\Http\Controllers;

use HotwiringLaravel\Hotstream\Hotstream;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PrivacyPolicyController
{
    public function show(): View
    {
        $policyFile = Hotstream::localizedMarkdownPath('policy.md');

        return view('policy', [
            'policy' => Str::markdown(file_get_contents($policyFile)),
        ]);
    }
}
