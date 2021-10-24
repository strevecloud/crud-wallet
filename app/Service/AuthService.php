<?php
namespace App\Service;

use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repository\UserWalletRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;


class AuthService extends BaseService{

    protected $userRepository,$userWalletRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->userWalletRepository = new UserWalletRepository;
    }

    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 

    public function register($data)
    {
        $newUser = $this->userRepository->createNewUser($data);

        $wallet = [
            'user_id' => $newUser->id
        ];

        $newWallet = $this->userWalletRepository->createNewUserWallet($wallet);

        if($newUser && $newWallet){

            return $this->sendSuccess([],'Register Success');

        }else{
            $message = 'register failed';
            return $this->sendBadRequest($message);
        }
    }

    public function login($data)
    {
        $user = $this->userRepository
            ->getUser()
            ->where('email', $data['email'])
            ->first();

        if (!$user) {
            $message = 'Email or password is wrong.';

            return $this->sendBadRequest($message);

        }else if (Hash::check($data['password'], $user->password)) {

            $data = [
                'token' => $this->jwt($user)
            ];

            return $this->sendSuccess($data);
        }else{
            $message = 'Email or password is wrong.';

            return $this->sendBadRequest($message);
        }
    }

}