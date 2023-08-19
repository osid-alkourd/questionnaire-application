<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')
                ->constrained('surveys')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('question_serial')->unique();
            $table->text('title');
            $table->enum('question_type' , [1,2,3,4,5]); //1 = Entry; 2 = Y/N; 3 = Multiple Selection; 4 = Single Selection; 5 = Rating;
            $table->enum('answer_option' , [1,2])->default(1); //1 = Optiponal (default); 2 = Mandatory
            $table->text('question_notes' , 255);
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
        Schema::dropIfExists('questions');
    }
};
