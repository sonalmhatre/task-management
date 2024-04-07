<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use DB;
class TaskController extends Controller
{
    //GET
    public function index(Request $request){
        
        $query = Task::orderBy('id','desc');
       
        if(!empty($request->status)){
            $query->where('status',$request->status);
        }
        if(!empty($request->due_date)){
            $query->where('due_date',$request->due_date);
        }
        if(!empty($request->user)){
            $query->whereHas('assignees', function($query) use($request){
                return $query->where('user_id',$request->user);
            });
        }
        $data = $query->paginate();
        return response()->json([
            'status'=>true,
            'message'=>'Task list',
            'data'=>$data
        ]);

    }
    //POST
    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'due_date'=>'required|date'
        ]);
        Task::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'due_date'=>$request->due_date
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Task created Successfully',
            'data'=>[]
        ]);
    }
    //POST
    public function update(Request $request,$id){
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json([
            'status'=>true,
            'message'=>'Task updated Successfully'
        ]);

    }
    //GET
    public function delete($id){
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Task Deleted Successfully',
            'data'=>[]
        ]);
    }
    //POST
    public function assigntask(Request $request,$taskid){
        try{
            $usersid = $request['userids'];
            $task = Task::where('id',$taskid)->first();
            $task->assignees()->sync($usersid);
            $status = true;
        }catch (\Exception $e) {
            $status = false;
            Log::error(
                'Something went wrong while getting the tasks from the database',
                [
                    'message' => $e->getMessage()
                ]
            );
        }
        return response()->json([
            'status'=>$status,
            'message'=>'Task Assigned to users',
            'data'=>[]
        ]);
    }
    public function unassigntask(Request $request,$taskid){
        $taskuser = DB::table('task_user')->where('task_id',$taskid)->where('user_id',$request->user_id)->delete();
        return response()->json([
            'status'=>true,
            'message'=>'Task Unassigned from user',
            'data'=>[]
        ]);
    }
    //POST
    public function changetaskstatus(Request $request,$id){
        $task = Task::findOrFail($id);
        $task->update(['status'=>$request->status]);
        return response()->json([
            'status'=>true,
            'message'=>'Task updated Successfully',
            'data'=>[]
        ]);
    }
    public function getauthusertask(){
        //$data = 
        $data= auth()->user()->tasks;
        
        return response()->json([
            'status'=>true,
            'message'=>'Logged in user task list',
            'data'=>$data
        ]);
    }
    public function usertask($userid){
        $user = User::where('id',$userid)->first();
        $data= $user->tasks;
        return response()->json([
            'status'=>true,
            'message'=>'Logged in user task list',
            'data'=>$data
        ]);
    }
}
