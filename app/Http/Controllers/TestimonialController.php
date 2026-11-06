<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'content' => ['required', 'string', 'min:10', 'max:2000'],
            'social_platform' => ['required', 'in:instagram,facebook,linkedin,tiktok,lainnya'],
            'social_url' => ['nullable', 'url', 'max:300'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'consent' => ['accepted'],
        ]);

        $path = $request->file('photo')->store('testimonials', 'public');

        $media = Media::query()->create([
            'file_name' => $request->file('photo')->getClientOriginalName(),
            'url' => $path,
            'alt_text' => 'Foto testimoni ' . $data['name'],
            'consent_ok' => true,
            'uploaded_by' => null,
        ]);

        Testimonial::query()->create([
            'name' => $data['name'],
            'content' => $data['content'],
            'social_platform' => $data['social_platform'],
            'social_url' => $data['social_url'] ?? null,
            'photo_media_id' => $media->id,
            'status' => 'pending',
            'ip_hash' => hash_hmac('sha256', $request->ip() ?? '', (string) config('app.key')),
        ]);

        return back()->with('status', 'Terima kasih. Testimoni Anda akan ditampilkan setelah ditinjau oleh tim YISI.');
    }
}
