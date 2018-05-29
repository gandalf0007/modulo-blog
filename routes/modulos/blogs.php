<?php




/*--------------------------------------BLOG------------------------------------------------*/
Route::get('blog-panel', 'BlogController@index')->middleware('permission:listar-post');
Route::get('blog-panel-datatable', 'BlogController@indexDatatable');
Route::get('blog-edit/{id}','BlogController@edit')->middleware('permission:crear-post');
Route::post('blog-store','BlogController@store')->middleware('permission:crear-post');
Route::put('blog-update/{id}','BlogController@update')->middleware('permission:editar-post');
Route::post('blog-cambiar-status/{id}','BlogController@CambiarStatus')->middleware('permission:editar-post');
Route::delete('blog-destroy/{id}','BlogController@destroy')->middleware('permission:eliminar-post');

Route::get('blog-categorias', 'BlogController@BlogCategoriaIndex')->middleware('permission:listar-post');
Route::post('blog-categorias-store','BlogController@BlogCategoriaStore')->middleware('permission:crear-post');
Route::put('blog-categorias-update/{id}','BlogController@BlogCategoriaUpdate')->middleware('permission:editar-post');
Route::delete('blog-categorias-destroy/{id}','BlogController@BlogCategoriaDestroy');

Route::get('blog-tags', 'BlogController@BlogTagsIndex')->middleware('permission:listar-post');
Route::post('blog-tags-store','BlogController@BlogTagsStore')->middleware('permission:crear-post');
Route::put('blog-tags-update/{id}','BlogController@BlogTagsUpdate')->middleware('permission:editar-post');
Route::delete('blog-tags-destroy/{id}','BlogController@BlogTagsDestroy')->middleware('permission:eliminar-post');
/*--------------------------------------BLOG------------------------------------------------*/
