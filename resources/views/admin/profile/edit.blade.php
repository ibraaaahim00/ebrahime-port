@extends('layouts.admin', ['title' => __('ui.profile')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.system') }}</p><h1>{{ __('ui.profile_title') }}</h1></div></div>
<form class="admin-card form-grid" method="POST" enctype="multipart/form-data" action="{{ route('admin.profile.update') }}">@csrf @method('PUT')
@foreach(['name','professional_title','status','email','phone','location','github_url','linkedin_url','facebook_url','instagram_url','whatsapp_url','hero_cta_text','hero_cta_url'] as $field)<label>{{ $field === 'status' ? __('ui.status_label') : __('ui.'.$field) }}<input name="{{ $field }}" value="{{ old($field, $profile->{$field}) }}"></label>@endforeach
<label class="full">{{ __('ui.short_bio') }}<textarea name="short_bio">{{ old('short_bio', $profile->short_bio) }}</textarea></label><label class="full">{{ __('ui.full_bio') }}<textarea name="full_bio">{{ old('full_bio', $profile->full_bio) }}</textarea></label>
<label>{{ __('ui.years_of_experience') }}<input type="number" name="years_of_experience" value="{{ old('years_of_experience', $profile->years_of_experience) }}"></label><label><span>{{ __('ui.available') }}</span><input type="hidden" name="available" value="0"><input type="checkbox" name="available" value="1" @checked(old('available', $profile->available))></label>
<label>{{ __('ui.profile_image') }}<input type="file" name="profile_image" accept="image/*"></label><label>{{ __('ui.cv_pdf') }}<input type="file" name="cv" accept="application/pdf"></label><div class="form-actions"><button class="btn" type="submit">{{ __('ui.save_profile') }}</button></div></form>
@endsection
