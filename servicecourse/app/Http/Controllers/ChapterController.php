<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Chapter;
use App\Models\Course;

class ChapterController extends Controller
{
    public function index(Request $request){

        $chapter = Chapter::query();

        $course_id = $request->query('course_id');

        $chapter->when($course_id,function($query) use ($course_id){
            return $query->where("course_id","=",$course_id);
        });


        return response()->json([
            'status' => 'success',
            'data' => $chapter->get()
        ]);
    }

    public function show($id){
        
        $chapter = Chapter::find($id);

        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    }
    
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'course_id' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $courseId = $request->input('course_id');
        $course = Course::find($courseId);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data Course"
            ], 404);
        }

        $chapter = Chapter::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    }

    public function update(Request $request,$id){
        $rules = [
            'name' => 'required|string',
            'course_id' => 'required|integer'
        ];
        $data = $request->all();

        $validator = Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $chapter = Chapter::find($id);
        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $courseId = $request->input('course_id');
        $course = Course::find($courseId);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data Course"
            ], 404);
        }

        $chapter->fill($data);
        $chapter->save();

        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ]);
    }

    public function destroy($id){
        
        $chapter = Chapter::find($id);

        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $chapter->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Chapter Deleted"
        ]);
    }
}
