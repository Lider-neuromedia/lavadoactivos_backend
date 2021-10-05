<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderBy('nombre', 'asc')
            ->paginate(20);
        return response()->json(compact('users'));
    }

    public function store(UserRequest $request)
    {
        return $this->saveOrUpdate($request);
    }

    public function show(User $user)
    {
        return response()->json(compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        return $this->saveOrUpdate($request, $user);
    }

    public function destroy(User $user)
    {
        //
    }

    private function saveOrUpdate(Request $request, User $user = null)
    {
        try {

            \DB::beginTransaction();

            $data = $request->only('nombre', 'cedula', 'celular', 'tipo', 'email');

            if ($request->has('password') && $request->get('password')) {
                $data['password'] = \Hash::make($request->get('password'));
            }

            if ($user == null) {
                $user = User::create($data);
                $message = 'Usuario creado correctamente';
            } else {
                $user->update($data);
                $message = 'Usuario actualizado correctamente';
            }

            \DB::commit();
            return response()->json(compact('user', 'message'), 200);

        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            \Log::info($ex->getTraceAsString());
            \DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
