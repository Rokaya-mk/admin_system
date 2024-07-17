<?php

namespace App\Http\Controllers\API;

use App\Events\NotificationEvent;
use App\Http\Requests\StoreProject;
use App\Http\Resources\ProjectResource;
use App\Mail\UserNotification;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectNotification;
use App\Notifications\UserNotification as NotificationsUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProjectController extends BaseController
{
    function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny',Project::class);
        
        return ProjectResource::collection(Project::orderBy('created_at', 'desc')->paginate(10));
    }
    // search project
    public function searchProject(Request $request){
        $search =$request->search_value;
        if($search){
            $projects= Project::where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orwhere('status','LIKE', "%$search%");
            })->latest()->paginate(10);
        }else{
            $projects = Project::orderBy('created_at', 'desc')->latest()->paginate(10);
        }
        return ProjectResource::collection($projects);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProject $request)
    {
        $this->authorize('create',Project::class);
        try {
            // specify data to get receive
            $data = $request->only(['name','description','status','user_id']);
            $project = Project::create($data);

            // get assigned user
            $assignedUser = User::find($project->user_id);
            if(!$assignedUser){
                return $this->SendError('Error to find assigned user');

            }else{
                 // send notification to assogned user
                 $message = 'New Project';
                 $assignedUser->notify(new ProjectNotification(auth('api')->user(), $project, $message));
                // send email to assigned user
                try {
                    Mail::to($assignedUser->email)->queue(new UserNotification($project," You've been assigned to new Project !!"));
                    //  broadcast(new NotificationEvent("new project assigned to you",$assignedUser->id))->toOthers();
                } catch (\Throwable $th) {
                    return $this->SendError('Error',$th->getMessage());
                }
            }
            return new ProjectResource($project);
        } catch (\Throwable $th) {
            return $this->SendError('Error',$th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProject $request, string $id)
    {
        try {
            $project = Project::find($id);
            // authorize the action
            $this->authorize('update',$project);
            // check if status changed
            if($project->status != $request->status){
                try {
                    $assignedUser = User::find($project->user_id);
                    $assignedUser->notify(new ProjectNotification(auth('api')->user(), $project, "Status project chenged!!"));
                    Mail::to($assignedUser->email)->queue(new UserNotification($project,"Status changed of this project: ".$project->name));
                    // broadcast(new NotificationEvent("Status of project changed",$assignedUser->id))->toOthers();
                } catch (\Throwable $th) {
                    return $this->SendError('Error',$th->getMessage());
                }
            }
            $project->update($request->all());
            return new ProjectResource($project);
        } catch (\Throwable $th) {
            return $this->SendError('Error',$th->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $project = Project::find($id);
             // authorize the action
            $this->authorize('delete',$project);
            $project->delete();
            return $this->SendResponse(null,'Project is deleted Successfully!');
        } catch (\Throwable $th) {
            return $this->SendError('Error',$th->getMessage());
        }
    }
    public function getBarChartData($year)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $numeric_months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        $projects_array = [];
        $in_progess_array = [];
        $finished_array = [];
        $canceled_array = [];

        foreach($numeric_months as $nm) {
            $projects = Project::whereMonth('created_at', '=', $nm)->whereYear('created_at', '=', $year)->get();
            array_push($projects_array, $projects->count());
        }

        foreach($numeric_months as $nm) {
            $projects = Project::where('status', 'in_progess')->whereMonth('created_at', '=', $nm)->whereYear('created_at', '=', $year)->get();
            array_push($in_progess_array, $projects->count());
        }
        foreach($numeric_months as $nm) {
            $projects = Project::where('status', 'finished')->whereMonth('created_at', '=', $nm)->whereYear('created_at', '=', $year)->get();
            array_push($finished_array, $projects->count());
        }
        foreach($numeric_months as $nm) {
            $projects = Project::where('status', 'canceled')->whereMonth('created_at', '=', $nm)->whereYear('created_at', '=', $year)->get();
            array_push($canceled_array, $projects->count());
        }

        return response()->json([
            'year'                  => $year,
            'months'                => $months,
            'projects_array'           => $projects_array,
            'in_progess_array' => $in_progess_array,
            'finished_array' => $finished_array,
            'canceled_array' => $canceled_array,
        ]);
    }
}
