<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\taskRequest;
use App\Models\task;
use App\Models\User;
use App\Models\userTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class taskController extends Controller
{

    public function index()
    {   
        $task=task::with("users")->get();
        return response()->json(["task" => $task ]);
    }

    public function store(taskRequest $request)
    {


        $userId=[];

        // check if users selected
        if(count($request->userCheck)!=0){  
            // collect  user id
            foreach($request->userCheck as $row){
                User::findOrFail($row["id"]);
                $userId[]=$row['id'];
            }    
        }

         

        $request->merge(["user_id" => Auth::id()]);
        $id= task::insertGetId($request->only("title", "description", "user_id", "start_date", "end_date"));

       return response()->json(["message" => "task created successfully","taskId"=>$id,"users"=>$userId], 200);
    }



    public function show($id)
    {   
        $task=task::with("users")->findOrFail($id);
        return response()->json(["task" => $task]);
    }


    public function edit($id)
    {
        return response()->json(["data" => task::findOrFail($id)]);
    }

    public function update(taskRequest $request, $id)
    {
        $request->merge(["user_id" => Auth::id()]);

        $task = task::findOrFail($id);

        $task->update($request->only("title", "description", "user_id", "start_date", "end_date"));

        return response()->json(["message" => "task updated successfully","taskId"=>$id], 200);
    }

    public function destroy($id)
    {
        task::findOrFail($id)->delete();
        return response()->json(["message" => "task deleted successfully"], 200);
    }
}
