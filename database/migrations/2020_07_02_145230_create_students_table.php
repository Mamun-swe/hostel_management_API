<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id');
            $table->bigInteger('admin_id');
            $table->string('name');
            $table->string('own_mobile_number');
            $table->string('parents_mobile_number');
            $table->float('advance_amount');
            $table->float('due_amount');
            $table->date('admission_date');
            $table->enum('status', ['active', 'deactive']);
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
        Schema::dropIfExists('students');
    }
}
