<?php namespace App\Http\Controllers\Callback;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ACME\Helpers\GeoAPI;
use App\ACME\Model\Callback\PhoneLog;
use App\ACME\Helpers\MttAPI;

class LogsController extends Controller {

    public function __construct()
    {
        $this->middleware('manager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $logs = PhoneLog::where('client_id','=',(int)\Input::get("id"))->orderBy('created_at','desc')->paginate(50);
        return view('callback.logs.index')->with(compact('logs'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $log = PhoneLog::find($id);
        $geo  =  GeoAPI::getByIP($log->ip);//"77.66.238.201"
        $detail = null;
        if(!empty($log->call_id)){
            $detail = MttAPI::getCallBackFollowmeCallInfo($log->call_id);
        }
        return view('callback.logs.show')->with(compact('log','geo','detail'));
    }


}
