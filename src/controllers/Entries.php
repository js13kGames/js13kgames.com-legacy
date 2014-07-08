<?php namespace js13kgames\controllers;

	// Internal dependencies
	use js13kgames\data\models;

	// Aliases
	use App, Config, Session, View;

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

		/**
		 *
		 */

		public function form()
		{
			return View::make('submit.form', array(
				'form' => $this->prepareForm()
			));
		}


		/**
		 *
		 */

		public function store()
		{
			$submission  = new Submission;
			$editions    = Edition::all();
			$reservedSlugs = array();

			$editions->each(function($edition) use($reservedSlugs) {
				$reservedSlugs[] = $edition->slug;
			});

			$submission->active      = 0;
			$submission->author      = Input::get('author');
			$submission->email       = Input::get('email');
			$submission->twitter     = 0 === strpos(Input::get('twitter'), '@') ? substr(Input::get('twitter'), 1) : Input::get('twitter');
			$submission->website_url = Input::get('website_url');
			$submission->github_url  = Input::get('github_url');
			$submission->server_url  = Input::get('server_url');
			$submission->title       = Input::get('title');
			$submission->description = Input::get('description');
			$submission->slug        = Str::slug($submission->title);
			$submission->edition_id  = Config::get('games.edition');

			Validator::extend('spam', function($attribute, $value, $parameters)
			{
				return $value == Session::get(Input::get('token'));
			});

			Validator::extend('unique_slug', function($attribute, $value, $parameters)
			{
				return !Submission::where('slug', '=', Str::slug($value))->first() instanceof Submission;
			});

			Validator::extend('reserved_slug', function($attribute, $value, $parameters) use($reservedSlugs)
			{
				return !in_array($value, $reservedSlugs);
			});

			Validator::extend('if_server', function($attribute, $value, $parameters) use($reservedSlugs)
			{
				if(in_array(2, Input::get('categories')))
				{
					return !empty($value);
				}

				return true;
			});

			$messages = array(
				'spam.required' => 'You didn\'t do the math. Please fill the spam protection field.',
				'spam.spam'     => 'Your math is off. Please try again. Harder, this time.',
				'unique_slug'   => 'A game with the name <a href="'.$submission->uri().'">'.$submission->title.'</a> has already been submitted. Please choose a different name.',
				'reserved_slug' => 'The title of the game must not be one of: '.implode(',', $reservedSlugs).'.',
				'if_server'     => 'A valid URL to the deployed game and a .zip with the server code must be provided for a game in the "Server" category.',
			);

			$rules = array(
				'spam'        => 'required|spam',
				'token'       => 'required',
				'author'      => 'required|min:3',
				'email'       => 'required|email',
				'categories'  => 'required',
				'website_url' => 'url',
				'github_url'  => 'url',
				'server_url'  => 'url|if_server',
				'title'       => 'required|min:2|max:100|unique_slug|reserved_slug',
				'description' => 'required|min:10|max:1000',
				'file'        => 'mimes:zip|max:13',
				'file_server' => 'mimes:zip|max:13|if_server',
				'small_screenshot' => 'mimes:jpeg,gif,png|max:100',
				'big_screenshot'   => 'mimes:jpeg,gif,png|max:100'
			);

			$validator = Validator::make(Input::all(), $rules, $messages);

			if($validator->fails())
			{
				return View::make('submit.form', array(
					'form' => $this->prepareForm(),
					'errors' => $validator->messages(),
					'submission' => $submission
				));
			}

			$imagine = new Imagine\Gd\Imagine();
			$zippy = Alchemy\Zippy\Zippy::load();

			if(!Input::file('file')->isValid()
				or !Input::file('small_screenshot')->isValid()
				or !Input::file('big_screenshot')->isValid()) App::abort(500);

			// Create the directory.
			mkdir($submission->path(), 0777);

			// Images.
			$imagine->open(Input::file('small_screenshot')->getRealPath())
				->resize(new Imagine\Image\Box(160, 160))
				->save($submission->path().'__small.jpg');

			$imagine->open(Input::file('big_screenshot')->getRealPath())
				->resize(new Imagine\Image\Box(400, 250))
				->save($submission->path().'__big.jpg');

			// Move the zip to the game directory.
			Input::file('file')->move($submission->path(), $submission->slug.'.zip');

			// Extract it.
			$archive = $zippy->open($submission->path().$submission->slug.'.zip');
			$archive->extract($submission->path());

			$submission->save();

			// Asign the categories to the database entry.
			foreach(Input::get('categories') as $inputCat) {
				$submission->categories()->attach($inputCat);
			};

			$submission->save();

			// Notify the contest owner.
			Mail::send('emails.submit.owner-note', array('submission' => $submission), function($message)
			{
				$message->to(Config::get('games.mail'))->subject('[Js13kgames] New submission.');
			});

			return View::make('submit.success', array(
				'submission' => $submission
			));
		}

		/**
		 *
		 */

		protected function prepareForm()
		{
			$form = [
				'token'      => md5(mt_rand()),
				'num'        => [mt_rand(1, 9), mt_rand(1, 9)],
				'categories' => models\Edition::find(Config::get('games.edition'))->categories
			];

			Session::flash('token', $form['token']);
			Session::flash($form['token'], $form['num'][0] + $form['num'][1]);

			return $form;
		}
	}