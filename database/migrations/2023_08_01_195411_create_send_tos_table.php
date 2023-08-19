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
        Schema::create('send_to', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')
                ->constrained('surveys')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('send_date');
            $table->enum('status' , [0,1,2]); // This tenant: 0 = Didn't open; 1 = Oppened; 2 = Answered 
            $table->date('status_date'); // Datetime of open or answer 
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
        Schema::dropIfExists('send_tos');
    }
};
