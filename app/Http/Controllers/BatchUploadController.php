<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use League\Csv\Reader;
use App\Models\subTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TaskManagementModel;
use App\Models\LogActionsTaskManagementModel;
use Illuminate\Contracts\Debug\ExceptionHandler;

class BatchUploadController extends Controller
{
    public function batch(Request $request)
    {

        set_time_limit(600);

        // Set RAM to Max
        ini_set('memory_limit', '-1');

        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Read the CSV file using League\Csv\Reader
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $headers = $csv->getHeader();

        // Loop through each row and insert the data into the Task Management & Subtask And Log models
        // raisedbyuser	issue	impact	rc	solution	solution2	status	due_date
        // 	owner	support	description	feedback	priority

        $teams = request()->user()->load('asssignusertoteam')
            ->asssignusertoteam->pluck('team_name')->first();
        $email =  request()->user()->email;
        $user_id = request()->user()->id;

        try {
            foreach ($csv as $row) {
                if (!empty($row['issue'])) {
                    $row = array_map('utf8_encode', $row);

                    if ($row['progress'] === null) {
                        $row['progress'] = 0;
                    }


                    $dueDate = Carbon::createFromFormat('m/d/Y H:i', $row['due_date']);
                    $row['issue'] = strval($row['issue']);
                    $row['description'] = strval($row['description']);

                    $create_taskmanagement = [
                        'creator' => $email,
                        'createdbyteam' => $teams,
                        'raisedbyuser' => $row['raisedbyuser'],
                        'issue' => $row['issue'],
                        'impact' => $row['impact'],
                        'rc' => $row['rc'],
                        'solution' => $row['solution'],
                        'solution2' => $row['solution2'],
                        'solution3' => $row['status'],
                        'due_date' => $dueDate->format('Y-m-d H:i:s'),
                        'latest_update' => date('Y-m-d H:i:s', strtotime(now())),
                        'progress' => $row['progress'],
                        'owner' => $row['owner'],
                        'current_processor' => $row['owner'],
                        'user_id' => $user_id,
                        'support' => $row['support'],
                        'description' => $row['description'],
                        'priority' => $row['priority'],
                        'label_for_system' => 'Parent;',
                    ];

                    $taskmanagement = new TaskManagementModel();

                    // Build UUID
                    $id = DB::table('task_management_models')->insertGetId($create_taskmanagement);
                    $uuid = 'UR-TSK-' . $id + '100001361';

                    // Update taskmanagement object with UUID
                    $taskmanagement->uuid = $uuid;

                    $update_taskmanagement = TaskManagementModel::where('id', $id)->first();
                    $update_taskmanagement->uuid = $uuid;
                    $update_taskmanagement->current_status = 'running';
                    $update_taskmanagement->created_at = now();
                    $update_taskmanagement->updated_at = now();
                    $update_taskmanagement->save();

                    // Log Actions Create Task
                    $task = TaskManagementModel::where('id', $id)->first();
                    $log = new LogActionsTaskManagementModel();
                    $log->task_management_model_id = $task->id;
                    $log->fail_label_for_system = $task->fail_label_for_system;
                    $log->success_label_for_system = $task->success_label_for_system;
                    $log->action = 'Create Task';
                    $log->uuid = $task->uuid;
                    $log->uuid_sub_task = $task->uuid_sub_task;
                    $log->is_cancel = $task->is_cancel;
                    $log->is_complete = $task->is_complete;
                    $log->is_fail = $task->is_fail;
                    $log->is_success = $task->is_success;
                    $log->searchable = $task->searchable;
                    $log->user_id = $task->user_id;
                    $log->creator = $task->creator;
                    $log->current_status = $task->current_status;
                    $log->label_for_system = $task->label_for_system;
                    $log->label_for_system2 = $task->label_for_system2;
                    $log->pending_for = $task->pending_for;
                    $log->visibletousers = $task->visibletousers;
                    $log->visibletoteams = $task->visibletoteams;
                    $log->createdbyteam = $task->createdbyteam;
                    $log->raisedbyuser = $task->raisedbyuser;
                    $log->issue = $task->issue;
                    $log->impact = $task->impact;
                    $log->rc = $task->rc;
                    $log->solution = $task->solution;
                    $log->solution2 = $task->solution2;
                    $log->solution3 = $task->solution3;
                    $log->latest_update = $task->latest_update;
                    $log->due_date = $task->due_date;
                    $log->progress = $task->progress;
                    $log->owner = $task->owner;
                    $log->current_processor = $task->current_processor;
                    $log->owner_team = $task->owner_team;
                    $log->description = $task->description;
                    $log->feedback = $task->feedback;
                    $log->priority = $task->priority;
                    $log->support = $task->support;
                    $log->task_created_at = $task->created_at;
                    $log->complete_description = $task->complete_description;
                    $log->cancel_description = $task->cancel_description;
                    $log->fail_description = $task->fail_description;
                    $log->complete_date = $task->complete_date;
                    $log->cancel_date = $task->cancel_date;
                    $log->fail_date = $task->fail_date;
                    $log->string_reserve1 = $task->string_reserve1;
                    $log->string_reserve2 = $task->string_reserve2;
                    $log->string_reserve3 = $task->string_reserve3;
                    $log->string_reserve4 = $task->string_reserve4;
                    $log->string_reserve5 = $task->string_reserve5;
                    $log->string_reserve6 = $task->string_reserve6;
                    $log->string_reserve7 = $task->string_reserve7;
                    $log->string_reserve8 = $task->string_reserve8;
                    $log->string_reserve9 = $task->string_reserve9;
                    $log->string_reserve10 = $task->string_reserve10;
                    $log->text_reserve1 = $task->text_reserve1;
                    $log->text_reserve2 = $task->text_reserve2;
                    $log->text_reserve3 = $task->text_reserve3;
                    $log->text_reserve4 = $task->text_reserve4;
                    $log->text_reserve5 = $task->text_reserve5;
                    $log->text_reserve6 = $task->text_reserve6;
                    $log->text_reserve7 = $task->text_reserve7;
                    $log->text_reserve8 = $task->text_reserve8;
                    $log->text_reserve9 = $task->text_reserve9;
                    $log->text_reserve10 = $task->text_reserve10;
                    $log->created_at = now();
                    $log->updated_at = now();
                    $log->save();


                    //Create Sub Tasks
                    $owners_for_subtasks = explode(";", $row['owner']);
                    $owners_for_subtasks = array_filter($owners_for_subtasks);
                    foreach ($owners_for_subtasks as $owner) {
                        $owner_user = User::where('email', $owner)->first();
                        $owner_id = $owner_user->id + 1989;
                        $subtask_create = new subTask();
                        $subtask_create->task_management_model_id = $task->id;
                        $subtask_create->fail_label_for_system = $task->fail_label_for_system;
                        $subtask_create->success_label_for_system = $task->success_label_for_system;
                        $subtask_create->uuid = $task->uuid;
                        $subtask_create->uuid_sub_task = $task->uuid . '-' . $owner_id;
                        $subtask_create->is_cancel = $task->is_cancel;
                        $subtask_create->is_complete = $task->is_complete;
                        $subtask_create->is_fail = $task->is_fail;
                        $subtask_create->is_success = $task->is_success;
                        $subtask_create->searchable = $task->searchable;
                        $subtask_create->user_id = $task->user_id;
                        $subtask_create->creator = $task->creator;
                        $subtask_create->current_status = $task->current_status;
                        $subtask_create->label_for_system = 'Child;';
                        $subtask_create->label_for_system2 = $task->label_for_system2;
                        $subtask_create->pending_for = $task->pending_for;
                        $subtask_create->visibletousers = $task->visibletousers;
                        $subtask_create->visibletoteams = $task->visibletoteams;
                        $subtask_create->createdbyteam = $task->createdbyteam;
                        $subtask_create->raisedbyuser = $task->raisedbyuser;
                        $subtask_create->issue = $task->issue;
                        $subtask_create->impact = $task->impact;
                        $subtask_create->rc = $task->rc;
                        $subtask_create->solution = $task->solution;
                        $subtask_create->solution2 = $task->solution2;
                        $subtask_create->solution3 = $task->solution3;
                        $subtask_create->due_date = $task->due_date;
                        $subtask_create->latest_update = $task->latest_update;
                        $subtask_create->progress = $task->progress;
                        $subtask_create->owner = $owner;
                        $subtask_create->current_processor = $task->current_processor;
                        $subtask_create->owner_team = $task->owner_team;
                        $subtask_create->support = $task->support;
                        $subtask_create->description = $task->description;
                        $subtask_create->feedback = $task->feedback;
                        $subtask_create->priority = $task->priority;
                        $subtask_create->complete_description = $task->complete_description;
                        $subtask_create->cancel_description = $task->cancel_description;
                        $subtask_create->fail_description = $task->fail_description;
                        $subtask_create->complete_date = $task->complete_date;
                        $subtask_create->cancel_date = $task->cancel_date;
                        $subtask_create->fail_date = $task->fail_date;
                        $subtask_create->string_reserve1 = $task->string_reserve1;
                        $subtask_create->string_reserve2 = $task->string_reserve2;
                        $subtask_create->string_reserve3 = $task->string_reserve3;
                        $subtask_create->string_reserve4 = $task->string_reserve4;
                        $subtask_create->string_reserve5 = $task->string_reserve5;
                        $subtask_create->string_reserve6 = $task->string_reserve6;
                        $subtask_create->string_reserve7 = $task->string_reserve7;
                        $subtask_create->string_reserve8 = $task->string_reserve8;
                        $subtask_create->string_reserve9 = $task->string_reserve9;
                        $subtask_create->string_reserve10 = $task->string_reserve10;
                        $subtask_create->text_reserve1 = $task->text_reserve1;
                        $subtask_create->text_reserve2 = $task->text_reserve2;
                        $subtask_create->text_reserve3 = $task->text_reserve3;
                        $subtask_create->text_reserve4 = $task->text_reserve4;
                        $subtask_create->text_reserve5 = $task->text_reserve5;
                        $subtask_create->text_reserve6 = $task->text_reserve6;
                        $subtask_create->text_reserve7 = $task->text_reserve7;
                        $subtask_create->text_reserve8 = $task->text_reserve8;
                        $subtask_create->text_reserve9 = $task->text_reserve9;
                        $subtask_create->text_reserve10 = $task->text_reserve10;
                        $subtask_create->created_at = now();
                        $subtask_create->updated_at = now();
                        $subtask_create->save();
                        //update UUID SubTask
                        $subtask_id = $subtask_create->id;
                        $subtask_create->uuid_sub_task = $task->uuid . '-' . $subtask_id + 100001981;
                        $subtask_create->save();

                        // Log Actions Create SubTasks
                        $log = new LogActionsTaskManagementModel();
                        $log->task_management_model_id = $task->id;
                        $log->fail_label_for_system = $task->fail_label_for_system;
                        $log->success_label_for_system = $task->success_label_for_system;
                        $log->action = 'Assign Task';
                        $log->uuid = $task->uuid;
                        $log->uuid_sub_task = $subtask_create->uuid_sub_task;
                        $log->is_cancel = $task->is_cancel;
                        $log->is_complete = $task->is_complete;
                        $log->is_fail = $task->is_fail;
                        $log->is_success = $task->is_success;
                        $log->searchable = $task->searchable;
                        $log->user_id = $task->user_id;
                        $log->creator = $task->creator;
                        $log->current_status = $task->current_status;
                        $log->label_for_system = 'Child;';
                        $log->label_for_system2 = $task->label_for_system2;
                        $log->pending_for = $task->pending_for;
                        $log->visibletousers = $task->visibletousers;
                        $log->visibletoteams = $task->visibletoteams;
                        $log->createdbyteam = $task->createdbyteam;
                        $log->raisedbyuser = $task->raisedbyuser;
                        $log->issue = $task->issue;
                        $log->impact = $task->impact;
                        $log->rc = $task->rc;
                        $log->solution = $task->solution;
                        $log->solution2 = $task->solution2;
                        $log->solution3 = $task->solution3;
                        $log->latest_update = $task->latest_update;
                        $log->due_date = $task->due_date;
                        $log->progress = $task->progress;
                        $log->owner = $owner;
                        $log->current_processor = $task->current_processor;
                        $log->owner_team = $task->owner_team;
                        $log->description = $task->description;
                        $log->feedback = $task->feedback;
                        $log->priority = $task->priority;
                        $log->support = $task->support;
                        $log->task_created_at = $task->created_at;
                        $log->complete_description = $task->complete_description;
                        $log->cancel_description = $task->cancel_description;
                        $log->fail_description = $task->fail_description;
                        $log->complete_date = $task->complete_date;
                        $log->cancel_date = $task->cancel_date;
                        $log->fail_date = $task->fail_date;
                        $log->string_reserve1 = $task->string_reserve1;
                        $log->string_reserve2 = $task->string_reserve2;
                        $log->string_reserve3 = $task->string_reserve3;
                        $log->string_reserve4 = $task->string_reserve4;
                        $log->string_reserve5 = $task->string_reserve5;
                        $log->string_reserve6 = $task->string_reserve6;
                        $log->string_reserve7 = $task->string_reserve7;
                        $log->string_reserve8 = $task->string_reserve8;
                        $log->string_reserve9 = $task->string_reserve9;
                        $log->string_reserve10 = $task->string_reserve10;
                        $log->text_reserve1 = $task->text_reserve1;
                        $log->text_reserve2 = $task->text_reserve2;
                        $log->text_reserve3 = $task->text_reserve3;
                        $log->text_reserve4 = $task->text_reserve4;
                        $log->text_reserve5 = $task->text_reserve5;
                        $log->text_reserve6 = $task->text_reserve6;
                        $log->text_reserve7 = $task->text_reserve7;
                        $log->text_reserve8 = $task->text_reserve8;
                        $log->text_reserve9 = $task->text_reserve9;
                        $log->text_reserve10 = $task->text_reserve10;
                        $log->created_at = now();
                        $log->updated_at = now();
                        $log->save();
                    }
                }
            }
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
        }

        return back()->with('success', 'New Tasks with Batch has been Created successfully.');
    }




    public function downloadtemplate(Request $request)
    {
        return response()->download(storage_path('task_management_template.csv'));
    }

    public function downloadtemplateupdate(Request $request)
    {
        return response()->download(storage_path('subtasks_update_template.csv'));
    }

    public function batchupdate(Request $request)
    {

        set_time_limit(500);

        // Set RAM to Max
        ini_set('memory_limit', '-1');

        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Read the CSV file using League\Csv\Reader
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $headers = $csv->getHeader();

        // Loop through each row and Update Subtasks And Log models

        // $data->uuid,
        // $data->uuid_sub_task,
        // $data->raisedbyuser,
        // $data->issue,
        // $data->impact,
        // $data->rc,
        // $data->solution,
        // $data->solution2,
        // $data->solution3,
        // $data->latest_update,
        // $data->due_date,
        // $data->progress,
        // $data->owner,
        // $data->current_processor,
        // $data->owner_team,
        // $data->support,
        // $data->description,
        // $data->feedback,
        // $data->priority,


        // 'UUID',    'UUID Sub Task',    'Raised by User',    'Issue',    'Impact',    'RC',    'Solution',
        // 'Solution2',    'Status',    'Latest Update',    'Due Date',    'Progress',    'Owner',    'Current Processor',
        // 'Owner Team',    'Support',    'Description',    'Feedback',    'Priority'

        foreach ($csv as $row) {

            if (!empty($row['UUID'])) {
                $row = array_map('utf8_encode', $row);

                $row['Feedback'] = strval($row['Feedback']);

                $taskmanagement_fb = subTask::where('uuid_sub_task', $row['UUID Sub Task'])->first();

                // Update Fb Data
                $update_taskmanagement = [
                    'id' => $taskmanagement_fb->id,
                    'impact' => $row['Impact'],
                    'rc' => $row['RC'],
                    'solution' => $row['Solution'],
                    'solution2' => $row['Solution2'],
                    'solution3' => $row['Status'],
                    'latest_update' => now(),
                    'progress' => $row['Progress'],
                    'feedback' => $row['Feedback'],
                    'label_for_system' => $taskmanagement_fb->label_for_system . 'Feedback Recived;',
                ];

                $taskmanagement_fb->update($update_taskmanagement);

                // Update Parent Task And Make Log
                //Find Parent
                $sub_task = (subTask::where('uuid_sub_task', $row['UUID Sub Task'])->first());
                $my_task_management_model_id = $sub_task->task_management_model_id;

                $parent_task = TaskManagementModel::where('id', $my_task_management_model_id)->first();

                if (!empty($sub_task->impact)) {
                    $parent_task->impact = $sub_task->impact;
                }
                if (!empty($sub_task->rc)) {
                    $parent_task->rc = $sub_task->rc;
                }
                $parent_task->solution = $sub_task->solution;
                if (!empty($sub_task->solution2)) {
                    $parent_task->solution2 = $sub_task->solution2;
                }
                if (!empty($sub_task->solution3)) {
                    $parent_task->solution3 = $sub_task->solution3;
                }
                $parent_task->latest_update = now();
                if (!empty($sub_task->progress)) {
                    $parent_task->progress = $sub_task->progress;
                }
                $parent_task->feedback = $sub_task->feedback;
                $parent_task->label_for_system = $parent_task->label_for_system . 'Feedback Recieved;';
                $parent_task->save();

                $userid = User::where('email', '=', $row['Owner'])->first()->id;
                // Log Actions Sub Task
                $task = subTask::where('uuid_sub_task', $row['UUID Sub Task'])->first();
                $log = new LogActionsTaskManagementModel();
                $log->task_management_model_id = $my_task_management_model_id;
                $log->fail_label_for_system = $task->fail_label_for_system;
                $log->success_label_for_system = $task->success_label_for_system;
                $log->action = 'Owner Feedback';
                $log->uuid = $task->uuid;
                $log->uuid_sub_task = $task->uuid_sub_task;
                $log->is_cancel = $task->is_cancel;
                $log->is_complete = $task->is_complete;
                $log->is_fail = $task->is_fail;
                $log->is_success = $task->is_success;
                $log->searchable = $task->searchable;
                $log->user_id = $userid;
                $log->creator = $task->creator;
                $log->current_status = $task->current_status;
                $log->label_for_system = $task->label_for_system;
                $log->label_for_system2 = $task->label_for_system2;
                $log->pending_for = $task->pending_for;
                $log->visibletousers = $task->visibletousers;
                $log->visibletoteams = $task->visibletoteams;
                $log->createdbyteam = $task->createdbyteam;
                $log->raisedbyuser = $task->raisedbyuser;
                $log->issue = $task->issue;
                $log->impact = $task->impact;
                $log->rc = $task->rc;
                $log->solution = $task->solution;
                $log->solution2 = $task->solution2;
                $log->solution3 = $task->solution3;
                $log->latest_update = $task->latest_update;
                $log->due_date = $task->due_date;
                $log->progress = $task->progress;
                $log->owner = $task->owner;
                $log->current_processor = $task->current_processor;
                $log->owner_team = $task->owner_team;
                $log->description = $task->description;
                $log->feedback = $task->feedback;
                $log->priority = $task->priority;
                $log->support = $task->support;
                $log->task_created_at = $task->created_at;
                $log->complete_description = $task->complete_description;
                $log->cancel_description = $task->cancel_description;
                $log->fail_description = $task->fail_description;
                $log->complete_date = $task->complete_date;
                $log->cancel_date = $task->cancel_date;
                $log->fail_date = $task->fail_date;
                $log->string_reserve1 = $task->string_reserve1;
                $log->string_reserve2 = $task->string_reserve2;
                $log->string_reserve3 = $task->string_reserve3;
                $log->string_reserve4 = $task->string_reserve4;
                $log->string_reserve5 = $task->string_reserve5;
                $log->string_reserve6 = $task->string_reserve6;
                $log->string_reserve7 = $task->string_reserve7;
                $log->string_reserve8 = $task->string_reserve8;
                $log->string_reserve9 = $task->string_reserve9;
                $log->string_reserve10 = $task->string_reserve10;
                $log->text_reserve1 = $task->text_reserve1;
                $log->text_reserve2 = $task->text_reserve2;
                $log->text_reserve3 = $task->text_reserve3;
                $log->text_reserve4 = $task->text_reserve4;
                $log->text_reserve5 = $task->text_reserve5;
                $log->text_reserve6 = $task->text_reserve6;
                $log->text_reserve7 = $task->text_reserve7;
                $log->text_reserve8 = $task->text_reserve8;
                $log->text_reserve9 = $task->text_reserve9;
                $log->text_reserve10 = $task->text_reserve10;
                $log->created_at = now();
                $log->updated_at = now();
                $log->save();
            }
        }

        return back()->with('success', 'Tasks Updated with Batch successfully.');
    }

    public function downloadtemplatecomplete(Request $request)
    {
        return response()->download(storage_path('complete_task_management_template.csv'));
    }

    public function batchcomplete(Request $request)
    {
        set_time_limit(600);

        // Set RAM to Max
        ini_set('memory_limit', '-1');

        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Read the CSV file using League\Csv\Reader
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $headers = $csv->getHeader();


        $teams = request()->user()->load('asssignusertoteam')
            ->asssignusertoteam->pluck('team_name')->first();
        $email =  request()->user()->email;
        $user_id = request()->user()->id;

        // UUID, Complete Description, Task Fail

        try {
            foreach ($csv as $row) {
                if (!empty($row['UUID'])) {
                    $row = array_map('utf8_encode', $row);
                    $completedtask = TaskManagementModel::where('uuid', $row['UUID'])->first();
                    $completedtask->is_complete = 1;
                    $completedtask->current_status = 'completed';
                    $completedtask->label_for_system = $completedtask->label_for_system . 'Complete Task';
                    // $completedtask->owner = null;
                    $completedtask->current_processor = null;
                    // $completedtask->support = null;
                    $completedtask->complete_date = now();
                    $completedtask->complete_description = $row['Complete Description'];

                    if ($row['Task Fail'] == 1) {
                        $completedtask->is_fail = 1;
                        $completedtask->fail_date = now();
                    } else {
                        $completedtask->is_success = 1;
                    }

                    $completedtask->update();

                    // Log Actions Complete Task
                    $task = TaskManagementModel::where('uuid', $row['UUID'])->first();
                    $log = new LogActionsTaskManagementModel();
                    $log->task_management_model_id = $task->id;
                    $log->fail_label_for_system = $task->fail_label_for_system;
                    $log->success_label_for_system = $task->success_label_for_system;
                    $log->action = 'Complete Task';
                    $log->uuid = $task->uuid;
                    $log->uuid_sub_task = $task->uuid_sub_task;
                    $log->is_cancel = $task->is_cancel;
                    $log->is_complete = $task->is_complete;
                    $log->is_fail = $task->is_fail;
                    $log->is_success = $task->is_success;
                    $log->searchable = $task->searchable;
                    $log->user_id = $task->user_id;
                    $log->creator = $task->creator;
                    $log->current_status = $task->current_status;
                    $log->label_for_system = $task->label_for_system;
                    $log->label_for_system2 = $task->label_for_system2;
                    $log->pending_for = $task->pending_for;
                    $log->visibletousers = $task->visibletousers;
                    $log->visibletoteams = $task->visibletoteams;
                    $log->createdbyteam = $task->createdbyteam;
                    $log->raisedbyuser = $task->raisedbyuser;
                    $log->issue = $task->issue;
                    $log->impact = $task->impact;
                    $log->rc = $task->rc;
                    $log->solution = $task->solution;
                    $log->solution2 = $task->solution2;
                    $log->solution3 = $task->solution3;
                    $log->latest_update = $task->latest_update;
                    $log->due_date = $task->due_date;
                    $log->progress = $task->progress;
                    $log->owner = $task->owner;
                    $log->current_processor = $task->current_processor;
                    $log->owner_team = $task->owner_team;
                    $log->description = $task->description;
                    $log->feedback = $task->feedback;
                    $log->priority = $task->priority;
                    $log->support = $task->support;
                    $log->task_created_at = $task->created_at;
                    $log->complete_description = $task->complete_description;
                    $log->cancel_description = $task->cancel_description;
                    $log->fail_description = $task->fail_description;
                    $log->complete_date = $task->complete_date;
                    $log->cancel_date = $task->cancel_date;
                    $log->fail_date = $task->fail_date;
                    $log->string_reserve1 = $task->string_reserve1;
                    $log->string_reserve2 = $task->string_reserve2;
                    $log->string_reserve3 = $task->string_reserve3;
                    $log->string_reserve4 = $task->string_reserve4;
                    $log->string_reserve5 = $task->string_reserve5;
                    $log->string_reserve6 = $task->string_reserve6;
                    $log->string_reserve7 = $task->string_reserve7;
                    $log->string_reserve8 = $task->string_reserve8;
                    $log->string_reserve9 = $task->string_reserve9;
                    $log->string_reserve10 = $task->string_reserve10;
                    $log->text_reserve1 = $task->text_reserve1;
                    $log->text_reserve2 = $task->text_reserve2;
                    $log->text_reserve3 = $task->text_reserve3;
                    $log->text_reserve4 = $task->text_reserve4;
                    $log->text_reserve5 = $task->text_reserve5;
                    $log->text_reserve6 = $task->text_reserve6;
                    $log->text_reserve7 = $task->text_reserve7;
                    $log->text_reserve8 = $task->text_reserve8;
                    $log->text_reserve9 = $task->text_reserve9;
                    $log->text_reserve10 = $task->text_reserve10;
                    $log->created_at = now();
                    $log->updated_at = now();
                    $log->save();


                    // Complete SubTasks after Completing Task
                    $complete_subtasks = subTask::where('task_management_model_id', $task->id)
                        ->where('is_cancel', '=', 0)
                        ->where('is_complete', '=', 0)
                        ->get();

                    foreach ($complete_subtasks as $complete_subtask) {
                        $complete_subtask->is_complete = 1;
                        $complete_subtask->current_status = 'completed';

                        // $complete_subtask->owner = null;
                        $complete_subtask->label_for_system = $complete_subtask->label_for_system . 'Complete Parent Task;';

                        $complete_subtask->current_processor = null;
                        // $complete_subtask->support = null;
                        $complete_subtask->complete_date = now();
                        $complete_subtask->complete_description =  $row['Complete Description'];

                        if ($row['Task Fail'] == 1) {
                            $complete_subtask->is_fail = 1;
                            $complete_subtask->fail_date = now();
                        } else {
                            $complete_subtask->is_success = 1;
                        }


                        $complete_subtask->update();


                        // Log Actions Complete SubTasks after Completing Task

                        $log = new LogActionsTaskManagementModel();
                        $log->task_management_model_id = $task->id;
                        $log->fail_label_for_system = $complete_subtask->fail_label_for_system;
                        $log->success_label_for_system = $complete_subtask->success_label_for_system;
                        $log->action = 'Complete Assign';
                        $log->uuid = $complete_subtask->uuid;
                        $log->uuid_sub_task = $complete_subtask->uuid_sub_task;
                        $log->is_cancel = $complete_subtask->is_cancel;
                        $log->is_complete = $complete_subtask->is_complete;
                        $log->is_fail = $complete_subtask->is_fail;
                        $log->is_success = $complete_subtask->is_success;
                        $log->searchable = $complete_subtask->searchable;
                        $log->user_id = $complete_subtask->user_id;
                        $log->creator = $complete_subtask->creator;
                        $log->current_status = $complete_subtask->current_status;
                        $log->label_for_system = $complete_subtask->label_for_system . 'Complete Assign;';
                        $log->label_for_system2 = $complete_subtask->label_for_system2;
                        $log->pending_for = $complete_subtask->pending_for;
                        $log->visibletousers = $complete_subtask->visibletousers;
                        $log->visibletoteams = $complete_subtask->visibletoteams;
                        $log->createdbyteam = $complete_subtask->createdbyteam;
                        $log->raisedbyuser = $complete_subtask->raisedbyuser;
                        $log->issue = $complete_subtask->issue;
                        $log->impact = $complete_subtask->impact;
                        $log->rc = $complete_subtask->rc;
                        $log->solution = $complete_subtask->solution;
                        $log->solution2 = $complete_subtask->solution2;
                        $log->solution3 = $complete_subtask->solution3;
                        $log->latest_update = $complete_subtask->latest_update;
                        $log->due_date = $complete_subtask->due_date;
                        $log->progress = $complete_subtask->progress;
                        $log->owner = $complete_subtask->owner;
                        $log->current_processor = $complete_subtask->current_processor;
                        $log->owner_team = $complete_subtask->owner_team;
                        $log->description = $complete_subtask->description;
                        $log->feedback = $complete_subtask->feedback;
                        $log->priority = $complete_subtask->priority;
                        $log->support = $complete_subtask->support;
                        $log->task_created_at = $complete_subtask->created_at;
                        $log->complete_description = $complete_subtask->complete_description;
                        $log->cancel_description = $complete_subtask->cancel_description;
                        $log->fail_description = $complete_subtask->fail_description;
                        $log->complete_date = $complete_subtask->complete_date;
                        $log->cancel_date = $complete_subtask->cancel_date;
                        $log->fail_date = $complete_subtask->fail_date;
                        $log->string_reserve1 = $complete_subtask->string_reserve1;
                        $log->string_reserve2 = $complete_subtask->string_reserve2;
                        $log->string_reserve3 = $complete_subtask->string_reserve3;
                        $log->string_reserve4 = $complete_subtask->string_reserve4;
                        $log->string_reserve5 = $complete_subtask->string_reserve5;
                        $log->string_reserve6 = $complete_subtask->string_reserve6;
                        $log->string_reserve7 = $complete_subtask->string_reserve7;
                        $log->string_reserve8 = $complete_subtask->string_reserve8;
                        $log->string_reserve9 = $complete_subtask->string_reserve9;
                        $log->string_reserve10 = $complete_subtask->string_reserve10;
                        $log->text_reserve1 = $complete_subtask->text_reserve1;
                        $log->text_reserve2 = $complete_subtask->text_reserve2;
                        $log->text_reserve3 = $complete_subtask->text_reserve3;
                        $log->text_reserve4 = $complete_subtask->text_reserve4;
                        $log->text_reserve5 = $complete_subtask->text_reserve5;
                        $log->text_reserve6 = $complete_subtask->text_reserve6;
                        $log->text_reserve7 = $complete_subtask->text_reserve7;
                        $log->text_reserve8 = $complete_subtask->text_reserve8;
                        $log->text_reserve9 = $complete_subtask->text_reserve9;
                        $log->text_reserve10 = $complete_subtask->text_reserve10;
                        $log->created_at = now();
                        $log->updated_at = now();
                        $log->save();
                    }
                }
            }
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
        }

        return back()->with('success', 'Tasks with Batch has been Completed successfully.');
    }
}
