<?php
namespace App\Http\Controllers;
use Validator;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
class AuthController extends BaseController 
{
    private $authService;
   
    public function __construct() {
        $this->authService = new AuthService;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users|max:255',
        ]);

        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = Hash::make($request->input('password'));

        $data = [
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ];
        $result = $this->authService->register($data);

        return response()->json($result);
    }

    public function authenticate(Request $request) {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        
        $result = $this->authService->login($data);

        return response()->json($result);
    }
}