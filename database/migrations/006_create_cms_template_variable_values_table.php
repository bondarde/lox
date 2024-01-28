<?php

use BondarDe\Lox\Models\CmsTemplateVariableValue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cms_template_variable_values', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId(CmsTemplateVariableValue::FIELD_CMS_PAGE_ID)
                ->constrained('cms_pages')
                ->cascadeOnDelete();

            $table->foreignId(CmsTemplateVariableValue::FIELD_CMS_TEMPLATE_VARIABLE_ID)
                ->constrained('cms_template_variables')
                ->cascadeOnDelete();

            $table->json(CmsTemplateVariableValue::FIELD_CONTENT)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_template_variable_values');
    }
};
