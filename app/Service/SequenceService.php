<?php
namespace App\Service;

class SequenceService extends BaseService{

    public $data;

    public function __construct()
    {
        $this->data = [20,7,8,10,2,5,6];
    }

    public function findSequence($find){
        $data = $this->data;

        $result = [];
        foreach($find as $key => $val){
            $result[] = $this->findSequenceExists($val,$data);           
        }

        return $this->sendSuccess($result);
    }

    public function findSequenceExists($find,$data){
        $findCount = count($find);
        $dataCount = count($data);

        if($findCount > $dataCount){
            return false;
        }

        $result = [];
        $finder = implode(',', $find);
        for ($i = 0; $i <= $dataCount-$findCount; $i++) {
            $matchCount = 0;
            for ($j = 0; $j < $findCount; $j++) {
              if ($find[$j] == $data[$i + $j]) {
                $matchCount++;
                if ($matchCount == $findCount) {
                    $result = [$finder => true];
                }
                
              }
            }
          }

        if(!$result){
            $result = [$finder => false];
        }
        return $result;
    }
}