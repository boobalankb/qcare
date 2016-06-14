{{ $url = '' }}
Click here to reset your password: 
@if ($user->isAdmin())
    {{$url = ''}}
@elseif ($user->isDonor())
    {{$url = 'api/v1/'}}
@else
    {{$url = ''}}
@endif
<a href="{{ $link = url($url.'password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
