<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\{
    LoginController, 
    LogoutController, 
    RegisterController
};

use App\Http\Controllers\API\ModuleAccessController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\AwardController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\SchoolEnvironmentController;
use App\Http\Controllers\API\SchoolLevelController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\SectionChatController;
use App\Http\Controllers\ChatController;
use App\Models\Subject;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route will be handled by the package's routes/api.php file.
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/register', [RegisterController::class, 'register']);

Route::post('/chat', [ChatController::class, 'sendMessage']);

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/auth/user', [ProfileController::class, 'getAuthenticatedUser']);
    Route::post('/auth/user/update', [ProfileController::class, 'updateAuthenticatedUser']);


    Route::get('/moduleAccess', [ModuleAccessController::class, 'moduleAccess']);
    Route::get('/get_profile/{id}', [ProfileController::class, 'getProfile']);
    Route::post('/update_profile/{id}', [ProfileController::class, 'updateProfile']);
    Route::post('/awards', [AwardController::class, 'awards']);

    Route::get('/announcement/{id}', [AnnouncementController::class, 'showAnnouncementDetails']);
    Route::post('/announcement/{id}/update', [AnnouncementController::class, 'updateAnnouncement']);
    Route::get('/announcement', [AnnouncementController::class, 'getAnnouncements']);
    Route::post('/announcement/delete', [AnnouncementController::class, 'deleteAnnouncement']);
    Route::post('/announcement', [AnnouncementController::class, 'storeAnnouncement']);
    Route::get('/announcement/search/{title}', [AnnouncementController::class, 'searchAnnouncement']);
    
    Route::get('/subject', [SubjectController::class, 'getSubjectlist']);
    Route::post('/subject', [SubjectController::class, 'storeSubject']);
    Route::get('/subject/{id}', [SubjectController::class, 'showSubjectDetails']);
    Route::delete('/subject/{id}', [SubjectController::class, 'deleteSubject']);
    Route::get('/subject/search/{subject}', [SubjectController::class, 'searchSubject']);
    Route::post('/update_subject/{id}', [SubjectController::class, 'updateSubject']);
    
    Route::get('/section', [SectionController::class, 'getSectionlist']);
    Route::post('/section', [SectionController::class, 'storeSection']);
    Route::get('/section/{id}', [SectionController::class, 'showSectionDetails']);
    Route::get('/section/search/{section}', [SectionController::class, 'searchSection']);
    Route::post('/sections/delete', [SectionController::class, 'deleteSection']);
    Route::post('/update_section/{id}', [SectionController::class, 'updateSection']);

    Route::get('/department', [DepartmentController::class, 'getDepartmentList']);
    Route::post('/department', [DepartmentController::class, 'storeDepartment']);
    Route::get('/department/{id}', [DepartmentController::class, 'showDepartmentDetails']);
    Route::get('/department/search/{department}', [DepartmentController::class, 'searchDepartment']);
    Route::post('/update_department/{id}', [DepartmentController::class, 'updateDepartment']);
    Route::post('/departments/delete', [DepartmentController::class, 'deleteDepartment']);
    
    Route::get('/school_environment', [SchoolEnvironmentController::class, 'getSchoolEnvironmentList']);
    Route::post('/school_environment', [SchoolEnvironmentController::class, 'storeSchoolEnvironment']);
    Route::get('/school_environment/{id}', [SchoolEnvironmentController::class, 'showSchoolEnvironmentDetails']);
    Route::get('/school_environment/search/{school_environment}', [SchoolEnvironmentController::class, 'searchSchoolEnvironment']);
    Route::put('/update_school_environment/{id}', [SchoolEnvironmentController::class, 'updateSchoolEnvironment']);
    Route::delete('/school_environment/{id}', [SchoolEnvironmentController::class, 'deleteSchoolEnvironment']);
    
    Route::get('/staff', [StaffController::class, 'getStaffList']);
    Route::post('/staff', [StaffController::class, 'storeStaffRecord']);
    Route::get('/staff/{id}', [StaffController::class, 'showStaffDetails']);
    Route::get('/staff/search/{staff}', [StaffController::class, 'searchStaff']);
    Route::put('/update_staff/{id}', [StaffController::class, 'updateStaffRecord']);
    Route::delete('/staff/{id}', [StaffController::class, 'deleteStaffRecord']);
    Route::get('/staff/get_department', [StaffController::class, 'getDepartmentList']);

    Route::get('/school_level', [SchoolLevelController::class, 'getSchoolLevelList']);
    Route::post('/school_level', [SchoolLevelController::class, 'storeSchoolLevel']);
    Route::get('/school_level/{id}', [SchoolLevelController::class, 'showSchoolLevelDetails']);
    Route::get('/school_level/search/{school_level}', [SchoolLevelController::class, 'searchSchoolLevel']);
    Route::post('/school_level/{id}', [SchoolLevelController::class, 'updateSchoolLevel']);
    Route::post('/school_levels/delete', [SchoolLevelController::class, 'deleteSchoolLevel']);
    
    Route::get('/students', [StudentController::class, 'getStudentList']);
    Route::post('/students', [StudentController::class, 'storeStudent']);
    Route::get('/students/{id}', [StudentController::class, 'showStudentDetails']);
    Route::get('/students/search/{student}', [StudentController::class, 'searchStudent']);
    Route::post('/update_student/{id}', [StudentController::class, 'updateStudentRecord']);
    Route::delete('/students/{id}', [StudentController::class, 'deleteStudentRecord']);

    Route::post('/addStudentSubject/{id}', [SubjectController::class, 'addStudentSubject']);
    Route::get('/subjectGrid', [SubjectController::class, 'getSubjectGrid']);
    Route::get('/sectionChat/{id}', [SectionChatController::class, 'getRoomData']);

});


