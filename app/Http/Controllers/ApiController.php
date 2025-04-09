<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{

    /**
     * [sendResponse description]
     *
     * @param object $data [description]
     * @param string $message [description]
     * @param integer $code [description]
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data, $message = null, $code = 200)
    {
        $response = [
            'isError' => false,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    } // sendResponse

    /**
     * [sendError description]
     *
     * @param string $message [description]
     * @param object $data [description]
     * @param integer $code [description]
     * @return \Illuminate\Http\Response
     */
    public function sendError($message, $data = null, $code = 404)
    {
        $response = [
            'isError' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    } // sendError

}
