<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Redis;


class StudentController extends Controller
{
    //
    function list()
    {
        return Student::all();
    }

    function addStudent(Request $request)
    {
        // return "add student method";
        // return $request->input();
        $student = new Student();
        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;

        if($student->save())
        {
            return ["result"=>"Student Added"];
        }
        return ["result"=>"Operation Failed"];

    }
    function updateStudent(Request $request)
    {
        // return "add student method";
        // return $request->input();
        $student = Student::find($request->id);
        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;

        if($student->save())
        {
            return ["result"=>"Student updated"];
        }
        return ["result"=>"Operation Failed"];
        
    }
    
    
    function deleteStudent($id)
    {
        $student = Student::destroy($id);
        if($student)
        {
            return ['result' => 'Student deleted'];
        }
        return ["result"=>"Operation Failed"];

    }


    public function show($id)
    {
        // Retrieve user by ID
        $student = Student::find($id);

        // Throw an exception if the user is not found
        throw_if(!$student, NotFoundHttpException::class, 'Student not found.');

        return response()->json([ 'success' => true, 'data' => $student, ], 200);
    }

    function index()
    {
    //    Cache::set('bigM',Student::all());
    //    echo Cache::get('bigM');
    
    //    $data = Cache::rememberForever('myKey',function()
    //    {
    //        return Student::all();

    //    });
    //    return $data;
    
    
    $second = 60;
    //    $value = Cache::remember('users', $second, function () {
    //         Log::info('Fetching data from the database');
    //         return Student::all();
    //     });
    //     Log::info('Returning cached value', ['value' => $value]);
    //     return $value;


    //    $value = Cache::remember('file_cache', $second, function () {
    //         Log::info('Fetching data from the database');
    //         return Student::all();
    //     });
    //     Log::info('Returning cached value from local file', ['value' => $value]);
    //     return $value;
        
        
    //    Cache::put('newKey', Student::all(), $second);
    // if (!Cache::has('newKey')) {
    //     // Cache the value for the specified number of seconds
    //     Cache::put('newKey', Student::all(), $second);
    // }
    //        echo Cache::get('newKey');
       
   

 
    // echo Redis::set('name', 'Taylor');
     
    // echo Redis::get('name');
    
// Setting the cache
Cache::put('name', 'Taylor', 600);  // Store for 10 minutes

// Getting the cache
$name = Cache::get('name');
Log::info('Returning cached value from local file', ['value' => $name]);
echo $name;  // Should print 'Taylor' if it's cached in Redis


}


}
