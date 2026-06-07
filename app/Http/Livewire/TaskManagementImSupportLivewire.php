<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\subTask;
use Livewire\Component;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ExportLogModel;
use App\Models\uaActionsAttemp;
use App\Models\TaskManagementModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\View\Components\Task;
use App\Models\LogActionsTaskManagementModel;

class TaskManagementImSupportLivewire extends Component
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
    public $user_email;
    public $edit_feedback;


    use WithPagination;


    public function render(Request $request)
    {
        $viewDetailsDispatchedByMe = TaskManagementModel::where('support', 'like', '%' . $this->user_email . '%')
            ->orderBy('latest_update', 'desc')
            ->where('issue', 'like', '%' . $this->issue_livesearch . '%')
            ->where('uuid', 'like', '%' . $this->uuid_livesearch . '%')
            ->where('priority', 'like', '%' . $this->priority_livesearch . '%')
            ->where('owner', 'like', '%' . $this->owner_livesearch . '%')
            ->where('description', 'like', '%' . $this->description_livesearch . '%')
            ->where('raisedbyuser', 'like', '%' . $this->raisedbyuser_livesearch . '%')
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
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

        return view('livewire.task-management-im-support-livewire', [
            'viewDetailsDispatchedByMe' => $viewDetailsDispatchedByMe,
        ])->with(['paginator' => $viewDetailsDispatchedByMe]);
    }

    // Mount
    public function mount(Request $request)
    {
        $this->dispatchedbyme_taskmanagementmodel = TaskManagementModel::where('support', 'like', '%' . $this->user_email . '%')
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->orderBy('latest_update', 'desc')
            ->get();

        $this->user_id_dispatch_access = auth()->user()->id;
        $this->user_email = auth()->user()->email;
    }


    // Edit Task

    public function editTaskManagementDataDispatch($id)
    {
        $this->modalDispatchedByMe = $this->dispatchedbyme_taskmanagementmodel->where('id', '=', $id)->first();

        $taskmanagement_edit = TaskManagementModel::where('id', $id)->first();


        if (Str::contains($taskmanagement_edit->support, $this->user_email)) {
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
            $this->edit_feedback= $taskmanagement_edit->feedback;

            $this->dispatchBrowserEvent('show-edit-task-management-modal');
        } else {
            // Log UA Try Edit
            $ualog = new uaActionsAttemp();
            $ualog->action = 'Support Feedback Attemp UA';
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
            // 'edit_raisedbyuser' => 'required|string|max:255',
            // 'edit_issue' => 'required|string|max:255',
            'edit_impact' => 'nullable|string|max:255',
            'edit_rc' => 'nullable|string|max:255',
            'edit_solution' => 'nullable|string|max:255',
            'edit_solution2' => 'nullable|string|max:255',
            'edit_solution3' => 'required|string|max:255',
            // 'edit_due_date' => 'required|date|after:now',
            // 'edit_latest_update' => 'nullable|string|max:255',
            'edit_progress' => 'nullable|numeric|between:0,100',
            // 'edit_owner' => 'required|string|max:255',
            // 'edit_support' => 'nullable|string|max:255',
            // 'edit_description' => 'required|string',
            'edit_priority' => 'required|string|max:255',
            'edit_feedback' => 'required|string',
            // 'task_cancel_description' => 'required|string'

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
            // 'edit_raisedbyuser' => 'required|string|max:255',
            // 'edit_issue' => 'required|string|max:255',
            'edit_impact' => 'nullable|string|max:255',
            'edit_rc' => 'nullable|string|max:255',
            'edit_solution' => 'nullable|string|max:255',
            'edit_solution2' => 'nullable|string|max:255',
            'edit_solution3' => 'required|string|max:255',
            // 'edit_due_date' => 'required|date|after:now',
            'edit_latest_update' => 'nullable|string|max:255',
            'edit_progress' => 'nullable|numeric|between:0,100',
            // 'edit_owner' => 'required|string|max:255',
            // 'edit_support' => 'nullable|string|max:255',
            // 'edit_description' => 'required|string',
            'edit_priority' => 'required|string|max:255',
            'edit_feedback' => 'required|string',


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
        $taskmanagement_edit->feedback = $this->edit_feedback;
        $taskmanagement_edit->priority = $this->edit_priority;

        // Update Edit Data
        $update_taskmanagement = [
            'id' => $taskmanagement_edit->id,
            // 'raisedbyuser' => $taskmanagement_edit->raisedbyuser,
            // 'issue' => $taskmanagement_edit->issue,
            'impact' => $taskmanagement_edit->impact,
            'rc' => $taskmanagement_edit->rc,
            'solution' => $taskmanagement_edit->solution,
            'solution2' => $taskmanagement_edit->solution2,
            'solution3' => $taskmanagement_edit->solution3,
            // 'due_date' => $taskmanagement_edit->due_date,
            'latest_update' => now(),
            'progress' => $taskmanagement_edit->progress,
            'label_for_system' => $taskmanagement_edit->label_for_system . 'Support Feedback;',
            // 'owner' => $taskmanagement_edit->owner,
            // 'current_processor' => $taskmanagement_edit->owner,
            // 'support' => $taskmanagement_edit->support,
            // 'description' => $taskmanagement_edit->description,
            'feedback' => $taskmanagement_edit->feedback,
            // 'priority' =>  $taskmanagement_edit->priority,
        ];

        $taskmanagement_edit->update($update_taskmanagement);


        // Log Actions Edit Task
        $task = TaskManagementModel::where('id', $this->task_edit_id)->first();
        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $task->id;
        $log->fail_label_for_system = $task->fail_label_for_system;
        $log->success_label_for_system = $task->success_label_for_system;
        $log->action = 'Support Feedback';
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
        $log->label_for_system = $task->label_for_system . 'Support Feedback;';
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
            $log->action = 'Support Feedback Sync';
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
        // $this->edit_issue = '';
        $this->edit_impact = '';
        $this->edit_rc = '';
        $this->edit_solution = '';
        $this->edit_solution2 = '';
        $this->edit_solution3 = '';
        // $this->edit_due_date = '';
        $this->edit_progress = '';
        // $this->edit_owner = '';
        // $this->edit_current_processor = '';
        // $this->edit_support = '';
        // $this->edit_description = '';
        // $this->edit_priority = '';
        // $this->stringowner_edit = '';
        // $this->stringsupport_edit = '';
        $this->edit_feedback = '';
        $this->file = '';

        $this->dispatchBrowserEvent('close-edit-task-management-modal');
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




}
