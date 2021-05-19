<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\task;
use App\Models\User;
use App\Models\userTask;
use Illuminate\Http\Request;


class userTasksController extends Controller
{
    public function store(Request $request)
    {
        if(count($request->users) > 0){
            $task = task::findOrFail($request->task_id);

            $message="";

            foreach($request->users as $row){
                $user = User::findOrFail($row);
                
                $check = userTask::where("task_id", $task->id)->where("user_id", $user->id)->count();
                // regre krdn la wargrtne tasky dwbara
                if ($check == 0) {
                    $user->tasks()->attach($task->id);
                    $message= response()->json(["message" => "success"], 200);
                } else {
                    $message= response()->json(["message" => "user already have this task"], 422);
                }
            }

            return $message;

           
        }else{
            return response(["message"=>"please assign users for task"],422);
        }
    }


    public function update(Request $request,$id){

        if(count($request->users) > 0){
            $task = task::findOrFail($id);

            $message="";
            
            //deleteing task for task $id and users $users

            $oldPerson=userTask::where("task_id",$id)->get();
            if($oldPerson){
                foreach ($oldPerson as  $row) {
                    $row->delete();
                }
            }


            foreach($request->users as $row){
                $user = User::findOrFail($row['id']);
                
                $check = userTask::where("task_id", $task->id)->where("user_id", $user->id)->count();
                // regre krdn la wargrtne tasky dwbara
                if ($check == 0) {
                    $user->tasks()->attach($task->id);
                    $message= response()->json(["message" => "success"], 200);
                } else {
                    $message= response()->json(["message" => "user already have this task"], 422);
                }
            }

            return $message;

           
        }else{
            return response(["message"=>"please assign users for task"],422);
        }
    }

   
   public function show($id)
    {
        return response()->json(["data"=> task::with("users")->findOrFail($id)],200);
    }



    public function delete($user_id,$task_id)
    {
        User::findOrFail($user_id);
        task::findOrFail($task_id);

        userTask::where("user_id",$user_id)->where("task_id",$task_id)->first()->delete();

        return response()->json(["message"=>"deleted successfully"],200);
    }
}
