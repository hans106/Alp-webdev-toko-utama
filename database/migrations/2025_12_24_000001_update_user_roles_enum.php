<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            // SQLite doesn't support MODIFY/ENUM. Replace column with string safely.
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_tmp')->default('customer');
            });

            DB::statement("UPDATE users SET role_tmp = role");

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('customer');
                $table->dropColumn('role_tmp');
            });

        } else {
            // Add additional role options to the users.role enum (MySQL/Postgres)
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('superadmin','admin','inventory','cashier','customer') NOT NULL DEFAULT 'customer'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_tmp')->default('customer');
            });

            DB::statement("UPDATE users SET role_tmp = role");

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin','customer'])->default('customer');
                $table->dropColumn('role_tmp');
            });

        } else {
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','customer') NOT NULL DEFAULT 'customer'");
        }
    }
};
