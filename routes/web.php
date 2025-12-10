<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('frontPage');
})->name('frontPage');

Route::get('/register', [AuthController::class, 'viewRegister'])->name('viewRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user-dashboard', [UserController::class, 'viewUserDashboard'])->name('viewUserDashboard');
Route::get('/fetch-user-jobs', [UserController::class, 'fetchJobs'])->name('fetchUserJobs');
Route::get('/view-user-notification', [UserController::class, 'viewUserNotification'])->name('viewUserNotification');
Route::get('/user-profile', [UserController::class, 'viewUserProfile'])->name('viewUserProfile');
Route::get('/manage-user', [UserController::class, 'adminManageUsers'])->name('viewManageUsers');
Route::patch('/user/status/{id}', [UserController::class, 'updateUserStatus'])->name('updateUserStatus');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('updateProfile');



Route::get('/admin-dashboard', [AdminController::class, 'viewAdminDashboard'])->name('viewAdminDashboard');
Route::get('/fetch-dashboard-data', [AdminController::class, 'fetchDashboardData']);

Route::get('/view-manage-applicant', [ApplicantController::class, 'viewManageApplicants'])->name('viewManageApplicants');
Route::get('/application-form/{id}', [ApplicantController::class, 'viewApplicationForm'])->name('viewApplicationForm');
Route::post('/submit/application-form/{id}', [ApplicantController::class, 'submitApplicationForm'])->name('submitApplicationForm');
Route::patch('/approve-applicant/{id}', [ApplicantController::class, 'approveApplicant'])->name('approveApplicant');
Route::patch('/reject-applicant/{id}', [ApplicantController::class, 'rejectApplicant'])->name('rejectApplicant');


Route::get('/view-manage-job', [JobController::class, 'viewManageJobs'])->name('viewManageJobs');
Route::get('/view-post-job', [JobController::class, 'viewPostJobs'])->name('viewPostJobs');
Route::get('/fetch-admin-job', [JobController::class, 'fetchAdminJobs']);
Route::get('/admin/jobs/get/{id}', [JobController::class, 'getJob']);
Route::post('/post-jobs', [JobController::class, 'addJob'])->name('postJobs');
Route::put('/admin/jobs/update/{id}', [JobController::class, 'editJob']);
Route::delete('/delete-job/{id}', [JobController::class, 'deleteJob'])->name('deleteJob');

Route::get('/view-admin-notification', [NotificationController::class, 'viewAdminNotification'])->name('viewAdminNotification');
Route::get('/view-user-notification', [NotificationController::class, 'viewUserNotification'])->name('viewUserNotification');
Route::delete('/notification/delete/{id}', [NotificationController::class, 'deleteNotification'])->name('deleteNotification');
Route::patch('/notification/read/{id}', [NotificationController::class, 'markAsRead'])->name('markAsRead');
