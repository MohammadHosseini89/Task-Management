<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TaskManagementModel;
use App\Models\LogActionsTaskManagementModel;
use App\Models\MyTeams;
use App\Models\subTask;
use Livewire\WithFileUploads;

class TaskManagementCreateTasksLivewire extends Component
{
    use WithFileUploads;

    public $searchTermFirstOwner;
    public $searchTermFirstSupport;

    public $users_owner;
    public $users_support;


    public $createdbyteam, $raisedby, $issue, $solution2, $solution3, $impact;
    public $rc, $solution, $due_date, $latest_update, $progress, $owner;
    public $support, $description, $user_id, $current_processor, $uuid, $priority;
    public $creator;

    public $file;
    public $stringowner;
    public $stringsupport;
    public $selectedItems = [];
    public $supportselectedItems = [];


    public function render(Request $request)
    {

        if (strlen($this->searchTermFirstOwner) >= 3) {
            $this->users_owner = User::whereRaw('lower(name) like ?', ['%' . strtolower($this->searchTermFirstOwner) . '%'])
                ->orWhereRaw('lower(jobid) like ?', ['%' . strtolower($this->searchTermFirstOwner) . '%'])
                ->get();
        }

        if (strlen($this->searchTermFirstSupport) >= 3) {
            $this->users_support = User::whereRaw('lower(name) like ?', ['%' . strtolower($this->searchTermFirstSupport) . '%'])
                ->orWhereRaw('lower(jobid) like ?', ['%' . strtolower($this->searchTermFirstSupport) . '%'])
                ->get();
        }

        $raisedby_access = MyTeams::where('user_id', '=', $this->user_id)->first();


        return view('livewire.task-management-create-tasks-livewire', [
            'raisedby_access' => $raisedby_access,
        ]);
    }



    // Mount
    public function mount(Request $request)
    {
        $teams = request()->user()->load('asssignusertoteam')
            ->asssignusertoteam->pluck('team_name')->first();

        $this->user_id = auth()->user()->id;
        $this->createdbyteam = $teams;
        $this->creator = auth()->user()->name;
        $this->latest_update = date('Y-m-d H:i:s', strtotime(now()));
    }


    // Create & Validate

    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'createdbyteam' => 'required|string|max:255',
            'raisedby' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'impact' => 'nullable|string|max:255',
            'rc' => 'nullable|string|max:255',
            'solution' => 'nullable|string|max:255',
            'solution2' => 'nullable|string|max:255',
            'solution3' => 'required|string|max:255',
            'due_date' => 'required|date|after:now',
            'latest_update' => 'nullable|string|max:255',
            'progress' => 'nullable|numeric|between:0,100',
            'owner' => 'required|string|max:255',
            'support' => 'nullable|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|max:255',
            'uuid' => 'nullable',
            // 'file' => 'nullable|mimes:csv,xlsx,pdf,rar|max:2048',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 0-100.',

            // 'file.mimes' => 'The :attribute field must be a CSV, XLSX, PDF, or RAR file.',
            // 'file.max' => 'The :attribute field may not be larger than :max kilobytes.',
        ]);
    }

    public function storeTaskManagementData(Request $request)
    {

        $this->owner = $this->stringowner;
        $this->support = $this->stringsupport;
        //on form submit validation
        $this->validate([
            'createdbyteam' => 'required|string|max:255',
            'raisedby' => 'required|string|max:255',
            'issue' => 'required|string|max:255',
            'impact' => 'nullable|string|max:255',
            'rc' => 'nullable|string|max:255',
            'solution' => 'nullable|string|max:255',
            'solution2' => 'nullable|string|max:255',
            'solution3' => 'required|string|max:255',
            'due_date' => 'required|date|after:now',
            'latest_update' => 'nullable|string|max:255',
            'progress' => 'nullable|numeric|between:0,100',
            'owner' => 'required|string|max:255',
            'support' => 'nullable|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|max:255',
            'uuid' => 'nullable',
            // 'file' => 'nullable|mimes:csv,xlsx,pdf,rar|max:2048',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 0-100.',

            // 'file.mimes' => 'The :attribute field must be a CSV, XLSX, PDF, or RAR file.',
            // 'file.max' => 'The :attribute field may not be larger than :max kilobytes.',
        ]);


        //Add TaskManagementModel Data
        $taskmanagement = new TaskManagementModel();

        $taskmanagement->createdbyteam = $this->createdbyteam;
        $taskmanagement->raisedbyuser = $this->raisedby;
        $taskmanagement->issue = $this->issue;
        $taskmanagement->impact = $this->impact;
        $taskmanagement->rc = $this->rc;
        $taskmanagement->solution = $this->solution;
        $taskmanagement->solution2 = $this->solution2;
        $taskmanagement->solution3 = $this->solution3;
        $taskmanagement->due_date = $this->due_date;
        $taskmanagement->latest_update = $this->latest_update;
        $taskmanagement->progress = $this->progress;
        $taskmanagement->owner = $this->stringowner;
        $taskmanagement->current_processor = $this->owner;
        $taskmanagement->user_id = $this->user_id;
        $taskmanagement->support = $this->support;
        $taskmanagement->description = $this->description;
        $taskmanagement->priority = $this->priority;
        $taskmanagement->uuid = $this->uuid;


        if ($taskmanagement['progress'] === null) {
            $taskmanagement['progress'] = 0;
        }



        $create_taskmanagement = [
            'creator' => auth()->user()->email,
            'createdbyteam' => $taskmanagement['createdbyteam'],
            'raisedbyuser' => $taskmanagement['raisedbyuser'],
            'issue' => $taskmanagement['issue'],
            'impact' => $taskmanagement['impact'],
            'rc' => $taskmanagement['rc'],
            'solution' => $taskmanagement['solution'],
            'solution2' => $taskmanagement['solution2'],
            'solution3' => $taskmanagement['solution3'],
            'due_date' => $taskmanagement['due_date'],
            'latest_update' => $taskmanagement['latest_update'],
            'progress' => $taskmanagement['progress'],
            'owner' => $this->stringowner,
            'current_processor' => $taskmanagement['current_processor'],
            'user_id' => $taskmanagement['user_id'],
            'support' => $this->stringsupport,
            'description' => $taskmanagement['description'],
            'priority' => $taskmanagement['priority'],
            'label_for_system' => 'Parent;',
        ];

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
        $owners_for_subtasks = explode(";", $this->stringowner);
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



        if ($this->getErrorBag()->any()) {
            // There are validation errors, so don't save the file
            return;
        }

        if ($this->file) {
            $attach = new Attachment;
            $filename = $this->file->getClientOriginalName();
            $extension = $this->file->getClientOriginalExtension();
            $current_time = date('Y-m-d_H-i-s');
            $path = $this->file->storeAs('public/attachments/' . $task->uuid, $current_time . $filename);
            $attach->user_id = auth()->user()->id;
            $attach->user_name = auth()->user()->name;
            $attach->email = auth()->user()->email;
            $attach->attached_in = 'Create Task';
            $attach->task_management_model_id = $task->id;
            $attach->filename = $this->file->getClientOriginalName();
            $attach->file_extension = $this->file->getClientOriginalExtension();
            $attach->storage_path = $path;
            $attach->save();

            // Perform any necessary actions with the uploaded file here...
        }

        // null important wires
        $this->issue = '';
        $this->impact = '';
        $this->rc = '';
        $this->solution = '';
        $this->solution2 = '';
        $this->solution3 = '';
        $this->due_date = '';
        $this->progress = '';
        $this->owner = '';
        $this->current_processor = '';
        $this->support = '';
        $this->description = '';
        $this->priority = '';
        $this->uuid = '';
        $this->stringowner = '';
        $this->stringsupport = '';
        $this->file = '';


        session()->flash('message', 'New Task has been Created successfully');
    }

    // get owners
    public function getSelectedOwners()
    {
        $ownerforcreate = [];
        // Save the selected items to the database
        foreach ($this->selectedItems as $selectedOwners) {
            $ownerforcreate[] = $selectedOwners;
        }

        $delimiter = ';';
        $this->stringowner = implode($delimiter, array_values($ownerforcreate)) . $delimiter;

        // Clear the selected items array
        $this->selectedItems = [];

        $this->dispatchBrowserEvent('close-view-owner-search-modal');
        // // Show a success message
        session()->flash('message', 'Owners Selected successfully');
    }

    //get supports

    public function getSelectedSupports()
    {
        $supportforcreate = [];
        // Save the selected items to the database
        foreach ($this->supportselectedItems as $selectedOwners) {
            $supportforcreate[] = $selectedOwners;
        }

        $delimiter = ';';
        $this->stringsupport = implode($delimiter, array_values($supportforcreate)) . $delimiter;

        // Clear the selected items array
        $this->supportselectedItems = [];

        $this->dispatchBrowserEvent('close-view-support-search-modal');
        // // Show a success message
        session()->flash('message', 'Support Selected successfully');
    }



    //  Modal Search Owner Open
    public function searchmodalowneropen()
    {
        $this->dispatchBrowserEvent('show-view-owner-search-modal');
    }

    //  Modal Search Support Open
    public function searchmodalsupportopen()
    {
        $this->dispatchBrowserEvent('show-view-support-search-modal');
    }

    //  Modal Search Owner Close
    public function searchmodalownerclose()
    {
        $this->dispatchBrowserEvent('close-view-owner-search-modal');
    }

    //  Modal Search Support Close
    public function searchmodalsupportclose()
    {
        $this->dispatchBrowserEvent('close-view-support-search-modal');
    }
}
