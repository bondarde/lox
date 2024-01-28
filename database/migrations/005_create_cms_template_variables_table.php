<?php

use BondarDe\Lox\Models\CmsTemplateVariable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cms_template_variables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId(CmsTemplateVariable::FIELD_CMS_TEMPLATE_ID)
                ->constrained('cms_templates')
                ->cascadeOnDelete();

            $table->string(CmsTemplateVariable::FIELD_LABEL)->nullable(false);
            $table->unsignedInteger(CmsTemplateVariable::FIELD_CONTENT_TYPE)->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_template_variables');
    }
};
