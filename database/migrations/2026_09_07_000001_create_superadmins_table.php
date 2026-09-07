<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * The superadmins table backs the 'superadmins' auth guard (config/auth.php).
 * It never had a migration - the table only existed in the original hosting
 * database - so a fresh deploy had no way to build it.
 */
return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('superadmins')) {
            return;
        }

        Schema::create('superadmins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('superadmins');
    }
};
