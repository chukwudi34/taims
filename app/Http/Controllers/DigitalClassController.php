<?php

namespace App\Http\Controllers;

use Youtube;
use DateTime;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\LiveClass;
use App\Mail\NotifyParent;
use App\Mail\NotifyStudent;
use App\Mail\NotifyAdmin;
use Illuminate\Http\Request;
use App\Models\RecordedVideo;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DigitalClassController extends Controller
{
    // live class index page
    public function liveClass()
    {
        return Inertia::render('Client/DigitalClass/Liveclass/Index');
    }

    //  recorded videos index page
    public function recordedVideos()
    {
        return Inertia::render('Client/DigitalClass/RecordedVideos/Index');
    }

    //  save meeting link
    public function saveMeetingLink(Request $request)
    {
        $this->validate($request, [
            'link' => 'required | max:255',
        ]);

        $user = Auth::user();
        $link = $request->link;

        User::where('id', $user->id)->update([
            'google_meet_link' => $link
        ]);

        return true;
    }

    public function generateRandomCode()
    {
        $firstPart = Str::random(4);

        $secondPart = Str::random(3);

        $thirdPart = Str::random(3);

        $randomCode = strtolower($firstPart) . '-' . strtolower($secondPart) . '-' . strtolower($thirdPart);

        return $randomCode;
    }
    // Save live class schedule
    public function saveLiveClassSchedule(Request $request)
    {
        try {

            $this->validate($request, [
                'subject' => 'required',
                'topic' => 'required',
                'class_date' => 'required',
                'end_time' => 'required',
                'start_time' => 'required',
                'class' => 'required',
                'price' => 'nullable|numeric|min:0',
            ]);

            $user = Auth::user();


            $start_time = DateTime::createFromFormat('H:i', $request->start_time);
            $end_time = DateTime::createFromFormat('H:i', $request->end_time);

            if (!$start_time || !$end_time) {
                dd("Invalid time format");
            }


            $interval = $start_time->diff($end_time);

            $hours = $interval->h;
            $minutes = $interval->i;
            $seconds = $interval->s;

            $total_time_minute_duration = ($hours * 60) + $minutes;


            $url = 'https://meet.jit.si/' . $this->generateRandomCode();
            $create = LiveClass::updateOrCreate([
                'subject_id' => $request->subject,
                'class_id' => $request->class,
                'topic_id' => $request->topic,
                'created_by' => $user->id,
                'date' => $request->class_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'time_duration' => $total_time_minute_duration,
                'meeting_url' => $url,
                'price' => $request->price ?? 0,
            ], [
                'status' => 'not_started',
            ]);

            if ($create) {

                $student_email = User::where('class_id', $request->class)->get('email');
                $admin = User::where('user_type_id', 3)->first();
                Mail::to($admin->email)->send(new NotifyAdmin($admin->email));


                foreach ($student_email as $key => $value) {
                    Mail::to($value->email)->send(new NotifyStudent($value->email));
                }
                return new JsonResponse(
                    [
                        'success' => true,
                        'message' => "Live Stream created successfully"
                    ],
                    200
                );
            }

            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //  fetch live class
    public function fetchLiveClass(Request $request)
    {
        try {
            $timezone = Auth::user()->region;
            $now = Carbon::now($timezone);
            $date = $now->format('Y-m-d');
            $time = $now->format('H:i');

            LiveClass::where('date', '<=', $date)
                ->where('end_time', '<=', $time)
                ->update(['status' => 'expired']);

            LiveClass::where('date', '>=', $date)
                ->where('start_time', '>', $time)
                ->update(['status' => 'not_started']);

            LiveClass::where('date', $date)
                ->where('start_time', '<=', $time)
                ->where('end_time', '>=', $time)
                ->update(['status' => 'ongoing']);

            $liveclass = LiveClass::select('*')
                ->where(function ($query) {
                    $query->where('created_by', Auth::user()->id)
                        ->orWhere('class_id', Auth::user()->class_id);
                });

            if (Auth::user()->user_type_id == 3) {
                $liveclass = LiveClass::select('*');
            }

            if (!is_null($request->subjectId)) {
                $liveclass->where('subject_id', $request->subjectId);
            }

            $result = $liveclass->orderBy('created_at', 'DESC')->paginate(30);

            $purchasedIds = Transaction::where('user_id', Auth::id())
                ->where('item_type', 'live_class')
                ->where('status', 'completed')
                ->pluck('item_id')
                ->toArray();

            $result->getCollection()->transform(function ($item) use ($purchasedIds) {
                $hasAccess = ($item->price <= 0) || in_array($item->id, $purchasedIds);
                $item->has_access = $hasAccess;
                if (!$hasAccess) {
                    $item->meeting_url = null;
                }
                return $item;
            });

            return $result;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }




    //  edit live class schedule
    public function editLiveClassSchedule(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'topic' => 'required',
            'class_date' => 'required',
            'class_time' => 'required',
            'price' => 'nullable|numeric|min:0',
        ]);

        $updateData = [
            'subject_id' => $request->subject,
            'topic_id' => $request->topic,
            'date' => $request->class_date,
            'time' => $request->class_time,
        ];

        if ($request->has('price')) {
            $updateData['price'] = $request->price;
        }

        LiveClass::where('id', $request->liveClassId)->update($updateData);

        return true;
    }

    //  fetch pre recorded videos
    public function  fetchRecordedVideos(Request $request)
    {
        $recordedVideos = RecordedVideo::select('*');

        if (!is_null($request->subjectId)) {
            $recordedVideos->where('subject_id', $request->subjectId);
        }

        $result = $recordedVideos->orderBy('created_at', 'DESC')->paginate(30);

        $purchasedIds = Transaction::where('user_id', Auth::id())
            ->where('item_type', 'video')
            ->where('status', 'completed')
            ->pluck('item_id')
            ->toArray();

        $result->getCollection()->transform(function ($item) use ($purchasedIds) {
            $hasAccess = ($item->price <= 0) || in_array($item->id, $purchasedIds);
            $item->has_access = $hasAccess;
            if (!$hasAccess) {
                $item->video_link = null;
            }
            return $item;
        });

        return $result;
    }

    //  upload pre recorded videos
    public function uploadRecordedVideos(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'topic' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'nullable|numeric|min:0',
        ]);

        try {
            $video = Youtube::upload($request->file('video')->getPathName(), [
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
                'category_id' => 27
            ]);
            if ($video) {
                RecordedVideo::create([
                    'subject_id' => $request->subject,
                    'topic_id' => $request->topic,
                    'title' => $request->title,
                    'description' => $request->description,
                    'video_link' => $video->getVideoId(),
                    'uploaded_by' => Auth::user()->id,
                    'price' => $request->price ?? 0,
                ]);

                return true;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return "Video uploaded successfully. Video ID is " . $video->getVideoId();
    }

    //  edit uploaded video details
    public function editRecordedVideos(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'topic' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'nullable|numeric|min:0',
        ]);

        try {
            $recorded_video = RecordedVideo::where('id', $request->id)->first();

            $recorded_video->subject_id = $request->subject;
            $recorded_video->topic_id = $request->topic;
            $recorded_video->title = $request->title;
            $recorded_video->description = $request->description;

            if ($request->has('price')) {
                $recorded_video->price = $request->price;
            }

            $video_id = $recorded_video->video_link;

            if ($recorded_video->isDirty(['title', 'description'])) {
                $updated_video = Youtube::update($video_id, [
                    'title'       => $request->input('title'),
                    'description' => $request->input('description'),
                    'category_id' => 27
                ]);
                if ($updated_video) {
                    $recorded_video->save();
                }
            }

            if (!is_null($request->video)) {
                $deleted_video = Youtube::delete($recorded_video->video_link);
                if ($deleted_video) {
                    $video = Youtube::upload($request->file('video')->getPathName(), [
                        'title'       => $request->input('title'),
                        'description' => $request->input('description'),
                        'category_id' => 27
                    ]);

                    if ($video) {
                        $recorded_video->video_link = $video->getVideoId();
                        $recorded_video->save();
                    }
                }
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //  function to Approve or Disapprove videos
    public function changeVideoStatus(Request $request)
    {
        RecordedVideo::where('id', $request->videoId)->update([
            'status' => $request->status
        ]);
        return true;
    }

    // delete recorded video
    public function deleteVideo(Request $request)
    {
        try {
            $recorded_video = RecordedVideo::where('id', $request->videoId)->first();

            if (!is_null($recorded_video)) {
                $deleted_video = Youtube::delete($recorded_video->video_link);
                if ($deleted_video) {
                    $recorded_video->delete();
                }
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateMeetingLink(Request $request)
    {
        $user_google_meet_link = Auth::user()->google_meet_link;
        $user_id = Auth::user()->id;
        if (!is_null($user_google_meet_link)) {
            $update = User::where('id', $user_id)->update([
                'google_meet_link' => Null
            ]);
        }
        $update = User::where('id', $user_id)->update([
            'google_meet_link' => Null
        ]);
    }
    // join live class — gated access, redirects to meeting url
    public function joinLiveClass($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->status !== 'ongoing') {
            return redirect()->back()->with('error', 'Live class is not currently active');
        }

        return redirect($liveClass->meeting_url);
    }

    // watch recorded video — gated access, redirects to youtube
    public function watchRecordedVideo($id)
    {
        $video = RecordedVideo::findOrFail($id);
        return redirect('https://www.youtube.com/watch?v=' . $video->video_link);
    }

    // function to change status after meeting expires
    public function updateElapsed(Request $request)
    {
        $user_id = Auth::user()->id;
        $update = LiveClass::where(['created_by' => $user_id, 'meeting_url' => Auth::user()->google_meet_link])->update([
            'status' => 'expired'
        ]);
        return true;
    }
}
