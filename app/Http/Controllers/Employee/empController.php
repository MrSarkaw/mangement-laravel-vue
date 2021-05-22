<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\userRequest;
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

    public function updateState(Request $request, $id)
    {
        try{
            if (in_array($request->status, $this->status)) {
                  userTask::findOrFail($id)->update($request->only("status"));
                  return response(["message" => "status updated"]);        
            } else {
                return response(["message" => "choose right status!"]);
            }

        }catch(Exception $e){
            return response(["message"=>"not found!"]);
        }
    }

    public function update(Request $request)
    {

       $user=Auth::user();


        $this->validate($request,[
            "name"=>"required|max:50",
            "email"=>"required|max:100|email|unique:users,email,".$user->id,
            "password"=>"nullable|min:6|confirmed",
        ]);


       if($request->path != null || $request->path != ''){
            $name=time().'.'.explode('/',explode(':',substr($request->path,0,strpos($request->path,';')))[1])[1];
            \Image::make($request->path)->save(public_path('profileImg/').$name);
            $request->merge(['path'=>$name]);

            $oldphoto=public_path('profileImg/').$user->path;
            if(file_exists($oldphoto)){
                @unlink($oldphoto);
            }

        }else{
            $request->merge(["path"=>$user->path]);
        }


       if($request->password=="" || $request->password == null){
           $user->update($request->only("name","email","path"));
       }else{
             $user->update($request->only("name","email","password","path"));
       }

       return response()->json(["message"=>"updated successfully"],200);
    }
    
    public function fetch(){
        return response(["user"=>Auth::user()],200);
    }
}
