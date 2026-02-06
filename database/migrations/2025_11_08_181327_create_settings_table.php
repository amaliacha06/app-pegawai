<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// database/migrations/YYYY_MM_DD_XXXX_create_settings_table.php

public function up(): void
{
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        
        // --- KOLOM SETTINGS DITAMBAHKAN ---
        $table->string('key')->unique();
        $table->text('value');
        $table->text('description')->nullable();
        // --- END KOLOM BARU ---
        
        $table->timestamps();
    });
}
};