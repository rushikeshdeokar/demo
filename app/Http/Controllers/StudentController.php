<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function getData(Request $request){
        
        if ($request->ajax()) {
            $authUserId = Auth::id();

            $students = DB::table('teacher as te')
                        ->join('student as st', 'te.id', '=', 'st.class_teacher_id')
                        ->where('st.user_id', $authUserId) 
                        ->where('st.deleted_at',null) 
                        ->select('st.*', 'te.name as teacher_name')
                        ->get();

            return DataTables::of($students)
            ->addColumn('action', function ($row) {
                return '<a href="' . route('student-edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <a href="' . route('student-destroy', $row->id) . '" class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById(\'delete-form-' . $row->id . '\').submit();">Delete</a>
                        <form id="delete-form-' . $row->id . '" action="' . route('student-destroy', $row->id) . '" method="POST" style="display: none;">
                            ' . csrf_field() . method_field('DELETE') . '
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create(Request $request){
        $teachers = Teacher::get();
        return view('create',compact('teachers'));
    }

    public function store(Request $request){ 

        $rules = [
            'student_name' => 'required|string|max:255',
            'class_teacher_id' => 'required|integer|exists:teacher,id', 
            'class' => 'required|string|max:255',
            'admission_date' => 'required|date',
            'yearly_fees' => 'required|numeric|min:0',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $authUserId = Auth::id();

        $student = new Student();
        $student->user_id = $authUserId;
        $student->student_name = $request->input('student_name');
        $student->class_teacher_id = $request->input('class_teacher_id');
        $student->class = $request->input('class');
        $student->admission_date = $request->input('admission_date');
        $student->yearly_fees = $request->input('yearly_fees');
        $student->save();

        $url = route('home');

        return response()->json(['success' => true, 'url'=> $url]);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $teachers = Teacher::all();
        return view('edit', compact('student', 'teachers'));
    }
    public function update(Request $request,$id){

        $rules = [
            'student_name' => 'required|string|max:255',
            'class_teacher_id' => 'required|integer|exists:teacher,id', 
            'class' => 'required|string|max:255',
            'admission_date' => 'required|date',
            'yearly_fees' => 'required|numeric|min:0',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $authUserId = Auth::id();
        $student = Student::findOrFail($id);
        $student->user_id = $authUserId;
        $student->student_name = $request->input('student_name');
        $student->class_teacher_id = $request->input('class_teacher_id');
        $student->class = $request->input('class');
        $student->admission_date = $request->input('admission_date');
        $student->yearly_fees = $request->input('yearly_fees');
        $student->save();

        $url = route('home');

        return response()->json(['success' => true, 'url'=> $url]);
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return redirect()->route('home')->with('success', 'Student deleted successfully.');
    }
}
