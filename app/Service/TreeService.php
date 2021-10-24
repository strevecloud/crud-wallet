<?php
namespace App\Service;
use App\Models\Node;

class TreeService extends BaseService{

    public $root;

    public function __construct($data = null)
    {
        if ($data !== null) {
            $this->root = new Node($data);
        }
    }

    public function ifNodeExists($data,$key){
        if($data == null){
            return false;
        }

        if($data->data == $key){
            return true;
        }

        $res1 = $this->ifNodeExists($data->left,$key);

        if($res1){
            return true;
        }

        $res2 = $this->ifNodeExists($data->right,$key);

        return $res2;
    }

    public function getNode($keys){
        $root = new Node(6);
        $root->left = new Node(7);
        $root->left->left = new Node(10);
        $root->left->right = new Node(8);
        $root->right = new Node(100);
        $root->right->left = new Node(14);

        $result = [];

        foreach($keys as $key){
            if($this->ifNodeExists($root,$key)){
                $result[$key] = true;
            }else{
                $result[$key] = false;
            }
        }

        return $this->sendSuccess($result);
    }

}