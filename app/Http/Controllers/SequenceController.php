<?php
namespace App\Http\Controllers;

use App\Service\SequenceService;

class SequenceController extends Controller{

    public function __construct()
    {
        $this->service = new SequenceService;
    }

    public function searchSequenceExists(){
        $find = [
            [7,8],
            [8,7],
            [7,10]
        ];

        $res = $this->service->findSequence($find);

        return response()->json($res);
    }
}