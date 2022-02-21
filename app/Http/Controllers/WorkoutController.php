<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Exercise;
use App\Http\Requests\WorkoutStoreRequest;

class WorkoutController extends Controller
{

    #listing all the workouts
    public function index() {
        return response()->json([
            'workouts' => Workout::all()
        ]);
    }
    #store method
    public function store(WorkoutStoreRequest $request)
    {
        $workout = Workout::create([
            'workout_name' => $request->workout_name,
            'workout_type' => $request->workout_type,
            'user_id' => auth()->user()->id
        ]);
        $exercises = [];
        foreach ($request->exercises as $single_exercise) {
            $exercise = Exercise::create([
                'input-1' => $single_exercise['input_1'],
                'input-2' => $single_exercise['input_2'],
                'input-3' => $single_exercise['input_3'],
                'input-4' => $single_exercise['input_4'],
                'workout_id' => $workout->id
            ]);
            array_push($exercises, $exercise);
        }
        return response()->json([
            'workout' => $workout,
            'exercises' => $exercises
        ]);
    }

    //deleting an existing workout
    public function destroy(Workout $workout)
    {
        if ($workout->delete()) {
            return response()->json([
                'message' => 'workout deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => "couldn't complete process",
                'status' => 204
            ]);
        }
    }

    //showing an existing workout
    public function show(Workout $workout)
    {
        return response()->json([
            'workout' => $workout,
            'exercises' => Exercise::whereBelongsTo(Workout::find($workout->id))->get()
        ]);
    }

    //editing an existing workout
    public function edit(WorkoutStoreRequest $request, Workout $workout)
    {
        $workout->workout_name = $request->workout_name;
        $workout->save();

        $exercises = Exercise::whereBelongsTo(Workout::find($workout->id))->get();
        for ($index = 0; $index < count($exercises); $index++) {
            $exercises[$index]['input-1'] = $request->exercises[$index]['input-1'];
            $exercises[$index]['input-2'] = $request->exercises[$index]['input-2'];
            $exercises[$index]['input-3'] = $request->exercises[$index]['input-3'];
            $exercises[$index]['input-4'] = $request->exercises[$index]['input-4'];
            $exercises[$index]->save();
        }
        return response()->json([
            'message' => 'update success',
            'workout' => $workout,
            'exercises' => $exercises
        ]);
    }

    #deleting an existing exercise
    public function destroyExercise(Exercise $exercise)
    {
        $exercise->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
