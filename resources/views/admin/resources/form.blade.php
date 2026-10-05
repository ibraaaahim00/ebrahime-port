@extends('layouts.admin', ['title' => ($item ? __('ui.edit') : __('ui.create')).' '.__('ui.resource_'.$resource)])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.content') }}</p><h1>{{ $item ? __('ui.edit') : __('ui.create') }} {{ __('ui.resource_'.$resource) }}</h1></div><a class="btn secondary" href="{{ route('admin.'.$resource.'.index') }}">← {{ __('ui.back') }}</a></div>
<form class="admin-card form-grid" method="POST" action="{{ $item ? route('admin.'.$resource.'.update', $item->id) : route('admin.'.$resource.'.store') }}">
    @csrf @if($item) @method('PUT') @endif
    @foreach($config['fields'] as $field)
        @php($label = __('ui.'.$field))
        @if(in_array($field, ['active', 'current']))
            <label><span>{{ $label }}</span><input type="hidden" name="{{ $field }}" value="0"><input type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $item?->{$field} ?? true))></label>
        @elseif(in_array($field, ['description', 'testimonial', 'technologies', 'highlights']))
            <label class="full">{{ $label }}<textarea name="{{ $field }}">{{ old($field, is_array($item?->{$field}) ? json_encode($item->{$field}, JSON_PRETTY_PRINT) : $item?->{$field}) }}</textarea></label>
        @else
            <label>{{ $label }}<input type="{{ in_array($field, ['start_date', 'end_date']) ? 'date' : (in_array($field, ['sort_order']) ? 'number' : 'text') }}" name="{{ $field }}" value="{{ old($field, $item?->{$field}) }}" {{ in_array($field, ['name', 'title', 'company', 'position', 'institution', 'degree']) ? 'required' : '' }}></label>
        @endif
    @endforeach
    <div class="form-actions"><a class="btn secondary" href="{{ route('admin.'.$resource.'.index') }}">{{ __('ui.back') }}</a><button class="btn" type="submit">{{ __('ui.save') }}</button></div>
</form>
@endsection
