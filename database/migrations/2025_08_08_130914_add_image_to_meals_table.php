<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Explicitly use MySQL connection
        Schema::connection('mysql')->table('meals', function (Blueprint $table) {
            // Add 'image' column safely
            if (!Schema::connection('mysql')->hasColumn('meals', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->table('meals', function (Blueprint $table) {
            if (Schema::connection('mysql')->hasColumn('meals', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
