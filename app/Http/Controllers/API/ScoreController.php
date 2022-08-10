<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Score;

class ScoreController extends Controller
{
    public function create(Request $request)
    {
        $student = new Student;

        // Simpan Data Utama (Student)
        $student->name = $request->name;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->save();

        // Simpan Data Score Student (Multiple)
        foreach($request->list_pelajaran as $key => $value){
            $score = array(
                'student_id' => $student->id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            $scores = Score::create($score);
        }

        return response()->json([
            'message' => 'success'
        ], 200);
    }


    public function getStudent($id)
    {
        $student = Student::with('score')->where('id', $id)->first();
        return response()->json([
            'message' => 'success',
            'data_student' => $student
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        // Update data utama (Student)
        $student->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        // Hapus data multiple sebelumnya
        Score::where('student_id', $id)->delete();

        // Isi ulang data multiple
        foreach($request->list_pelajaran as $key => $value){
            $score = array(
                'student_id' => $student->id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            $scores = Score::create($score);
        }

        return response()->json([
            'message' => 'success'
        ], 200);
    }
    
}
