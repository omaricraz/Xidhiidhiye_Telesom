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
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('name');
            $table->enum('role', ['Manager', 'Team_Lead', 'Employee', 'Intern'])->default('Employee')->after('email');
            $table->unsignedBigInteger('team_id')->nullable()->after('role');
            $table->text('tech_stack')->nullable()->after('team_id');
            $table->string('status_emoji')->nullable()->after('tech_stack');

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn(['full_name', 'role', 'team_id', 'tech_stack', 'status_emoji']);
        });
    }
};








