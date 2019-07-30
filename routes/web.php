<?php
use App\User;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Routing\Annotation\Route;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

Route::get('locale/{locale}', function ($locale) {
    \Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/donator', function () {
    return 'Coming Soon <a href="/home">back</a>';
});

Route::get('/organization', function () {
    return 'Coming Soon <a href="/home">back</a>';
});

// Route::get('/x', function () {
//     $users = User::whereHas('role', function($q){
//         $q->where('name', 'organization');
//     })->get();
//     return $users;
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::prefix('')
//    ->namespace('api')
//    ->group(function (){
//        Route::get('news', 'NewsController@index')->name('news.index');
//
//    });

Route::get('/cost-type', 'CostTypeController@index')->name('cost-type');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')
    ->middleware(array('auth', 'admin-only'))
    ->namespace('Admin')
    ->group(function (){
    
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');

        Route::get('add-users', 'UserController@addUsers')->name('admin.add-users');
        Route::get('users/search', 'UserController@search')->name('admin.users.search');
        Route::get('donators/search', 'DonatorController@search')->name('admin.donators.search');
        Route::get('organizations/search', 'OrganizationController@search')->name('admin.organizations.search');
        Route::get('projects/search', 'ProjectController@search')->name('admin.projects.search');
        Route::get('news/search', 'NewsController@search')->name('admin.news.search');
        Route::get('logs/search', 'LogController@search')->name('admin.logs.search');
        Route::get('events/search', 'EventController@search')->name('admin.events.search');
        // Route::get('publications/search', 'PublicationController@search')->name('admin.publications.search');


        Route::get('donator-create', 'UserController@create_donator')->name('admin.users.donator');
        Route::get('org-create', 'UserController@create_org')->name('admin.users.org');
        Route::get('user/avatar/{user}', 'UserController@avatar')->name('admin.users.avatar');
        Route::resource('users', 'UserController', [
            'names' => [
                'index'   => 'admin.users.index',
                'create'  => 'admin.users.create',
                'store'   => 'admin.users.store',
                'show'    => 'admin.users.show',
                'edit'    => 'admin.users.edit',
                'update'  => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ]
        ]);        

        // Routes for Events
        Route::get('events', 'EventController@index')->name('admin.events.index');
        Route::get('events/create', 'EventController@create')->name('admin.events.create');
        Route::get('events/edit/{Event}', 'EventController@edit')->name('admin.events.edit');
        Route::post('events/store', 'EventController@store')->name('admin.events.store');
        Route::patch('events/update/{Event}', 'EventController@update')->name('admin.events.update');
        Route::get('events/destroy/{Event}', 'EventController@destroy')->name('admin.events.destroy');
        Route::get('events/featured/{event}', 'EventController@featured')->name('admin.events.featured');
        Route::get('events/image_destroy/{image}', 'EventController@image_destroy')->name('admin.image.destroy');

        // Routes for News
        Route::get('news', 'NewsController@index')->name('admin.news.index');
        Route::get('news/show/{News}', 'NewsController@show')->name('admin.news.show');
        Route::get('news/create', 'NewsController@create')->name('admin.news.create');
        Route::get('news/edit/{News}', 'NewsController@edit')->name('admin.news.edit');
        Route::post('news/store', 'NewsController@store')->name('admin.news.store');
        Route::patch('news/update/{News}', 'NewsController@update')->name('admin.news.update');
        Route::get('news/destroy/{News}', 'NewsController@destroy')->name('admin.news.destroy');
        Route::get('news/featured/{news}', 'NewsController@featured')->name('admin.news.featured');
        Route::get('news/image_destroy/{image}', 'NewsController@image_destroy')->name('admin.newsimage.destroy');

        // Routes for Projects
        Route::get('projects', 'ProjectController@index')->name('admin.projects.index');
        Route::get('project/create', 'ProjectController@create')->name('admin.project.create');
        Route::get('project/{project}', 'ProjectController@show')->name('admin.project.show');
        Route::get('project/edit/{project}', 'ProjectController@edit')->name('admin.project.edit');
        Route::post('project/store', 'ProjectController@store')->name('admin.project.store');
        Route::patch('project/update/{project}', 'ProjectController@update')->name('admin.project.update');
        Route::get('project/edit/categories/{project}', 'ProjectController@categories')->name('admin.project-cat.update');
        Route::get('project/destroy/{project}', 'ProjectController@destroy')->name('admin.project.destroy');
        Route::get('project-to-pdf/{id}', 'ProjectController@pdf')->name('admin.project.pdf');

        // Routes for Narrative
        Route::get('narrative/create/', 'NarrativeController@create')->name('admin.narrative.create');
        Route::post('narrative/store/', 'NarrativeController@store')->name('admin.narrative.store');
        Route::get('narrative/edit/{narrative}', 'NarrativeController@edit')->name('admin.narrative.edit');
        Route::patch('narrative/update/{narrative}', 'NarrativeController@update')->name('admin.narrative.update');
        Route::get('narrative/show/{narrative}', 'NarrativeController@show')->name('admin.narrative.show');

        // Routes for Costs
        Route::get('cost/create/{project_id}', 'CostController@create')->name('admin.costs.create');
        Route::get('cost/edit/{cost}', 'CostController@edit')->name('admin.cost.edit');
        Route::post('cost/store', 'CostController@store')->name('admin.cost.store');
        Route::patch('cost/update/{cost}', 'CostController@update')->name('admin.cost.update');
        Route::get('cost/destroy/{cost}', 'CostController@destroy')->name('admin.cost.destroy');

        // Routes for category
        Route::get('categories', 'CategoryController@index')->name('admin.category.index');
        Route::get('category/create/{project_id}', 'CategoryController@create')->name('admin.category.create');
        Route::get('category/edit/{category}', 'CategoryController@edit')->name('admin.category.edit');
        Route::post('category/store', 'CategoryController@store')->name('admin.category.store');
        // Route::patch('category/update/project/{project_id}', 'CategoryController@update')->name('admin.category.update');
        Route::patch('category/update/{category}', 'CategoryController@update')->name('admin.category.update');
        Route::get('category/destroy/{category}', 'CategoryController@destroy')->name('admin.category.destroy');

        // Donator route
        Route::get('donators', 'DonatorController@index')->name('admin.donators.index');

        // Routes for Logs
        Route::get('logs', 'LogController@index')->name('admin.logs.index');
        Route::get('logs/destroy', 'LogController@destroy')->name('admin.logs.destroy');
        Route::get('table', 'LogController@table')->name('admin.table');

        // Routes for Organizations
        Route::get('organizations', 'OrganizationController@index')->name('admin.organizations.index');
        // Route::get('organization/create', 'OrganizationController@create')->name('admin.organization.create');
        // Route::get('organization/show/{project}', 'OrganizationController@show')->name('admin.organization.show');
        // Route::get('organization/edit/{project}', 'OrganizationController@edit')->name('admin.organization.edit');
        // Route::post('organization/store', 'OrganizationController@store')->name('admin.organization.store');
        // Route::patch('organization/update/{organization}', 'OrganizationController@update')->name('admin.organization.update');
        // Route::get('organization/destroy/{organization}', 'OrganizationController@destroy')->name('admin.organization.destroy');

        // Routes for Donators

        Route::get('donators', 'DonatorController@index')->name('admin.donators.index');

        // Routes for publications

        Route::get('publications', 'PublicationController@index')->name('admin.publications.index');
        Route::get('publication/create', 'PublicationController@create')->name('admin.publication.create');
        Route::get('publication/show/{publication}', 'PublicationController@show')->name('admin.publication.show');
        Route::get('publication/edit/{publication}', 'PublicationController@edit')->name('admin.publication.edit');
        Route::post('publication/store', 'PublicationController@store')->name('admin.publication.store');
        Route::patch('publication/update/{publication}', 'PublicationController@update')->name('admin.publication.update');
        Route::get('publication/destroy/{publication}', 'PublicationController@destroy')->name('admin.publication.destroy');
        Route::get('publication/image_destroy/{image}', 'PublicationController@image_destroy')->name('admin.publication_image.destroy');

        //Routes for libraries

        Route::get('libraries', 'LibraryController@index')->name('admin.libraries.index');
        Route::get('library/create', 'LibraryController@create')->name('admin.library.create');
        Route::get('library/show/{id}', 'LibraryController@show')->name('admin.library.show');
        Route::get('library/edit/{id}', 'LibraryController@edit')->name('admin.library.edit');
        Route::post('library/store', 'LibraryController@store')->name('admin.library.store');
        Route::patch('library/update/{id}', 'LibraryController@update')->name('admin.library.update');
        Route::get('library/destroy/{id}', 'LibraryController@destroy')->name('admin.library.destroy');
        Route::get('library/image_destroy/{image}', 'LibraryController@image_destroy')->name('admin.library_image.destroy');

        // Routes for detail

        Route::get('details', 'DetailController@index')->name('admin.details.index');
        Route::get('detail/create/{user_id}', 'DetailController@create')->name('admin.detail.create');
        Route::get('detail/show/{detail}', 'DetailController@show')->name('admin.detail.show');
        Route::get('detail/edit/{detail}', 'DetailController@edit')->name('admin.detail.edit');
        Route::post('detail/store', 'DetailController@store')->name('admin.detail.store');
        Route::patch('detail/update/{detail}', 'DetailController@update')->name('admin.detail.update');
        Route::get('detail/destroy/{detail}', 'DetailController@destroy')->name('admin.detail.destroy');

        // Routes for gallery


        Route::get('galleries', 'GalleryController@index')->name('admin.galleries.index');
        Route::get('gallery/create', 'GalleryController@create')->name('admin.gallery.create');
        Route::get('gallery/show/{id}', 'GalleryController@show')->name('admin.gallery.show');
        Route::get('gallery/edit/{id}', 'GalleryController@edit')->name('admin.gallery.edit');
        Route::post('gallery/store', 'GalleryController@store')->name('admin.gallery.store');
        Route::patch('gallery/update/{id}', 'GalleryController@update')->name('admin.gallery.update');
        Route::get('gallery/destroy/{id}', 'GalleryController@destroy')->name('admin.gallery.destroy');
        Route::get('gallery/image_destroy/{id}', 'GalleryController@image_destroy')->name('admin.gallery_image.destroy');

        //contact us

        Route::get('contact-us', 'ContactUsController@contact_us')->name('admin.contactus');
        Route::post('contact-us', 'ContactUsController@contact_us_post')->name('admin.contactus.store');
    
    });

    Route::get('/uuu', function(Request $request) {
        return $request->user()->role_id;
    });