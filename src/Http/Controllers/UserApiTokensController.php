<?php

namespace Hotwired\Hotstream\Http\Controllers;

use Hotwired\Hotstream\Hotstream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserApiTokensController
{
    public function index(Request $request)
    {
        return view('api-tokens.index', [
            'tokens' => $request->user()->tokens()->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('api-tokens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = $request->user()->createToken(
            $request->input('name'),
            Hotstream::validPermissions($request->input('permissions'))
        );

        return redirect()->route('api-tokens.index')
            ->with('status', __('API Token created.'))
            ->with('createdToken', encrypt(explode('|', $token->plainTextToken, 2)[1]));
    }

    public function show(Request $request, $tokenId)
    {
        $token = $request->user()->tokens()->findOrFail($tokenId);

        return view('api-tokens.show', [
            'token' => $token,
        ]);
    }

    public function edit(Request $request, $tokenId)
    {
        $token = $request->user()->tokens()->findOrFail($tokenId);

        return view('api-tokens.edit', [
            'token' => $token,
        ]);
    }

    public function update(Request $request, $tokenId)
    {
        $token = $request->user()->tokens()->findOrFail($tokenId);

        $token->update(['abilities' => Hotstream::validPermissions($request->input('permissions'))]);

        return redirect()->route('api-tokens.index')->with('status', __('Token permission updated.'));
    }

    public function destroy(Request $request, $tokenId)
    {
        $token = $request->user()->tokens()->findOrFail($tokenId);

        $token->delete();

        return redirect()->route('api-tokens.index')->with('status', __('Token deleted.'));
    }
}
