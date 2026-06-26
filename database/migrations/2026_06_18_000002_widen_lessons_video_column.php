<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('lessons') || ! Schema::hasColumn('lessons', 'video')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `lessons` MODIFY `video` TEXT NULL');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('lessons') || ! Schema::hasColumn('lessons', 'video')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `lessons` MODIFY `video` VARCHAR(255) NULL');
        }
    }
};
