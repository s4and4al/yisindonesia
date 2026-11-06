<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('file_name');
            $table->string('url', 500);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('credit')->nullable();
            $table->boolean('consent_ok')->default(false);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->string('description')->nullable();
            $table->smallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->string('excerpt', 400)->nullable();
            $table->longText('content');
            $table->foreignUuid('cover_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('post_categories')->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('seo_title', 160)->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
            $table->index(['status', 'published_at']);
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->foreignUuid('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        Schema::create('post_revisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->constrained()->cascadeOnDelete();
            $table->string('title', 220);
            $table->longText('content');
            $table->foreignId('edited_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['post_id', 'created_at']);
        });

        Schema::create('pillars', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 120)->unique();
            $table->string('summary', 500)->nullable();
            $table->char('color_hex', 7)->nullable();
            $table->smallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 190);
            $table->string('slug', 200)->unique();
            $table->foreignUuid('logo_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('website_url', 300)->nullable();
            $table->string('partner_type', 60)->nullable();
            $table->boolean('show_logo')->default(false);
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->string('summary', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('focus_activity')->nullable();
            $table->string('location', 220)->nullable();
            $table->string('province', 80)->nullable();
            $table->unsignedSmallInteger('year_start');
            $table->unsignedSmallInteger('year_end')->nullable();
            $table->string('status', 20)->default('completed');
            $table->foreignUuid('cover_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->longText('impact_summary')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('publish_status', 20)->default('draft');
            $table->string('seo_title', 160)->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->timestamps();
            $table->index(['publish_status', 'year_start']);
        });

        Schema::create('program_pillars', function (Blueprint $table) {
            $table->foreignUuid('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pillar_id')->constrained()->cascadeOnDelete();
            $table->primary(['program_id', 'pillar_id']);
        });

        Schema::create('program_partners', function (Blueprint $table) {
            $table->foreignUuid('program_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('partner_id')->constrained()->cascadeOnDelete();
            $table->string('role', 80)->nullable();
            $table->primary(['program_id', 'partner_id']);
        });

        Schema::create('program_media', function (Blueprint $table) {
            $table->foreignUuid('program_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('media_id')->constrained()->cascadeOnDelete();
            $table->string('caption')->nullable();
            $table->smallInteger('sort_order')->default(0);
            $table->primary(['program_id', 'media_id']);
        });

        Schema::create('program_posts', function (Blueprint $table) {
            $table->foreignUuid('program_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('post_id')->constrained()->cascadeOnDelete();
            $table->primary(['program_id', 'post_id']);
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->string('position', 150);
            $table->string('group_name', 80);
            $table->string('division', 190)->nullable();
            $table->longText('bio')->nullable();
            $table->foreignUuid('photo_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->smallInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 220);
            $table->string('doc_type', 20)->default('lainnya');
            $table->string('description', 400)->nullable();
            $table->foreignUuid('media_id')->constrained('media')->restrictOnDelete();
            $table->unsignedSmallInteger('year')->nullable();
            $table->foreignUuid('program_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_public')->default(true);
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();
        });

        Schema::create('legal_identity', function (Blueprint $table) {
            $table->string('key', 80)->primary();
            $table->string('label', 120);
            $table->string('value', 300);
            $table->boolean('is_public')->default(true);
            $table->smallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 220);
            $table->string('slug', 240)->unique();
            $table->longText('content')->nullable();
            $table->string('status', 20)->default('draft');
            $table->string('seo_title', 160)->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('key', 80)->primary();
            $table->json('value');
            $table->timestamps();
        });

        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('address', 400);
            $table->string('phone', 40)->nullable();
            $table->string('email', 190)->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->smallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->string('email', 190);
            $table->string('organization', 190)->nullable();
            $table->string('topic', 80)->nullable();
            $table->longText('message');
            $table->string('status', 20)->default('new');
            $table->char('ip_hash', 64)->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email', 190)->unique();
            $table->string('name', 150)->nullable();
            $table->timestamp('consent_at');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('token', 64)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('legal_identity');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('program_posts');
        Schema::dropIfExists('program_media');
        Schema::dropIfExists('program_partners');
        Schema::dropIfExists('program_pillars');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('pillars');
        Schema::dropIfExists('post_revisions');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('media');
    }
};
