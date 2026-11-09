<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            // Foreign Keys linking to Students and Events
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            
            // FR2: Participant Information and Registration Date
            $table->string('participant_name');
            $table->string('participant_email');
            $table->dateTime('registration_date')->useCurrent();
            
            // FR3, FR4, FR5: Tracking Pending status and Admin approvals
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('admin_remarks')->nullable(); // Useful for FR5 rejection notes
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('event_registrations');
    }
};