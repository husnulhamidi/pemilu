<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysRoleMenuActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_role_menu_actions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_action_id');
            $table->enum('status_code', ['active', 'inactive','nullified'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('sys_roles')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('menu_action_id')->references('id')->on('sys_menu_actions')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_role_menu_actions');
    }
}
