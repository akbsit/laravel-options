<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_NAME = 'options';

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE_NAME)) {
            return;
        }

        Schema::create(self::TABLE_NAME, function (Blueprint $oTable) {
            $oTable->id();

            $oTable->string('group', 100)->nullable();
            $oTable->string('option', 100);
            $oTable->text('value')->nullable();
            $oTable->text('description')->nullable();

            $oTable->timestamps();

            $oTable->index('group');
            $oTable->index('option');
            $oTable->unique([
                'group',
                'option',
            ]);
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            return;
        }

        Schema::dropIfExists(self::TABLE_NAME);
    }
};
