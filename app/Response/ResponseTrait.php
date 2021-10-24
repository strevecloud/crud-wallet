<?php

namespace App\Response;

trait ResponseTrait
{

    private $customCodeAndMessage = [
        '200' => 'Success',
        '201' => 'Data Creation Succeded',
        '422' => 'Request Validation Error',
        '400' => 'Bad Request',
        '401' => 'Unauthenticated',
        '404' => 'Not Found',
    ];

    protected function sendNotFound($message = null)
    {
        if(!$message){
            $message = $this->customCodeAndMessage['404'];
        }
        return $this->sendResponse(404,'404', $message,[]);
    }

    protected function sendValidationError($data,$message = null)
    {
        if(!$message){
            $message = $this->customCodeAndMessage['422'];
        }
        return $this->sendResponse(422,'422', $message,$data);
    }

    protected function sendSuccess($data = [],$message = null)
    {
        if(!$message){
            $message = $this->customCodeAndMessage['200'];
        }

        return $this->sendResponse(200,'200', $message,$data);
    }

    protected function sendCreated($data = [],$message = null)
    {
        if(!$message){
            $message = $this->customCodeAndMessage['201'];
        }
        return $this->sendResponse(201,'201', $message,$data);
    }

    protected function sendBadRequest($message = null)
    {
        if(!$message){
            $message = $this->customCodeAndMessage['400'];
        }
        return $this->sendResponse(400,'400', $message,[]);
    }

    protected function sendResponse($httpCode = 200, $appCode, $message, $data = [])
    {
        $appCode = is_string($appCode) ? (string) $appCode : $appCode;
        $responseData = [
            'status_code' => $appCode,
            'status_message' => $message
        ];


        $objectData = [];
        if(!isset($data['data'])) {
            $objectData['data'] = $data;
        } else {
            $objectData = $data;
        }

        $responseData = array_merge($responseData, $objectData);

        return $responseData;

        // return response()->json($responseData, $httpCode, [
        //     'X-App-Version' => config('app.version'),
        // ]);
    }
}