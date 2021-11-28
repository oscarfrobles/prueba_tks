<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planificaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('valoracion_id')->nullable();  
            $table->foreign('valoracion_id')->references('id')->on('valoraciones');
            $table->unsignedBigInteger('user_id')->nullable();  
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTimeTz('dt_job')->nullable();
            // 0 sin asignación, 1 asignada, 2 completada
            $table->enum('status', array(0,1,2))->default(0);
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
        Schema::dropIfExists('planificaciones');
    }
}
