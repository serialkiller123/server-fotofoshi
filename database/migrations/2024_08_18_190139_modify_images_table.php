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
        Schema::table('images', function (Blueprint $table) {
            // Drop the 'path' column if it exists
            if (Schema::hasColumn('images', 'path')) {
                $table->dropColumn('path');
            }

            // Rename 'name' column to 'filename'
            if (Schema::hasColumn('images', 'name')) {
                $table->renameColumn('name', 'filename');
            }
            
            // If 'user_id' column does not exist, add it
            if (!Schema::hasColumn('images', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            // Add 'path' column back if needed
            if (!Schema::hasColumn('images', 'path')) {
                $table->string('path');
            }

            // Rename 'filename' column back to 'name'
            if (Schema::hasColumn('images', 'filename')) {
                $table->renameColumn('filename', 'name');
            }

            // Drop 'user_id' column if it exists
            if (Schema::hasColumn('images', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
