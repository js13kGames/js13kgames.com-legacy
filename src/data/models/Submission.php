<?php

class Submission extends Eloquent {

	public $table = 'submissions';

	public function uri()
	{
		return '/entries/'.$this->slug;
	}

	public function path()
	{
		return static::storagePath().$this->slug.'/';
	}

	public function categories()
	{
		return $this->belongsToMany('Category');
	}

	public function edition()
	{
		return $this->belongsTo('Edition');
	}

	public function votes()
	{
		return $this->hasMany('Vote');
	}

	public function getScore()
	{
		$tempScore = 0;

		if($count = $this->votes->count())
		{
			foreach($this->votes as $vote)
			{
				$tempScore += $vote->value;
			}

			$tempScore = round($tempScore / $count);
		}

		return $tempScore;
	}

	public function getCategories()
	{
		$categories = array();

		foreach($this->categories as $category)
		{
			$categories[] = $category->title;
		}

		return $categories;
	}

	public function getUserVote()
	{
		if(!$user = Auth::user()) return 0;

		foreach($this->votes as $vote)
		{
			if($user->id === $vote->user_id) return $vote->value;
		}

		return 0;
	}

	public function delete()
	{
		$it    = new RecursiveDirectoryIterator($this->path());
		$files = new RecursiveIteratorIterator($it,	RecursiveIteratorIterator::CHILD_FIRST);

		foreach($files as $file)
		{
			if($file->getFilename() === '.' || $file->getFilename() === '..') continue;

			if($file->isDir())
				rmdir($file->getRealPath());
			else
				unlink($file->getRealPath());
		}

		rmdir($this->path());

		parent::delete();
	}

	public static function storagePath()
	{
		return base_path('public/games/');
	}
}