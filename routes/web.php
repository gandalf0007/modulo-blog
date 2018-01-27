<?php

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





Route::group(['middleware' =>['web']], function () {
    
Route::get('blog', 'BlogController@BlogPost');
Route::get('blog/{slug}', 'BlogController@BlogPostItem');
Route::get('blog-categoria/{slug}', 'BlogController@BlogPostCategoria');
Route::get('blog-tags/{slug}', 'BlogController@BlogPostTags');

});





Route::group(['middleware' =>['admin']], function () {


/*----------------------------------CONFIGURACIONES-----------------------------------*/
Route::get('settings','AdminController@Config');

Route::get('blog-settings', 'BlogController@BlogSettingsIndex');
Route::post('blog-settings-disqus-store','BlogController@BlogSettingsDisqusStore');
Route::put('blog-settings-disqus-update/{id}','BlogController@BlogSettingsDisqusUpdate');
Route::post('blog-settings-imagen-store','BlogController@BlogSettingsImagenStore');
Route::put('blog-settings-imagen-update','BlogController@BlogSettingsImagenUpdate');


/*----------------------------------CONFIGURACIONES-----------------------------------*/



/*--------------------------------------BLOG------------------------------------------------*/
Route::get('blog-panel', 'BlogController@index');
Route::get('blog-panel-datatable', 'BlogController@indexDatatable');
Route::post('blog-store','BlogController@store');
Route::put('blog-update/{id}','BlogController@update');
Route::post('blog-cambiar-status/{id}','BlogController@CambiarStatus');
Route::delete('blog-destroy/{id}','BlogController@destroy');

Route::get('blog-categorias', 'BlogController@BlogCategoriaIndex');
Route::post('blog-categorias-store','BlogController@BlogCategoriaStore');
Route::put('blog-categorias-update/{id}','BlogController@BlogCategoriaUpdate');
Route::delete('blog-categorias-destroy/{id}','BlogController@BlogCategoriaDestroy');

Route::get('blog-tags', 'BlogController@BlogTagsIndex');
Route::post('blog-tags-store','BlogController@BlogTagsStore');
Route::put('blog-tags-update/{id}','BlogController@BlogTagsUpdate');
Route::delete('blog-tags-destroy/{id}','BlogController@BlogTagsDestroy');
/*--------------------------------------BLOG------------------------------------------------*/



/*--------------------------------------FILEMANAGER------------------------------------------------*/
Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');
/*--------------------------------------FILEMANAGER------------------------------------------------*/



 });



















