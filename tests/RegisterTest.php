<?php
use App\Models\User;
class RegisterTest extends TestCase{

    // public function testSuccessRegister()
    // {
    //     $payload = [
    //         'email' => 'sefriandsz@gmail.com',
    //         'password' => '12345678',
    //     ];

    //     $this->post('/register',$payload,[]);
    //     $this->seeStatusCode(201);

    //     $this->seeJsonStructure([
    //         'message',
    //         'code'
    //     ]);

    //     $expected = [
    //         'message' => 'register_success',
    //         'code'    => 201,
    //     ];


    //     $this->assertEquals(
    //         json_encode($expected), $this->response->getContent()
    //     );
    // }

    public function testRegisterFailedEmail()
    {
        $payload = [
            'email' => 'sefriandsz',
            'password' => '12345678',
            'phone' => '0834374634'
        ];

        $this->post('/register',$payload,[]);
        $this->seeStatusCode(422);

        $this->seeJsonStructure([
            'email',
        ]);

        $expected = [
            'email' => ['The email must be a valid email address.'],
        ];

        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }

    public function testRegisterFailedEmailUse()
    {
        $payload = [
            'email' => 'strevecloud@gmail.com',
            'password' => '12345678',
            'phone' => '0834374634'
        ];

        $this->post('/register',$payload,[]);
        $this->seeStatusCode(422);

        $this->seeJsonStructure([
            'email',
        ]);

        $expected = [
            'email' => ['The email has already been taken.'],
        ];


        $this->assertEquals(
            json_encode($expected), $this->response->getContent()
        );
    }
}