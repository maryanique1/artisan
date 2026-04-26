<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_manage_admins')->default(false)->after('is_active');
        });

        // Les admins existants reçoivent l'accès complet
        DB::table('users')->where('role', 'admin')->update(['can_manage_admins' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('can_manage_admins');
        });
    }
};
