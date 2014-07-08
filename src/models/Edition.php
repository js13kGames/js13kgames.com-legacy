<?php

class Edition extends Eloquent {

	protected $table = 'editions';
	public $timestamps = false;

	public function uri()
	{
		return '/entries/'.$this->slug;
	}

	public function categories()
	{
		return $this->hasMany('Category');
	}

	public function submissions()
	{
		return $this->hasMany('Submission');
	}
}