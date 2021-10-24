<?php
use App\Models\UserWallet;
use App\Models\User;
use App\Models\UserWalletCard;
class UserCardTest extends TestCase{

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

    public function getUserWallet()
    {
        $wallet = User::with('userWallet')
        ->where('email','=','sefriandsz@gmail.com')
        ->first();

        $userWallet = $wallet->userWallet->first();

        return $userWallet;
    }

    public function testGetWallet()
    {
        $header = $this->getHeaderToken();

        $this->get('/me/wallet',$header);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data' => [
                'data'
            ]
        ]);
    }

    public function testCreateNewCard()
    {
        $header = $this->getHeaderToken();
        $userWallet = $this->getUserWallet();

        $this->post('/me/card/'.$userWallet->code,[],$header);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data'
        ]);
    }

    public function testUpdateCard()
    {
        $wallet = $this->getUserWallet();
        $card = UserWalletCard::where('user_wallet_id','=',$wallet->id)->first();

        $header = $this->getHeaderToken();

        $data = [
            'daily_limit' => 500000,
            'monthly_limit' => 5000000
        ];

        $this->put('/me/card/'.$card->code,$data,$header);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data',
        ]);
    }

    public function testDeleteCard()
    {
        $wallet = $this->getUserWallet();
        $card = UserWalletCard::where('user_wallet_id','=',$wallet->id)->first();
        $header = $this->getHeaderToken();
        
        $this->delete('/me/card/'.$card->code,[],$header);
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data',
        ]);
    }
}