<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        dd(auth::guard('students'));
        // $users = User::all();
        // return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'nombre'      => 'required',
            'cedula'      => 'required|unique:users',
            'celular'      => 'required',
            'tipo'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required'
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return [
                'status' => "error",
                "code" => 200,
                'errors'  => $validator->errors()->all()
            ];
        }
        $users = new User();
        $users->nombre = $request->nombre;
        $users->cedula = $request->cedula;
        $users->celular = $request->celular;
        $users->tipo = $request->tipo;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        if($users == null){
            return [
                'status' => "error",
                "code" => 404,
                'errors'  => "El usuario no existe"
            ];
        }else{
            return response()->json($users);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        if($users == null){
            return [
                'status' => "error",
                "code" => 200,
                'errors'  => "El usuario no existe"
            ];
        }

        $rules = [
            'nombre'      => 'required',
            'cedula'      => 'required|unique:users,cedula,'.$users->id,
            'celular'      => 'required',
            'tipo'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$users->id,
            'password'  => ''
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return [
                'status' => "error",
                "code" => 404,
                'errors'  => $validator->errors()->all()
            ];
        }
        
        $users->nombre = $request->nombre;
        $users->cedula = $request->cedula;
        $users->celular = $request->celular;
        $users->tipo = $request->tipo;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->save();
        return response()->json($users);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}