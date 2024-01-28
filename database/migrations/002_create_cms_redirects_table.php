<?php

use BondarDe\Lox\Models\CmsRedirect;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('cms_redirects')) {
            return;
        }

        Schema::create('cms_redirects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string(CmsRedirect::FIELD_PATH)
                ->unique();
            $table->string(CmsRedirect::FIELD_TARGET)
                ->nullable(false)
                ->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_redirects');
    }
};
