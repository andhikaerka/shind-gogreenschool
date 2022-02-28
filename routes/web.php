<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::redirect('/home', '/');

Auth::routes(['verify' => true]);
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change Password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }

});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'approved', 'admin']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/statistic', 'DashboardController@statistic')->name('statistic');

    /// Planning
    // Schools
    Route::delete('schools/destroy', 'SchoolController@massDestroy')->name('schools.massDestroy');
    Route::post('schools/media', 'SchoolController@storeMedia')->name('schools.storeMedia');
    Route::resource('schools', 'SchoolController')->except(['show']);

    // Assessment
    Route::get('assessments', 'AssessmentController@index')->name('assessments.index');
    Route::post('assessments/update', 'AssessmentController@update')->name('assessments.update');
    Route::get('assessments/print', 'AssessmentController@print')->name('assessments.print');

    /// Setting
    // Banners
    Route::delete('banners/destroy', 'BannerController@massDestroy')->name('banners.massDestroy');
    Route::post('banners/media', 'BannerController@storeMedia')->name('banners.storeMedia');
    Route::resource('banners', 'BannerController');

    // Curriculum Calendars
    Route::delete('curriculum-calendars/destroy', 'CurriculumCalendarController@massDestroy')->name('curriculum-calendars.massDestroy');
    Route::resource('curriculum-calendars', 'CurriculumCalendarController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
});

// School
Route::group(['as' => 'school.', 'namespace' => 'School', 'middleware' => ['auth', 'approved', 'astc']], function () {
    Route::get('/{school_slug}/dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => '{school_slug}', 'middleware' => ['auth', 'approved', 'astc']], function () {
        // Statistics
        Route::get('/statistics', 'StatisticController@index')->name('statistics');

        /// Planning
        // Account
        Route::post('account/media', 'UserController@storeMedia')->name('account.storeMedia');
        Route::get('account/show', 'UserController@show')->name('account.show');
        Route::get('account/edit', 'UserController@edit')->name('account.edit');
        Route::post('account/update', 'UserController@update')->name('account.update');

        // WorkGroups
        Route::delete('work-groups/destroy', 'WorkGroupController@massDestroy')->name('work-groups.massDestroy');
        Route::resource('work-groups', 'WorkGroupController')->except(['show']);

        // Schools
        Route::post('/media', 'SchoolController@storeMedia')->name('storeMedia');
        Route::get('/show', 'SchoolController@show')->name('show');
        Route::get('/print', 'SchoolController@print')->name('print');
        Route::get('/edit', 'SchoolController@edit')->name('edit');
        Route::post('/update', 'SchoolController@update')->name('update');

        // Infrastructures
        Route::delete('infrastructures/destroy', 'InfrastructureController@massDestroy')->name('infrastructures.massDestroy');
        Route::post('infrastructures/media', 'InfrastructureController@storeMedia')->name('infrastructures.storeMedia');
        Route::resource('infrastructures', 'InfrastructureController')->except(['show']);

        // Disasters
        Route::delete('disasters/destroy', 'DisasterController@massDestroy')->name('disasters.massDestroy');
        Route::post('disasters/media', 'DisasterController@storeMedia')->name('disasters.storeMedia');
        Route::resource('disasters', 'DisasterController')->except(['show']);

        // Quality Reports
        Route::delete('quality-reports/destroy', 'QualityReportController@massDestroy')->name('quality-reports.massDestroy');
        Route::post('quality-reports/media', 'QualityReportController@storeMedia')->name('quality-reports.storeMedia');
        Route::resource('quality-reports', 'QualityReportController')->except(['show']);

        // Environments
        Route::delete('environments/destroy', 'EnvironmentController@massDestroy')->name('environments.massDestroy');
        Route::post('environments/media', 'EnvironmentController@storeMedia')->name('environments.storeMedia');
        Route::resource('environments', 'EnvironmentController')->except(['show']);

        // Teams
        Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
        Route::post('teams/media', 'TeamController@storeMedia')->name('teams.storeMedia');
        Route::resource('teams', 'TeamController')->except(['show']);

        // Studies
        Route::delete('studies/destroy', 'StudyController@massDestroy')->name('studies.massDestroy');
        Route::resource('studies', 'StudyController')->except(['show']);

        // Curricula
        Route::delete('curricula/destroy', 'CurriculumController@massDestroy')->name('curricula.massDestroy');
        Route::post('curricula/media', 'CurriculumController@storeMedia')->name('curricula.storeMedia');
        Route::resource('curricula', 'CurriculumController')->except(['show']);

        // Lesson Plans
        Route::delete('lesson-plans/destroy', 'LessonPlanController@massDestroy')->name('lesson-plans.massDestroy');
        Route::post('lesson-plans/media', 'LessonPlanController@storeMedia')->name('lesson-plans.storeMedia');
        Route::resource('lesson-plans', 'LessonPlanController')->except(['show']);

        // Budget Plans
        Route::delete('budget-plans/destroy', 'BudgetPlanController@massDestroy')->name('budget-plans.massDestroy');
        Route::resource('budget-plans', 'BudgetPlanController')->except(['show']);

        // Partners
        Route::delete('partners/destroy', 'PartnerController@massDestroy')->name('partners.massDestroy');
        Route::post('partners/media', 'PartnerController@storeMedia')->name('partners.storeMedia');
        Route::resource('partners', 'PartnerController')->except(['show']);

        // Cadres
        Route::delete('cadres/destroy', 'CadreController@massDestroy')->name('cadres.massDestroy');
        Route::post('cadres/media', 'CadreController@storeMedia')->name('cadres.storeMedia');
        Route::resource('cadres', 'CadreController')->except(['show']);

        // Work Programs
        Route::delete('work-programs/destroy', 'WorkProgramController@massDestroy')->name('work-programs.massDestroy');
        Route::post('work-programs/media', 'WorkProgramController@storeMedia')->name('work-programs.storeMedia');
        Route::resource('work-programs', 'WorkProgramController')->except(['show']);

        // Innovations
        Route::delete('innovations/destroy', 'InnovationController@massDestroy')->name('innovations.massDestroy');
        Route::post('innovations/media', 'InnovationController@storeMedia')->name('innovations.storeMedia');
        Route::resource('innovations', 'InnovationController')->except(['show']);

        // This Year Action Plans
        Route::get('this-year-action-plans', 'ThisYearActionPlanController@index')->name('this-year-action-plans.index');
        Route::get('this-year-action-plans/print', 'ThisYearActionPlanController@print')->name('this-year-action-plans.print');

        // Next Year Action Plans
        Route::get('next-year-action-plans', 'NextYearActionPlanController@index')->name('next-year-action-plans.index');
        Route::get('next-year-action-plans/print', 'NextYearActionPlanController@print')->name('next-year-action-plans.print');

        /// Implementation Activity
        // Cadre Activities
        Route::delete('cadre-activities/destroy', 'CadreActivityController@massDestroy')->name('cadre-activities.massDestroy');
        Route::post('cadre-activities/media', 'CadreActivityController@storeMedia')->name('cadre-activities.storeMedia');
        Route::resource('cadre-activities', 'CadreActivityController')->except(['show']);

        // Activities
        Route::delete('activities/destroy', 'ActivityController@massDestroy')->name('activities.massDestroy');
        Route::post('activities/media', 'ActivityController@storeMedia')->name('activities.storeMedia');
        Route::resource('activities', 'ActivityController')->except(['show']);

        /*// Activity Implementation
        Route::delete('activity-implementations/destroy', 'ActivityImplementationController@massDestroy')->name('activity-implementations.massDestroy');
        Route::post('activity-implementations/media', 'ActivityImplementationController@storeMedia')->name('activity-implementations.storeMedia');
        Route::resource('activity-implementations', 'ActivityImplementationController');

        // This Year Action Plans
        Route::get('this-year-activity-implementations', 'ThisYearActivityImplementationController@index')->name('this-year-activity-implementations.index');

        // Next Year Action Plans
        Route::get('next-year-activity-implementations', 'NextYearActivityImplementationController@index')->name('next-year-activity-implementations.index');*/

        /// Monitoring and Evaluation
        // Monitor
        Route::delete('monitors/destroy', 'MonitorController@massDestroy')->name('monitors.massDestroy');
        Route::post('monitors/media', 'MonitorController@storeMedia')->name('monitors.storeMedia');
        Route::resource('monitors', 'MonitorController')->except(['show']);

        // Recommendation
        Route::delete('recommendations/destroy', 'RecommendationController@massDestroy')->name('recommendations.massDestroy');
        Route::group(['middleware' => ['admin']], function () {
            Route::post('recommendations/{recommendation}/pending', 'RecommendationController@pending')->name('recommendations.pending');
            Route::post('recommendations/{recommendation}/continue', 'RecommendationController@continue')->name('recommendations.continue');
        });
        Route::resource('recommendations', 'RecommendationController')->except(['show']);

        // Evaluation
        Route::get('evaluations', 'EvaluationController@index')->name('evaluations.index');
        Route::get('evaluations/print', 'EvaluationController@print')->name('evaluations.print');

        /*// Movement Recommendation
        Route::get('movement-recommendations', 'MovementRecommendationController@index')->name('movement-recommendations.index');*/

        /// Verification
        // Assessment
        Route::get('assessments', 'AssessmentController@index')->name('assessments.index');
        Route::post('assessments/update', 'AssessmentController@update')->name('assessments.update');
        Route::get('assessments/print', 'AssessmentController@print')->name('assessments.print');

        /*// Assessment Results
        Route::get('assessment-results', 'AssessmentResultController@index')->name('assessment-results.index');

        // Assessment Result Verifications
        Route::get('assessment-result-verifications', 'AssessmentResultVerificationController@index')->name('assessment-result-verifications.index');*/


        //additional
        //environmental issue
        Route::delete('environmental-issues/destroy', 'EnvironmentalIssueController@massDestroy')->name('environmental-issues.massDestroy');
        Route::post('environmental-issues/media', 'EnvironmentalIssueController@storeMedia')->name('environmental-issues.storeMedia');
        Route::resource('environmental-issues', 'EnvironmentalIssueController')->except(['show']);

        //self development
        Route::delete('extracurriculars/destroy', 'ExtracurricularController@massDestroy')->name('extracurriculars.massDestroy');
        Route::post('extracurriculars/media', 'ExtracurricularController@storeMedia')->name('extracurriculars.storeMedia');
        Route::resource('extracurriculars', 'ExtracurricularController')->except(['show']);

        Route::delete('habituations/destroy', 'HabituationController@massDestroy')->name('habituations.massDestroy');
        Route::post('habituations/media', 'HabituationController@storeMedia')->name('habituations.storeMedia');
        Route::resource('habituations', 'HabituationController')->except(['show']);
    });
});

Route::get('/{school_slug}', 'HomeController@school')->name('school');
