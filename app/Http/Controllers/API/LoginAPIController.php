<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Validator;

class LoginAPIController extends Controller
{
    
    /**
     * Login user and create token
     *
     * @return LoginResource|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //dd(bcrypt(12345678));
        $credentials['email'] = $request->get('email');
        $credentials['password'] = $request->get('password');

        if (! Auth::attempt($credentials)) {
            // return response()->json(['Invalid']);
            return response()->json(['error' => 'Invalid credentials. Please check your email and password.'], 401);

        }

        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();
    
        $oauthClient = Client::where('password_client', 1)->latest()->first();

        if (is_null($oauthClient)) {
            return response()->json('Oauth password client not found.');
        }

            $data = [
                'username' => $request->email,
                'password' => $request->password,
                'client_id' => $oauthClient->id,
                'client_secret' => $oauthClient->secret,
                'grant_type' => 'password',
            ];

            //dd($data);

            $request = app('request')->create('/oauth/token', 'POST', $data);
            //dd(app()->handle($request)->getContent());
            $tokenResult = json_decode(app()->handle($request)->getContent());           

            //dd($tokenResult);
    
            $user->access_token = $tokenResult->access_token;
            $user->refresh_token = $tokenResult->refresh_token;

           return response()->json($user);
       
    }

    // Refreshing Tokens
    public function refreshingTokens(Request $request)
    {
        // Validate the input to ensure 'refresh_token' is provided
        $validator = Validator::make($request->all(), [
            'refresh_token' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Refresh token is required.'], 400);
        }
    
        // Fetch the OAuth password client
        $oauthClient = Client::where('password_client', 1)->latest()->first();
    
        if (is_null($oauthClient)) {
            return response()->json(['error' => 'OAuth password client not found.'], 404);
        }
    
        // Prepare the data for refreshing the token
        $data = [
            'grant_type' => 'refresh_token',
            'client_id' => $oauthClient->id,
            'client_secret' => $oauthClient->secret,
            'refresh_token' => $request->refresh_token,
        ];
    
        try {
            // Create an internal request to the /oauth/token endpoint
            $tokenRequest = app('request')->create('/oauth/token', 'POST', $data);
            $response = app()->handle($tokenRequest);
    
            // Decode the JSON response
            $tokenResult = json_decode($response->getContent());
    
            // Check if the response contains an access token
            if (isset($tokenResult->access_token)) {
                return response()->json([
                    'access_token' => $tokenResult->access_token,
                    'refresh_token' => $tokenResult->refresh_token,
                    'expires_in' => $tokenResult->expires_in,
                ]);
            }
    
            // Return error if no access token was generated
            return response()->json([
                'error' => $tokenResult->error ?? 'An unknown error occurred.',
                'message' => $tokenResult->message ?? 'Unable to refresh the token.',
            ], 400);
        } catch (\Exception $e) {
            // Catch and return any unexpected exceptions
            return response()->json([
                'error' => 'server_error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
