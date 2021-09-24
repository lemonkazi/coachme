<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CoachmeAppsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    public function resetPasswordMail($email, $token, $user,$os) {
        $fromMailAddress = config('global.mail_from_address');
        $fromMailName = config('global.mail_from_name');
        $title = config('global.mail_reset_pass_title');
        $subject = config('global.mail_reset_pass_sub');

        $androidUrl = config('global.mail_reset_pass_url') . '?app_url=' . config('global.android_reset_pass_url') . '&token='. $token;
        $iosUrl = config('global.mail_reset_pass_url') . '?app_url=' . config('global.ios_reset_pass_url') . '&token='. $token;    
        $webUrl = config('global.mail_reset_pass_url') . '?token='. $token;
        // echo $androidUrl; die;
        $content = array(
            'title' => $title,
            'webUrl' => $webUrl,
            'androidUrl' => $androidUrl,
            'iosUrl' => $iosUrl,
            'isAppUser' => $user->isUser(),
            'os' => $os,
        );

        Mail::send('emails.machidoriApp', $content, function ($message) use ($email, $fromMailAddress, $fromMailName, $subject) {
            $message->from($fromMailAddress, $fromMailName);
            $message->to($email);
            $message->subject($subject);
        });
    }

    /*Contact mail send*/
    public function contactMail($email, $dataarr) {
        $fromMailAddress = config('global.mail_from_address');
        $fromMailName = config('global.mail_from_name');
        $title = config('global.mail_reset_pass_title');
        $subject = config('global.mail_reset_pass_sub');

        $content = array(
            'title' => $title,
            'content' => $dataarr
        );

        Mail::send('emails.contactmail', $content, function ($message) use ($email, $fromMailAddress, $fromMailName, $subject) {
            $message->from($fromMailAddress, $fromMailName);
            $message->to($email);
            $message->subject($subject);
        });
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('emails.verifyUser');
        return $this->markdown('emails.machidoriApp');
    }
}
