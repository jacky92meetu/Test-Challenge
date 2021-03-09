<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->all();
        $validator = Validator::make($validatedData, [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'user_type' => ['required',Rule::in(['user','manager','admin'])]
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        $validatedData['password'] = Hash::make($request->password);
        $user = User::create($validatedData);

        $accessToken = $user->generateToken();

        return response(['user' => $user, 'access_token' => $accessToken], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->all();
        $validatedData = array_intersect_key($validatedData,array_flip(['name','email','password','user_type']));
        $validator = Validator::make($validatedData, [
            'name' => 'max:55',
            'email' => 'email',
            'user_type' => [Rule::in(['user','manager','admin'])]
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        if(isset($validatedData['email']) && User::where('email','=',$validatedData['email'])->where('id','<>',$user->id)->exists()){
            return response(['errors'=>'New email is not available'], 400);
        }

        if(isset($validatedData['password'])){
            $validatedData['password'] = Hash::make($request->password);
        }
        
        $user->update($validatedData);

        return response(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        
        return response()->json(null, 204);
    }
}
