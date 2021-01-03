<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Mentor;

class MentorController extends Controller
{
    public function index(){

        $mentor = Mentor::all();

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function show($id){
        
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }
    
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $mentor = Mentor::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function update(Request $request,$id){
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $mentor->fill($data);
        $mentor->save();

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function destroy($id){
        
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $mentor->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Mentor Deleted"
        ]);
    }
}