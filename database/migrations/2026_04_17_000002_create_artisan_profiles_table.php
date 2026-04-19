<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisan_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('metier');
            $table->string('ville');
            $table->string('quartier');
            $table->json('portfolio')->nullable();
            $table->string('proof_document')->nullable(); // Chemin vers diplôme/certification uploadé
            $table->string('proof_type')->nullable(); // diplome, certificat, preuve_experience
            $table->enum('validation_status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->boolean('is_available')->default(true);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['ville', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisan_profiles');
    }
};
