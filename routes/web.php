<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
Route::get('/generate', function() {
    try {
        $dbconnect = DB::connection()->getPDO();
        $dbname = DB::connection()->getDatabaseName();
        echo "Connected successfully to the database. Database name is :".$dbname;
     } catch(Exception $e) {
        echo $e->getMessage();
     }
});
Route::get('/connection', function() {
    try {
        $dbconnect = DB::connection()->getPDO();
        $dbname = DB::connection()->getDatabaseName();
        echo "Connected successfully to the database. Database name is :".$dbname;
     } catch(Exception $e) {
        echo $e->getMessage();
     }
});
// Remove route cache
Route::get('/clear-route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return 'All routes cache has just been removed';
});
Route::get('/cache-clear', function() {
    Artisan::call('cache:clear');
     return "cache clear All";
    //dd("cache clear All");
});

Route::get('/send-mail', 'MailController@resetPassword');

Route::group(['prefix'=>'sct','middleware'=>'auth'], function (){
    Route::get('/update-password', 'PagesController@updatePassword');
    Route::post('/submit-updatepass','System\UsersController@submitUpdatepassword')->name('submit-updatepass');
});

Route::group(['middleware'=>'auth'], function (){
    Route::get('/dashboard', 'PagesController@index')->name('dashboard');
    Route::get('/menu', 'PagesController@menu')->name('menu');
    Route::get('/permission-denied', 'PagesController@permissionDenied');
    Route::get('/profile', 'PagesController@profile')->name('profile');
    Route::post('update-profile','System\UsersController@updateProfile')->name('update-profile');
    // Route::get('view-manual-book','PagesController@viewManualBook')->name('view-manual-book');
});

Route::group(['prefix'=>'voting','middleware'=>'auth'], function (){

    Route::get('/','VotingController@index');
    Route::get('/data','VotingController@ajaxData');
    Route::post('/submit','VotingController@submit');
    Route::post('/show','VotingController@show');
    Route::delete('/delete','VotingController@destroy');
    Route::get('/combo-desa','VotingController@comboDesa');
});


Route::group(['prefix'=>'caleg','middleware'=>'auth'], function (){

    Route::get('/','CalegController@index');
    Route::get('/data','CalegController@ajaxData');
    Route::post('/submit','CalegController@submit');
    Route::post('/show','CalegController@show');
    Route::delete('/delete','CalegController@destroy');
});

Route::group(['prefix'=>'pemilih','middleware'=>'auth'], function (){

    Route::get('/','PemilihController@index');
    Route::get('/data','PemilihController@ajaxData');
    Route::post('/submit','PemilihController@submit');
    Route::post('/show','PemilihController@show');
    Route::delete('/delete','PemilihController@destroy');
    Route::post('/import_excel','PemilihController@importExcel');
});

Route::group(['prefix'=>'kecamatan','middleware'=>'auth'], function (){

    Route::get('/','KecamatanController@index');
    Route::get('/data','KecamatanController@ajaxData');
    Route::post('/submit','KecamatanController@submit');
    Route::post('/show','KecamatanController@show');
    Route::delete('/delete','KecamatanController@destroy');
});

Route::group(['prefix'=>'desa','middleware'=>'auth'], function (){

    Route::get('/','DesaController@index');
    Route::get('/data','DesaController@ajaxData');
    Route::post('/submit','DesaController@submit');
    Route::post('/show','DesaController@show');
    Route::delete('/delete','DesaController@destroy');
});

Route::group(['prefix'=>'system','middleware'=>'auth'], function (){

    //user
    Route::get('/users','System\UsersController@index');
    Route::get('/users/ajax-data','System\UsersController@ajaxData');
    Route::post('/users/submit','System\UsersController@submit');
    Route::post('/users/show','System\UsersController@show');
    Route::delete('/users/delete','System\UsersController@destroy');
    //role
    Route::get('/role','System\RolesController@index');
    Route::get('/role/ajax-data','System\RolesController@ajaxData');
    Route::post('/role/submit','System\RolesController@submit');
    Route::post('/role/create','System\RolesController@store');
    Route::post('/role/show','System\RolesController@show');
    Route::delete('/role/delete','System\RolesController@destroy');
    Route::get('/role/role-access','System\RolesController@roleAccess')->name('generate-menu-access');

    //menu
    Route::get('/menu','System\MenuController@index');
    Route::get('/menu/ajax-data','System\MenuController@ajaxData');
    Route::post('/menu/submit','System\MenuController@submit');
    Route::post('/menu/show','System\MenuController@show');
    Route::delete('/menu/delete','System\MenuController@destroy');
    Route::get('/menu/action','System\MenuController@menuAction')->name('generate-menu-action');

});

Route::group(['prefix'=>'autocomplete','middleware'=>'auth'], function (){

    //user
    Route::get('/key','AutocompleteController@datalist');
    Route::get('/keterangan','AutocompleteController@datalistKet');
    Route::get('/vendor','AutocompleteController@datalistVendor');
 
});

// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');

Route::group(['prefix'=>'master-data','middleware'=>'auth'], function (){
    Route::get('kategori','KategoriController@index')->name('kategori.index');
    Route::get('kategori/data','KategoriController@getData')->name('kategori.data');
    Route::post('kategori/submit','KategoriController@storeOrUpdate')->name('kategori.store');
    Route::get('kategori/{id}/show','KategoriController@show')->name('kategori.show');
    Route::delete('kategori/{id}/delete','KategoriController@destroy')->name('kategori.delete');

    Route::get('satuan','SatuanController@index')->name('satuan.index');
    Route::get('satuan/data','SatuanController@getData')->name('satuan.data');
    Route::post('satuan/submit','SatuanController@storeOrUpdate')->name('satuan.store');
    Route::get('satuan/{id}/show','SatuanController@show')->name('satuan.show');
    Route::delete('satuan/{id}/delete','SatuanController@destroy')->name('satuan.delete');
});

require __DIR__.'/auth.php';
