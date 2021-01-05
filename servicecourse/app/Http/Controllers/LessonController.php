<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Lesson;
use App\Models\Chapter;

class LessonController extends Controller
{
    public function index(Request $request){

        $lesson = Lesson::query();

        $chapter_id = $request->query('chapter_id');

        $lesson->when($chapter_id,function($query) use ($chapter_id){
            return $query->where("chapter_id","=",$chapter_id);
        });


        return response()->json([
            'status' => 'success',
            'data' => $lesson->get()
        ]);
    }

    public function show($id){
        
        $lesson = Lesson::find($id);

        if(!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }
    
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'video' => 'required|string',
            'chapter_id' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $chapter_id = $request->input('chapter_id');
        $chapter = Chapter::find($chapter_id);
        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data Chapter"
            ], 404);
        }

        $lesson = Lesson::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    public function update(Request $request,$id){
        $rules = [
            'name' => 'required|string',
            'video' => 'required|string',
            'chapter_id' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $lesson = Lesson::find($id);

        if(!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $chapter_id = $request->input('chapter_id');
        $chapter = Chapter::find($chapter_id);
        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data Chapter"
            ], 404);
        }

        $lesson->fill($data);
        $lesson->save();

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ]);
    }

    public function destroy($id){
        
        $lesson = Lesson::find($id);

        if(!$lesson){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $lesson->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Lesson Deleted"
        ]);
    }
}
