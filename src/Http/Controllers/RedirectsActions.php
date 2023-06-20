<?php

namespace HotwiredLaravel\Hotstream\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

trait RedirectsActions
{
    /**
     * Gets the redirect response for the given action.
     */
    public function redirectPath($action): Response|RedirectResponse
    {
        if (method_exists($action, 'redirectTo')) {
            $response = $action->redirectTo();
        } else {
            $response = property_exists($action, 'redirectTo')
                ? $action->redirectTo
                : config('fortify.home');
        }

        return $response instanceof Response ? $response : redirect($response);
    }
}
