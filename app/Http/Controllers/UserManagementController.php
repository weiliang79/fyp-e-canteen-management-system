<?php

namespace App\Http\Controllers;

use App\Models\RestTime;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function PHPSTORM_META\map;

class UserManagementController extends Controller
{
    public function index(){
        $users = User::all();
        $students = Student::all();
        return view('admin.user_management.index', compact('users', 'students'));
    }

    public function showCreateForm(){
        $roles = Role::get();
        return view('admin.user_management.create', compact('roles'));
    }

    public function save(Request $request){

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'unique:users,email|unique:students,email',
            'password' => ['required', Rules\Password::defaults()],
            'role' => 'required|integer|gt:0'
        ],
        [
            'role.gt' => 'The role field need to choose a role.',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'role_id' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user_management')->with('swal-success', 'New user details save successful.');

    }

    public function delete(Request $request){
        User::destroy($request->user_id);
        return response()->json('User delete successful.');
    }

    public function showStudentCreateForm(){

        if(count(RestTime::all()) == 0){
            return redirect()->route('admin.user_management.student.rest_time');
        }

        $restTimes = RestTime::all();

        return view('admin.user_management.student.create', compact('restTimes'));
    }

    public function saveStudent(Request $request){

        $request->validate([
            'student_number' => 'required|numeric|gt:0|unique:students,student_number',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'nullable|unique:users,email|unique:students,email',
            'password' => ['required', Rules\Password::defaults()],
            'rest_id.*' => 'integer|gt:0',
        ],
        [
            'student_number.gt' => 'The student number is invalid.',
            'rest_id.*.gt' => 'The rest time field need to choose a rest time.',
        ]);

        //dd($request);

        $student = Student::create([
            'student_number' => $request->student_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if($request->rest_id){
            foreach($request->rest_id as $id){
                $student->restTimes()->attach($id);
            }
        }

        return redirect()->route('admin.user_management')->with('swal-success', 'New Student Details save successful.');
    }

    public function showStudentEditForm(Request $request){
        $restTimes = RestTime::all();
        $student = Student::find($request->id);

        return view('admin.user_management.student.edit', compact('student', 'restTimes'));
    }

    public function updateStudent(Request $request){

        $request->validate([
            'rest_id.*' => 'integer|gt:0',
        ],
        [
            'rest_id.*.gt' => 'The rest time field need to choose a rest time.',
        ]);

        $student = Student::find($request->id);

        //dd($request, $student);

        $restIds = $request->rest_id;

        foreach($restIds as $id){
            if($student->restTimes()->wherePivot('rest_time_id', $id)->count() == 0){
                $student->restTimes()->attach($id);
            }
        }

        $needDelete = $student->restTimes()->wherePivotNotIn('rest_time_id', $restIds)->pluck('id')->toArray();
        $student->restTimes()->detach($needDelete);

        return redirect()->route('admin.user_management')->with('swal-success', 'Student info update successful.');


    }

    public function deleteStudent(Request $request){
        $student = Student::find($request->student_id);
        $student->restTimes()->detach();
        $student->delete();
        return response()->json('Student delete successful.');
    }
}
