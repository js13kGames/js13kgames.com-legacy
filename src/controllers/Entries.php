<?php namespace js13kgames\controllers;

	// Internal dependencies
	use js13kgames\data\models;

	// Aliases
	use App, Config, View;

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
			// Default index, ie. current edition and no specified category.
			if(null === $edition) $edition = Config::get('games.edition_slug');

			// Grab the Edition by slug.
			if(!$edition = models\Edition::where('slug', '=', trim($edition, '/'))->first()) {
				App::abort(404, 'The requested edition does not exist.');
			}

			// Grab the default Category for the given Edition if none was given...
			if(null === $category)
			{
				$category = $edition->categories()->first();
			}
			// ... or find the actual requested Category.
			else
			{
				$category = models\Category::find($category);
			}

			// Ensure we've actually got a Category.
			if(null === $category) {
				App::abort(404, 'The requested category does not exist.');
			}

			// Display the index.
			return View::make('entries.index', [
				'editions'    => models\Edition::all(),
				'edition'     => $edition,
				'categories'  => $edition->categories,
				'category'    => $category,
				'submissions' => $category->submissions()->where('active', '=', 1)->orderBy('created_at', 'DESC')->get(['title', 'slug', 'author']),
				'title'       => $edition->title .' | '.$category->title.' Entries | js13kGames'
			]);
		}

		/**
		 *
		 */

		public function show($slug)
		{
			// Check if we hit a reserved Edition slug first. If so, show the index instead.
			if(null !== $edition = models\Edition::where('slug', '=', trim($slug, '/'))->first())
			{
				return $this->index($edition->slug);
			}

			// Ensure we've actually got a Submission with the given slug.
			if(!$submission = models\Submission::where('slug', '=', trim($slug, '/'))->first())
			{
				App::abort(404, 'The requested game does not exist.');
			}

			// Display the entry.
			return View::make('entries.view', [
				'entry' => $submission,
				'title' => $submission->title.' | js13kGames'
			]);
		}
	}