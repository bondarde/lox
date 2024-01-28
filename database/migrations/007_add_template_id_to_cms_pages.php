<?php

use BondarDe\Lox\Models\CmsPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->foreignId(CmsPage::FIELD_CMS_TEMPLATE_ID)
                ->nullable()
                ->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropColumn(CmsPage::FIELD_CMS_TEMPLATE_ID);
        });
    }
};
