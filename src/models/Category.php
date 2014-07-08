<?php

class Category extends Eloquent {

	public $table = 'categories';
	public $timestamps = false;

	public function uri()
	{
		return $this->edition->uri().'/'.$this->id;
	}

	public function edition()
	{
		return $this->belongsTo('Edition');
	}

	public function submissions()
	{
		return $this->belongsToMany('Submission');
	}
}