@extends('layouts.admin', ['title' => __('ui.settings')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.system') }}</p><h1>{{ __('ui.site_settings') }}</h1></div></div>
<form class="admin-card form-grid" method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
@foreach($settings as $group => $items)
    <h2 class="full">{{ __('ui.group_'.$group) }}</h2>
    @foreach($items as $setting)
        @if(in_array($setting->key, ['logo_path', 'favicon_path', 'og_image']))
            <label>{{ __('ui.setting_'.$setting->key) }}<input type="file" name="{{ $setting->key === 'og_image' ? 'og_image' : str_replace('_path', '', $setting->key) }}" accept="image/*"></label>
        @else
            <label>{{ __('ui.setting_'.$setting->key) }}<input name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"></label>
            @if(data_get($setting->translations ?? [], 'ar.value') !== null)
                <label>{{ __('ui.setting_arabic_version') }}<input dir="rtl" name="translations[ar][{{ $setting->key }}]" value="{{ data_get($setting->translations, 'ar.value') }}"></label>
            @endif
        @endif
    @endforeach
@endforeach
<div class="form-actions"><button class="btn" type="submit">{{ __('ui.save_settings') }}</button></div></form>
@endsection
