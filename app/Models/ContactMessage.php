<?php

namespace App\Models;

use Database\Factories\ContactMessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /** @use HasFactory<ContactMessageFactory> */
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'read_at', 'archived_at'];

    protected function casts(): array
    {
        return ['read_at' => 'datetime', 'archived_at' => 'datetime'];
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }
}
