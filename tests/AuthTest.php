<?php
use Faker\Factory as Faker;
use App\Models\User;
use App\Service\UserService;

class AuthTest extends TestCase{

    public function accountGenerator()
    {
        $faker = Faker::create('id_ID');

        $phone = $faker->e164PhoneNumber();

        $payload = [
            'email' => $faker->email(),
            'password' => $faker->password(),
            'phone' => str_replace('+','0',$phone)
        ];

        return $payload;
    }

    public function getUser()
    {
        $user = User::where('email','=','sefriandsz@gmail.com')->first();
        return $user;
    }

     public function testSuccessRegister()
    {
        $payload = $this->accountGenerator();

        $this->post('/register',$payload,[]);

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data'
        ]);

        $expected = [
            'status_code'    => "200",
            'status_message' => 'Register Success',
            'data' => []
        ];

        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }


    public function testAuthSuccess()
    {
        $payload = [
            'email' => 'sefriandsz@gmail.com',
            'password' => '12345678',
        ];

        $this->post('/login',$payload,[]);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data' => [
                'token'
            ]
        ]);
    }

    public function testAuthError()
    {
        $payload = $this->accountGenerator();

        $this->post('/login',$payload,[]);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data'
        ]);

        $expected = [
            'status_code'    => "400",
            'status_message' => 'Email or password is wrong.',
            'data' => []
        ];

        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testAuthErrorFieldNullPassword()
    {
        $faker = Faker::create('id_ID');

        $payload = [
            'email' => $faker->email(),
        ];

        $this->post('/login',$payload,[]);
        $this->seeStatusCode(422);

        $this->seeJsonStructure([
            'password'
        ]);
    }

    public function testAuthErrorFieldNullEmail()
    {
        $faker = Faker::create('id_ID');

        $payload = [
            'password' => $faker->password(),
        ];

        $this->post('/login',$payload,[]);
        $this->seeStatusCode(422);

        $this->seeJsonStructure([
            'email'
        ]);
    }
    
}