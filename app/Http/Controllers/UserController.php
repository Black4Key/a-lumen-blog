<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get($id){
        return User::findOrFail($id);
    }

    public function getList()
    {
        return User::all();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'picture' => 'required|string',
        ]);
        
        $user = new User();
        $user->password = Hash::make($request->input('password'));
        $user->api_token = Str::random();
        $user->fill($request->all());
        $user->save();
        return $user;
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email','=', $request->input('email'))->first();
        if(!Hash::check($request->input('password'),$user->password)){
            throw new UnauthorizedException('Unauthorized.');
        }
        return response(['api_token'=>$user->api_token]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'filled|string',
            'picture' => 'filled|string',
            'subscription' => 'filled|string'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return [];
    }

    
}
