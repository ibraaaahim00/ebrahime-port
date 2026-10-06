@extends('layouts.admin', ['title' => __('ui.account')])

@section('content')
<div class="toolbar">
    <div>
        <p class="eyebrow">{{ __('ui.system') }}</p>
        <h1>{{ __('ui.account_title') }}</h1>
        <p class="muted">{{ __('ui.account_description') }}</p>
    </div>
</div>

<form class="admin-card form-grid" method="POST" action="{{ route('admin.account.update') }}">
    @csrf
    @method('PUT')

    <label>
        {{ __('ui.name') }}
        <input type="text" name="name" value="{{ old('name', $account->name) }}" autocomplete="name" required>
    </label>

    <label>
        {{ __('ui.email') }}
        <input type="email" name="email" value="{{ old('email', $account->email) }}" autocomplete="email" required>
    </label>

    <div class="full account-security-note">
        <strong>{{ __('ui.account_security_title') }}</strong>
        <span>{{ __('ui.account_security_description') }}</span>
    </div>

    <label>
        {{ __('ui.current_password') }}
        <input type="password" name="current_password" autocomplete="current-password" required>
    </label>

    <label>
        {{ __('ui.new_password') }}
        <input type="password" name="new_password" autocomplete="new-password" minlength="12">
    </label>

    <label>
        {{ __('ui.confirm_new_password') }}
        <input type="password" name="new_password_confirmation" autocomplete="new-password" minlength="12">
    </label>

    <div class="form-actions">
        <button class="btn" type="submit">{{ __('ui.save_account') }}</button>
    </div>
</form>
@endsection
