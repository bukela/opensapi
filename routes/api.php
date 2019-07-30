<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
   return $request->user();
});

Route::namespace('Api')
   //  ->middleware(array('auth', 'admin-only'))
   //  ->middleware(array('auth:api','admin-only'))
   //  ->middleware('auth:api')
    ->group(function (){

     Route::resource('/events', 'EventController');
     Route::resource('/news', 'NewsController');
     Route::resource('/users', 'UserController');
     Route::resource('/projects', 'ProjectController');
     Route::resource('/costs', 'CostController');
     Route::get('/costs/download/{id}', 'CostController@download');
     Route::resource('/organizations', 'OrganizationController');
     Route::resource('/donators', 'DonatorController');
     Route::resource('/categories', 'CategoryController');
     Route::resource('/narratives', 'NarrativeController');
     Route::resource('/publications', 'PublicationController');
     Route::resource('/libraries', 'LibraryController');
     Route::get('/publications/download/{id}', 'PublicationController@download');
     Route::resource('/details', 'DetailController');
     Route::resource('/galleries', 'GalleryController');
     Route::get('/galleries/image_destroy/{id}', 'FileController@image_destroy');
     Route::get('/dashboard/events', 'DashboardController@user_events');
     Route::get('/dashboard/news', 'DashboardController@user_news');
     Route::get('/dashboard/projects', 'DashboardController@user_projects');
     Route::get('/dashboard/organization_users', 'DashboardController@organization_users');
     Route::get('/dashboard/donator_users', 'DashboardController@donator_users');
     
    });

    Route::post('contact-us', 'Api\ContactUsController@contact_us_post');

Route::group([
      // 'prefix' => 'auth'
      ], function () {
            Route::post('login', 'Api\AuthController@login');
         
            Route::group([
            'middleware' => 'auth:api'
            ], function() {
               Route::get('logout', 'Api\AuthController@logout');
               Route::get('user', 'Api\AuthController@user');
         });
  });