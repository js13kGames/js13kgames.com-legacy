@extends('layouts.master')
@section('content')
<p class="message success">
	<b>Success!</b> Your submission has been saved. However, it still needs to be verified before it becomes available.
	You will receive an e-mail to the address <b>{{ $submission->user->email }}</b> when it gets accepted or rejected.
</p>
@stop