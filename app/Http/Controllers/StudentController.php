<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {

        $activeStudents = Student::orderBy('id','desc')->where('del_flag','N')->get();
        // dd($activeStudents);

        $inactiveStudents = Student::orderBy('id','desc')->where('del_flag','Y')->get();
        // dd($inactiveStudents);
        return view('pages.student',compact('activeStudents','inactiveStudents'));
    }


    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'studentName' => 'required|string|max:255',
                'studentMail' => 'required|email|max:255|unique:students,email',
                'studentNumber' => 'required|string|max:20|unique:students,phone_number',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'subjects' => 'required|array',
                'subjects.*.subjectName' => 'required|string|max:255',
                'subjects.*.mark' => 'required',
                'subjects.*.grade' => 'required',
            ], [
                'studentMail.unique' => 'Email already exists',
                'studentNumber.unique' => 'Phone number already exists',
            ]);
            $student = Student::create([
                'name' => $validatedData['studentName'],
                'email' => $validatedData['studentMail'],
                'phone_number' => $validatedData['studentNumber'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'country' => $validatedData['country'],
            ]);

            foreach ($request->input('subjects') as $subjectData) {
                $subject = new Subject();
                $subject->name = $subjectData['subjectName'];
                $subject->mark = $subjectData['mark'];
                $subject->grade = $subjectData['grade'];
                $student->subjects()->save($subject);
            }

            return response()->json(['message' => 'Student details saved successfully']);
         } catch (QueryException $e) {
        return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => '' . $e->getMessage()], 500);
        }
    }

    // ====================== show function =================//
    public function show($id)
    {

        $student = Student::with('subjects')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }



    // =================== edit function ===================//
    public function edit($id)
    {
        try {

            $student = Student::with('subjects')->findOrFail($id);

            return response()->json(['student' => $student]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to fetch student data.'], 500);
        }
    }



    public function update(Request $request, $id)
    {
        try {

            $validatedData = $request->validate([
                'studentName' => 'required|string|max:255',
                'studentMail' => 'required|email|max:255|unique:students,email,' . $id,
                'studentNumber' => 'required|string|max:20|unique:students,phone_number,' . $id,
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'subjects' => 'required|array',
                'subjects.*.subjectName' => 'required|string|max:255',
                'subjects.*.mark' => 'required',
                'subjects.*.grade' => 'required',
            ], [
                'studentMail.unique' => 'Email already exists',
                'studentNumber.unique' => 'Phone number already exists',
            ]);


            $student = Student::findOrFail($id);


            $student->update([
                'name' => $validatedData['studentName'],
                'email' => $validatedData['studentMail'],
                'phone_number' => $validatedData['studentNumber'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'country' => $validatedData['country'],
            ]);

            $existingSubjects = $student->subjects->keyBy('id')->toArray();
            $newSubjects = collect($request->input('subjects'))->keyBy('id')->toArray();

            $subjectsToDelete = array_diff_key($existingSubjects, $newSubjects);
            Subject::destroy(array_keys($subjectsToDelete));

            foreach ($request->input('subjects') as $subjectData) {
                $subject = Subject::updateOrCreate(
                    ['id' => $subjectData['id'] ?? null, 'student_id' => $student->id],
                    ['name' => $subjectData['subjectName'], 'mark' => $subjectData['mark'], 'grade' => $subjectData['grade']]
                );
            }

            return response()->json(['message' => 'Student details updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    //==================== destroy function ================//
    public function destroy($id) {
        try {
            $project = Student::findOrFail($id);

            $project->delete();
            Subject::where('student_id', $id)->delete();


            return response()->json(['status' => 'Success', 'message' => 'Student deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Error', 'message' => 'Failed to delete project.'], 500);
        }
    }
    // ===================== Inative Student =================== //

    public function inactiveStudentId(Request $request)
    {

        try {
            $studentId = $request->studentId;
            $inactiveStudent = Student::where('id' , $studentId)->first();
            return response()->json($inactiveStudent);

        } catch (Exception $e) {
            return response()->json([
                "status" => 'Error',
                "message" => 'An error occurred while getting the data.',
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function inactive(Request $request)
    {
        $inactiveStudentId = $request->studentId;

        try {
            $student = Student::findOrFail($inactiveStudentId);

            $student->del_flag = 'Y';
            $student->save();

            return response()->json([
                'message' => "Student Inactivated Successfully",
                'status' => "Success",
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => "Database Error",
                "message" => "Unable to inactive Student",
            ]);
        }
    }

    // ===================== Active Student =================== //
    public function activeStudentId(Request $request)
    {
        try {
            $studentId = $request->studentId;
            $activeStudent = Student::where('id' , $studentId)->first();
            return response()->json($activeStudent);

        } catch (Exception $e) {
            return response()->json([
                "status" => 'Error',
                "message" => 'An error occurred while getting the data.',
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function active(Request $request)
    {
        $activeStudentId = $request->studentId;
        try {
            $student = Student::findOrFail($activeStudentId);
            $student->del_flag = 'N';
            $student->save();

            return response()->json([
                'message' => "Student activated successfully",
                'status' => "Success",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "error" => " Error",
                "message" => "Unable to activate Student",
            ], 500);
        }
    }
}
