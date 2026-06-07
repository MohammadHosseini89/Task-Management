<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\subTask;
use Livewire\Component;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ExportLogModel;
use App\Models\uaActionsAttemp;
use App\Models\TaskManagementModel;
use Illuminate\Support\Facades\Storage;
use App\Models\LogActionsTaskManagementModel;

class TaskManagementDispatchedByMeLivewire extends Component
{
    use WithFileUploads;
    public $dispatchedbyme_taskmanagementmodel;
    public $modalDispatchedByMe;
    public $task_cancel_id;
    public $task_edit_id;

    public $edit_issue, $edit_solution2, $edit_solution3, $edit_impact, $edit_priority;
    public $edit_rc, $edit_solution, $edit_due_date, $edit_latest_update, $edit_progress, $edit_owner;
    public $edit_support, $edit_description, $edit_current_processor, $edit_raisedbyuser;

    public $user_id_dispatch_access;
    public $searchTermFirstOwnerEdit;
    public $SupportEditsearchTermFirst;

    public $users_owner_edit;
    public $users_support_edit;

    public $dispatchedbymetasklog;
    public $tasklogmodal;

    public $stringowner_edit, $stringsupport_edit;
    public $selectedItems_edit = [];
    public $supportselectedItems_edit = [];

    public $dispatchedbymeattach;
    public $file;

    public $Assigned_SubTasks;
    public $cancel_subtasks_id;

    public $request_subtask_cancel;
    public $complete_task_id;
    public $complete_subtasks_id;
    public $complete_request_subtask;

    public $assignback_subtasks_id;
    public $assignback_request_subtask;

    public $assignbackfeedback;

    public $task_cancel_description;
    public $task_complete_description;

    public $subtask_complete_description;
    public $subtask_cancel_description;


    public $issue_livesearch, $priority_livesearch, $owner_livesearch;
    public $uuid_livesearch, $description_livesearch, $raisedbyuser_livesearch;
    public $task_fail;
    public $subtask_fail;



    use WithPagination;


    public function render(Request $request)
    {
        $viewDetailsDispatchedByMe = TaskManagementModel::where('user_id', '=', $request->user()->id)
            ->orderBy('latest_update', 'desc')
            ->where('issue', 'like', '%' . $this->issue_livesearch . '%')
            ->where('uuid', 'like', '%' . $this->uuid_livesearch . '%')
            ->where('priority', 'like', '%' . $this->priority_livesearch . '%')
            ->where('owner', 'like', '%' . $this->owner_livesearch . '%')
            ->where('description', 'like', '%' . $this->description_livesearch . '%')
            ->where('raisedbyuser', 'like', '%' . $this->raisedbyuser_livesearch . '%')
            ->paginate(10);



        if (strlen($this->searchTermFirstOwnerEdit) >= 3) {
            $this->users_owner_edit = User::whereRaw('lower(name) like ?', ['%' . strtolower($this->searchTermFirstOwnerEdit) . '%'])
                ->orWhereRaw('lower(jobid) like ?', ['%' . strtolower($this->searchTermFirstOwnerEdit) . '%'])
                ->get();
        }

        if (strlen($this->SupportEditsearchTermFirst) >= 3) {
            $this->users_support_edit = User::whereRaw('lower(name) like ?', ['%' . strtolower($this->SupportEditsearchTermFirst) . '%'])
                ->orWhereRaw('lower(jobid) like ?', ['%' . strtolower($this->SupportEditsearchTermFirst) . '%'])
                ->get();
        }

        return view('livewire.task-management-dispatched-by-me-livewire', [
            'viewDetailsDispatchedByMe' => $viewDetailsDispatchedByMe,
        ])->with(['paginator' => $viewDetailsDispatchedByMe]);
    }

    // Mount
    public function mount(Request $request)
    {
        $this->dispatchedbyme_taskmanagementmodel = TaskManagementModel::where('user_id', '=', $request->user()->id)
            ->orderBy('latest_update', 'desc')
            ->get();

        $this->user_id_dispatch_access = auth()->user()->id;
    }


    // Edit Task

    public function editTaskManagementDataDispatch($id)
    {
        $this->modalDispatchedByMe = $this->dispatchedbyme_taskmanagementmodel->where('id', '=', $id)->first();

        $taskmanagement_edit = TaskManagementModel::where('id', $id)->first();


        if ($taskmanagement_edit->user_id === $this->user_id_dispatch_access) {
            $this->task_edit_id = $taskmanagement_edit->id;
            $this->edit_raisedbyuser = $taskmanagement_edit->raisedbyuser;
            $this->edit_issue = $taskmanagement_edit->issue;
            $this->edit_impact = $taskmanagement_edit->impact;
            $this->edit_rc = $taskmanagement_edit->rc;
            $this->edit_solution = $taskmanagement_edit->solution;
            $this->edit_solution2 = $taskmanagement_edit->solution2;
            $this->edit_solution3 = $taskmanagement_edit->solution3;
            $this->edit_due_date = $taskmanagement_edit->due_date;
            $this->edit_latest_update = $taskmanagement_edit->latest_update;
            $this->edit_progress = $taskmanagement_edit->progress;
            $this->edit_support = $taskmanagement_edit->support;
            $this->edit_owner = $taskmanagement_edit->owner;
            $this->edit_description = $taskmanagement_edit->description;
            $this->edit_priority = $taskmanagement_edit->priority;
            $this->edit_current_processor = $taskmanagement_edit->current_processor;

            $this->dispatchBrowserEvent('show-edit-task-management-modal');
        } else {
            // Log UA Try Edit
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Edit Attemp UA';
            $ualog->task_management_model_id = $id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }

    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'edit_raisedbyuser' => 'required|string|max:255',
            'edit_issue' => 'required|string|max:255',
            'edit_impact' => 'nullable|string|max:255',
            'edit_rc' => 'nullable|string|max:255',
            'edit_solution' => 'nullable|string|max:255',
            'edit_solution2' => 'nullable|string|max:255',
            'edit_solution3' => 'required|string|max:255',
            'edit_due_date' => 'required|date|after:now',
            'edit_latest_update' => 'nullable|string|max:255',
            'edit_progress' => 'nullable|numeric|between:0,100',
            'edit_owner' => 'required|string|max:255',
            'edit_support' => 'nullable|string|max:255',
            'edit_description' => 'required|string',
            'edit_priority' => 'required|string|max:255',
            'task_cancel_description' => 'required|string'

        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 0-100.'
        ]);
    }


    public function editTaskData(Request $request)
    {
        if (strlen($this->searchTermFirstOwnerEdit) >= 3) {
            $this->edit_owner = $this->stringowner_edit;
        }

        if (strlen($this->SupportEditsearchTermFirst) >= 3) {
            $this->edit_support = $this->stringsupport_edit;
        }

        //on form submit validation
        $this->validate([
            'edit_raisedbyuser' => 'required|string|max:255',
            'edit_issue' => 'required|string|max:255',
            'edit_impact' => 'nullable|string|max:255',
            'edit_rc' => 'nullable|string|max:255',
            'edit_solution' => 'nullable|string|max:255',
            'edit_solution2' => 'nullable|string|max:255',
            'edit_solution3' => 'required|string|max:255',
            'edit_due_date' => 'required|date|after:now',
            'edit_latest_update' => 'nullable|string|max:255',
            'edit_progress' => 'nullable|numeric|between:0,100',
            // 'edit_owner' => 'required|string|max:255',
            'edit_support' => 'nullable|string|max:255',
            'edit_description' => 'required|string',
            'edit_priority' => 'required|string|max:255',

        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 0-100.'
        ]);

        // get Edit Data
        $taskmanagement_edit = TaskManagementModel::where('id', $this->task_edit_id)->first();
        $taskmanagement_edit->raisedbyuser = $this->edit_raisedbyuser;
        $taskmanagement_edit->issue = $this->edit_issue;
        $taskmanagement_edit->impact = $this->edit_impact;
        $taskmanagement_edit->rc = $this->edit_rc;
        $taskmanagement_edit->solution = $this->edit_solution;
        $taskmanagement_edit->solution2 = $this->edit_solution2;
        $taskmanagement_edit->solution3 = $this->edit_solution3;
        $taskmanagement_edit->due_date = $this->edit_due_date;
        $taskmanagement_edit->latest_update = $this->edit_latest_update;
        $taskmanagement_edit->progress = $this->edit_progress;
        $taskmanagement_edit->owner = $this->edit_owner;
        $taskmanagement_edit->current_processor = $this->edit_owner;
        $taskmanagement_edit->support = $this->edit_support;
        $taskmanagement_edit->description = $this->edit_description;
        $taskmanagement_edit->priority = $this->edit_priority;

        // Update Edit Data
        $update_taskmanagement = [
            'id' => $taskmanagement_edit->id,
            'raisedbyuser' => $taskmanagement_edit->raisedbyuser,
            'issue' => $taskmanagement_edit->issue,
            'impact' => $taskmanagement_edit->impact,
            'rc' => $taskmanagement_edit->rc,
            'solution' => $taskmanagement_edit->solution,
            'solution2' => $taskmanagement_edit->solution2,
            'solution3' => $taskmanagement_edit->solution3,
            'due_date' => $taskmanagement_edit->due_date,
            'latest_update' => now(),
            'progress' => $taskmanagement_edit->progress,
            'label_for_system' => $taskmanagement_edit->label_for_system . 'Edit Task;',
            // 'owner' => $taskmanagement_edit->owner,
            // 'current_processor' => $taskmanagement_edit->owner,
            'support' => $taskmanagement_edit->support,
            'description' => $taskmanagement_edit->description,
            'priority' =>  $taskmanagement_edit->priority,
        ];

        $taskmanagement_edit->update($update_taskmanagement);


        // Log Actions Edit Task
        $task = TaskManagementModel::where('id', $this->task_edit_id)->first();
        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $task->id;
        $log->fail_label_for_system = $task->fail_label_for_system;
        $log->success_label_for_system = $task->success_label_for_system;
        $log->action = 'Edit Task';
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
        $log->label_for_system = $task->label_for_system . 'Edit Task;';
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

        // Subtasks Edit
        $edit_subtasks = subTask::where('task_management_model_id', $this->task_edit_id)
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->get();

        foreach ($edit_subtasks as $edit_subtask) {

            $update_taskmanagement['label_for_system'] = $edit_subtask->label_for_system . 'Edit Task;';
            $edit_subtask->update($update_taskmanagement);

            // Log Actions Sync SubTasks

            $log = new LogActionsTaskManagementModel();
            $log->task_management_model_id = $this->task_edit_id;
            $log->fail_label_for_system = $edit_subtask->fail_label_for_system;
            $log->success_label_for_system = $edit_subtask->success_label_for_system;
            $log->action = 'Assigned Task Sync';
            $log->uuid = $edit_subtask->uuid;
            $log->uuid_sub_task = $edit_subtask->uuid_sub_task;
            $log->is_cancel = $edit_subtask->is_cancel;
            $log->is_complete = $edit_subtask->is_complete;
            $log->is_fail = $edit_subtask->is_fail;
            $log->is_success = $edit_subtask->is_success;
            $log->searchable = $edit_subtask->searchable;
            $log->user_id = $edit_subtask->user_id;
            $log->creator = $edit_subtask->creator;
            $log->current_status = $edit_subtask->current_status;
            $log->label_for_system = $edit_subtask->label_for_system . 'Sync Subtask;';
            $log->label_for_system2 = $edit_subtask->label_for_system2;
            $log->pending_for = $edit_subtask->pending_for;
            $log->visibletousers = $edit_subtask->visibletousers;
            $log->visibletoteams = $edit_subtask->visibletoteams;
            $log->createdbyteam = $edit_subtask->createdbyteam;
            $log->raisedbyuser = $edit_subtask->raisedbyuser;
            $log->issue = $edit_subtask->issue;
            $log->impact = $edit_subtask->impact;
            $log->rc = $edit_subtask->rc;
            $log->solution = $edit_subtask->solution;
            $log->solution2 = $edit_subtask->solution2;
            $log->solution3 = $edit_subtask->solution3;
            $log->latest_update = $edit_subtask->latest_update;
            $log->due_date = $edit_subtask->due_date;
            $log->progress = $edit_subtask->progress;
            $log->owner = $edit_subtask->owner;
            $log->current_processor = $edit_subtask->current_processor;
            $log->owner_team = $edit_subtask->owner_team;
            $log->description = $edit_subtask->description;
            $log->feedback = $edit_subtask->feedback;
            $log->priority = $edit_subtask->priority;
            $log->support = $edit_subtask->support;
            $log->task_created_at = $edit_subtask->created_at;
            $log->complete_description = $edit_subtask->complete_description;
            $log->cancel_description = $edit_subtask->cancel_description;
            $log->fail_description = $edit_subtask->fail_description;
            $log->complete_date = $edit_subtask->complete_date;
            $log->cancel_date = $edit_subtask->cancel_date;
            $log->fail_date = $edit_subtask->fail_date;
            $log->string_reserve1 = $edit_subtask->string_reserve1;
            $log->string_reserve2 = $edit_subtask->string_reserve2;
            $log->string_reserve3 = $edit_subtask->string_reserve3;
            $log->string_reserve4 = $edit_subtask->string_reserve4;
            $log->string_reserve5 = $edit_subtask->string_reserve5;
            $log->string_reserve6 = $edit_subtask->string_reserve6;
            $log->string_reserve7 = $edit_subtask->string_reserve7;
            $log->string_reserve8 = $edit_subtask->string_reserve8;
            $log->string_reserve9 = $edit_subtask->string_reserve9;
            $log->string_reserve10 = $edit_subtask->string_reserve10;
            $log->text_reserve1 = $edit_subtask->text_reserve1;
            $log->text_reserve2 = $edit_subtask->text_reserve2;
            $log->text_reserve3 = $edit_subtask->text_reserve3;
            $log->text_reserve4 = $edit_subtask->text_reserve4;
            $log->text_reserve5 = $edit_subtask->text_reserve5;
            $log->text_reserve6 = $edit_subtask->text_reserve6;
            $log->text_reserve7 = $edit_subtask->text_reserve7;
            $log->text_reserve8 = $edit_subtask->text_reserve8;
            $log->text_reserve9 = $edit_subtask->text_reserve9;
            $log->text_reserve10 = $edit_subtask->text_reserve10;
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
            $attach->attached_in = 'Edit Task';
            $attach->task_management_model_id = $task->id;
            $attach->filename = $this->file->getClientOriginalName();
            $attach->file_extension = $this->file->getClientOriginalExtension();
            $attach->storage_path = $path;
            $attach->save();

            // Perform any necessary actions with the uploaded file here...
        }


        session()->flash('message', 'Task has been Updated successfully');

        // null important wires
        $this->edit_issue = '';
        $this->edit_impact = '';
        $this->edit_rc = '';
        $this->edit_solution = '';
        $this->edit_solution2 = '';
        $this->edit_solution3 = '';
        $this->edit_due_date = '';
        $this->edit_progress = '';
        $this->edit_owner = '';
        $this->edit_current_processor = '';
        $this->edit_support = '';
        $this->edit_description = '';
        $this->edit_priority = '';
        $this->stringowner_edit = '';
        $this->stringsupport_edit = '';
        $this->file = '';

        $this->dispatchBrowserEvent('close-edit-task-management-modal');
    }



    // Cancel Task
    public function cancelConfirm($id)
    {

        $this->modalDispatchedByMe = $this->dispatchedbyme_taskmanagementmodel->where('id', '=', $id)->first();
        $this->task_cancel_id = $id;
        $request_for_cancel = TaskManagementModel::where('id', $this->task_cancel_id)->first();
        if ($request_for_cancel->user_id === $this->user_id_dispatch_access) {
            $this->dispatchBrowserEvent('show-cancel-confirmation-modal');
        } else {
            // Log UA Try Cancel
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Cancel Task Attemp UA';
            $ualog->task_management_model_id = $this->task_cancel_id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }


    public function CancelTask()
    {
        $this->validate([
            'task_cancel_description' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
        ]);

        $cancelledtask = TaskManagementModel::where('id', $this->task_cancel_id)->first();
        $cancelledtask->is_cancel = 1;
        $cancelledtask->current_status = 'cancelled';
        $cancelledtask->label_for_system = $cancelledtask->label_for_system . 'Cancel Task;';

        // $cancelledtask->owner = null;
        $cancelledtask->current_processor = null;
        $cancelledtask->cancel_date = now();
        $cancelledtask->cancel_description = $this->task_cancel_description;
        // $cancelledtask->support = null;

        $cancelledtask->update();



        // Log Actions Cancel Task
        $task = TaskManagementModel::where('id', $this->task_cancel_id)->first();
        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $task->id;
        $log->fail_label_for_system = $task->fail_label_for_system;
        $log->success_label_for_system = $task->success_label_for_system;
        $log->action = 'Cancel Task';
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




        // Cancel SubTasks after cancelling Task
        $cancel_subtasks = subTask::where('task_management_model_id', $this->task_cancel_id)
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->get();

        foreach ($cancel_subtasks as $cancel_subtask) {
            $cancel_subtask->is_cancel = 1;
            $cancel_subtask->current_status = 'cancelled';
            // $cancel_subtask->owner = null;
            $cancel_subtask->label_for_system = $cancel_subtask->label_for_system . 'Cancel Parent Task;';

            $cancel_subtask->current_processor = null;
            // $cancel_subtask->support = null;
            $cancel_subtask->cancel_date = now();
            $cancel_subtask->cancel_description = $this->task_cancel_description;

            $cancel_subtask->update();


            // Log Actions Cancel SubTasks after cancelling Task

            $log = new LogActionsTaskManagementModel();
            $log->task_management_model_id = $this->task_cancel_id;
            $log->fail_label_for_system = $cancel_subtask->fail_label_for_system;
            $log->success_label_for_system = $cancel_subtask->success_label_for_system;
            $log->action = 'Cancel Assign';
            $log->uuid = $cancel_subtask->uuid;
            $log->uuid_sub_task = $cancel_subtask->uuid_sub_task;
            $log->is_cancel = $cancel_subtask->is_cancel;
            $log->is_complete = $cancel_subtask->is_complete;
            $log->is_fail = $cancel_subtask->is_fail;
            $log->is_success = $cancel_subtask->is_success;
            $log->searchable = $cancel_subtask->searchable;
            $log->user_id = $cancel_subtask->user_id;
            $log->creator = $cancel_subtask->creator;
            $log->current_status = $cancel_subtask->current_status;
            $log->label_for_system = $cancel_subtask->label_for_system . 'Cancel Assign;';
            $log->label_for_system2 = $cancel_subtask->label_for_system2;
            $log->pending_for = $cancel_subtask->pending_for;
            $log->visibletousers = $cancel_subtask->visibletousers;
            $log->visibletoteams = $cancel_subtask->visibletoteams;
            $log->createdbyteam = $cancel_subtask->createdbyteam;
            $log->raisedbyuser = $cancel_subtask->raisedbyuser;
            $log->issue = $cancel_subtask->issue;
            $log->impact = $cancel_subtask->impact;
            $log->rc = $cancel_subtask->rc;
            $log->solution = $cancel_subtask->solution;
            $log->solution2 = $cancel_subtask->solution2;
            $log->solution3 = $cancel_subtask->solution3;
            $log->latest_update = $cancel_subtask->latest_update;
            $log->due_date = $cancel_subtask->due_date;
            $log->progress = $cancel_subtask->progress;
            $log->owner = $cancel_subtask->owner;
            $log->current_processor = $cancel_subtask->current_processor;
            $log->owner_team = $cancel_subtask->owner_team;
            $log->description = $cancel_subtask->description;
            $log->feedback = $cancel_subtask->feedback;
            $log->priority = $cancel_subtask->priority;
            $log->support = $cancel_subtask->support;
            $log->task_created_at = $cancel_subtask->created_at;
            $log->complete_description = $cancel_subtask->complete_description;
            $log->cancel_description = $cancel_subtask->cancel_description;
            $log->fail_description = $cancel_subtask->fail_description;
            $log->complete_date = $cancel_subtask->complete_date;
            $log->cancel_date = $cancel_subtask->cancel_date;
            $log->fail_date = $cancel_subtask->fail_date;
            $log->string_reserve1 = $cancel_subtask->string_reserve1;
            $log->string_reserve2 = $cancel_subtask->string_reserve2;
            $log->string_reserve3 = $cancel_subtask->string_reserve3;
            $log->string_reserve4 = $cancel_subtask->string_reserve4;
            $log->string_reserve5 = $cancel_subtask->string_reserve5;
            $log->string_reserve6 = $cancel_subtask->string_reserve6;
            $log->string_reserve7 = $cancel_subtask->string_reserve7;
            $log->string_reserve8 = $cancel_subtask->string_reserve8;
            $log->string_reserve9 = $cancel_subtask->string_reserve9;
            $log->string_reserve10 = $cancel_subtask->string_reserve10;
            $log->text_reserve1 = $cancel_subtask->text_reserve1;
            $log->text_reserve2 = $cancel_subtask->text_reserve2;
            $log->text_reserve3 = $cancel_subtask->text_reserve3;
            $log->text_reserve4 = $cancel_subtask->text_reserve4;
            $log->text_reserve5 = $cancel_subtask->text_reserve5;
            $log->text_reserve6 = $cancel_subtask->text_reserve6;
            $log->text_reserve7 = $cancel_subtask->text_reserve7;
            $log->text_reserve8 = $cancel_subtask->text_reserve8;
            $log->text_reserve9 = $cancel_subtask->text_reserve9;
            $log->text_reserve10 = $cancel_subtask->text_reserve10;
            $log->created_at = now();
            $log->updated_at = now();
            $log->save();
        }


        session()->flash('message', 'Task has been Cancelled successfully');


        $this->dispatchBrowserEvent('close-modal-cancel');

        $this->task_cancel_description = '';
        $this->task_cancel_id = '';
    }

    //Complete Data Task Modal
    public function CompleteDataDispatch($id)
    {

        $this->modalDispatchedByMe = $this->dispatchedbyme_taskmanagementmodel->where('id', '=', $id)->first();
        $this->complete_task_id = $id;
        $complete_request = TaskManagementModel::where('id', $this->complete_task_id)
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->first();

        if ($complete_request->user_id === $this->user_id_dispatch_access) {
            $this->dispatchBrowserEvent('show-complete-confirmation-modal');
        } else {

            // Log UA Try Complete
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Complete Task Attemp UA';
            $ualog->task_management_model_id = $this->complete_task_id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }


    public function CompleteTask()
    {
        $this->validate([
            'task_complete_description' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
        ]);

        $completedtask = TaskManagementModel::where('id', $this->complete_task_id)->first();
        $completedtask->is_complete = 1;
        $completedtask->current_status = 'completed';
        $completedtask->label_for_system = $completedtask->label_for_system . 'Complete Task';
        // $completedtask->owner = null;
        $completedtask->current_processor = null;
        // $completedtask->support = null;
        $completedtask->complete_date = now();
        $completedtask->complete_description = $this->task_complete_description;

        if($this->task_fail){
            $completedtask->is_fail = 1;
            $completedtask->fail_date = now();
        }else{
            $completedtask->is_success = 1;
        }

        $completedtask->update();


        // Log Actions Complete Task
        $task = TaskManagementModel::where('id', $this->complete_task_id)->first();
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
        $complete_subtasks = subTask::where('task_management_model_id', $this->complete_task_id)
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
            $complete_subtask->complete_description = $this->task_complete_description;

            if($this->task_fail){
                $complete_subtask->is_fail = 1;
                $complete_subtask->fail_date = now();
            }else{
                $complete_subtask->is_success = 1;
            }


            $complete_subtask->update();


            // Log Actions Complete SubTasks after Completing Task

            $log = new LogActionsTaskManagementModel();
            $log->task_management_model_id = $this->complete_task_id;
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


        session()->flash('message', 'Task has been Completed successfully');


        $this->dispatchBrowserEvent('close-complete-confirmation-modal');

        $this->task_complete_description = '';
        $this->complete_task_id = '';
        $this->task_fail = '';
    }

    public function CloseModalComplete()
    {
        $this->dispatchBrowserEvent('close-complete-confirmation-modal');
    }



    // Complete SubTask Modal Solo
    public function CompleteSubTask($id)
    {
        $this->complete_subtasks_id = $id;
        $this->complete_request_subtask = subTask::where('id', $this->complete_subtasks_id)->first();
        if ($this->complete_request_subtask->user_id === $this->user_id_dispatch_access) {
            $this->dispatchBrowserEvent('show-subtask-complete-confirmation-modal');
        } else {
            // Log UA Try Cancel Solo
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Complete Subtask Attemp UA';
            $ualog->task_management_model_id = $this->complete_subtasks_id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }


    public function CloseSubtaskCompleteModal()
    {
        $this->dispatchBrowserEvent('close-subtask-complete-confirmation-modal');
    }


    // Complete Subtask Action
    public function CompleteSubTaskConfirmed()
    {
        $this->validate([
            'subtask_complete_description' => 'required|string',

        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
        ]);

        //find owner and parent to replace in parent task
        $owner_to_replace_in_task = $this->complete_request_subtask->owner . ';';
        $taskid = $this->complete_request_subtask->task_management_model_id;

        //Complete Subtask Solo
        $this->complete_request_subtask->is_complete = 1;
        $this->complete_request_subtask->current_status = 'completed';
        // $this->complete_request_subtask->owner = null;
        $this->complete_request_subtask->label_for_system = $this->complete_request_subtask->label_for_system . 'Complete Assign Solo;';
        $this->complete_request_subtask->current_processor = null;
        // $this->complete_request_subtask->support = null;

        if($this->subtask_fail){
            $this->complete_request_subtask->is_fail = 1;
            $this->complete_request_subtask->fail_date = now();
        }else{
            $this->complete_request_subtask->is_success = 1;
        }

        $this->complete_request_subtask->complete_date = now();
        $this->complete_request_subtask->complete_description = $this->subtask_complete_description;
        $this->complete_request_subtask->update();


        // Log Actions Complete SubTask Solo

        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $this->complete_request_subtask->task_management_model_id;
        $log->fail_label_for_system = $this->complete_request_subtask->fail_label_for_system;
        $log->success_label_for_system = $this->complete_request_subtask->success_label_for_system;
        $log->action = 'Complete Assign';
        $log->uuid = $this->complete_request_subtask->uuid;
        $log->uuid_sub_task = $this->complete_request_subtask->uuid_sub_task;
        $log->is_cancel = $this->complete_request_subtask->is_cancel;
        $log->is_complete = $this->complete_request_subtask->is_complete;
        $log->is_fail = $this->complete_request_subtask->is_fail;
        $log->is_success = $this->complete_request_subtask->is_success;
        $log->searchable = $this->complete_request_subtask->searchable;
        $log->user_id = $this->complete_request_subtask->user_id;
        $log->creator = $this->complete_request_subtask->creator;
        $log->current_status = $this->complete_request_subtask->current_status;
        $log->label_for_system = $this->complete_request_subtask->label_for_system;
        $log->label_for_system2 = $this->complete_request_subtask->label_for_system2;
        $log->pending_for = $this->complete_request_subtask->pending_for;
        $log->visibletousers = $this->complete_request_subtask->visibletousers;
        $log->visibletoteams = $this->complete_request_subtask->visibletoteams;
        $log->createdbyteam = $this->complete_request_subtask->createdbyteam;
        $log->raisedbyuser = $this->complete_request_subtask->raisedbyuser;
        $log->issue = $this->complete_request_subtask->issue;
        $log->impact = $this->complete_request_subtask->impact;
        $log->rc = $this->complete_request_subtask->rc;
        $log->solution = $this->complete_request_subtask->solution;
        $log->solution2 = $this->complete_request_subtask->solution2;
        $log->solution3 = $this->complete_request_subtask->solution3;
        $log->latest_update = $this->complete_request_subtask->latest_update;
        $log->due_date = $this->complete_request_subtask->due_date;
        $log->progress = $this->complete_request_subtask->progress;
        $log->owner = $this->complete_request_subtask->owner;
        $log->current_processor = $this->complete_request_subtask->current_processor;
        $log->owner_team = $this->complete_request_subtask->owner_team;
        $log->description = $this->complete_request_subtask->description;
        $log->feedback = $this->complete_request_subtask->feedback;
        $log->priority = $this->complete_request_subtask->priority;
        $log->support = $this->complete_request_subtask->support;
        $log->task_created_at = $this->complete_request_subtask->created_at;
        $log->complete_description = $this->complete_request_subtask->complete_description;
        $log->cancel_description = $this->complete_request_subtask->cancel_description;
        $log->fail_description = $this->complete_request_subtask->fail_description;
        $log->complete_date = $this->complete_request_subtask->complete_date;
        $log->cancel_date = $this->complete_request_subtask->cancel_date;
        $log->fail_date = $this->complete_request_subtask->fail_date;
        $log->string_reserve1 = $this->complete_request_subtask->string_reserve1;
        $log->string_reserve2 = $this->complete_request_subtask->string_reserve2;
        $log->string_reserve3 = $this->complete_request_subtask->string_reserve3;
        $log->string_reserve4 = $this->complete_request_subtask->string_reserve4;
        $log->string_reserve5 = $this->complete_request_subtask->string_reserve5;
        $log->string_reserve6 = $this->complete_request_subtask->string_reserve6;
        $log->string_reserve7 = $this->complete_request_subtask->string_reserve7;
        $log->string_reserve8 = $this->complete_request_subtask->string_reserve8;
        $log->string_reserve9 = $this->complete_request_subtask->string_reserve9;
        $log->string_reserve10 = $this->complete_request_subtask->string_reserve10;
        $log->text_reserve1 = $this->complete_request_subtask->text_reserve1;
        $log->text_reserve2 = $this->complete_request_subtask->text_reserve2;
        $log->text_reserve3 = $this->complete_request_subtask->text_reserve3;
        $log->text_reserve4 = $this->complete_request_subtask->text_reserve4;
        $log->text_reserve5 = $this->complete_request_subtask->text_reserve5;
        $log->text_reserve6 = $this->complete_request_subtask->text_reserve6;
        $log->text_reserve7 = $this->complete_request_subtask->text_reserve7;
        $log->text_reserve8 = $this->complete_request_subtask->text_reserve8;
        $log->text_reserve9 = $this->complete_request_subtask->text_reserve9;
        $log->text_reserve10 = $this->complete_request_subtask->text_reserve10;
        $log->created_at = now();
        $log->updated_at = now();
        $log->save();



        // Sync Parent Task Porocessor

        $parent_task = TaskManagementModel::where('id', $taskid)->first();
        $parent_task->owner = str_replace($owner_to_replace_in_task, '', $parent_task->owner);
        $parent_task->current_processor = str_replace($owner_to_replace_in_task, '', $parent_task->current_processor);
        $parent_task->latest_update = now();
        $parent_task->label_for_system = $parent_task->label_for_system . 'Complete Assign Solo;';
        $parent_task->update();


        // Log Actions Sync Task Processor Task
        $task = TaskManagementModel::where('id', $taskid)->first();
        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $task->id;
        $log->fail_label_for_system = $task->fail_label_for_system;
        $log->success_label_for_system = $task->success_label_for_system;
        $log->action = 'Sync Task Processors';
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
        $log->label_for_system = $task->label_for_system . 'Sync Task Processors;';
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

        $this->subtask_complete_description = '';
        $this->subtask_fail = '';

        $this->dispatchBrowserEvent('close-subtask-complete-confirmation-modal');
    }



    // Cancel SubTask Modal Solo
    public function cancelSubTask($id)
    {
        $this->cancel_subtasks_id = $id;
        $this->request_subtask_cancel = subTask::where('id', $this->cancel_subtasks_id)->first();
        if ($this->request_subtask_cancel->user_id === $this->user_id_dispatch_access) {
            $this->dispatchBrowserEvent('show-subtask-cancel-confirmation-modal');
        } else {
            // Log UA Try Cancel Solo
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Cancel Subtask Attemp UA';
            $ualog->task_management_model_id = $this->cancel_subtasks_id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }

    // Cancel Subtask Action
    public function CancelSubTaskConfirmed()
    {
        $this->validate([
            'subtask_cancel_description' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
        ]);

        //find owner and parent to replace in parent task
        $owner_to_replace_in_task = $this->request_subtask_cancel->owner . ';';
        $taskid = $this->request_subtask_cancel->task_management_model_id;

        //Cancel Subtask Solo
        $this->request_subtask_cancel->is_cancel = 1;
        $this->request_subtask_cancel->current_status = 'cancelled';
        // $this->request_subtask_cancel->owner = null;
        $this->request_subtask_cancel->label_for_system = $this->request_subtask_cancel->label_for_system . 'Cancel Assign Solo;';
        $this->request_subtask_cancel->current_processor = null;
        // $this->request_subtask_cancel->support = null;

        $this->request_subtask_cancel->cancel_date = now();
        $this->request_subtask_cancel->cancel_description = $this->subtask_cancel_description;

        $this->request_subtask_cancel->update();

        // Log Actions Cancel SubTask Solo

        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $this->request_subtask_cancel->task_management_model_id;
        $log->fail_label_for_system = $this->request_subtask_cancel->fail_label_for_system;
        $log->success_label_for_system = $this->request_subtask_cancel->success_label_for_system;
        $log->action = 'Cancel Assign';
        $log->uuid = $this->request_subtask_cancel->uuid;
        $log->uuid_sub_task = $this->request_subtask_cancel->uuid_sub_task;
        $log->is_cancel = $this->request_subtask_cancel->is_cancel;
        $log->is_complete = $this->request_subtask_cancel->is_complete;
        $log->is_fail = $this->request_subtask_cancel->is_fail;
        $log->is_success = $this->request_subtask_cancel->is_success;
        $log->searchable = $this->request_subtask_cancel->searchable;
        $log->user_id = $this->request_subtask_cancel->user_id;
        $log->creator = $this->request_subtask_cancel->creator;
        $log->current_status = $this->request_subtask_cancel->current_status;
        $log->label_for_system = $this->request_subtask_cancel->label_for_system;
        $log->label_for_system2 = $this->request_subtask_cancel->label_for_system2;
        $log->pending_for = $this->request_subtask_cancel->pending_for;
        $log->visibletousers = $this->request_subtask_cancel->visibletousers;
        $log->visibletoteams = $this->request_subtask_cancel->visibletoteams;
        $log->createdbyteam = $this->request_subtask_cancel->createdbyteam;
        $log->raisedbyuser = $this->request_subtask_cancel->raisedbyuser;
        $log->issue = $this->request_subtask_cancel->issue;
        $log->impact = $this->request_subtask_cancel->impact;
        $log->rc = $this->request_subtask_cancel->rc;
        $log->solution = $this->request_subtask_cancel->solution;
        $log->solution2 = $this->request_subtask_cancel->solution2;
        $log->solution3 = $this->request_subtask_cancel->solution3;
        $log->latest_update = $this->request_subtask_cancel->latest_update;
        $log->due_date = $this->request_subtask_cancel->due_date;
        $log->progress = $this->request_subtask_cancel->progress;
        $log->owner = $this->request_subtask_cancel->owner;
        $log->current_processor = $this->request_subtask_cancel->current_processor;
        $log->owner_team = $this->request_subtask_cancel->owner_team;
        $log->description = $this->request_subtask_cancel->description;
        $log->feedback = $this->request_subtask_cancel->feedback;
        $log->priority = $this->request_subtask_cancel->priority;
        $log->support = $this->request_subtask_cancel->support;
        $log->task_created_at = $this->request_subtask_cancel->created_at;
        $log->complete_description = $this->request_subtask_cancel->complete_description;
        $log->cancel_description = $this->request_subtask_cancel->cancel_description;
        $log->fail_description = $this->request_subtask_cancel->fail_description;
        $log->complete_date = $this->request_subtask_cancel->complete_date;
        $log->cancel_date = $this->request_subtask_cancel->cancel_date;
        $log->fail_date = $this->request_subtask_cancel->fail_date;
        $log->string_reserve1 = $this->request_subtask_cancel->string_reserve1;
        $log->string_reserve2 = $this->request_subtask_cancel->string_reserve2;
        $log->string_reserve3 = $this->request_subtask_cancel->string_reserve3;
        $log->string_reserve4 = $this->request_subtask_cancel->string_reserve4;
        $log->string_reserve5 = $this->request_subtask_cancel->string_reserve5;
        $log->string_reserve6 = $this->request_subtask_cancel->string_reserve6;
        $log->string_reserve7 = $this->request_subtask_cancel->string_reserve7;
        $log->string_reserve8 = $this->request_subtask_cancel->string_reserve8;
        $log->string_reserve9 = $this->request_subtask_cancel->string_reserve9;
        $log->string_reserve10 = $this->request_subtask_cancel->string_reserve10;
        $log->text_reserve1 = $this->request_subtask_cancel->text_reserve1;
        $log->text_reserve2 = $this->request_subtask_cancel->text_reserve2;
        $log->text_reserve3 = $this->request_subtask_cancel->text_reserve3;
        $log->text_reserve4 = $this->request_subtask_cancel->text_reserve4;
        $log->text_reserve5 = $this->request_subtask_cancel->text_reserve5;
        $log->text_reserve6 = $this->request_subtask_cancel->text_reserve6;
        $log->text_reserve7 = $this->request_subtask_cancel->text_reserve7;
        $log->text_reserve8 = $this->request_subtask_cancel->text_reserve8;
        $log->text_reserve9 = $this->request_subtask_cancel->text_reserve9;
        $log->text_reserve10 = $this->request_subtask_cancel->text_reserve10;
        $log->created_at = now();
        $log->updated_at = now();
        $log->save();


        // Sync Parent Task Porocessor

        $parent_task = TaskManagementModel::where('id', $taskid)->first();
        $parent_task->owner = str_replace($owner_to_replace_in_task, '', $parent_task->owner);
        $parent_task->current_processor = str_replace($owner_to_replace_in_task, '', $parent_task->current_processor);
        $parent_task->latest_update = now();
        $parent_task->label_for_system = $parent_task->label_for_system . 'Cancel Assign Solo;';
        $parent_task->update();


        // Log Actions Cancel Task
        $task = TaskManagementModel::where('id', $taskid)->first();
        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $task->id;
        $log->fail_label_for_system = $task->fail_label_for_system;
        $log->success_label_for_system = $task->success_label_for_system;
        $log->action = 'Sync Task Processors';
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
        $log->label_for_system = $task->label_for_system . 'Sync Task Processors;';
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

        $this->subtask_cancel_description = '';

        $this->dispatchBrowserEvent('close-subtask-cancel-confirmation-modal');
    }

    // Close Modal Control Assign
    public function CloseControlAssignModal()
    {
        $this->dispatchBrowserEvent('close-view-assign-modal');
    }

    // Close Modal Cancel Sub Task

    public function CloseSubtaskCancelModal()
    {
        $this->dispatchBrowserEvent('close-subtask-cancel-confirmation-modal');
    }

    // Close Modal Cancel Task
    public function CloseModalCancel()
    {
        $this->task_cancel_id = '';
        $this->dispatchBrowserEvent('close-modal-cancel');
    }

    // Close Edit Modal
    public function closeEditTaskManagementModal()
    {
        $this->dispatchBrowserEvent('close-edit-task-management-modal');
    }

    // DispatchedbyME Modal Function

    public function viewDetailsDispatchedByMe($id)
    {
        $this->modalDispatchedByMe = $this->dispatchedbyme_taskmanagementmodel->where('id', '=', $id)->first();
        //log table come
        $this->dispatchedbymetasklog = LogActionsTaskManagementModel::where('task_management_model_id', '=', $id)
            // ->orderBy('id', 'asc')
            ->get();
        //attach table come
        $this->dispatchedbymeattach = Attachment::where('task_management_model_id', '=', $id)->get();
        $this->dispatchBrowserEvent('show-view-dispatched-by-me-modal');
    }

    // Download Attach Function
    public function downloadattach($id)
    {
        $which_attachmemt = $this->dispatchedbymeattach->where('id', '=', $id)->first();

        // Check if the attachment exists
        if (!$which_attachmemt) {
            abort(404);
        }

        // Get the file path from the attachment
        $path = $which_attachmemt->storage_path;

        // Check if the file exists
        if (!Storage::exists($path)) {
            abort(404);
        }


        // Generate and return the download response
        $filename = $which_attachmemt->filename;

        //log download

        ExportLogModel::LogUserExportCSV($id, auth()->user(), $which_attachmemt->file_extension, session()->getId(), $filename);

        return response()->download(storage_path('app/' . $path), $filename, [
            'Content-Type' => Storage::mimeType($path),
        ]);
    }

    //Assign Control Modal
    public function editAssignDataDispatch($id)
    {
        $this->modalDispatchedByMe = $this->dispatchedbyme_taskmanagementmodel->where('id', '=', $id)->first();

        $userid_check = TaskManagementModel::where('id', $id)->first()->user_id;
        $this->Assigned_SubTasks = subTask::where('user_id', $this->user_id_dispatch_access)
            ->where('task_management_model_id', $id)->get();

        if ($userid_check === $this->user_id_dispatch_access) {

            $this->dispatchBrowserEvent('show-view-assign-modal');
        } else {
            // Log UA Try Edit Solo
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Edit Assign Attemp UA';
            $ualog->task_management_model_id = $id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }



    //  Add Assign To Tasks Function
    public function addAssigntoTask()
    {
        if (strlen($this->searchTermFirstOwnerEdit) >= 3) {
            $this->edit_owner = $this->stringowner_edit;

            //on form submit validation
            $this->validate([
                'edit_owner' => 'required|string|max:255',
            ], [
                'required' => 'The :attribute field is required.',
                'string' => 'The :attribute field must be a string.',
            ]);

            $owner_to_add = $this->edit_owner;
            $taskid_for_newassign = $this->modalDispatchedByMe->id;
            // get Task Data and update its Processor
            $task_add_owner = TaskManagementModel::where('id', $taskid_for_newassign)->first();
            $current_owners = $task_add_owner->owner;
            $current_processors = $task_add_owner->current_processor;

            $task_add_owner->owner = $current_owners . $this->edit_owner;
            $task_add_owner->current_processor = $current_processors . $this->edit_owner;

            $task_add_owner->update();

            // Build Sub Tasks Assign
            $owners_for_subtasks = explode(";", $owner_to_add);
            $owners_for_subtasks = array_filter($owners_for_subtasks);
            foreach ($owners_for_subtasks as $owner) {
                $owner_user = User::where('email', $owner)->first();
                $owner_id = $owner_user->id + 1989;
                $subtask_create = new subTask();
                $subtask_create->task_management_model_id = $taskid_for_newassign;
                $subtask_create->fail_label_for_system = $task_add_owner->fail_label_for_system;
                $subtask_create->success_label_for_system = $task_add_owner->success_label_for_system;
                $subtask_create->uuid = $task_add_owner->uuid;
                $subtask_create->uuid_sub_task = $task_add_owner->uuid . '-' . $owner_id;
                $subtask_create->is_cancel = $task_add_owner->is_cancel;
                $subtask_create->is_complete = $task_add_owner->is_complete;
                $subtask_create->is_fail = $task_add_owner->is_fail;
                $subtask_create->is_success = $task_add_owner->is_success;
                $subtask_create->searchable = $task_add_owner->searchable;
                $subtask_create->user_id = $task_add_owner->user_id;
                $subtask_create->creator = $task_add_owner->creator;
                $subtask_create->current_status = $task_add_owner->current_status;
                $subtask_create->label_for_system = 'Child;';
                $subtask_create->label_for_system2 = $task_add_owner->label_for_system2;
                $subtask_create->pending_for = $task_add_owner->pending_for;
                $subtask_create->visibletousers = $task_add_owner->visibletousers;
                $subtask_create->visibletoteams = $task_add_owner->visibletoteams;
                $subtask_create->createdbyteam = $task_add_owner->createdbyteam;
                $subtask_create->raisedbyuser = $task_add_owner->raisedbyuser;
                $subtask_create->issue = $task_add_owner->issue;
                $subtask_create->impact = $task_add_owner->impact;
                $subtask_create->rc = $task_add_owner->rc;
                $subtask_create->solution = $task_add_owner->solution;
                $subtask_create->solution2 = $task_add_owner->solution2;
                $subtask_create->solution3 = $task_add_owner->solution3;
                $subtask_create->due_date = $task_add_owner->due_date;
                $subtask_create->latest_update = $task_add_owner->latest_update;
                $subtask_create->progress = $task_add_owner->progress;
                $subtask_create->owner = $owner;
                $subtask_create->current_processor = $task_add_owner->current_processor;
                $subtask_create->owner_team = $task_add_owner->owner_team;
                $subtask_create->support = $task_add_owner->support;
                $subtask_create->description = $task_add_owner->description;
                $subtask_create->feedback = $task_add_owner->feedback;
                $subtask_create->priority = $task_add_owner->priority;
                $subtask_create->complete_description = $task_add_owner->complete_description;
                $subtask_create->cancel_description = $task_add_owner->cancel_description;
                $subtask_create->fail_description = $task_add_owner->fail_description;
                $subtask_create->complete_date = $task_add_owner->complete_date;
                $subtask_create->cancel_date = $task_add_owner->cancel_date;
                $subtask_create->fail_date = $task_add_owner->fail_date;
                $subtask_create->string_reserve1 = $task_add_owner->string_reserve1;
                $subtask_create->string_reserve2 = $task_add_owner->string_reserve2;
                $subtask_create->string_reserve3 = $task_add_owner->string_reserve3;
                $subtask_create->string_reserve4 = $task_add_owner->string_reserve4;
                $subtask_create->string_reserve5 = $task_add_owner->string_reserve5;
                $subtask_create->string_reserve6 = $task_add_owner->string_reserve6;
                $subtask_create->string_reserve7 = $task_add_owner->string_reserve7;
                $subtask_create->string_reserve8 = $task_add_owner->string_reserve8;
                $subtask_create->string_reserve9 = $task_add_owner->string_reserve9;
                $subtask_create->string_reserve10 = $task_add_owner->string_reserve10;
                $subtask_create->text_reserve1 = $task_add_owner->text_reserve1;
                $subtask_create->text_reserve2 = $task_add_owner->text_reserve2;
                $subtask_create->text_reserve3 = $task_add_owner->text_reserve3;
                $subtask_create->text_reserve4 = $task_add_owner->text_reserve4;
                $subtask_create->text_reserve5 = $task_add_owner->text_reserve5;
                $subtask_create->text_reserve6 = $task_add_owner->text_reserve6;
                $subtask_create->text_reserve7 = $task_add_owner->text_reserve7;
                $subtask_create->text_reserve8 = $task_add_owner->text_reserve8;
                $subtask_create->text_reserve9 = $task_add_owner->text_reserve9;
                $subtask_create->text_reserve10 = $task_add_owner->text_reserve10;
                $subtask_create->created_at = now();
                $subtask_create->updated_at = now();
                $subtask_create->save();

                //update UUID SubTask
                $subtask_id = $subtask_create->id;
                $subtask_create->uuid_sub_task = $task_add_owner->uuid . '-' . $subtask_id + 100001981;
                $subtask_create->save();

                // Log Actions Create SubTasks
                $log = new LogActionsTaskManagementModel();
                $log->task_management_model_id = $taskid_for_newassign;
                $log->fail_label_for_system = $task_add_owner->fail_label_for_system;
                $log->success_label_for_system = $task_add_owner->success_label_for_system;
                $log->action = 'Assign Task';
                $log->uuid = $task_add_owner->uuid;
                $log->uuid_sub_task = $subtask_create->uuid_sub_task;
                $log->is_cancel = $task_add_owner->is_cancel;
                $log->is_complete = $task_add_owner->is_complete;
                $log->is_fail = $task_add_owner->is_fail;
                $log->is_success = $task_add_owner->is_success;
                $log->searchable = $task_add_owner->searchable;
                $log->user_id = $task_add_owner->user_id;
                $log->creator = $task_add_owner->creator;
                $log->current_status = $task_add_owner->current_status;
                $log->label_for_system = 'Child;';
                $log->label_for_system2 = $task_add_owner->label_for_system2;
                $log->pending_for = $task_add_owner->pending_for;
                $log->visibletousers = $task_add_owner->visibletousers;
                $log->visibletoteams = $task_add_owner->visibletoteams;
                $log->createdbyteam = $task_add_owner->createdbyteam;
                $log->raisedbyuser = $task_add_owner->raisedbyuser;
                $log->issue = $task_add_owner->issue;
                $log->impact = $task_add_owner->impact;
                $log->rc = $task_add_owner->rc;
                $log->solution = $task_add_owner->solution;
                $log->solution2 = $task_add_owner->solution2;
                $log->solution3 = $task_add_owner->solution3;
                $log->latest_update = $task_add_owner->latest_update;
                $log->due_date = $task_add_owner->due_date;
                $log->progress = $task_add_owner->progress;
                $log->owner = $owner;
                $log->current_processor = $task_add_owner->current_processor;
                $log->owner_team = $task_add_owner->owner_team;
                $log->description = $task_add_owner->description;
                $log->feedback = $task_add_owner->feedback;
                $log->priority = $task_add_owner->priority;
                $log->support = $task_add_owner->support;
                $log->task_created_at = $task_add_owner->created_at;
                $log->complete_description = $task_add_owner->complete_description;
                $log->cancel_description = $task_add_owner->cancel_description;
                $log->fail_description = $task_add_owner->fail_description;
                $log->complete_date = $task_add_owner->complete_date;
                $log->cancel_date = $task_add_owner->cancel_date;
                $log->fail_date = $task_add_owner->fail_date;
                $log->string_reserve1 = $task_add_owner->string_reserve1;
                $log->string_reserve2 = $task_add_owner->string_reserve2;
                $log->string_reserve3 = $task_add_owner->string_reserve3;
                $log->string_reserve4 = $task_add_owner->string_reserve4;
                $log->string_reserve5 = $task_add_owner->string_reserve5;
                $log->string_reserve6 = $task_add_owner->string_reserve6;
                $log->string_reserve7 = $task_add_owner->string_reserve7;
                $log->string_reserve8 = $task_add_owner->string_reserve8;
                $log->string_reserve9 = $task_add_owner->string_reserve9;
                $log->string_reserve10 = $task_add_owner->string_reserve10;
                $log->text_reserve1 = $task_add_owner->text_reserve1;
                $log->text_reserve2 = $task_add_owner->text_reserve2;
                $log->text_reserve3 = $task_add_owner->text_reserve3;
                $log->text_reserve4 = $task_add_owner->text_reserve4;
                $log->text_reserve5 = $task_add_owner->text_reserve5;
                $log->text_reserve6 = $task_add_owner->text_reserve6;
                $log->text_reserve7 = $task_add_owner->text_reserve7;
                $log->text_reserve8 = $task_add_owner->text_reserve8;
                $log->text_reserve9 = $task_add_owner->text_reserve9;
                $log->text_reserve10 = $task_add_owner->text_reserve10;
                $log->created_at = now();
                $log->updated_at = now();
                $log->save();
            }

            // Log Sync Task
            $log = new LogActionsTaskManagementModel();
            $log->task_management_model_id = $taskid_for_newassign;
            $log->fail_label_for_system = $task_add_owner->fail_label_for_system;
            $log->success_label_for_system = $task_add_owner->success_label_for_system;
            $log->action = 'Sync Task Processors';
            $log->uuid = $task_add_owner->uuid;
            $log->uuid_sub_task = $subtask_create->uuid_sub_task;
            $log->is_cancel = $task_add_owner->is_cancel;
            $log->is_complete = $task_add_owner->is_complete;
            $log->is_fail = $task_add_owner->is_fail;
            $log->is_success = $task_add_owner->is_success;
            $log->searchable = $task_add_owner->searchable;
            $log->user_id = $task_add_owner->user_id;
            $log->creator = $task_add_owner->creator;
            $log->current_status = $task_add_owner->current_status;
            $log->label_for_system = $task_add_owner->label_for_system . 'Sync Task Processors;';
            $log->label_for_system2 = $task_add_owner->label_for_system2;
            $log->pending_for = $task_add_owner->pending_for;
            $log->visibletousers = $task_add_owner->visibletousers;
            $log->visibletoteams = $task_add_owner->visibletoteams;
            $log->createdbyteam = $task_add_owner->createdbyteam;
            $log->raisedbyuser = $task_add_owner->raisedbyuser;
            $log->issue = $task_add_owner->issue;
            $log->impact = $task_add_owner->impact;
            $log->rc = $task_add_owner->rc;
            $log->solution = $task_add_owner->solution;
            $log->solution2 = $task_add_owner->solution2;
            $log->solution3 = $task_add_owner->solution3;
            $log->latest_update = $task_add_owner->latest_update;
            $log->due_date = $task_add_owner->due_date;
            $log->progress = $task_add_owner->progress;
            $log->owner = $task_add_owner->owner;
            $log->current_processor = $task_add_owner->current_processor;
            $log->owner_team = $task_add_owner->owner_team;
            $log->description = $task_add_owner->description;
            $log->feedback = $task_add_owner->feedback;
            $log->priority = $task_add_owner->priority;
            $log->support = $task_add_owner->support;
            $log->task_created_at = $task_add_owner->created_at;
            $log->complete_description = $task_add_owner->complete_description;
            $log->cancel_description = $task_add_owner->cancel_description;
            $log->fail_description = $task_add_owner->fail_description;
            $log->complete_date = $task_add_owner->complete_date;
            $log->cancel_date = $task_add_owner->cancel_date;
            $log->fail_date = $task_add_owner->fail_date;
            $log->string_reserve1 = $task_add_owner->string_reserve1;
            $log->string_reserve2 = $task_add_owner->string_reserve2;
            $log->string_reserve3 = $task_add_owner->string_reserve3;
            $log->string_reserve4 = $task_add_owner->string_reserve4;
            $log->string_reserve5 = $task_add_owner->string_reserve5;
            $log->string_reserve6 = $task_add_owner->string_reserve6;
            $log->string_reserve7 = $task_add_owner->string_reserve7;
            $log->string_reserve8 = $task_add_owner->string_reserve8;
            $log->string_reserve9 = $task_add_owner->string_reserve9;
            $log->string_reserve10 = $task_add_owner->string_reserve10;
            $log->text_reserve1 = $task_add_owner->text_reserve1;
            $log->text_reserve2 = $task_add_owner->text_reserve2;
            $log->text_reserve3 = $task_add_owner->text_reserve3;
            $log->text_reserve4 = $task_add_owner->text_reserve4;
            $log->text_reserve5 = $task_add_owner->text_reserve5;
            $log->text_reserve6 = $task_add_owner->text_reserve6;
            $log->text_reserve7 = $task_add_owner->text_reserve7;
            $log->text_reserve8 = $task_add_owner->text_reserve8;
            $log->text_reserve9 = $task_add_owner->text_reserve9;
            $log->text_reserve10 = $task_add_owner->text_reserve10;
            $log->created_at = now();
            $log->updated_at = now();
            $log->save();

            $this->edit_owner = '';
            $this->stringowner_edit = '';

            session()->flash('message', 'New Assign has been Created successfully');

            $this->dispatchBrowserEvent('close-view-assign-modal');
        }
    }

    // Assign Back Modal
    public function rejectedAssignBack($id)
    {
        $this->assignback_subtasks_id = $id;
        $this->assignback_request_subtask = subTask::where('id', $this->assignback_subtasks_id)->first();
        // $this->assignbackfeedback = $this->assignback_request_subtask->feedback ;

        if ($this->assignback_request_subtask->user_id === $this->user_id_dispatch_access) {
            $this->dispatchBrowserEvent('show-subtask-assign-back-modal');
        } else {
            // Log UA Try Cancel Solo
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Assign Back Subtask Attemp UA';
            $ualog->task_management_model_id = $this->complete_subtasks_id;
            $ualog->user_id = auth()->user()->id;
            $ualog->user_name = auth()->user()->name;
            $ualog->email = auth()->user()->email;
            $ualog->save();
            $this->dispatchBrowserEvent('show-ua-info-modal');
        }
    }

    //Assign Back Rejected Subtask
    public function AssignBackSubTask()
    {
        $this->assignback_request_subtask->label_for_system2 = null;
        $this->assignback_request_subtask->label_for_system = $this->assignback_request_subtask->label_for_system . 'Assign Back;';
        $this->assignback_request_subtask->feedback = $this->assignbackfeedback;
        $this->assignback_request_subtask->latest_update = now();
        $this->assignback_request_subtask->update();

        session()->flash('message', 'Assign Back has been Done successfully');

        // Log Actions Assign Back SubTask

        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $this->assignback_request_subtask->task_management_model_id;
        $log->fail_label_for_system = $this->assignback_request_subtask->fail_label_for_system;
        $log->success_label_for_system = $this->assignback_request_subtask->success_label_for_system;
        $log->action = 'Assign Back';
        $log->uuid = $this->assignback_request_subtask->uuid;
        $log->uuid_sub_task = $this->assignback_request_subtask->uuid_sub_task;
        $log->is_cancel = $this->assignback_request_subtask->is_cancel;
        $log->is_complete = $this->assignback_request_subtask->is_complete;
        $log->is_fail = $this->assignback_request_subtask->is_fail;
        $log->is_success = $this->assignback_request_subtask->is_success;
        $log->searchable = $this->assignback_request_subtask->searchable;
        $log->user_id = $this->assignback_request_subtask->user_id;
        $log->creator = $this->assignback_request_subtask->creator;
        $log->current_status = $this->assignback_request_subtask->current_status;
        $log->label_for_system = $this->assignback_request_subtask->label_for_system . 'Assign Back;';
        $log->label_for_system2 = $this->assignback_request_subtask->label_for_system2;
        $log->pending_for = $this->assignback_request_subtask->pending_for;
        $log->visibletousers = $this->assignback_request_subtask->visibletousers;
        $log->visibletoteams = $this->assignback_request_subtask->visibletoteams;
        $log->createdbyteam = $this->assignback_request_subtask->createdbyteam;
        $log->raisedbyuser = $this->assignback_request_subtask->raisedbyuser;
        $log->issue = $this->assignback_request_subtask->issue;
        $log->impact = $this->assignback_request_subtask->impact;
        $log->rc = $this->assignback_request_subtask->rc;
        $log->solution = $this->assignback_request_subtask->solution;
        $log->solution2 = $this->assignback_request_subtask->solution2;
        $log->solution3 = $this->assignback_request_subtask->solution3;
        $log->latest_update = $this->assignback_request_subtask->latest_update;
        $log->due_date = $this->assignback_request_subtask->due_date;
        $log->progress = $this->assignback_request_subtask->progress;
        $log->owner = $this->assignback_request_subtask->owner;
        $log->current_processor = $this->assignback_request_subtask->current_processor;
        $log->owner_team = $this->assignback_request_subtask->owner_team;
        $log->description = $this->assignback_request_subtask->description;
        $log->feedback = $this->assignback_request_subtask->feedback;
        $log->priority = $this->assignback_request_subtask->priority;
        $log->support = $this->assignback_request_subtask->support;
        $log->task_created_at = $this->assignback_request_subtask->created_at;
        $log->complete_description = $this->assignback_request_subtask->complete_description;
        $log->cancel_description = $this->assignback_request_subtask->cancel_description;
        $log->fail_description = $this->assignback_request_subtask->fail_description;
        $log->complete_date = $this->assignback_request_subtask->complete_date;
        $log->cancel_date = $this->assignback_request_subtask->cancel_date;
        $log->fail_date = $this->assignback_request_subtask->fail_date;
        $log->string_reserve1 = $this->assignback_request_subtask->string_reserve1;
        $log->string_reserve2 = $this->assignback_request_subtask->string_reserve2;
        $log->string_reserve3 = $this->assignback_request_subtask->string_reserve3;
        $log->string_reserve4 = $this->assignback_request_subtask->string_reserve4;
        $log->string_reserve5 = $this->assignback_request_subtask->string_reserve5;
        $log->string_reserve6 = $this->assignback_request_subtask->string_reserve6;
        $log->string_reserve7 = $this->assignback_request_subtask->string_reserve7;
        $log->string_reserve8 = $this->assignback_request_subtask->string_reserve8;
        $log->string_reserve9 = $this->assignback_request_subtask->string_reserve9;
        $log->string_reserve10 = $this->assignback_request_subtask->string_reserve10;
        $log->text_reserve1 = $this->assignback_request_subtask->text_reserve1;
        $log->text_reserve2 = $this->assignback_request_subtask->text_reserve2;
        $log->text_reserve3 = $this->assignback_request_subtask->text_reserve3;
        $log->text_reserve4 = $this->assignback_request_subtask->text_reserve4;
        $log->text_reserve5 = $this->assignback_request_subtask->text_reserve5;
        $log->text_reserve6 = $this->assignback_request_subtask->text_reserve6;
        $log->text_reserve7 = $this->assignback_request_subtask->text_reserve7;
        $log->text_reserve8 = $this->assignback_request_subtask->text_reserve8;
        $log->text_reserve9 = $this->assignback_request_subtask->text_reserve9;
        $log->text_reserve10 = $this->assignback_request_subtask->text_reserve10;
        $log->created_at = now();
        $log->updated_at = now();
        $log->save();

        $this->dispatchBrowserEvent('close-subtask-assign-back-modal');
    }

    // close Assign Back Modal
    public function closeAssignBackModal()
    {
        $this->dispatchBrowserEvent('close-subtask-assign-back-modal');
    }


    // Log Modal Function
    public function viewDetailsLog($id)
    {
        $this->tasklogmodal = $this->dispatchedbymetasklog->where('id', '=', $id)->first();
        $this->dispatchBrowserEvent('show-view-log-modal');
    }


    // DispatchedbyME Close Modal Function

    public function closeModalDispatchedByMeModal()
    {
        $this->dispatchBrowserEvent('close-view-dispatched-by-me-modal');
    }

    // Log Modal Close

    public function closeLogModal()
    {
        $this->dispatchBrowserEvent('close-view-log-modal');
    }


    // get owners
    public function getSelectedOwnersEdit()
    {
        $ownerforedit = [];

        foreach ($this->selectedItems_edit as $selectedOwners) {
            $ownerforedit[] = $selectedOwners;
        }

        $delimiter = ';';
        $this->stringowner_edit = implode($delimiter, array_values($ownerforedit)) . $delimiter;

        // Clear the selected items array
        $this->selectedItems_edit = [];

        $this->dispatchBrowserEvent('close-view-owner-edit-search-modal');
        // // Show a success message
        // session()->flash('message', 'Owners Selected successfully');
    }

    //get supports

    public function getSelectedSupportsEdit()
    {
        $supportforedit = [];
        // Save the selected items to the database
        foreach ($this->supportselectedItems_edit as $selectedsupports_edit) {
            $supportforedit[] = $selectedsupports_edit;
        }

        $delimiter = ';';
        $this->stringsupport_edit = implode($delimiter, array_values($supportforedit)) . $delimiter;

        // Clear the selected items array
        $this->supportselectedItems_edit = [];

        $this->dispatchBrowserEvent('close-view-support-edit-search-modal');
        // // Show a success message
        // session()->flash('message', 'Support Selected successfully');
    }

    // open search modals
    public function searchmodalownereditopen()
    {
        $this->dispatchBrowserEvent('show-view-owner-edit-search-modal');
    }

    public function searchmodalsupporteditopen()
    {
        $this->dispatchBrowserEvent('show-view-support-edit-search-modal');
    }

    //close search modals
    public function searchmodalownereditclose()
    {
        $this->dispatchBrowserEvent('close-view-owner-edit-search-modal');
    }

    public function searchmodalsupporteditclose()
    {
        $this->dispatchBrowserEvent('close-view-support-edit-search-modal');
    }
}
