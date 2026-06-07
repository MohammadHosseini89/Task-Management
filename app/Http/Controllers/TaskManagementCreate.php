<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskManagementModel;

class TaskManagementCreate extends Controller
{
    public function createNewTask(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'raisedbyteam' => 'required|string|max:255',
            'raisedbyuser' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'issue2' => 'nullable|string|max:255',
            'issue3' => 'nullable|string|max:255',
            'impact' => 'nullable|string|max:255',
            'rc' => 'nullable|string|max:255',
            'solution' => 'nullable|string|max:255',
            'due_date' => 'required|date|after:now',
            'latest_update' => 'nullable|string|max:255',
            'progress' => 'nullable|numeric|between:0,100',
            'owner' => 'required|string|max:255',
            'support' => 'nullable|string|max:255',
            'description' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 0-100.'
        ]);

        $user_id = $request->user()->id;
        $validatedData['current_processor'] = $validatedData['owner'];
        $validatedData['user_id'] = $user_id;
        if ($validatedData['progress'] === null) {
            $validatedData['progress'] = 0;
        }



        // Create a new task management model instance with the validated data
        $task = new TaskManagementModel($validatedData);

        // Save the task to the database
        $task->save();

        $id = $task->id;
        $uuid = 'UR-TSK-' . $id + '100831';
        // update the task with the generated UUID
        $task['uuid'] = $uuid ;

        $task->update();



        // Redirect back to the form with a success message
        return redirect()->back()->with('success', 'Task created successfully!');
    }
}
