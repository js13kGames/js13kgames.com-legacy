<?php

class Vote extends Eloquent {

	public $table = 'votes';

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function submission()
	{
		return $this->belongsTo('Submission');
	}
}