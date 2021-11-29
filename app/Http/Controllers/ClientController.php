<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index(Request $req)
    {
        $client = Client::all();
        return view('dashboard', compact('client'));
    }
    public function create(Request $request)
    {
        $client = new Client();
        $client->id = $request->id;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->apiKey = $this->apiKeyCreator();
        $client->status = $request->status;
        $client->save();
        Mail::to($request->email)->send(new SendMail($client->apiKey)); 
        return response()->json([
            'status' => 'successful add',
            'data' => $client,
        ]);
    } 
    public function edit(Request $request){
        $client = Client::where('id' , $request['id'])
        ->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'status'=>$request->status]);
        return response()->json([
            'status' => 'successful edit',
            'data' => $client,
        ]);

   }
   public function apiKeyCreator(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i < 20; $i++) {
        if($i % 5 == 0)
            $randomString .= "-";
        else{
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
    }
    return $randomString;
}
}
