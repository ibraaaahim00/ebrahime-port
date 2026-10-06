<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        return view('admin.account.edit', ['account' => request()->user()]);
    }

    public function update(UpdateAccountRequest $request): RedirectResponse
    {
        $account = $request->user();
        $data = $request->safe()->only(['name', 'email']);

        if ($request->filled('new_password')) {
            $data['password'] = $request->string('new_password')->toString();
        }

        $account->forceFill($data)->save();
        $request->session()->regenerate();

        return back()->with('success', __('ui.account_updated'));
    }
}
