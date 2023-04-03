<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\WorkTodoController;
use App\Http\Controllers\CheckListController;
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


Route::post( '/login', array( AuthController::class, 'login' ) );
Route::group(
	array( 'middleware' => array( 'auth:sanctum', 'admin' ) ),
	function() {

		Route::get('/logout', [AuthController::class, 'logout']);
		Route::get( '/user', array( AuthController::class, 'logged' ) );
		// Get all project
		Route::post( 'store', array( ProjectController::class, 'store' ) );
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
				Route::post( '/index/{id}', array( TaskController::class, 'index' ) );
				Route::post( '/show/{id}', array( TaskController::class, 'show' ) );
			}
		);

        Route::group(
			array( 'prefix' => 'labels' ),
			function () {
                Route::post( '/', array( LabelController::class, 'index' ) );
			}
		);

        Route::group(
			array( 'prefix' => 'todo' ),
			function () {
                Route::post( '/create', array( WorkTodoController::class, 'create' ) );
                Route::post( '/remove/{id}', array( WorkTodoController::class, 'destroy' ) );
			}
		);

        Route::group(
			array( 'prefix' => 'checklist' ),
			function () {
                Route::post( '/create', array( CheckListController::class, 'create' ) );			
                Route::post( '/remove/{id}', array( CheckListController::class, 'creadestroyte' ) );			
            }
		);
	}
);

