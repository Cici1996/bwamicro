<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ImageCourse;
use App\Models\Course;

class ImageCourseController extends Controller
{
    public function create(Request $request){
        $rules = [
            'image' => 'required|url',
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

        $course_id = $request->input('course_id');
        $course = Course::find($course_id);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data Course"
            ], 404);
        }


        $image_course = ImageCourse::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $image_course
        ]);
    }

    public function destroy($id){
        
        $image_course = ImageCourse::find($id);

        if(!$image_course){
            return response()->json([
                'status' => 'error',
                'message' => "Not Found Data"
            ], 404);
        }

        $image_course->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Image-Course Deleted"
        ]);
    }
}
