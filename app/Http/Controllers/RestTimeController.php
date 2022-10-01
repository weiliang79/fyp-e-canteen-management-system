<?php

namespace App\Http\Controllers;

use App\Models\RestTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RestTimeController extends Controller
{
    public function index(){
        $restTimes = RestTime::all();

        if(count($restTimes) == 0){
            Session::flash('swal-warning', 'Please at least create a rest time first.');
            return view('admin.user_management.student.manage_rest_time', compact('restTimes'));
        }

        return view('admin.user_management.student.manage_rest_time', compact('restTimes'));
    }

    public function update(Request $request){

        $request->validate([
            'start_time.*' => 'required',
            'end_time.*' => 'required',
        ],
        [
            'start_time.*' => 'The start time field is required.',
            'end_time.*' => 'The end time field is required.',
        ]);

        $id = $request->rest_time_id ?: array();

        for($i = 0; $i < count($request->day_id); $i++){

            if(isset($id[$i])){

                //update the rest time details
                RestTime::find($id[$i])->update([
                    'day_id' => $request->day_id[$i],
                    'start_time' => $request->start_time[$i],
                    'end_time' => $request->end_time[$i],
                    'description' => $request->description[$i],
                ]);

            } else {

                //create the rest time details
                $rest = RestTime::create([
                    'day_id' => $request->day_id[$i],
                    'start_time' => $request->start_time[$i],
                    'end_time' => $request->end_time[$i],
                    'description' => $request->description[$i],
                ]);

                array_push($id, $rest->id);
            }

        }

        //delete the record if not inside id array
        $needDeteteIds = RestTime::whereNotIn('id', $id)->pluck('id')->toArray();

        if(count($needDeteteIds) !== 0){
            foreach ($needDeteteIds as $id) {
                RestTime::find($id)->students()->detach();
            }
            RestTime::whereIn('id', $needDeteteIds)->delete();
        }

        return redirect()->route('admin.user_management')->with('swal-success', 'Rest Time update successful.');
    }
}
