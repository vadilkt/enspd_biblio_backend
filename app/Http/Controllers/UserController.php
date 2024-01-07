<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $this->validate($request, [
            'noms' => 'required',
            'matricule' => 'required|unique:users',
            'mail' => 'required|email',
            'role' => 'nullable',
            'filiere' => 'required',
        ]);

        // Create a new user
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'noms' => 'required',
            'matricule' => 'required',
        ]);

        // Attempt to authenticate the user
        $credentials = $request->only('noms', 'matricule');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();

            // Generate a token for the user
            $token = $user->createToken('access_token')->accessToken;

            // Return the token and user role
            return response()->json([
                'token' => $token,
                'role' => $user->role,
            ]);
        }

        // Authentication failed
        throw ValidationException::withMessages([
            'message' => 'Invalid credentials',
        ]);
    }

    public function destroy($id)
    {
        // Find the user by id and delete
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
