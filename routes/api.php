<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CardController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// return $request->user();
// });
// Route::group(['middleware' => ['guest']], function () {
// Route::post('login', 'App\Http\Controllers\API\AuthController@login');
// });
Route::post( '/login', array( AuthController::class, 'login' ) );
// Route::resource('tasks',TaskController::class)->only(['index', 'create', 'edit']);
Route::group(
	array( 'middleware' => array( 'auth:sanctum', 'admin' ) ),
	function() {

		// Route::get('/logout', [AuthController::class, 'logout']);
		Route::get( '/user', array( AuthController::class, 'logged' ) );
		// Get all project
		Route::post( 'store', array( ProjectController::class, 'store' ) );
		// Route::resource('tasks',TaskController::class)->only(['index', 'show', 'create', 'edit']);
		// Route::group(['prefix' => 'admin'], function(){
		// Route::get('/', [ProductController::class, 'index']);
		// Route::get('/products/delete', [ProductController::class, 'del']);

		// Route::resource('products', ProductController::class)->only(['index', 'show', 'create', 'edit']);
		// Route::resource('roles', RoleController::class);
		// Route::resource('permissions', PermissionController::class);
		// });
		// Route::group(['prefix' => 'tasks','middleware' => ['auth:sanctum', 'admin']], function () {
		// Route::post('create', [TaskController::class, 'create']);
		// });
		Route::group(
			array( 'prefix' => 'project' ),
			function () {
				Route::post( 'store', array( ProjectController::class, 'store' ) );
				Route::post( 'create', array( ProjectController::class, 'create' ) );
				// Route::get( '/{id}', array( ProjectController::class, 'show' ) );
			}
		);

        Route::group(
			array( 'prefix' => 'card' ),
			function () {
				Route::post( '/', array( CardController::class, 'index' ) );
			}
		);

        Route::group(
			array( 'prefix' => 'tasks' ),
			function () {
                Route::post( '/update', array( TaskController::class, 'update' ) );
				Route::post( '/create', array( TaskController::class, 'create' ) );
				Route::post( '/{id}', array( TaskController::class, 'show' ) );
			}
		);
	}
);

// Route::group(
// 	array(
// 		'prefix'     => 'tasks',
// 		'middleware' => array( 'auth:sanctum', 'admin' ),
// 	),
// 	function () {
// 		Route::post( 'create', array( TaskController::class, 'create' ) );
// 	}
// );

// Route::group(['prefix' => 'tasks','middleware' => ['auth:sanctum', 'admin']], function () {
// Route::post('create', [TaskController::class, 'create']);
// });
