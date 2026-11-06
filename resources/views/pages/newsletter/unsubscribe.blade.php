@extends('layouts.app')
@section('title', 'Berhenti Berlangganan — YISI')
@section('content')
    <section class="section-pad"><div class="container-wide max-w-xl rounded-[1.7rem] border border-[#e2e7df] bg-white p-8 text-center sm:p-12"><p class="eyebrow">Preferensi email</p><h1 class="serif mt-4 text-4xl">Berhenti menerima kabar YISI?</h1><p class="mt-4 text-sm leading-6 text-[#62716a]">Konfirmasi di bawah untuk menghentikan langganan email pembaruan dari YISI.</p><form method="POST" action="{{ route('newsletter.unsubscribe') }}" class="mt-7">@csrf<input type="hidden" name="token" value="{{ $subscriber->token }}"><button class="focus-ring rounded-full bg-[#a3131b] px-6 py-3 text-sm font-bold text-white">Berhenti berlangganan</button></form></div></section>
@endsection
