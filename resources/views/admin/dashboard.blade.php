@extends('layouts.admin', ['title' => __('ui.dashboard')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.workspace') }}</p><h1>{{ __('ui.dashboard') }}</h1><p class="muted">{{ __('ui.portfolio_metrics') }}</p></div><a class="btn" href="{{ route('home') }}">↗ {{ __('ui.view_portfolio') }}</a></div>
<div class="admin-grid metrics">
    @foreach ($metrics as $label => $value)
        <div class="admin-card metric-card"><span class="metric-label">{{ __('ui.'.$label) }}</span><span class="metric-value">{{ $value }}</span></div>
    @endforeach
</div>
@endsection
