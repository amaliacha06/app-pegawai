<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            
            // --- KOLOM PENILAIAN KINERJA DITAMBAHKAN DI SINI ---
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('reviewer_id')->nullable()->constrained('employees')->onDelete('set null'); // Tambah reviewer_id (FK ke employees)
            $table->string('period', 50);          
            $table->date('review_date');           
            $table->decimal('score', 5, 2)->nullable(); 
            $table->text('feedback');              
            $table->text('training_recommendation')->nullable(); 
            $table->enum('status', ['Draft', 'Completed'])->default('Draft');
            // --- END KOLOM BARU ---
            
            $table->timestamps();
            
            // Tambahkan index unik untuk mencegah double review di periode yang sama
            $table->unique(['employee_id', 'period']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};