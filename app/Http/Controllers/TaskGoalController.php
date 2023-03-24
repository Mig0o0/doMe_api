<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskGoalRequest;
use Illuminate\Http\Request;
use App\Models\Goal;


class TaskGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Goal $goal)
    {
        return $goal->tasks()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskGoalRequest $request, Goal $goal)
    {
        return $goal->tasks()->create($request->validated());
    }

}
