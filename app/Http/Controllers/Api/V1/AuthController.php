<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RegisterValidator;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        
        $rules = array(
             'atoken' => 'required',
             'firstname' => 'required',
             'initials' => 'required',
             'lastname' => 'required',
             'sex' => 'required',
             'birthdate' => 'required',
             'email' => 'required|email|unique:users,email',
             'password' => 'required',
             'repeat_password' => 'required|same:password',
             'city' => 'required',
             'country' => 'required',
             'postal_code' => 'required',
             'street' => 'required',
             'house_number' => 'required',
             'accept_terms' => 'required',
        );

        if($request->atoken != 'NVQBlcbPpGQb2JF90EX1SiUZz0M0kADwxaabguo3zxsOwlaFWfmswdjx9DSejvB8BWPDCbAdV2beAbTaJPgUNCEXcXGPJ1dmMrZ1RJfZ333hnMyO16mb5celcOuqr2PqmGwq8mxd6y92o9QJbHfwS53Iec32tLNZ9hxKQ==') {
            return response()->json([
                'success' => false,
                'message' => 'Authorization token is invalid',
            ], 400);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = new User();
        $user->firstname = $request->firstname;
        $user->initials = $request->initials;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        // convert the rest of the request to json and store it in the data column
        $user->data = json_encode($request->except(['atoken', 'firstname', 'initials', 'lastname', 'email', 'password', 'repeat_password']));
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
        ], 201);

    }

    public function login(Request $request) {

        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        if(!password_verify($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is incorrect',
            ], 401);
        }

        $token = $user->createToken('Password Grant Client');

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token->accessToken,
            ],
        ], 200);


    }

    public function autologin(Request $request) {

        // check with passport if bearer token is valid
        $user = Auth::user();

        if(!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
            ],
        ], 200);

    }
}
