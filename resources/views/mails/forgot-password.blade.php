<p>This email has come to you because you forgot the password.</p>
<p>You can click on the link below <a href="{{route('set-forgot-password', $token->token)}}" target="_blank">Reset password</a></p>
<p>If you have not requested, then you don't need to do anything.</p>
<p>Thanks</p>
<p>Team {{Setting::get('app_name')}}</p>