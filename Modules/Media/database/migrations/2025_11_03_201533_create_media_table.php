<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary()->autoIncrement();
            $table->morphs('mediable');
            $table->string('status')->default(\Modules\Media\Enums\MediaStatusEnum::PENDING->value);
            $table->string('path')->nullable();
            $table->string('disk')->default('local');
            $table->string('type')->default(\Modules\Media\Enums\MediaTypeEnum::IMAGE->value);
            $table->unsignedBigInteger('size')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
