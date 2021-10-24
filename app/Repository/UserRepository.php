<?php
namespace App\Repository;
use App\Models\User;

class UserRepository{

    protected $modelUser;

    public function __construct()
    {
        $this->modelUser = new User;
    }

    public function getUserActive()
    {
        return $this->modelUser->where('is_active','=',true)->simplePaginate(10);
    }

    public function getUser()
    {
        return $this->modelUser;
    }

    public function createNewUser($data)
    {
        $data['code'] = randomString();
        return $this->modelUser->create($data);
    }
}