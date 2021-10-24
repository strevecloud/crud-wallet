<?php
namespace App\Models;
class Node
{
    public $data, $left, $right;

    public function __construct($data)
    {
        $this->data = $data;
        $this->left = $this->right = null;
    }
}