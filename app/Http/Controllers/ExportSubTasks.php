<?php

namespace App\Http\Controllers;

use League\Csv\Writer;
use App\Models\subTask;
use Illuminate\Http\Request;
use App\Models\ExportLogModel;
use Illuminate\Support\Facades\Session;

class ExportSubTasks extends Controller
{
    public function downloadsubtasks(Request $request)
    {

        $current_time = date('Y-m-d_H-i-s');
        $filename = 'All Running Subtasks' . '_' . $current_time . '.csv';


        // Build CSV File
        $csvWriter = Writer::createFromPath(storage_path('app/' . $filename), 'w+');

        $query_total = subTask::where('is_cancel', '=', 0)
            ->where('is_complete', '=', 0)
            ->orderBy('latest_update', 'desc')
            ->get();

        $csvWriter->insertOne([
            'UUID',    'UUID Sub Task',    'Raised by User',    'Issue',    'Impact',    'RC',    'Solution',
            'Solution2',    'Status',    'Latest Update',    'Due Date',    'Progress',    'Owner',    'Current Processor',
            'Owner Team',    'Support',    'Description',    'Feedback',    'Priority'
        ]);

        foreach ($query_total as $data) {
            $csvWriter->insertOne([
                $data->uuid,
                $data->uuid_sub_task,
                $data->raisedbyuser,
                $data->issue,
                $data->impact,
                $data->rc,
                $data->solution,
                $data->solution2,
                $data->solution3,
                $data->latest_update,
                $data->due_date,
                $data->progress,
                $data->owner,
                $data->current_processor,
                $data->owner_team,
                $data->support,
                $data->description,
                $data->feedback,
                $data->priority,
            ]);
        }

        $user = $request->user();
        ExportLogModel::LogUserExportCSV(1,$user, 'All Running Subtasks', Session::getId(), $filename);

        // Return the CSV file as a download
        return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend(true);
    }
}
