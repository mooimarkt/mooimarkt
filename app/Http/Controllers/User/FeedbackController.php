<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Ads;
use App\AdsImages;
use App\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerFeedbackMail;
use App\Mail\FeedbackReplyMail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller as BaseController;

class FeedbackController extends BaseController
{
    public function getFeedbackPage(){
        return view('newthemplate/shareexperience');
    }

    public function getFeedbackPageOld(){
        return view('user/shareexperience');
    }

    public function sendFeedbackEmail(Request $request){

        $timeStamp = Carbon::now()->timestamp;

        $feedback_img_path = $request->file('feedback_img_path');

        $feedbackName = $request->input('txtFeedbackName');
        $feedbackPhone = $request->input('txtFeedbackPhone');
        $feedbackEmail = $request->input('txtFeedbackEmail');
        $feedbackSubject = $request->input('txtFeedbackSubject');
        $feedbackDescription = $request->input('txtFeedbackDescription');

        $feedback = new Feedback;

        $feedback->feedbackName = $feedbackName;
        $feedback->feedbackPhone = $feedbackPhone;
        $feedback->feedbackEmail = $feedbackEmail;
        $feedback->feedbackSubject = $feedbackSubject;
        $feedback->feedbackDescription = $feedbackDescription;

        Mail::to('support@b4mx.com')->send(new CustomerFeedbackMail($feedback, $feedback_img_path, $timeStamp));

        Mail::to($feedbackEmail)->send(new FeedbackReplyMail($timeStamp));

        return redirect()->back()->with(['success' => trans('message-box.thankyouforyourfeedback') ]);
    }
}