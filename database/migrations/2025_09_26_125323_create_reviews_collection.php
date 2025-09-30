<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('reviews', function ($collection) {
            $collection->id();
            $collection->string('username');
            $collection->tinyInteger('rating');
            $collection->text('comment');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('reviews');
    }
};

