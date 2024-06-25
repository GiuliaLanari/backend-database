<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();

        if (!$user) {
            Log::error('Utente non autenticato');
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        try {
            $user->email = $request->email;
            $user->save();
        } catch (\Exception $e) {
            Log::error('Errore durante il salvataggio dell\'email: ' . $e->getMessage());
            return response()->json(['error' => 'Errore durante il salvataggio dell\'email'], 500);
        }

        return response()->json(['message' => 'Email updated successfully']);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            Log::error('Utente non autenticato');
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $user->name = $request->input('name');
            $user->surname = $request->input('surname');
            $user->save();
        } catch (\Exception $e) {
            Log::error('Errore durante il salvataggio del profilo: ' . $e->getMessage());
            return response()->json(['error' => 'Errore durante il salvataggio del profilo'], 500);
        }

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }
}