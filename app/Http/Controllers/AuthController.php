<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * controller for handling user registration and authentication
 */
class AuthController extends Controller
{

    /**
     * adding  auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    /**
     * new user registration
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // get allowed max file size
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        // defining validation rules
        $validator = Validator::make($request->all(), [
            'email' =>  'required|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|min:8',
            'passport_img'=>'image|nullable|max:' . $max_size
            ]);

        // test validation
        if ($validator->fails()) {
            return response()->json(['error' => 'bad request'], 400);
        }

        // handle file upload
        if($request->hasFile('passport_img')){
            // get file with extenstion
            $fileNamewithExt = $request->file('passport_img')->getClientOriginalName();
            // get file name only
            $filename = pathinfo($fileNamewithExt, PATHINFO_FILENAME);
            // get extension only
            $extension = $request->file('passport_img')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // upload image
            $path = $request->file('passport_img')->storeAs('public/passport_images', $fileNameToStore);
        }else{
            // no file was uploaded
            $fileNameToStore = 'no_profile_pic.jpg';
        }

        // creaye new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'passport_img' => $fileNameToStore
        ]);

        // login new user
        $token = auth('api')->login($user);

        // return responce object
        return $this->respondWithToken($token);
    }

    /**
     * get current user object
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return response()->json(auth('api')->user())->setStatusCode(200);
    }

    /**
     * login user
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        // defining validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // test validation
        if ($validator->fails()) {
            return response()->json(['error' => 'email and password is required'], 400);
        }

        // get credentials
        $credentials = $request->only(['email', 'password']);

        // login user
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // return token
        return $this->respondWithToken($token);
    }

    /**
     * logout current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(){
        auth('api')->logout();
        return response()->json(['message'=> 'Successfully Logged out']);
    }

    /**
     * get refresh token
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * creates a json resource
     *
     * @param  String  $token
     *
     * @return \Illuminate\Http\Response
     */
    protected function respondWithToken($token)
    {
        $user = $this->guard()->user();
        $user->passport_img = '/storage/passport_images/'.$user->passport_img;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ])->setStatusCode(200);
    }

    /**
     * defining api guard.
     */
    public function guard(){
        return Auth::Guard('api');
    }
}
