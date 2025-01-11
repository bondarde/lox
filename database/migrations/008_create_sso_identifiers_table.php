<?php

use BondarDe\Lox\Models\SsoIdentifier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sso_identifiers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId(SsoIdentifier::FIELD_USER_ID)
                ->constrained()
                ->cascadeOnDelete();

            $table->string(SsoIdentifier::FIELD_PROVIDER_NAME);
            $table->string(SsoIdentifier::FIELD_PROVIDER_ID);
            $table->text(SsoIdentifier::FIELD_PROVIDER_DATA)->nullable();

            $table->unique([
                SsoIdentifier::FIELD_PROVIDER_NAME,
                SsoIdentifier::FIELD_PROVIDER_ID,
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sso_identifiers');
    }
};
