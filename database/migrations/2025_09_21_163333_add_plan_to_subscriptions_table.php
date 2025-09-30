
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getName() === 'mysql') {
            Schema::connection('mysql')->table('subscriptions', function (Blueprint $table) {
                if (!Schema::hasColumn('subscriptions', 'plan')) {
                    $table->string('plan')->after('user_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::getConnection()->getName() === 'mysql') {
            Schema::connection('mysql')->table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('plan');
            });
        }
    }
};
