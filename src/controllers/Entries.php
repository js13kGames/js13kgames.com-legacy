<?php namespace js13kgames\controllers;

	// Internal dependencies
	use js13kgames\data\models;

	// Aliases
	use App, Config, Input, Session, Validator, View;

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
			return $this->renderForm();
		}


		/**
		 *
		 */

		public function store()
		{
			// Reduce some overhead.
			$input  = Input::all();
			$errors = null;

			// Instantiate a Submission regardless of validation. We will use it to either repopulate the form or
			// save it if everything was fine.
			$submission  = new models\Submission;

			$submission->author      = $input['author'];
			$submission->email       = $input['email'];
			$submission->twitter     = 0 === strpos($input['twitter'], '@') ? substr($input['twitter'], 1) : $input['twitter'];
			$submission->website_url = $input['website_url'];
			$submission->github_url  = $input['github_url'];
			$submission->server_url  = $input['server_url'];
			$submission->title       = $input['title'];
			$submission->description = $input['description'];

			// Validate the form submission
			// Captcha first.
			if(true !== $validator = $this->validateCaptcha())
			{
				$errors = $validator->messages();
			}

			// Validate the model.
			if(true !== ($validator = $submission->getValidator() and $validator->passes()))
			{
				$errors = null !== $errors ? $errors->merge($validator->messages()) : $validator->messages();
			}

			// If we ended up with any validation errors, render the form again and re-populate it.
			if(null !== $errors)
			{
				return $this->renderForm([
					'errors'     => $errors,
					'submission' => $submission
				]);
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

			return View::make('submit.success', array(
				'submission' => $submission
			));
		}

		/**
		 *
		 */

		protected function validateCaptcha()
		{
			// Reduce some overhead.
			$input = Input::all();

			// Before we do anything else, first ensure the 'captcha' was correct.
			Validator::extend('spam', function($attribute, $value, $parameters) use($input)
			{
				return $value == Session::get($input['token']);
			});

			$validator = Validator::make($input,
			[
				'spam'  => 'required|spam',
				'token' => 'required',
			],
			[
				'token.required' => 'You seem to be using some hacky way to submit the form. Not cool bro, not cool.',
				'spam.required'  => 'You didn\'t do the math. Please fill the spam protection field.',
				'spam.spam'      => 'Your math is off. Please try again. Harder, this time.',
			]);

			// If validation failed, return the Validator instance so we get access to the messages. Otherwise
			// just return true.
			return $validator->fails() ? $validator : true;
		}

		/**
		 *
		 */

		protected function renderForm(array $data = [])
		{
			return View::make('submit.form', array_merge(['form' => $this->prepareForm()], $data));
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