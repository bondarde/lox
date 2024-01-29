<?php

use BondarDe\Lox\Models\CmsPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('cms_pages')) {
            return;
        }

        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId(CmsPage::FIELD_CREATED_BY)
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId(CmsPage::FIELD_UPDATED_BY)
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId(CmsPage::FIELD_PARENT_ID)
                ->nullable()
                ->constrained('cms_pages');
            $table->string(CmsPage::FIELD_PATH)->nullable(false)->unique();
            $table->string(CmsPage::FIELD_SLUG)->nullable(false);

            $table->json(CmsPage::FIELD_PAGE_TITLE)->nullable();
            $table->json(CmsPage::FIELD_MENU_TITLE)->nullable();
            $table->json(CmsPage::FIELD_CONTENT)->nullable();

            $table->json(CmsPage::FIELD_H1_TITLE)->nullable();
            $table->json(CmsPage::FIELD_META_DESCRIPTION)->nullable();
            $table->string(CmsPage::FIELD_CANONICAL)->nullable();

            $table->boolean(CmsPage::FIELD_IS_PUBLIC)->nullable(false);
            $table->boolean(CmsPage::FIELD_IS_INDEX)->nullable(false);
            $table->boolean(CmsPage::FIELD_IS_FOLLOW)->nullable(false);

            $table->unique([
                CmsPage::FIELD_SLUG,
                CmsPage::FIELD_PARENT_ID,
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_pages');
    }
};
