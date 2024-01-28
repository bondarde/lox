<?php

use BondarDe\Lox\Models\CmsAssistantTask;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('cms_assistant_tasks')) {
            return;
        }

        Schema::create('cms_assistant_tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp(CmsAssistantTask::FIELD_EXECUTION_STARTED_AT)->nullable();
            $table->timestamp(CmsAssistantTask::FIELD_EXECUTION_FINISHED_AT)->nullable();

            $table->text(CmsAssistantTask::FIELD_TASK)->nullable();
            $table->text(CmsAssistantTask::FIELD_TOPIC)->nullable(false);
            $table->string(CmsAssistantTask::FIELD_LOCALE, 2)->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_assistant_tasks');
    }
};
