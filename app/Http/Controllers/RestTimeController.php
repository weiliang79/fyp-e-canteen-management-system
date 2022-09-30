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
            'day_id' => 'required|array',
            'start_time' => 'required|array',
            'end_time' => 'required|array',
        ]);

        $id = $request->id ? $request->id : array();

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

            //delete the record if not inside id array
            RestTime::whereNotIn('id', $id)->delete();
        }

        return redirect()->route('admin.user_management')->with('swal-success', 'Rest Time update successful.');
    }
}
