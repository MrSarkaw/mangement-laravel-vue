<?php

namespace App\Http\Controllers\Admin;

use App\Events\deleteTask;
use App\Events\task as EventsTask;
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

                    // task for realtime
                    $data=userTask::with("task")->where("user_id",$user->id)->where("task_id",$task->id)->first();
                    broadcast(new EventsTask($data));

                    $message= response()->json(["message" => "success"], 200);
                } else {
                    $message= response()->json(["message" => "user already have this task"], 422);
                }
            }

            return $message;

           
        }
    }


    public function update(Request $request,$id){

       
            $task = task::findOrFail($id);

            $message="";
            
            //collect fot deleteing usertask for task $id and users $users when all unsign or who un sign ...
            if(count($request->users) > 0){

                $userId=[];

                foreach($request->users as $user){
                    $userId[]=$user['id'];
                }
             
                $oldPerson=userTask::where("task_id",$id)->whereNotIn("user_id",$userId)->get();
            }else{
                $oldPerson=userTask::where("task_id",$id)->get();
            }

            // deleteing who unsign task
            if($oldPerson){
                foreach ($oldPerson as  $row) {
                    broadcast(new deleteTask($row));
                    $row->delete();
                }
            }


            // inserting new user for task
        if(count($request->users) > 0){

            foreach($request->users as $row){
                $user = User::findOrFail($row['id']);
                
                $check = userTask::where("task_id", $task->id)->where("user_id", $user->id)->count();
                // regre krdn la wargrtne tasky dwbara
                if ($check == 0) {
                    $user->tasks()->attach($task->id);

                    // task for raeltime
                    $data=userTask::with("task")->where("user_id",$user->id)->where("task_id",$task->id)->first();
                    broadcast(new EventsTask($data));


                    $message= response()->json(["message" => "success"], 200);
                } 
            }

            return $message;

           
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
