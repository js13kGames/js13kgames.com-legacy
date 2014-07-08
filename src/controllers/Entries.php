<?php namespace js13kgames\controllers;

	/**
	 * Contest Entries Controller
	 *
	 * @package     Js13kgames\Controllers
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Entries extends Base
	{
		/**
		 *
		 */

		public function index($edition = null, $category = null)
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

		/**
		 *
		 */

		public function show($slug)
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