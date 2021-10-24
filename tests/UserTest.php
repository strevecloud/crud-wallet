<?php
class UserTest extends TestCase{

    public function testGetUserFailedUnautorize()
    {
        $this->get('/user');
        $this->seeStatusCode(401);

        $this->seeJsonStructure([
            'error'
        ]);
    }

    public function getHeaderToken()
    {
        $payload = [
            'email' => 'sefriandsz@gmail.com',
            'password' => '12345678',
        ];

        $this->post('/login',$payload,[]);

        $content = $this->response->getContent();
        $getToken = json_decode($content);
        $token = $getToken->data->token;

        $header = [ 'Authorization' => 'Bearer '.$token];

        return $header;
    }


    public function testGetUserSuccess()
    {
        $payload = [
            'email' => 'strevecloud@gmail.com',
            'password' => '12345678',
        ];

        $this->post('/login',$payload,[]);

        $header = $this->getHeaderToken();
        $this->get('/user',$header);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data' 
        ]);
    }
}