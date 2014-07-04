@foreach($mails as $mail)

"{{ $mail->author }}" {{ htmlspecialchars('<'.$mail->email.'>') }},

@endforeach