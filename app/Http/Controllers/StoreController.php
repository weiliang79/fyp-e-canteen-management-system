<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
{
    public function adminIndex(){
        $stores = Store::all();
        return view('admin.store.index', compact('stores'));
    }

    public function index(){
        $user = User::find(Auth::user()->id);
        if($user->isAdmin()){
            echo 'TODO';
        } else {

            $store = $user->store;

            if($store === null){
                Session::flash('swal-warning', 'Please create a store information first.');
                return view('food_seller.store.edit', compact('store'));
            }

            return view('food_seller.store.index', compact('store'));
        }

    }

    public function showEditForm(){
        $user = User::find(Auth::user()->id);
        $store = $user->store;
        return view('food_seller.store.edit', compact('store'));
    }

    public function save(Request $request){
        //dd($request);

        $request->validate([
            'store_name' => 'required',
            'logo_path' => 'nullable|url',
        ]);

        $user = User::find(Auth::user()->id);

        if($user->store()->count() == 0){
            $user->store()->create([
                'name' => $request->store_name,
                'logo_path' => $request->logo_path ? substr(parse_url($request->logo_path, PHP_URL_PATH), 1) : null,
                'description' => $request->description,
            ]);
        } else {
            $store = $user->store;
            $store->name = $request->store_name;
            $store->logo_path = $request->logo_path;
            $store->description = $request->description;
            $store->save();
        }

        return redirect()->route('food_seller.store')->with('swal-success', 'Store information save successful.');
    }
}
