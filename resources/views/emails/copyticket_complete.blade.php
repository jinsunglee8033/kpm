@component('mail::message')

# Hi {{ $details['who'] }},
Please do action for Task #{{ $details['c_id'] }}
@component('mail::panel')
{{ $details['task_name'] }}
@endcomponent

@component('mail::table')
| TYPE          | STATUS        | Asset ID  |
| ------------- |:-------------:| ---------:|
| {{ $details['task_type'] }}   | {{ $details['task_status'] }} | {{ $details['c_id'] }}|
@endcomponent

@component('mail::button', ['url' => url($details['url']),'color' => 'error'])
Go to Asset
@endcomponent

Thanks,<br>
KDO Project Manager

<small><i>This email address will not receive replies. If you have any questions, please contact to Janene Mascarella</i></small>
@endcomponent
