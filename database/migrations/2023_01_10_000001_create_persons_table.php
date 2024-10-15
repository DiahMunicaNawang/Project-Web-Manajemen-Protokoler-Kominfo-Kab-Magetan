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
        Schema::create('persons', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->uuid('id')->primary();
            $table->string('nip');
            $table->string('name', 200);
            $table->string('email', 200);
            $table->string('phone', 20)->nullable();
            $table->string('photo', 200)->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['L', 'P'])->comment('L: Laki-laki, P: Perempuan')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
