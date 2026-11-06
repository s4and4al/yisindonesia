<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\TestimonialController;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/tentang', [SiteController::class, 'about'])->name('about');
Route::get('/pilar', [SiteController::class, 'pillars'])->name('pillars');
Route::get('/program', [SiteController::class, 'programs'])->name('programs.index');
Route::get('/program/{program:slug}', [SiteController::class, 'program'])->name('programs.show');
Route::get('/berita/feed.xml', [SiteController::class, 'newsFeed'])->name('news.feed');
Route::get('/berita', [SiteController::class, 'news'])->name('news.index');
Route::get('/berita/{post:slug}', [SiteController::class, 'post'])->name('news.show');
Route::get('/kontak', [SiteController::class, 'contact'])->name('contact');
Route::post('/kontak', [SiteController::class, 'sendMessage'])->middleware('throttle:3,1')->name('contact.send');
Route::post('/testimoni', [TestimonialController::class, 'store'])->middleware('throttle:5,1')->name('testimonials.store');
Route::get('/tim', [SiteController::class, 'team'])->name('team');
Route::get('/legalitas', [SiteController::class, 'legal'])->name('legal');
Route::get('/kebijakan-privasi', [SiteController::class, 'privacy'])->name('privacy');
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
Route::post('/kabari', [NewsletterController::class, 'subscribe'])->middleware('throttle:3,1')->name('newsletter.subscribe');
Route::get('/kabari/konfirmasi/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');
Route::get('/kabari/berhenti/{token}', [NewsletterController::class, 'unsubscribePage'])->name('newsletter.unsubscribe.show');
Route::post('/kabari/berhenti', [NewsletterController::class, 'unsubscribe'])->middleware('throttle:5,1')->name('newsletter.unsubscribe');
