<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use Illumininate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource - all registered users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }
     /**
     * Display a listing of the resource. - patients of nutriologist
     *
     * @return \Illuminate\Http\Response
     */
    public function ownUsers(){
        $users = Auth::user()->getPacients();
        return response()->json(['data' => $users], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $newUser = User::create([
                'name' => request('name'),
                'lastname' => request('lastname'),
                'phone'     => request('phone'),
                'age'       => request('age'),
                'email'     => request('email'),

            ]);
            $newUser->becomesNutriologist();
            DB::commit();
            return response()->json(['message' => 'Usuario creado con éxito.', $newUser], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Ha surgido un error al crear el usuario', 'error' => $e->getMessage()]);
        }
    }
    /**
     * Store a newly created resource in storage(patient).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storePatient(Request $request){
        $currentUser = Auth::user();
        try {
            DB::begintTransaction();
            $newPatient = User::create([
                'name' => request('name'),
                'lastname' => request('lastname'),
                'phone'     => request('phone'),
                'age'       => request('age'),
                'email'     => request('email'),
                'creator'   => $currentUser->id
            ]);
            $newPatient->becomesPatient();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Ha surgido un error al crear el paciente', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource(user).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id)->with(['roles']);
        return response()->json(['data' => $user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->udpate($request->all());
            DB::commit();
            return response()->json(['message' => 'Datos del usuario actualizados con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha surgido un error al actualizar los datos del usuario', 'error' => $e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ha surgido un error al eliminar el usuario', ], 500);
        }
    }
}
