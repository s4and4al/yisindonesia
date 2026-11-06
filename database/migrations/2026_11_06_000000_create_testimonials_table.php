<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->text('content');
            $table->string('social_platform', 30)->nullable();
            $table->string('social_url', 300)->nullable();
            $table->foreignUuid('photo_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('status', 20)->default('pending');
            $table->char('ip_hash', 64)->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
