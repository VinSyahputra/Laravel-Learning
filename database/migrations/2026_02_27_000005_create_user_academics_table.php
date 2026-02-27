<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('institution');
            $table->enum('degree', [
                'high_school',
                'diploma',
                'associate',
                'bachelor',
                'master',
                'doctorate',
                'certificate',
            ]);
            $table->string('field_of_study', 150)->nullable();
            $table->smallInteger('year_start')->unsigned()->nullable();
            $table->smallInteger('year_end')->unsigned()->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_academics');
    }
};
