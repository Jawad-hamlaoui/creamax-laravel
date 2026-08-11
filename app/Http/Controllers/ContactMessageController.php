<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        $data = $request->safe()->except(['audio', 'website']);

        if ($request->hasFile('audio')) {
            $data['audio_path'] = $request->file('audio')->store('contact-audio', 'local');
        }

        $data['ip_address'] = $request->ip();
        $data['user_agent'] = substr((string) $request->userAgent(), 0, 255);

        $contactMessage = ContactMessage::create($data);

        if ($ownerEmail = Setting::current()->email) {
            Mail::to($ownerEmail)->send(new NewContactMessage($contactMessage));
        }

        return back()->with('contact_success', true);
    }
}
