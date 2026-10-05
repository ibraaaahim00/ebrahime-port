<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class ContactMessageService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): ContactMessage
    {
        return ContactMessage::query()->create($data + ['status' => 'unread']);
    }

    public function markAsRead(ContactMessage $message): ContactMessage
    {
        $message->forceFill(['status' => 'read', 'read_at' => now()])->save();

        return $message->refresh();
    }

    public function archive(ContactMessage $message): ContactMessage
    {
        $message->forceFill(['status' => 'archived', 'archived_at' => now()])->save();

        return $message->refresh();
    }

    public function delete(ContactMessage $message): bool
    {
        return DB::transaction(fn (): bool => (bool) $message->delete());
    }
}
