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
        Schema::create('responses', function (Blueprint $table) {
            $table->foreignId('survey_id')
                ->constrained('surveys')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('question_id')
                ->constrained('questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('answer_serial')->unique();
            $table->text('answer_text', 255);
            $table->enum('answer_value', [1, 2]); // 1 = Selected; Null = Not selected 
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
        Schema::dropIfExists('responses');
    }
};
