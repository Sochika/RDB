<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\OperativesController;
use App\Http\Controllers\BeatController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

// Route::get('/', function () {
//   return view('welcome');
// });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->name('dashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


  //Admin
  Route::get('/admin', [AdminController::class, 'index'])->name('admin');
  Route::get('/admin/leads', [AdminController::class, 'leads'])->name('admin.leads');
  Route::get('/admin/alleads', [AdminController::class, 'alleads'])->name('admin.alleads');
  Route::get('/admin/allRecruits', [AdminController::class, 'allRecruits'])->name('admin.allRecruits');
  Route::get('/admin/recruits', [AdminController::class, 'recruits'])->name('admin.recruits');
  Route::get('/admin/recruitForm', [AdminController::class, 'recruitForm'])->name('admin.recruit');
  // Route::post('/recruit/store', [AdminController::class, 'recruitSave'])->name('recruit.store');
  Route::get('/admin-lead/form', [AdminController::class, 'beatForm'])->name('adminLead.form');
  // Route::post('/lead/store', [AdminController::class, 'beatSave'])->name('lead.store');
  Route::post('/admin/get-week-recruits', [AdminController::class, 'admin.getWeekRecruits']);
  Route::post('/admin/get-week-leads', [AdminController::class, 'admin.getWeekLeads']);

  // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/market', [MarketController::class, 'index'])->name('market');
  Route::get('/leads', [MarketController::class, 'leads'])->name('leads');
  Route::get('/alleads', [MarketController::class, 'alleads'])->name('alleads');
  Route::get('/allRecruits', [MarketController::class, 'allRecruits'])->name('allRecruits');
  Route::get('/market/recruits', [MarketController::class, 'recruits'])->name('recruits');
  Route::get('/market/recruitForm', [MarketController::class, 'recruitForm'])->name('market.recruit');
  Route::post('/recruit/store', [MarketController::class, 'recruitSave'])->name('recruit.store');
  Route::get('/lead/form', [MarketController::class, 'beatForm'])->name('lead.form');
  Route::post('/lead/store', [MarketController::class, 'beatSave'])->name('lead.store');
  Route::post('/get-week-recruits', [MarketController::class, 'getWeekRecruits']);
  Route::post('/get-week-leads', [MarketController::class, 'getWeekLeads']);

  Route::get('/operatives', [StaffController::class, 'index'])->name('staffs-operatives');
  Route::get('/graduated', [StaffController::class, 'staffGraduated'])->name('staffs.Graduated');
  Route::get('/staffs', [StaffController::class, 'index'])->name('staffs-admin');
  Route::get('/staff/table', [StaffController::class, 'tablex']);
  Route::get('/staff/onboarding', [StaffController::class, 'stafform'])->name('staff.onboarding');
  Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
  Route::post('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
  Route::get('/staff/view/{id}', [StaffController::class, 'view'])->name('staff-view');
  Route::get('/staff/activity/{id}', [StaffController::class, 'activity'])->name('staff-activity');
  Route::post('/staff/assign', [StaffController::class, 'staffAssign'])->name('staff.assign');
  Route::post('/staff/graduate', [StaffController::class, 'graduate'])->name('staff.graduate');
  Route::post('/staff/ungraduate', [StaffController::class, 'ungraduate'])->name('staff.ungraduate');
  Route::post('/staff/delete', [StaffController::class, 'delete'])->name('staff.delete');

  Route::resource('/beats', BeatController::class)->name('index', 'beats');
  Route::get('/beat/add', [BeatController::class, 'addBeat'])->name('beat.add');
  Route::get('/beat/edit/{id}', [BeatController::class, 'editBeat'])->name('beat.edit');
  Route::post('/beat/update/{id}', [BeatController::class, 'update'])->name('beat.update');
  Route::get('/beat/closeOperative/{id}', [BeatController::class, 'getBeatStaffclose'])->name('beat.closeOperative');
  Route::post('/beat/branch/add', [BeatController::class, 'beatBranchstore'])->name('beatBranch.add');
  Route::get('/getBeatBranch/{beatId}', [BeatController::class, 'getBeatBranch'])->name('BeatBranch.location');

  Route::get('/sitReps', [AttendanceController::class, 'index'])->name('sitReps');
  Route::get('/callRepTable', [AttendanceController::class, 'fetchAttendanceData'])->name('callReps.fetch');
  Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
  Route::get('/offOperative', [AttendanceController::class, 'offOperative'])->name('staffs.offOperative');
  Route::post('/attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
  Route::get('/attendance/{staffId}/monthly/{month?}', [AttendanceController::class, 'showMonthlyAttendance'])->name('attendance.monthly');
  Route::get('/attendance/fetch', [AttendanceController::class, 'fetchStaffData'])->name('attendance.fetch');
  Route::get('/attendance/download-csv', [AttendanceController::class, 'downloadCsv'])->name('attendance.downloadCsv');
  Route::get('/attendance/filterByDate', [AttendanceController::class, 'filterByDate'])->name('attendance.filterByDate');

  Route::post('/shift/cancel', [ShiftController::class, 'cancel'])->name('shift.cancel');
  Route::post('/shift/delete', [ShiftController::class, 'delete'])->name('shift.delete');

  Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
  Route::post('/settings/set', [SettingsController::class, 'setBeatView'])->name('settings.set');
  Route::post('/settings/role', [SettingsController::class, 'setRoles'])->name('settings.role');
  Route::delete('/role/delete/{id}', [SettingsController::class, 'deleteRole'])->name('roles.delete');
  Route::post('/settings/shift', [SettingsController::class, 'setShifts'])->name('settings.shift');
  Route::get('settings/roles/edit/{id}', [SettingsController::class, 'editRole'])->name('roles.edit');
  // Route::delete('settings/roles/delete/{id}', [SettingsController::class, 'destroyRole'])->name('roles.delete');
  Route::get('settings/shifts/edit/{id}', [SettingsController::class, 'editShiftype'])->name('shifts.edit');
  Route::delete('settings/shifts/delete/{id}', [SettingsController::class, 'destroyShiftype'])->name('shift_type.delete');


  // Route::get('/update', [UpdateController::class, 'update'])->name('update');
  Route::get('/clear', [UpdateController::class, 'clear'])->name('clear');
  Route::get('/registera', [AuthController::class, 'showAddminForm'])->name('registera');
  Route::post('/addmin', [AuthController::class, 'store'])->name('addmin');

  Route::get('/update', function () {
    // Check if user is logged in and has ID 1
    if (Auth::check() && Auth::id() == 1) {
      return app(UpdateController::class)->update(); // Call the update method
    }

    return abort(403, 'Unauthorized action.'); // Deny access if not authorized
  })->name('update');



  Route::get('/rollback-migration', function () {
    // Check if a user is logged in and if their ID is 1
    if (Auth::check() && Auth::id() == 1) {
      try {
        Artisan::call('migrate:rollback');
        return 'Migration rollback successful';
      } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
      }
    } else {
      return 'Not Allowed to this';
    }
  });
});

Route::get('/db-version', function () {
  // Fetch the database connection name
  $connection = config('database.default');

  // Initialize the version variable
  $version = '';

  switch ($connection) {
    case 'mysql':
      $version = DB::select("SELECT VERSION() as version")[0]->version;
      break;

    case 'pgsql':
      $version = DB::select("SELECT version() as version")[0]->version;
      break;

    case 'sqlite':
      $version = DB::select("SELECT sqlite_version() as version")[0]->version;
      break;

    case 'sqlsrv':
      $version = DB::select("SELECT @@VERSION as version")[0]->version;
      break;

    default:
      $version = 'Unsupported database';
  }

  return "Database version: " . $version;
});

require __DIR__ . '/auth.php';

// Route::middleware([
//   'auth:sanctum',
//   config('jetstream.auth_session'),
//   'verified',
// ])->group(function () {
//   Route::get('/dashboard', function () {
//     return view('dashboard');
//   })->name('dashboard');
// });
