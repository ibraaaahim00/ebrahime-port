<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct(private ContactMessageService $messages) {}

    public function index(): View
    {
        return view('admin.messages.index', ['messages' => ContactMessage::query()->latest()->paginate(20)]);
    }

    public function show(ContactMessage $message): View
    {
        $this->messages->markAsRead($message);

        return view('admin.messages.show', ['message' => $message->refresh()]);
    }

    public function read(ContactMessage $message): RedirectResponse
    {
        $this->messages->markAsRead($message);

        return back()->with('success', __('ui.message_read'));
    }

    public function archive(ContactMessage $message): RedirectResponse
    {
        $this->messages->archive($message);

        return back()->with('success', __('ui.message_archived'));
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $this->messages->delete($message);

        return back()->with('success', __('ui.message_deleted'));
    }
}
