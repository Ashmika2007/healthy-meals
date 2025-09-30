<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (Schema::getConnection()->getName() !== 'mysql') {
        return; // skip this migration if not MySQL
    }

    Schema::connection('mysql')->table('users', function (Blueprint $table) {
        $table->string('role')->default('user')->after('password');
    });
}

public function down(): void
{
    if (Schema::getConnection()->getName() !== 'mysql') {
        return;
    }

    Schema::connection('mysql')->table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};