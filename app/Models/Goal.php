<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'progress'
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'goalId');
    }

    public function complete(){
        return $this->update(["progress" => 100]);
    }

    public function sProgress($progress){
        $this->update(["progress" => $progress]);
        return $this;
    }

    public function progress(){
        // Get Tasks Of Goal
        $tasks = $this->tasks();

        // Calculate Progress
        $progress = ( $tasks->sum('progress') / $tasks->count() );

        return $this->sProgress($progress);
    }
}
