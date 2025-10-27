<?php

use App\Models\city;
use App\Models\country;
use App\Models\department;
use App\Models\state;
use App\Models\Team;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(country::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(state::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(city::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(department::class)->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('address');
            $table->char('zip-code');
            $table->date('date_of_birth');
            $table->date('date_hired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
