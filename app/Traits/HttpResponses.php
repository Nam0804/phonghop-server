<?php

namespace App\Traits;

trait HttpResponses {
    protected function success($data,$messages=null,$code =200){
        return response()->json(
            [
                'status'=> true,
                'messsages' => $messages,
                'data' => $data,
            ],$code);
    }
    protected function error($data,$messages=null,$code){
        return response()->json(
            [
                'status'=> false,
                'messsages' => $messages,
                'data' => $data,
            ],$code);
    }
}
