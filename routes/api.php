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
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProjectUserController;
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
Route::post('/check-login', [AuthController::class, 'checkLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/first-login', [AuthController::class, 'firstLogin']);
Route::group(
	array( 'middleware' => array( 'auth:sanctum' ) ), function(){
        Route::get('allusers' , [AuthController::class, 'index']);
    },
);
Route::group(
	// array( 'middleware' => array( 'auth:sanctum' ) ), function(){
    //     Route::get('allusers' , [AuthController::class, 'index']);
    // },
	array( 'middleware' => array( 'auth:sanctum', 'admin' ) ),
	function() {
		Route::get('/logout', [AuthController::class, 'logout']);
		Route::get( '/user', array( AuthController::class, 'logged' ) );
        Route::group(
            array( 'prefix' => 'user' ),
            function () {
                Route::post('update', [AuthController::class, 'update']);
                Route::post('create', [AuthController::class, 'create']);
                Route::post('change-role-user/{id}', [AuthController::class, 'changeRoleUser']);
                Route::post('change-password-user/{id}', [AuthController::class, 'changePasswordUser']);
                Route::post('change-password', [AuthController::class, 'changePassword']);
            }
        );
		// Get all project
		Route::post( 'store', array( ProjectController::class, 'store' ) );
		Route::group(
			array( 'prefix' => 'project' ),
			function () {
				Route::post( 'index', array( ProjectController::class, 'index' ) );
				Route::post( 'create', array( ProjectController::class, 'create' ) );
				Route::post( 'show', array( ProjectController::class, 'show' ) );
				Route::post( 'update', array( ProjectController::class, 'update' ) );
				Route::post( 'adduser', array( ProjectUserController::class, 'create' ) );					
			}
		);

        Route::group(
			array( 'prefix' => 'tasks' ),
			function () {
                Route::post( '/update', array( TaskController::class, 'update' ) );
				Route::post( '/create', array( TaskController::class, 'create' ) );
				Route::post( '/index', array( TaskController::class, 'index' ) );
				Route::post( '/show/{id}', array( TaskController::class, 'show' ) );
				Route::post( '/store', array( TaskController::class, 'store' ) );
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
                Route::post( '/remove/{id}', array( CheckListController::class, 'destroy' ) );			
                Route::post( '/update/{id}', array( CheckListController::class, 'update' ) );			
            }
		);

        Route::group(
			array( 'prefix' => 'media' ),
			function () {			
                Route::post( '/remove/{id}', array( MediaController::class, 'destroy' ) );			
            }
		);
	}
);

