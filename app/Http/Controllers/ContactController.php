<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function __construct(private ContactMessageService $messages) {}

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $this->messages->create($request->validated());

        return back()->with('contact_success', 'Thank you. Your message has been received.');
    }
}
