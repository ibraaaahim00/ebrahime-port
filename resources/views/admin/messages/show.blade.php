@extends('layouts.admin', ['title' => __('ui.message')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.contact_messages') }}</p><h1>{{ $message->subject }}</h1></div><a class="btn secondary" href="{{ route('admin.messages.index') }}">← {{ __('ui.back') }}</a></div>
<div class="admin-card"><p><strong>{{ $message->name }}</strong> · {{ $message->email }} @if($message->phone) · {{ $message->phone }} @endif</p><hr><p style="white-space:pre-wrap;line-height:1.8">{{ $message->message }}</p><form method="POST" action="{{ route('admin.messages.archive', $message) }}">@csrf<button class="btn" type="submit">{{ __('ui.archive') }}</button></form></div>
@endsection
