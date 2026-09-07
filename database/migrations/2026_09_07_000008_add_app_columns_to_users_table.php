<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * The users table is still Laravel's stock one, but this app stores doctors in
 * it: SuperAdminController::saveDoctor() writes unique_code, ref_id, contact_no,
 * state, type, qr_code_path and status, and never sets a password - so the
 * stock NOT NULL password column has to be relaxed as well.
 *
 * The password change is raw SQL because ->change() needs doctrine/dbal, which
 * this project does not require.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'unique_code')) {
                $table->string('unique_code')->nullable()->index()->after('id');
            }
            if (! Schema::hasColumn('users', 'ref_id')) {
                $table->string('ref_id')->nullable()->index()->after('unique_code');
            }
            if (! Schema::hasColumn('users', 'contact_no')) {
                $table->string('contact_no')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'state')) {
                $table->string('state')->nullable()->after('contact_no');
            }
            if (! Schema::hasColumn('users', 'type')) {
                $table->string('type')->nullable()->after('state');
            }
            if (! Schema::hasColumn('users', 'qr_code_path')) {
                $table->string('qr_code_path')->nullable()->after('type');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('qr_code_path');
            }
        });

        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['unique_code', 'ref_id', 'contact_no', 'state', 'type', 'qr_code_path', 'status'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
