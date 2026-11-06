<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:190'],
            'consent' => ['accepted'],
        ]);

        $subscriber = Subscriber::query()->firstOrNew(['email' => $data['email']]);
        if ($subscriber->exists && $subscriber->confirmed_at && ! $subscriber->unsubscribed_at) {
            return back()->with('status', 'Alamat email ini sudah berlangganan kabar YISI.');
        }

        $token = Str::random(64);
        $subscriber->fill([
            'consent_at' => now(),
            'confirmed_at' => null,
            'unsubscribed_at' => null,
            'token' => $token,
        ])->save();

        $confirmationUrl = route('newsletter.confirm', ['token' => $token]);
        $unsubscribeUrl = route('newsletter.unsubscribe.show', ['token' => $token]);

        Mail::raw(
            "Terima kasih telah mendaftar kabar YISI.\n\nKonfirmasi langganan Anda melalui tautan ini:\n{$confirmationUrl}\n\nAnda dapat berhenti berlangganan kapan saja melalui:\n{$unsubscribeUrl}\n\nJika Anda tidak meminta email ini, abaikan pesan ini.",
            fn ($message) => $message->to($subscriber->email)->subject('Konfirmasi langganan kabar YISI'),
        );

        return back()->with('status', 'Periksa email Anda untuk mengonfirmasi langganan kabar YISI.');
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscriber = Subscriber::query()->where('token', $token)->firstOrFail();
        abort_if($subscriber->unsubscribed_at, 404);

        $subscriber->forceFill(['confirmed_at' => $subscriber->confirmed_at ?? now()])->save();

        return redirect()->route('home')->with('status', 'Langganan kabar YISI berhasil dikonfirmasi.');
    }

    public function unsubscribePage(string $token): View
    {
        $subscriber = Subscriber::query()->where('token', $token)->firstOrFail();

        return view('pages.newsletter.unsubscribe', compact('subscriber'));
    }

    public function unsubscribe(Request $request): RedirectResponse
    {
        $data = $request->validate(['token' => ['required', 'string', 'size:64']]);
        $subscriber = Subscriber::query()->where('token', $data['token'])->firstOrFail();
        $subscriber->forceFill(['unsubscribed_at' => now()])->save();

        return redirect()->route('home')->with('status', 'Anda telah berhenti berlangganan kabar YISI.');
    }
}
