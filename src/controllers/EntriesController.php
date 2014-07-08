<?php

class EntriesController extends BaseController
{
	public function showIndex($edition = null, $category = null)
	{
		if(null === $edition) $edition = Config::get('games.edition_slug');

		if(!$edition = Edition::where('slug', '=', trim($edition, '/'))->first()) {
			App::abort(404);
		}

		if(null === $category) {
			$category = $edition->categories()->first();
		} else {
			$category = Category::find($category);
		}

		if(null === $category) {
			App::abort(404);
		}

		return View::make('entries.index', array(
			'editions' => Edition::all(),
			'edition' => $edition,
			'categories' => $edition->categories,
			'category' => $category,
			'submissions' => $category->submissions()->where('active', '=', 1)->orderBy('created_at', 'DESC')->get(array('title', 'slug', 'author')),
			'title' => $edition->title .' | '.$category->title.' Entries | js13kGames'
		));
	}

	public function showEntry($slug)
	{
		// Check if we hit a reserved edition slug first.
		foreach(Edition::all() as $edition)
		{
			if($slug === $edition->slug) return $this->showIndex($edition->slug);
		}

		if(!$submission = Submission::where('slug', '=', trim($slug, '/'))->first())
		{
			App::abort(404);
		}

		return View::make('entries.view', array(
			'entry' => $submission,
			'title' => $submission->title.' | js13kGames'
		));
	}
}