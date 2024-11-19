<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = [
            'due'           => '10-28-2022',
            'who'           => 'Rory',
            'creator'       => 'Trang',
            'team'          => 'Creative',
            'c_id'          => '1229',
            'a_id'          => '3993',
            'task_name'     => 'imPRESS | Memorial Day | 2023',
            'asset_type'    => ucwords(str_replace('_', ' ', 'email_blast')),
            'asset_status'  => 'copy_request',
            'url' => '/admin/campaign/1229/edit#3993'
        ];

        $details = [
            'who'       => 'Rory',
            'creator'   => 'Trang',
            'c_id'      => 1645,
            'task_name' => 'imPRESS Falsies FAQ + Hacks Organic Videos',
            'asset_type'=> ucwords(str_replace('_', ' ', 'email_blast')),
            'url'       => '/admin/campaign/' . 1645 . '/edit',

        ];

        return $this->markdown('emails.new_project_asset_owner')->with('details', $details);
    }

    public function email_send()
    {

//        Mail::to('jilee2@kissusa.com')->send(new SendMail());
        return new SendMail();
    }


}
