<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (Schema::getConnection()->getName() !== 'mysql') {
        return; // skip for MongoDB
    }

    Schema::connection('mysql')->table('meals', function (Blueprint $table) {
        $table->string('image_path')->after('image');
    });
}

public function down(): void
{
    if (Schema::getConnection()->getName() !== 'mysql') {
        return;
    }

    Schema::connection('mysql')->table('meals', function (Blueprint $table) {
        $table->dropColumn('image_path');
    });
}
};
  