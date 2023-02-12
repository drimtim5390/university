<?php

use App\Models\Group;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->tinyInteger('position');
            $table->foreignIdFor(Group::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Room::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Teacher::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Subject::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['date', 'position', 'group_id']);
            $table->unique(['date', 'position', 'room_id']);
            $table->unique(['date', 'position', 'teacher_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
