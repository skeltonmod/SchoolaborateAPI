<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant', function (Blueprint $table) {
            $table->id();
            $table->integer('tenant_id');
            $table->string('tenant_name', 255);
            $table->integer('school_type')->default(1);
            $table->integer('quarterly_config')->default(1);
            $table->string('tenant_api_token', 255);
            $table->integer('subscription_type')->default(0);
            $table->dateTime('expiration_date');
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
        Schema::dropIfExists('tenant');
    }
}
