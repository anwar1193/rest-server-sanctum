<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Resources\StudentResource;

class FormController extends Controller
{

    public function create(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $proses = Student::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        // Success Or Not
        $data = Student::where('id' , '=', $proses->id)->get();

        if($data){
            return response()->json([
                'message' => 'Student has been added',
                'data_student' => $data
            ], 200);
        }
    }

    // TANPA RESOURCE
    // public function edit($id)
    // {
    //     $student = Student::find($id);
    //     return response()->json([
    //         'message' => 'success',
    //         'data_student' => $student
    //     ], 200);
    // }

    // DENGAN RESOURCE
    public function edit($id)
    {
        $student = Student::find($id);
        
        $studentCollection = new StudentResource($student);

        return response()->json([
            'message' => 'success',
            'data_student' => $studentCollection
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $student->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        return response()->json([
            'message' => 'success',
            'data_student' => $student
        ],200);
    }

    public function delete($id)
    {
        $student = Student::find($id)->delete();

        return response()->json([
            'message' => 'Student berhasil dihapus'
        ], 200);
    }

    // public function show(Request $request)
    // {
    //     $perPage = $request->get('per_page');

    //     $students = Student::paginate($perPage);
    //     foreach($students as $key => $student){
    //         $data['id'] = $student->id;
    //         $data['name'] = $student->name;
    //         $data['address'] = $student->address;
    //         $data['phone'] = $student->phone;
    //         $datas[] = $data;
    //     }

    //     $dataStudent['data'] = $datas;
    //     $dataStudent['next_page_url'] = $students->nextPageUrl();

    //     return response()->json([
    //         'message' => 'success',
    //         'data_student' => $dataStudent
    //     ], 200);
    // }

    public function show(Request $request)
    {
        $perPage = $request->get('per_page');

        $students = Student::paginate($perPage);
        
        $collectionStudent = StudentResource::collection($students);

        $dataStudent['data'] = $collectionStudent;
        $dataStudent['next_page_url'] = $students->nextPageUrl();

        return response()->json([
            'message' => 'success',
            'data_student' => $dataStudent
        ], 200);
    }
    
}
