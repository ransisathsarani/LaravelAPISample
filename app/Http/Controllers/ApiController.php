<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use Validator;

class ApiController extends Controller
{
	//get all students
    public function getAllStudents() {
      $students = Student::all();
      return response()->json([
      	"status_code" => 200,
      	"message" => "Success",
      	"data" => $students
      ], 200);
    }

    //create a new student
    public function createStudent(Request $request) {

    	$valid = Validator::make($request->all(),[
    		'name' => 'required',
    		'course' => 'required'
    	]);

    	if ($valid->fails()) {

    		return response()->json([
    			"status_code" => 401,
      			"message" => "Error Occured",
    			"error" =>$valid->errors()
    		], 401);
    	}

    	$student = new Student;
	    $student->name = $request->name;
	    $student->course = $request->course;
	    $student->save();

	    return response()->json([
	    	"status_code" => 200,
	    	"message" => "student record created",
	    	"data" => "null"
	    ]);
	      
    }

    //get student by id
    public function getStudent($id) {
      if (Student::where('id', $id)->exists()) {
        $student = Student::where('id', $id)->get();
        return response()->json([
        	"status_code" => 200,
        	"message" => "Success",
        	"data" => $student
        ]);
      } else {
        return response()->json([
        	"status_code" => 404,
          	"message" => "Student not found",
          	"data" => "null"
        ], 404);
      }
    }

    //update student by id
    public function updateStudent(Request $request, $id) {
      if (Student::where('id', $id)->exists()) {
        $student = Student::find($id);

        $student->name = is_null($request->name) ? $student->name : $request->name;
        $student->course = is_null($request->course) ? $student->course : $request->course;
        $student->save();

        return response()->json([
        	"status_code" => 200,
          	"message" => "records updated successfully",
          	"data" => "null"
        ], 200);
      } else {
        return response()->json([
        	"status_code" => 404,
          	"message" => "Student not found",
          	"data" => "null"
        ], 404);
      }
    }

    //delete student by id
    public function deleteStudent ($id) {
      if(Student::where('id', $id)->exists()) {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
        	"status_code" => 202,
          	"message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
        	"status_code" => 404,
          	"message" => "Student not found"
        ], 404);
      }
    }
}