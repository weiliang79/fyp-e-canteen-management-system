<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Notifications\StudentVerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;

class StudentProfileController extends Controller
{
    /**
     * Show the student profile.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('profile.student');
    }

    /**
     * Update the student profile.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user = Student::find(auth()->guard('student')->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('student.profile')->with('swal-success', 'Profile update successful.');
    }

    /**
     * Send the verification email to the given email address.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function verifyEmail(Request $request)
    {
        $user = Student::find(Auth::guard('student')->user()->id);

        $request->validate([
            'email' => 'required|email|unique:users,email|unique:students,email,' . $user->id,
        ]);

        $token = random_int(100000, 999999);

        try {
            Notification::route('mail', $request->email)->notify(new StudentVerifyEmailNotification($user, $token));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 502);
        }

        $user->emailVerify()->create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'The verification code has sent to the entered email.',
        ]);
    }

    /**
     * Update the student's email after verified.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
        ]);

        $user = Student::find(Auth::guard('student')->user()->id);
        $userCode = $user->emailVerify()->orderBy('created_at', 'DESC')->first();

        if ($request->code !== $userCode->token) {
            return back()->withErrors(['code' => 'The verification code is invalid.'])->withInput();
        } else if ($userCode->created_at->addMinutes(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'))->lt(Carbon::now())) {
            return back()->withErrors(['code' => 'The verification code is expired.'])->withInput();
        }

        $user->email = $request->email;
        $user->email_verified_at = Carbon::now();
        $user->save();

        $user->emailVerify()->delete();

        return redirect()->route('student.profile')->with('swal-success', 'Email address update successful.');
    }

    /**
     * Update the student's password.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Student::find(auth()->guard('student')->user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('student.profile')->with('swal-success', 'Password update successful.');
    }

    /**
     * Update the student's notification.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotify(Request $request)
    {
        $user = Student::find(Auth::guard('student')->user()->id);
        $user->allow_email_notify = $request->email_notify == 'on' ? true : false;
        $user->save();

        return redirect()->route('student.profile')->with('swal-success', 'Notification update successful.');
    }
}
