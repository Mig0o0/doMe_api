<?php
use App\Models\Task;
use App\Models\Goal;

function makeProgerss($id){
    $task =  Task::find($id);
    echo "Hi " . $id . "\n";

    if($id == 0){
        return;
    }

    $subtasks = $task->tasks();

    $progress = ( $subtasks->sum('progress') / $subtasks->count() ) ;

    echo "Progress " . $progress . "\n";

    $update = $task->update(["progress", $progress]);

    echo $update . "\n";

    return makeProgerss($task->parentTask != null ? $task->parentTask : 0);
}

function progressGoal($id){
    $goal =  Goal::find($id);
    dd($id);
    $subtasks = $goal->tasks();

    $progress = ( $subtasks->sum('progress') / $subtasks->count() ) ;

    $goal->update(["progress", $progress]);

    return ($goal->parentTask != 0 || $goal->parentTask != null) ? makeProgerss($goal->parentTask) : "Success";
}

function is_zero($mixture){
    return $mixture == 0;
}
?>
