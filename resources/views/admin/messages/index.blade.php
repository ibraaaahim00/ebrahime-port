@extends('layouts.admin', ['title' => __('ui.messages')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.content') }}</p><h1>{{ __('ui.contact_messages') }}</h1><p class="muted">{{ __('ui.manage_database_content') }}</p></div></div>
<div class="admin-table-wrap"><table><thead><tr><th>{{ __('ui.sender') }}</th><th>{{ __('ui.subject') }}</th><th>{{ __('ui.status') }}</th><th>{{ __('ui.received') }}</th><th>{{ __('ui.actions') }}</th></tr></thead><tbody>
@forelse($messages as $message)
    <tr><td><span class="table-primary">{{ $message->name }}</span><span class="table-secondary">{{ $message->email }}</span></td><td>{{ $message->subject }}</td><td><span class="status-badge {{ $message->read_at ? '' : 'inactive' }}">{{ $message->status }}</span></td><td class="muted">{{ $message->created_at->format('Y-m-d H:i') }}</td><td><div class="action-row"><a class="btn small secondary" href="{{ route('admin.messages.show', $message) }}">{{ __('ui.view') }}</a><form class="inline" method="POST" action="{{ route('admin.messages.archive', $message) }}">@csrf<button class="btn small" type="submit">{{ __('ui.archive') }}</button></form><form class="inline" method="POST" action="{{ route('admin.messages.destroy', $message) }}">@csrf @method('DELETE')<button class="btn small danger" type="submit" onclick="return confirm('{{ __('ui.delete_confirm') }}')">{{ __('ui.delete') }}</button></form></div></td></tr>
@empty
    <tr><td colspan="5" class="muted">{{ __('ui.no_records') }}</td></tr>
@endforelse
</tbody></table></div>{{ $messages->links('components.pagination') }}
@endsection
