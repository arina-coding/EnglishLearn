<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('remember_token');
            }

            if (!Schema::hasColumn('users', 'login_streak')) {
                $table->integer('login_streak')->default(0)->after('last_login_at');
            }

            if (!Schema::hasColumn('users', 'current_streak')) {
                $table->integer('current_streak')->default(0)->after('login_streak');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['current_streak'];

            if (Schema::hasColumn('users', 'current_streak')) {
                $table->dropColumn('current_streak');
            }

            if (Schema::hasColumn('users', 'login_streak')) {
                $table->dropColumn('login_streak');
            }

            if (Schema::hasColumn('users', 'last_login_at')) {
                $table->dropColumn('last_login_at');
            }
        });
    }
};