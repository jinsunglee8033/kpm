@component('mail::message')

# You got a new message from {{ $details['who'] }}
<b style="font: bold;">Copywriter Ticket Request : {{ $details['c_title'] }}</b>

@component('mail::panel')
{{ $details['message'] }}
@endcomponent

@component('mail::button', ['url' => url($details['url']),'color' => 'error'])
Go to Task
@endcomponent

Thanks,<br>
KDO Project Manager

<small><i>This email address will not receive replies. If you have any questions, please contact Janene Mascarella</i></small>
@endcomponent