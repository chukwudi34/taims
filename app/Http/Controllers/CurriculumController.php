<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Classes;
use App\Models\Subjects;
use App\Models\SubjectTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurriculumController extends Controller
{
    // curriculum index page
    public function index()
    {
        return Inertia::render('Admin/Curriculum/Index');
    }

    //  function to fetch all subjects from DB
    public function fetch_subject(Request $request)
    {
        try {


            $subjects = Subjects::with('classes');

            if ($request->filled('class_id')) {
                $subjects->where('class_id', $request->class_id);
            }

            return $subjects->orderBy('class_id', 'asc')->get();
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    // public function fetch_subject_user()
    // {
    //     $subjects =  Subjects::where('user_id',Auth::user()->id)->get();
    //     return $subjects;
    // }

    //   function to fetch topics for a particular subject
    public function fetch_subject_topics($subject_id)
    {
        $topics = SubjectTopic::where(['subject_id' => $subject_id, 'status' => 'approved'])->get();

        return $topics;
    }

    // function to save new subject in DB
    public function create_subject(Request $request)
    {
        $this->validate($request, [
            'subject_name' => 'required | max:255',
            'subject_code' => 'required | max:255',
            'status' => 'required',
        ]);

        $created_subject = Subjects::create([
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
            'status' => $request->status,
            'created_by' => Auth::user()->id
        ]);

        return $created_subject;
    }

    //  function to edit subject details in DB
    public function edit_subject(Request $request)
    {
        $subject = Subjects::where('id', $request->id);
        $this->validate($request, [
            'subject_name' => 'required | max:255',
            'subject_code' => 'required | max:255',
            'status' => 'required',
        ]);
        $subject->update([
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
            'status' => $request->status
        ]);

        return true;
    }

    //  function to delete subject
    public function delete_subject(Request $request)
    {
        $subject = Subjects::where('id', $request->id);
        $subject->delete();

        return true;
    }

    //  function to fetch topic based on selected subject
    public function fetch_topic(Request $request)
    {
        // if (Auth::user()->user_type == 'admin') {
        $topics = SubjectTopic::where('subject_id', $request->subjectId)
            ->get();
        // }
        //  else {
        //     $topics = SubjectTopic::where(['subject_id' => $request->subjectId, 'created_by' => Auth::user()->id])
        //         ->get();
        // }
        return $topics;
    }

    //  function to add new topic to DB
    public function create_topic(Request $request)
    {
        $this->validate($request, [
            'topicName' => 'required | max:255',
            'description' => 'required | max:255',
            'subjectId' => 'required | max:255',
            'status' => 'required',
        ]);

        $created_topic = SubjectTopic::create([
            'topic_name' => $request->topicName,
            'description' => $request->description,
            'subject_id' => $request->subjectId,
            'status' => $request->status,
            'created_by' => Auth::user()->id
        ]);

        return $created_topic;
    }

    //  function to update topic details in DB
    public function update_topic(Request $request)
    {
        $topic = SubjectTopic::where('id', $request->id);

        $this->validate($request, [
            'topic_name' => 'required | max:255',
            'description' => 'required | max:255',
            'subject_id' => 'required | max:255',
            'status' => 'required',
        ]);

        $topic->update([
            'topic_name' => $request->topic_name,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'status' => $request->status
        ]);

        return true;
    }

    //  function to delete topic from DB
    public function delete_topic(Request $request)
    {
        $topic = SubjectTopic::where('id', $request->id);
        $topic->delete();
        return true;
    }

    // class index page
    public function class_index()
    {
        return Inertia::render('Admin/Classes/Index');
    }
    //  function to fetch all class from DB
    public function fetch_class()
    {
        $classes =  Classes::all();
        return $classes;
    }
    // function to save new class in DB
    public function create_class(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'class_name' => 'required | max:255',
            'class_code' => 'required | max:255',
            'status' => 'required',
        ]);

        $created_class = Classes::create([
            'class_code' => $request->class_code,
            'class_name' => $request->class_name,
            'status' => $request->status,
        ]);

        return $created_class;
    }
}
