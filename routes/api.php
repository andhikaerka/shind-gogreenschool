<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['as' => 'api.', 'namespace' => 'Api'], function () {
    Route::post('cities', 'CityController@index')->name('cities');
    Route::post('classes', 'ClassController@index')->name('classes');
    Route::post('quality-reports', 'QualityReportController@index')->name('quality-reports');
    Route::post('work-groups', 'WorkGroupController@index')->name('work-groups');
    Route::post('partners', 'PartnerController@index')->name('partners');
    Route::post('studies', 'StudyController@index')->name('studies');
    Route::post('activities', 'ActivityController@index')->name('activities');
    Route::post('checklist-templates', 'ChecklistTemplateController@index')->name('checklist-templates');
    Route::post('work-programs', 'WorkProgramController@index')->name('work-programs');
    Route::post('cadre-activities', 'CadreActivityController@index')->name('cadre-activities');

    Route::post('study', 'StudyController@show')->name('study');
    Route::post('work-program', 'WorkProgramController@show')->name('work-program');

    Route::post('schools/data', 'SchoolController@data')->name('schools.data');
    Route::post('cadre-activities/data', 'CadreActivityController@data')->name('cadre-activities.data');

    Route::post('studies/check-percentage', 'StudyController@checkPercentage')->name('studies.check-percentage');

    Route::post('teams', 'TeamController@index')->name('teams');
    Route::post('environments', 'EnvironmentsController@index')->name('environments');
    Route::post('lesson-plans', 'LessonPlanController@index')->name('lesson-plans');
    Route::post('budget-plans', 'BudgetPlanController@index')->name('budget-plans');
    Route::post('checklist-templates-by-group', 'ChecklistTemplateController@getByWorkGroup')->name('checklist-templates-by-group');
    Route::post('studies/get-percentage', 'WorkProgramController@getPercentage')->name('work-programs.get-percentage');
});
