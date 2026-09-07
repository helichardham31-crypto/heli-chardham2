<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Singular table name on purpose - the Accompany model pins $table = 'accompany'.
 * ref_id holds the owning user's unique_code, which is how the hasMany joins.
 */
return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('accompany')) {
            return;
        }

        Schema::create('accompany', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->index();
            $table->string('name');
            $table->string('ref_id')->index();
            $table->string('type')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accompany');
    }
};
