<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->id();
            $table->string('role',50);
            $table->tinyInteger('is_disposisi')->nullable();
            $table->tinyInteger('is_approval')->nullable();
            $table->tinyInteger('is_back_document')->nullable();
            $table->tinyInteger('is_confirm_document')->nullable();
            $table->tinyInteger('is_update_document')->nullable();
            $table->tinyInteger('is_update_text')->nullable();
            $table->enum('status_code', ['active', 'inactive','nullified'])->default('active');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('sys_roles');
    }
}
