@component('mail::message')

# Hi {{ $details['who'] }},
@component('mail::panel')
{{ $details['task_name'] }}
@endcomponent

This project #{{ $details['c_id'] }} created by {{ $details['creator'] }}. <br>
Please create <span style="color:#ffffff; font-size: medium;background-color: #933434;border-radius: 6px;">&nbsp;{{ $details['asset_type'] }}&nbsp;</span>.

@component('mail::button', ['url' => url($details['url']),'color' => 'error'])
Go to Project
@endcomponent

Thanks,<br>
KDO Project Manager

<small><i>This email address will not receive replies. If you have any questions, please contact Mo Tuhin or Vincent "Vinny" Cerone.</i></small>
@endcomponent
