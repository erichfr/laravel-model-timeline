<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_timelines', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject'); // Cria subject_id e subject_type
            $table->nullableMorphs('actor'); // Cria actor_id e actor_type
            
            $table->string('action')->index(); 
            $table->string('description');     
            $table->text('body')->nullable();  
            $table->json('metadata')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_timelines');
    }
};