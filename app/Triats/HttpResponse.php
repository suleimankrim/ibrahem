<?php
namespace App\Triats;
trait HttpResponse
{
    public function seccuss($data,$message=null,$code=200)
    {
        return response()->json([
            'status'=>'Request was seccusful.',
            'message'=>$message,
            'data'=>$data
        ],$code);
    }
    public function erorr($data,$message=null,$code=404)
    {
        return response()->json([
            'status'=>'Erorr has accourd',
            'message'=>$message,
            'data'=>$data
        ],$code);
    }
}