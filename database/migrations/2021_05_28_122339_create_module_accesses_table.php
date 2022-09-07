<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('module_id', 50);
            $table->string('module_label', 100);
            $table->string('module_slug', 100);
            $table->integer('canEdit')->default(1);
            $table->integer('canSave')->default(1);
            $table->integer('canDelete')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_accesses');
    }
}
