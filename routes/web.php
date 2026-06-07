<?php

use App\Http\Controllers\BatchUploadController;
use App\Http\Controllers\ExportSubTasks;
use App\Http\Livewire\CreateBatch;
use App\Http\Livewire\HubComponent;
use App\Http\Livewire\ResetPassword;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\AdminComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\storeNewUser;
use App\Http\Livewire\TeamManagerView;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamsController;
use App\Http\Livewire\TasksOverviewTotal;
use App\Http\Controllers\storeNewRaisedBy;
use App\Http\Livewire\TeamsAssignComponent;
use App\Http\Controllers\importTeamscsvFile;
use App\Http\Livewire\UsersControlComponent;
use App\Http\Livewire\UserTasksOverviewTotal;
use App\Http\Controllers\TaskManagementCreate;
use App\Http\Livewire\AssignCredentialsComponent;
use App\Http\Controllers\UploadExcelAsAdminForUsers;
use App\Http\Livewire\TaskManagementMyTasksLivewire;
use App\Http\Livewire\TagsForRaisedbyControlComponent;
use App\Http\Livewire\TaskManagementImSupportLivewire;
use App\Http\Livewire\TaskManagementCreateTasksLivewire;
use App\Http\Livewire\TaskManagementCancelledTasksLivewire;
use App\Http\Livewire\TaskManagementCompletedTasksLivewire;
use App\Http\Livewire\TaskManagementDispatchedByMeLivewire;
use App\Http\Livewire\TaskManagementControlLivewireComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// Basic welcome landing Route
Route::get('/welcome', HubComponent::class)->name('welcome')->middleware('protect');

Auth::routes([
    'reset' => false,
    'register' => false,
    'verify' => false,
    'confirm' => false,
]);

//Admin only Routes
Route::post('/users', [storeNewUser::class, 'store'])->name('users.store')->middleware('protect');
Route::get('/admin', AdminComponent::class)->name('admin')->middleware('protect');
Route::get('/user-control-admin', UsersControlComponent::class)->name('user-control')->middleware('protect');


Route::get('upload-excel-as-admin-for-users', [UploadExcelAsAdminForUsers::class, 'userupload'])->name('upload-excel-as-admin-for-users');
Route::post('upload-excel-as-admin-for-users', [App\Http\Controllers\UploadExcelAsAdminForUsers::class, 'userupload'])->name('upload-excel-as-admin-for-users');

Route::get('upload-excel-as-admin-for-raisedby', [App\Http\Controllers\UploadExcelAsAdminForRaisedBy::class, 'raisedbyupload'])->name('upload-excel-as-admin-for-raisedby');
Route::post('upload-excel-as-admin-for-raisedby', [App\Http\Controllers\UploadExcelAsAdminForRaisedBy::class, 'raisedbyupload'])->name('upload-excel-as-admin-for-raisedby');

Route::post('/raisedby', [storeNewRaisedBy::class, 'store'])->name('raisedbytags.store')->middleware('protect');
Route::get('/raisedbycontrol', TagsForRaisedbyControlComponent::class)->name('raisedbycontrol')->middleware('protect');

Route::get('/assign-credentials-control', AssignCredentialsComponent::class)->name('assign-credentials-controll')->middleware('protect');





Route::post('teams.import', [importTeamscsvFile::class, 'import'])->name('teams.import')->middleware('protect');


// Tasks Routes
Route::get('/tasks/create', TaskManagementCreateTasksLivewire::class)->name('tasks')->middleware('protect');
Route::get('/tasks/dispatchedbyme', TaskManagementDispatchedByMeLivewire::class)->name('dispatchedbyme')->middleware('protect');
Route::get('/tasks/mytasks', TaskManagementMyTasksLivewire::class)->name('mytasks')->middleware('protect');
Route::get('/tasks/cancelled', TaskManagementCancelledTasksLivewire::class)->name('cancelled')->middleware('protect');
Route::get('/tasks/control', TaskManagementControlLivewireComponent::class)->name('controltask')->middleware('protect');
Route::get('/tasks/completed', TaskManagementCompletedTasksLivewire::class)->name('completed')->middleware('protect');
Route::get('/tasks/imsupport', TaskManagementImSupportLivewire::class)->name('support')->middleware('protect');


// Task OverViewTotal
Route::get('/tasks/overview', TasksOverviewTotal::class)->name('tasksoverview')->middleware('protect');
Route::get('/tasks/user/overview', UserTasksOverviewTotal::class)->name('usertasksoverview')->middleware('protect');


Route::get('/teamsassign', TeamsAssignComponent::class)->name('teamsassign');
Route::post('/teams/assign/users', [TeamsController::class, 'assignUserToTeam'])->name('teams.assign.submit');

// Reset Password
Route::get('/reset', ResetPassword::class)->name('reset-password')->middleware('protect');


// Team Manager View
Route::get('/team-manager', TeamManagerView::class)->name('team-manager')->middleware('protect');


// Batch Import
Route::get('/batch-interface', CreateBatch::class)->name('batch-interface')->middleware('protect');

Route::post('/batchupload', [BatchUploadController::class, 'batch'])->name('batchupload')->middleware('protect');
Route::get('/downloadbatchtemplate', [BatchUploadController::class, 'downloadtemplate'])->name('downloadbatchtemplate')->middleware('protect');

// Export Sub Tasks
Route::post('/downloadallrunningsubtasks', [ExportSubTasks::class, 'downloadsubtasks'])->name('downloadallrunningsubtasks')->middleware('protect');

Route::get('/downloadbatchupdatetemplate', [BatchUploadController::class, 'downloadtemplateupdate'])->name('downloadbatchupdatetemplate')->middleware('protect');
Route::post('/batchuploadupdate', [BatchUploadController::class, 'batchupdate'])->name('batchuploadupdate')->middleware('protect');


Route::get('/downloadbatchcompletetemplate', [BatchUploadController::class, 'downloadtemplatecomplete'])->name('downloadbatchcompletetemplate')->middleware('protect');
Route::post('/batchuploadcomplete', [BatchUploadController::class, 'batchcomplete'])->name('batchuploadcomplete')->middleware('protect');


