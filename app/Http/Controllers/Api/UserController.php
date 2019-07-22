<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use Illumininate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
/**
* @OA\Info(title="User Resource", version="1.0")
*
* @OA\Server(url="http://localhost:8000")
*/
class UserController extends Controller
{
    /**
     * Display a listing of the resource - all registered users.
     *
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Get(
    *     path="/api/users",
    *     summary="List users",
    *     @OA\Response(
    *         response=200,
    *         description="List all users registered."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server error."
    *     )
    * )
    */
    public function index()
    {
        $data = UserResource::collection(User::with(['roles','nutriologist'])->get());
        return response()->json(['data' => $data], 200);
    }
     /**
     * Display a listing of the resource. - patients of nutriologist
     *
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Get(
    *     path="/api/users/mypatients",
    *     tags={"USers"},
    *     operationId="ownUsers",
    *     summary="GEt List of patients",
    *     @OA\Response(
    *         response=200,
    *         description="List all patients by user."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server error."
    *     )
    * )
    */
    public function ownUsers(){
        $patients = UserResource::collection(request()->user()->getPacients());
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
        $currentUser = request()->user();
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
        $user = new UserResource(User::find($id)->with(['roles','nutriologist'])->first());
        return response()->json($user, 200);

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
