<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // Retrieve all users
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'noms' => 'required',
            'matricule' => 'required|unique:users',
            'mail' => 'required|email',
            'role' => 'nullable',
            'filiere' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "errors" => $validator->errors()->getMessages()
            ]);
        }

        // Create a new user
        $user = User::create([
            "noms" => $request->noms,
            "matricule" => $request->matricule,
            "mail" => $request->mail,
            "role" => $request->role,
            "filiere" => $request->filiere
        ]);

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'noms' => 'required',
            'matricule' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                "errors" => $validator->errors()->getMessages()
            ]);
        }

        // Attempt to authenticate the user
        $user = User::where("noms",$request->noms)->first();

        if($user == null ){
            return response()->json([
                "errors" => "Parametres de connexion invalide"
            ]);
        }

        $user->token = Str::random(20);
        $user->save();

        if($user->matricule == $request->matricule){
            return response()->json([
                "role" => $user->role,
                "token" => $user->token
            ]);
        }else{
            return response()->json([
                "errors" => "Parametres de connexion invalide"
            ]);
        }
    }

    public function destroy($id)
    {
        // Find the user by id and delete
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
