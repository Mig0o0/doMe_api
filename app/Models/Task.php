<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Goal;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'progress'
    ];

    public function goal(){
        return $this->belongsTo(Goal::class, 'goaldId');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'parentTask');
    }

    public function isTopLevelTask(){
        return !is_null($this->goalId);
    }

    public function complete(){
        $this->update(["progress" => 100]);
        return $this;
    }

    public function sProgress($progress){
        $this->update(["progress" => $progress]);
        return $this;
    }

    public function progress(){

        if(is_null($this->parentTask) || is_zero($this->parentTask)){
            $goal = Goal::find($this->goalId)->progress();
            return $this;
        }

        // Get Parent Task
        $pTask = Task::find($this->parentTask);

        // Get SubTasks
        $subTasks = $pTask->tasks();

        // Calculate Progress
        $progress = ( $subTasks->sum('progress') / $subTasks->count() );

        return $pTask->sProgress($progress)->progress();
    }

    public function isGoal(){
        return (!is_null($this->goalId) && !is_null($this->parentTask)) ? Goal::find($this->goalId) : false ;
    }
}
