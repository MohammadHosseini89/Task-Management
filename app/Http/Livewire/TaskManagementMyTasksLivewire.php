<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ExportLogModel;
use Illuminate\Support\Facades\DB;
use App\Models\TaskManagementModel;
use Illuminate\Support\Facades\Storage;
use App\Models\LogActionsTaskManagementModel;
use App\Models\subTask;

class TaskManagementMyTasksLivewire extends Component
{
    use WithPagination;

    use WithFileUploads;
    public $mytasks__taskmanagementmodel;
    public $modalMytasks;

    public $task_reject_id;
    public $task_fb_id;

    public $fb_issue, $fb_solution2, $fb_solution3, $fb_impact, $fb_priority;
    public $fb_rc, $fb_solution, $fb_due_date, $fb_latest_update, $fb_progress, $fb_owner;
    public $fb_support, $fb_description, $fb_current_processor;

    public $searchTermFirstOwnerFb;
    public $SupportFbsearchTermFirst;

    public $users_owner_fb;
    public $users_support_fb;

    public $mytasks_tasklog;
    public $tasklogmodal;

    public $stringowner_fb, $stringsupport_fb;
    public $selectfbems_fb = [];
    public $supportselectfbems_fb = [];

    public $mytasks_attach;
    public $file;

    public $fb_feedback;

    public $mytasks_taskmanagementmodel;

    public $rejectfeedback;
    public $checked_userid;
    public $issue_livesearch, $priority_livesearch, $owner_livesearch;
    public $uuid_livesearch, $description_livesearch, $raisedbyuser_livesearch;


    public function render(Request $request)
    {
        $view_mytasks_taskmanagementmodel = subTask::where('owner', 'like', '%' . $request->user()->email . '%')
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->whereNull('label_for_system2')
            ->orderBy('latest_update', 'desc')
            ->where('issue', 'like', '%' . $this->issue_livesearch . '%')
            ->where('uuid', 'like', '%' . $this->uuid_livesearch . '%')
            ->where('priority', 'like', '%' . $this->priority_livesearch . '%')
            ->where('owner', 'like', '%' . $this->owner_livesearch . '%')
            ->where('description', 'like', '%' . $this->description_livesearch . '%')
            ->where('raisedbyuser', 'like', '%' . $this->raisedbyuser_livesearch . '%')
            ->paginate(10);

        if (strlen($this->searchTermFirstOwnerFb) >= 3) {
            $this->users_owner_fb = User::whereRaw('lower(name) like ?', ['%' . strtolower($this->searchTermFirstOwnerFb) . '%'])
                ->orWhereRaw('lower(jobid) like ?', ['%' . strtolower($this->searchTermFirstOwnerFb) . '%'])
                ->get();
        }

        if (strlen($this->SupportFbsearchTermFirst) >= 3) {
            $this->users_support_fb = User::whereRaw('lower(name) like ?', ['%' . strtolower($this->SupportFbsearchTermFirst) . '%'])
                ->orWhereRaw('lower(jobid) like ?', ['%' . strtolower($this->SupportFbsearchTermFirst) . '%'])
                ->get();
        }

        return view('livewire.task-management-my-tasks-livewire', [
            'view_mytasks_taskmanagementmodel' => $view_mytasks_taskmanagementmodel
        ])->with(['paginator' => $view_mytasks_taskmanagementmodel]);
    }

    // Mount
    public function mount(Request $request)
    {

        $this->mytasks_taskmanagementmodel = subTask::where('owner', 'like', '%' . $request->user()->email . '%')
            ->where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->orderBy('latest_update', 'desc')
            ->get();

        $this->mytasks__taskmanagementmodel = $this->mytasks_taskmanagementmodel;

        $this->checked_userid = auth()->user()->id;
    }



    // Fb Sub Task

    public function fbTaskManagementDataDispatch($id)
    {
        $this->modalMytasks = $this->mytasks__taskmanagementmodel->where('id', '=', $id)->first();
        $taskmanagement_fb = subTask::where('id', $id)->first();

        $this->task_fb_id = $taskmanagement_fb->id;
        $this->fb_issue = $taskmanagement_fb->issue;
        $this->fb_impact = $taskmanagement_fb->impact;
        $this->fb_rc = $taskmanagement_fb->rc;
        $this->fb_solution = $taskmanagement_fb->solution;
        $this->fb_solution2 = $taskmanagement_fb->solution2;
        $this->fb_solution3 = $taskmanagement_fb->solution3;
        $this->fb_due_date = $taskmanagement_fb->due_date;
        $this->fb_latest_update = $taskmanagement_fb->latest_update;
        $this->fb_progress = $taskmanagement_fb->progress;
        $this->fb_support = $taskmanagement_fb->support;
        $this->fb_owner = $taskmanagement_fb->owner;
        $this->fb_description = $taskmanagement_fb->description;
        $this->fb_priority = $taskmanagement_fb->priority;
        $this->fb_current_processor = $taskmanagement_fb->current_processor;

        $this->fb_feedback = $taskmanagement_fb->feedback;

        $this->dispatchBrowserEvent('show-fb-task-management-modal');
    }

    //Input fields on update validation
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'fb_issue' => 'required|string|max:255',
            'fb_impact' => 'nullable|string|max:255',
            'fb_rc' => 'nullable|string|max:255',
            'fb_solution' => 'required|string|max:255',
            'fb_solution2' => 'nullable|string|max:255',
            'fb_solution3' => 'required|string|max:255',
            'fb_due_date' => 'required|date|after:now',
            'fb_latest_update' => 'nullable|string|max:255',
            'fb_progress' => 'required|numeric|between:0,100',
            'fb_owner' => 'required|string|max:255',
            'fb_support' => 'nullable|string|max:255',
            'fb_description' => 'required|string',
            'fb_priority' => 'required|string|max:255',
            'fb_feedback' => 'required|string',
            'rejectfeedback' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 1-100.'
        ]);
    }



    public function fbTaskData(Request $request)
    {
        if (strlen($this->searchTermFirstOwnerFb) >= 3) {
            $this->fb_owner = $this->stringowner_fb;
        }

        if (strlen($this->SupportFbsearchTermFirst) >= 3) {
            $this->fb_support = $this->stringsupport_fb;
        }

        //on form submit validation
        $this->validate([

            'fb_issue' => 'required|string|max:255',
            'fb_impact' => 'nullable|string|max:255',
            'fb_rc' => 'nullable|string|max:255',
            'fb_solution' => 'required|string|max:255',
            'fb_solution2' => 'nullable|string|max:255',
            'fb_solution3' => 'required|string|max:255',
            // 'fb_due_date' => 'required|date|after:now',
            'fb_latest_update' => 'nullable|string|max:255',
            'fb_progress' => 'required|numeric|between:0,100',
            'fb_owner' => 'required|string|max:255',
            'fb_support' => 'nullable|string|max:255',
            'fb_description' => 'required|string',
            'fb_priority' => 'required|string|max:255',
            'fb_feedback' => 'required|string',

        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field may not be greater than :max characters.',
            'date' => 'The :attribute field must be a valid date.',
            'numeric' => 'The :attribute field must be a number between 1-100.'
        ]);

        // get Fb Data
        $taskmanagement_fb = subTask::where('id', $this->task_fb_id)->first();
        $taskmanagement_fb->issue = $this->fb_issue;
        $taskmanagement_fb->impact = $this->fb_impact;
        $taskmanagement_fb->rc = $this->fb_rc;
        $taskmanagement_fb->solution = $this->fb_solution;
        $taskmanagement_fb->solution2 = $this->fb_solution2;
        $taskmanagement_fb->solution3 = $this->fb_solution3;
        $taskmanagement_fb->due_date = $this->fb_due_date;
        $taskmanagement_fb->latest_update = $this->fb_latest_update;
        $taskmanagement_fb->progress = $this->fb_progress;
        $taskmanagement_fb->owner = $this->fb_owner;
        $taskmanagement_fb->support = $this->fb_support;
        $taskmanagement_fb->description = $this->fb_description;
        $taskmanagement_fb->feedback = $this->fb_feedback;
        $taskmanagement_fb->priority = $this->fb_priority;

        // Commented due to new procedure
        // remove processor after feedback

        // $taskmanagement_fb->current_processor = str_replace(auth()->user()->email . ';','', $taskmanagement_fb->current_processor);

        // Update Fb Data
        $update_taskmanagement = [
            'id' => $taskmanagement_fb->id,
            'impact' => $taskmanagement_fb->impact,
            'rc' => $taskmanagement_fb->rc,
            'solution' => $taskmanagement_fb->solution,
            'solution2' => $taskmanagement_fb->solution2,
            'solution3' => $taskmanagement_fb->solution3,
            'latest_update' => now(),
            'progress' => $taskmanagement_fb->progress,
            // 'owner' => $taskmanagement_fb->owner,
            // 'current_processor' => $taskmanagement_fb->current_processor,
            // 'support' => $taskmanagement_fb->support,
            'feedback' => $taskmanagement_fb->feedback,
            'label_for_system' => $taskmanagement_fb->label_for_system . 'Feedback Recived;',
        ];

        $taskmanagement_fb->update($update_taskmanagement);


        // Update Parent Task And Make Log
        //Find Parent
        $sub_task = (subTask::where('id', $this->task_fb_id)->first());
        $my_task_management_model_id = $sub_task->task_management_model_id;

        $parent_task = TaskManagementModel::where('id', $my_task_management_model_id)->first();

        if(!empty($sub_task->impact)){
        $parent_task->impact = $sub_task->impact;}
        if(!empty($sub_task->rc)){
        $parent_task->rc = $sub_task->rc;}
        $parent_task->solution = $sub_task->solution;
        if(!empty($sub_task->solution2)){
        $parent_task->solution2 = $sub_task->solution2;}
        if(!empty($sub_task->solution3)){
        $parent_task->solution3 = $sub_task->solution3;}
        $parent_task->latest_update = now();
        if(!empty($sub_task->progress)){
        $parent_task->progress = $sub_task->progress;}
        $parent_task->feedback = $sub_task->feedback;
        $parent_task->label_for_system = $parent_task->label_for_system.'Feedback Recieved;';
        $parent_task->save();


        // Log Actions Sub Task
        $task = subTask::where('id', $this->task_fb_id)->first();
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
        $log->user_id = $this->checked_userid;
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
            $attach->user_id = $this->checked_userid;
            $attach->user_name = auth()->user()->name;
            $attach->email = auth()->user()->email;
            $attach->attached_in = 'Feedback Task';
            $attach->task_management_model_id = $my_task_management_model_id;
            $attach->filename = $this->file->getClientOriginalName();
            $attach->file_extension = $this->file->getClientOriginalExtension();
            $attach->storage_path = $path;
            $attach->save();

            // Perform any necessary actions with the uploaded file here...
        }

        session()->flash('message', 'Task has been Updated successfully');

        // null important wires
        $this->fb_issue = '';
        $this->fb_impact = '';
        $this->fb_rc = '';
        $this->fb_solution = '';
        $this->fb_solution2 = '';
        $this->fb_solution3 = '';
        $this->fb_due_date = '';
        $this->fb_progress = '';
        $this->fb_owner = '';
        $this->fb_current_processor = '';
        $this->fb_support = '';
        $this->fb_description = '';
        $this->fb_priority = '';
        $this->stringowner_fb = '';
        $this->stringsupport_fb = '';
        $this->fb_feedback = '';

        $this->dispatchBrowserEvent('close-fb-task-management-modal');
    }



    // Reject Task
    public function rejectTask($id)
    {
        $this->modalMytasks = $this->mytasks__taskmanagementmodel->where('id', '=', $id)->first();
        $this->task_reject_id = $id;
        $this->dispatchBrowserEvent('show-reject-confirmation-modal');
    }

    public function TaskReject()
    {
        $this->validate([
            'rejectfeedback' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute field must be a string.',
        ]);

        $taskreject = subTask::where('id', $this->task_reject_id)->first();
        $taskreject->feedback = $this->rejectfeedback;
        $taskreject->label_for_system = $taskreject->label_for_system.'Rejected;';
        $taskreject->label_for_system2 = 'Rejected';
        $taskreject->update();

        // Find Parent
        $subtask = subTask::where('id', $this->task_reject_id)->first();
        $task_management_model_id = $subtask->task_management_model_id;
        $task = TaskManagementModel::where('id', $task_management_model_id)->first();

        // Update Parent
        $task->feedback = $this->rejectfeedback;
        $task->label_for_system = $task->label_for_system.'Task Rejected;';
        $task->save();

        // Log Actions
        $log = new LogActionsTaskManagementModel();
        $log->task_management_model_id = $task->id;
        $log->fail_label_for_system = $task->fail_label_for_system;
        $log->success_label_for_system = $task->success_label_for_system;
        $log->action = 'Reject Task';
        $log->uuid = $task->uuid;
        $log->uuid_sub_task = $taskreject->uuid_sub_task;
        $log->is_cancel = $task->is_cancel;
        $log->is_complete = $task->is_complete;
        $log->is_fail = $task->is_fail;
        $log->is_success = $task->is_success;
        $log->searchable = $task->searchable;
        $log->user_id = $this->checked_userid;
        $log->creator = $task->creator;
        $log->current_status = $task->current_status;
        $log->label_for_system = $task->label_for_system.'Rejected Task;';
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



        session()->flash('message', 'Task has been Cancelled successfully');

        $this->dispatchBrowserEvent('close-modal-reject');

        $this->task_reject_id = '';
    }

    // Close Modal Cancel
    public function CloseModalReject()
    {
        $this->task_reject_id = '';
        $this->dispatchBrowserEvent('close-modal-reject');
    }

    // Close Fb Modal
    public function closeFbTaskManagementModal()
    {
        $this->dispatchBrowserEvent('close-fb-task-management-modal');
    }

    // Mytasks_ Modal Function

    public function viewDetailsMytasks($id)
    {
        $this->modalMytasks = $this->mytasks__taskmanagementmodel->where('id', '=', $id)->first();
        //Find Parent ID to Show Log and Attach
        $my_task_management_model_id = (subTask::where('id',$id)->first()->task_management_model_id);

        $my_subtask_uuid = (subTask::where('id',$id)->first()->uuid_sub_task);
        //log table come
        $this->mytasks_tasklog = LogActionsTaskManagementModel::where('task_management_model_id', '=', $my_task_management_model_id)
        ->where('uuid_sub_task',$my_subtask_uuid)->get();
        //attach table come
        $this->mytasks_attach = Attachment::where('task_management_model_id', '=', $my_task_management_model_id)->get();
        $this->dispatchBrowserEvent('show-view-my-tasks-modal');
    }

    // Download Attach Function
    public function downloadattach($id)
    {
        $which_attachmemt = $this->mytasks_attach->where('id', '=', $id)->first();

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

        $this->tasklogmodal = $this->mytasks_tasklog->where('id', '=', $id)->first();
        $this->dispatchBrowserEvent('show-view-log-modal');
    }

    // Mytasks_ Close Modal Function

    public function closemodalMytasksModal()
    {
        $this->dispatchBrowserEvent('close-view-my-tasks-modal');
    }

    // Log Modal Close

    public function closeLogModal()
    {
        $this->dispatchBrowserEvent('close-view-log-modal');
    }

    // get owners
    public function getSelectedOwnersFb()
    {
        $ownerforfb = [];

        foreach ($this->selectfbems_fb as $selectedOwners) {
            $ownerforfb[] = $selectedOwners;
        }

        $delimiter = ' ; ';
        $this->stringowner_fb = implode($delimiter, array_values($ownerforfb));

        // Clear the selected items array
        $this->selectfbems_fb = [];

        $this->dispatchBrowserEvent('close-view-owner-fb-search-modal');
        // // Show a success message
        // session()->flash('message', 'Owners Selected successfully');
    }

    //get supports

    public function getSelectedSupportsFb()
    {
        $supportforfb = [];
        // Save the selected items to the database
        foreach ($this->supportselectfbems_fb as $selectedsupports_fb) {
            $supportforfb[] = $selectedsupports_fb;
        }

        $delimiter = ' ; ';
        $this->stringsupport_fb = implode($delimiter, array_values($supportforfb));

        // Clear the selected items array
        $this->supportselectfbems_fb = [];

        $this->dispatchBrowserEvent('close-view-support-fb-search-modal');
        // // Show a success message
        // session()->flash('message', 'Support Selected successfully');
    }

    // open search modals
    public function searchmodalownerfbopen()
    {
        $this->dispatchBrowserEvent('show-view-owner-fb-search-modal');
    }

    public function searchmodalsupportfbopen()
    {
        $this->dispatchBrowserEvent('show-view-support-fb-search-modal');
    }

    //close search modals
    public function searchmodalownerfbclose()
    {
        $this->dispatchBrowserEvent('close-view-owner-fb-search-modal');
    }

    public function searchmodalsupportfbclose()
    {
        $this->dispatchBrowserEvent('close-view-support-fb-search-modal');
    }
}
