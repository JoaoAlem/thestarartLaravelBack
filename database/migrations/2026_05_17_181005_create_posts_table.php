<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->binary('id', length: 16, fixed: true)->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('guid')->unique()->autoIncrement();
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt');
            $table->binary('content');
            $table->json('tags')->nullable();
            $table->timestamp('publish_date');
            $table->tinyInteger('visibility', unsigned: true); // Talvez tenhamos posts vísiveis (1) para todos e visíveis somente para usuários logados (2)
            $table->string('lang', 2)->default('pt')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->fullText(['title, slug, excerpt, content, tags']);
            $table->foreignId('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
