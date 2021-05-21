<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function () {
    // admin section,
    Route::middleware(["isAdmin"])->group(function () {
        // user
        Route::resource("users","Admin\\userController");
        // tasks
        Route::resource("tasks","Admin\\taskController")->except("create");
        // user task
        Route::resource("task/mangement","Admin\\userTasksController")->except(["index","edit","create","destroy"]);
            //  custome delete for user task
             Route::delete('task/mangement/{user_id}/{task_id}', "Admin\userTasksController@delete");
      });



      Route::get("currentUser","Auth\LogoutController@currentUser");

    //   employee section

        // fetch all task
        Route::get("/employee/task","Employee\\empController@index");
        Route::patch("/employee/task/{task_id}","Employee\\empController@updateState");
        Route::patch("/employee/profile","Employee\\empController@update");
        route::get("/employee/fetchProfile","Employee\\empController@fetch");


});

Route::post("login","Auth\LoginController@login");
Route::post("logout","Auth\LogoutController@logout");

