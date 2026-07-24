<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use Inertia\Inertia;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Classes;
use App\Models\Question;
use App\Models\LiveClass;
use App\Models\QuizCategory;
use Illuminate\Http\Request;
use App\Models\OptionQuestion;
use App\Models\AnsweredQuestion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\Q;

class QuizController extends Controller
{
    public function index()
    {
        return Inertia::render('Quiz/Setup/Index');
    }

    public function quiz_index()
    {
        return Inertia::render('Quiz/Bank/Index');
    }

    public function fetchLive(Request $request, $class_id)
    {
        return response()->json(
            LiveClass::where('class_id', $class_id)->where('created_by', Auth::user()->id)
                ->where('status', 1)
                ->with('topic')
                ->get()
        );
    }

    public function setQuizCategory(Request $request)
    {
        try {


            $category =  QuizCategory::updateOrCreate([
                'class_id' => $request->class,
                'created_by' => Auth::user()->id,
                'subject_id' => $request->subject,
                'topic_id' => $request->topic,
            ], [
                'status' => "pending"
            ]);
            return $category->save();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function setQuiz(Request $request)
    {
        try {
            $quiz =  Quiz::updateOrCreate(
                [
                    'title' => $request->title,
                    'user_id' => Auth::user()->id,
                    'duration' => $request->duration,
                    'category_id' => $request->category_id,
                ],
                [
                    'status' => "pending"
                ]
            );
            return response()->json(['message' => 'quiz created successfully', 'status' => true], 200);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function setQuizCategoryLive(Request $request)
    {
        $quizCategory = QuizCategory::find($request->id);

        if (!$quizCategory) {
            return response()->json(['message' => 'Quiz Category not found'], 404);
        }

        $newStatus = match ($quizCategory->status) {
            'pending' => 'approved',
            'approved' => 'disapproved',
            'disapproved' => 'approved',
            default => 'pending',
        };

        $quizCategory->update(['status' => $newStatus]);

        return response()->json(['message' => 'Status updated successfully', 'status' => $newStatus], 200);
    }

    public function setQuizLive(Request $request)
    {
        Quiz::where('id', $request->id)->update([
            'status' => 'approved'
        ]);
        return true;
    }
    public function getQuizCategory(Request $request)
    {
        $class_id = $request->class_id;
        $subject = $request->subject;
        $category = QuizCategory::with(['class', 'topic', 'subject']);

        if (!is_null($subject)) {
            $category->where('subject_id', $subject);
        }
        if (!is_null($class_id)) {
            $category->where('class_id', $class_id);
        }

        return response()->json(['status' => true, 'data' => $category->get()], 200);
    }
    public function fetchQuizCategory(Request $request)
    {
        try {

            $quiz_category = QuizCategory::with(['class', 'topic', 'subject']);

            if (!is_null($request->subjectId)) {
                $quiz_category->where('subject_id', $request->subjectId);
            }

            return $quiz_category->orderBy('created_at', 'DESC')->paginate(30);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function fetchQuiz(Request $request)
    {
        try {


            $quiz = Quiz::where('user_id', Auth::user()->id)->with('quiz_category');
            return $quiz->orderBy('created_at', 'DESC')->paginate(30);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function manage_quiz_questions($quiz_id)
    {
        return Inertia::render('Quiz/Bank/Partials/ManageQuestion', ["quiz_id" => $quiz_id]);
    }

    public function setQuizQuestion(Request $request)
    {
        DB::transaction(function () use ($request) {
            $question = Question::create([
                'question_title' => $request[0]["question_title"],
                'mark_obtainable' => $request[0]["mark_obtainable"],
                'quiz_id' => $request[0]["quiz_id"],
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]);
            foreach ($request[1] as $key => $value) {
                $option =  Option::create([
                    'question_id' => $question->id,
                    'option' => $request[1][$key]["option"],
                    'is_correct' => $request[1][$key]["is_correct"] == true ? "true" : "false",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        });
        return true;
    }
    public function fetchQuizQuestions(Request $request, $id = null)
    {
        try {
            $question_option = Question::where('quiz_id', $request->id)->with("options")->get();
            return  $question_option;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deleteQuestion(Request $request)
    {
        Option::where('question_id', $request->id)->delete();
        Question::where('id', $request->id)->delete();
        return  true;
    }


    public function takeQuizIndex(Request $request)
    {
        return Inertia::render('Quiz/Student/Index');
    }

    public function fetchLiveQuizForStudent(Request $request)
    {
        try {
            $user = Auth::user();

            $quizCategoryClassIds = QuizCategory::where('class_id', $user->class_id)->pluck('id');

            $quizData = Quiz::whereIn('category_id', $quizCategoryClassIds)
                ->whereHas('question.optionQuestions', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with([
                    'question.optionQuestions' => function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->with('options');
                    },
                    'question.optionQuestions.options' => function ($query) {
                        $query->select('id', 'option', 'is_correct');
                    }
                ])
                ->withCount('question')
                ->orderBy('created_at', 'DESC')
                ->paginate(30);

            return response()->json($quizData, 200);
        } catch (\Throwable $th) {

            return response()->json([
                'message' => 'Failed to fetch quizzes. Please try again later.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }



    public function startQuiz(Request $request, $quiz_id)
    {
        return Inertia::render('Quiz/Student/Partials/QuizAttempt', ['quiz_id' => $quiz_id]);
    }

    public function fetchToStart(Request $request)
    {
        $data = Question::where('quiz_id', $request->id)->with('options');
        return $data->paginate(30);
    }

    public function submitQuiz(Request $request)
    {
        try {
            foreach ($request->data as $key => $value) {
                $insert_record = OptionQuestion::create([
                    'option_id' => $request->data[$key]["option"]["id"],
                    'question_id' => $request->data[$key]["option"]["question_id"],
                    'user_id' => Auth::user()->id,
                    'quiz_id' => $request->data[$key]["question"]["quiz_id"]
                ]);
            }
            return $insert_record;
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    public function getQuizQuestion(Request $request)
    {
        $all_live_class_ids = LiveClass::where('created_by', Auth::user()->id)->pluck('class_id');
        $get_quiz_category_ids = QuizCategory::where('user_id', Auth::user()->id)->whereIn('live_class_id', $all_live_class_ids)->pluck('id');
        $get_quiz_under_category_ids =  Quiz::whereIn('category_id', $get_quiz_category_ids)->pluck('id');
        $get_all_question_ids = Question::whereIn('quiz_id', $get_quiz_under_category_ids)->pluck("id");

        $attemptedQuestionIds = OptionQuestion::whereIn('question_id', $get_all_question_ids)->distinct()
            ->pluck('user_id')
            ->count();
        return ["total_participant" => $attemptedQuestionIds];
        // dd($attemptedQuestionIds);
    }

    public function getAnswer(Request $request, $quiz_id)
    {
        $user_id_quiz_ans = OptionQuestion::where('user_id', Auth::user()->id)->where('quiz_id', $quiz_id)->with(['question', 'options'])
            ->get();
        $quiz_question = Question::all();
        $quiz_option = Option::all();
        $get_result = [];
        foreach ($quiz_option as $key => $value) {
            foreach ($user_id_quiz_ans as $key2 => $value2) {
                $get_result["total_question"] = count($quiz_question);
                $get_result["total_mark_for_question"] = $quiz_question->pluck('mark_obtainable')->sum();
                $get_result["total_answered_question"] = count($user_id_quiz_ans);
                if (($user_id_quiz_ans[$key2]["options"]["is_correct"] == true) && ($user_id_quiz_ans[$key2]["options"]["id"] == $quiz_option[$key]["id"])) {
                    $get_result["get_distinct_quiz_done_by_student"] = Quiz::whereIn('id', OptionQuestion::where('user_id', $user_id_quiz_ans[$key2]["user_id"])->pluck('quiz_id'))->distinct()->get();
                    $ans = Answer::firstOrNew([
                        "user_id" => $user_id_quiz_ans[$key2]["user_id"],
                        "option_id" => $user_id_quiz_ans[$key2]["options"]["id"],
                        "mark_obtainable" => $user_id_quiz_ans[$key2]["question"]["mark_obtainable"]
                    ]);
                    $ans->save();
                }
            }
        }
        $get_result["total_correct_answer"] = Answer::where('user_id', Auth::user()->id)->count();
        $get_result["total_scored"] = Answer::where('user_id', Auth::user()->id)->sum('mark_obtainable');
        $get_result["total_missed_question_mark"] = $get_result["total_mark_for_question"] - $get_result["total_scored"];
        $get_result["student_detail"] =  User::where('id', Auth::user()->id)->first();

        return Inertia::render('Quiz/Student/Partials/CheckResult', ["result" => response()->json($get_result)]);
    }
}
