<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\userTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class empController extends Controller
{
    private $status = [0, 1, 2];
    public function index()
    {
        $userTask = userTask::with("task")->where("user_id", Auth::id())->get();

        return response()->json(["tasks" => $userTask, "status" => $this->status]);
    }

    public function updateState(Request $request, $task_id)
    {
        try{
            if (in_array($request->status, $this->status)) {

                  userTask::where("task_id", $task_id)
                        ->where("user_id", Auth::id())->firstOrFail()
                        ->update($request->only("status"));
         
                    return response(["message" => "status updated"]);
                
                
            } else {
                return response(["message" => "choose right status!"]);
            }

        }catch(Exception $e){
            return response(["message"=>"not found!"]);
        }

       
   
    }
}
