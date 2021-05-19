<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\userRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    private $level=[0,1];

    public function index()
    {
        return response()->json(["users"=>User::all()]);
    }


    public function create(){
        return response(["level"=>$this->level]);
    }

    
    public function store(userRequest $request)
    {   
        
       if(in_array($request->isAdmin,$this->level)){

            if($request->path){
                $name=time().'.'.explode('/',explode(':',substr($request->path,0,strpos($request->path,';')))[1])[1];
                \Image::make($request->path)->save(public_path('profileImg/').$name)->resize(100,100);
                $request->merge(['path'=>$name]);
            }else{
                $request->merge(["path"=>null]);
            }

           $request->merge(["user_id"=>Auth::id()]);
           User::create($request->only("name","email","password","user_id","path","isAdmin"));
           return response()->json(["message"=>"user create successfully"],200);
       }else{
           return response()->json(["message"=>"level not found"],422);
       }
    }


    
    public function show($id)
    {
       return response()->json(["data"=> User::findOrFail($id)]);
    }

  
    public function edit($id)
    {
        return response()->json(["user"=> User::findOrFail($id)]);
    }

  
    public function update(userRequest $request, $id)
    {
       $user=User::findOrFail($id);


       if($request->path != null || $request->path != ''){
            $name=time().'.'.explode('/',explode(':',substr($request->path,0,strpos($request->path,';')))[1])[1];
            \Image::make($request->path)->save(public_path('profileImg/').$name)->resize(100,100);
            $request->merge(['path'=>$name]);

            $oldphoto=public_path('profileImg/').$user->path;
            if(file_exists($oldphoto)){
                @unlink($oldphoto);
            }

        }else{
            $request->merge(["path"=>$user->path]);
        }


       if($request->password=="" || $request->password == null){
           $user->update($request->only("name","email","isAdmin","path"));
       }else{
             $user->update($request->only("name","email","password","isAdmin","path"));
       }

       return response()->json(["message"=>"updated successfully"],200);
    }

   
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(["message"=>"deleted successfully"]);
    }
}
