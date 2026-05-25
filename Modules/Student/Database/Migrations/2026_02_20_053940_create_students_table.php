<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
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
            $table->string('student_date_of_birth')->nullable();
            $table->string('user_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('student_address')->nullable();
            $table->string('student_phone')->nullable();
            $table->string('student_gender')->nullable();
            $table->string('student_profile')->nullable();
            $table->string('student_documents')->nullable();

    
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
};
