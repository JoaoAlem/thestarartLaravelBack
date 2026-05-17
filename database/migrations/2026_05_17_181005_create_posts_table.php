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
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('guid')->unique()->autoIncrement();
            $table->string('title');
            $table->string('slug');
            $table->text('excerpt');
            $table->longText('content')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('publish_date');
            $table->tinyInteger('visibility', unsigned: true); // Talvez tenhamos posts vísiveis (1) para todos e visíveis somente para usuários logados (2)
            $table->string('lang', 2)->default('pt')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->fullText(['title', 'slug', 'excerpt'], 'posts_fulltext_en')
                ->language('english');

            $table->fullText(['title', 'slug', 'excerpt'], 'posts_fulltext_pt')
                ->language('portuguese');

            $table->fullText(['title', 'slug', 'excerpt'], 'posts_fulltext_es')
                ->language('spanish');
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
