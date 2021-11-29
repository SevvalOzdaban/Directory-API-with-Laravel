<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Directory;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Client::where('apiKey', $request->header('x-api-key'))->get();
        if($data->isEmpty()){
            return response()->json(['message' => 'This apiKey doesnt exist.']);
        }
        else{
            $directory = Directory::where('clientId', $data[0]->id)->get();
            return response()->json(['message' => 'Database listed..', 'data' => $directory, 200]);
        }
    }
    public function create(Request $request)
    {
        $data = Client::where('apiKey', $request->header('x-api-key'))->get();
        if($data->isEmpty()){
            return response()->json(['message' => 'This apiKey doesnt exist.']);
        }
        else{
            $directory = new Directory();
            $directory->clientId = $data[0]->id;
            $directory->name = $request->name;
            $directory->surname = $request->surname;
            $directory->email = $request->email;
            $directory->phone = $request->phone;
            $directory->save();
            return response()->json(['message' => 'New user created..', 'data' => $directory, 200]);
        }
       
    } 
    public function update(Request $request)
    { 
        $data = Client::where('apiKey', $request->header('x-api-key'))->get();
        if($data->isEmpty()){
            return response()->json(['message' => 'This apiKey doesnt exist.']);
        }
        else{
        Directory::where('id', $request->clientId)
            ->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        return response()->json(['message' => 'Client updated succesfully']);
    }
}
    public function destroy(Request $request)
    {
        $data = Client::where('apiKey', $request->header('x-api-key'))->get();
        if($data->isEmpty()){
            return response()->json(['message' => 'This apiKey doesnt exist.']);
        }
        else{
        $directory = Directory::find($request->personId)->delete();
        return response()->json(['message' => 'Successfully deleted', 'data' => $directory]);
    }
}
}
