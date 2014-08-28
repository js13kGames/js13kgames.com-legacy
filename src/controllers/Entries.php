<?php namespace js13kgames\controllers;

	// External dependencies
	use Carbon\Carbon;
	use Imagine;

	// Internal dependencies
	use js13kgames\data\models;

	// Aliases
	use Auth, App, Config, Input, Session, Validator;

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

		public function index(models\Category $category = null)
		{
			// Grab the default Category for the given Edition if none was given.
			if(!$category->title) $category = $this->getEdition()->categories()->first();

			// Display the index.
			return $this->display('entries.index', [
				'category'    => $category,
				'submissions' => $category->submissions()->with('user')->where('active', '=', 1)->orderBy('created_at', 'DESC')->get(['title', 'slug', 'user_id']),
				'title'       => $category->title.' Entries | js13kGames'
			]);
		}

		/**
		 *
		 */

		public function show($slug)
		{
			// Check if we hit a reserved Category slug first. If so, show the index instead.
			if(null !== $category = models\Category::where('slug', '=', trim($slug, '/'))->first())
			{
				return $this->index($category);
			}

			// Ensure we've actually got a Submission with the given slug.
			if(!$submission = models\Submission::with('user', 'repository')->where('slug', '=', trim($slug, '/'))->first())
			{
				App::abort(404, 'The requested game does not exist.');
			}

			// Display the entry.
			return $this->display('entries.show', [
				'entry' => $submission,
				'title' => $submission->title.' | js13kGames'
			]);
		}

		/**
		 *
		 */

		public function form()
		{
			return $this->validateEditionTimeframe() ? $this->renderForm() : $this->display('entries.submission.closed');
		}

		/**
		 *
		 */

		public function store()
		{
			if(!$this->validateEditionTimeframe()) App::abort('403', 'Submissions are closed.');

			// Reduce some overhead.
			$input  = Input::all();
			$errors = null;

			// Instantiate a Submission regardless of validation. We will use it to either repopulate the form or
			// save it if everything was fine.
			$submission  = new models\Submission;

			$submission->website_url = $input['website_url'];
			$submission->title       = $input['title'];
			$submission->description = $input['description'];

			// Validate the form submission
			// Captcha first.
			if(true !== $validator = $this->validateCaptcha())
			{
				$errors = $validator->messages();
			}

			// Validate the model.
			if(true !== ($validator = $submission->getValidator($input) and $validator->passes()))
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

			// Also ensure the images were uploaded correctly.
			if(!Input::file('small_screenshot')->isValid() or !Input::file('big_screenshot')->isValid())
			{
				App::abort(500, 'Invalid/failed image uploads.');
			}

			if(!Input::file('file')->isValid())
			{
				App::abort(500, 'Invalid/failed zip upload.');
			}

			// Attempt to assign an existing User.
			if(!$user = models\User::findByEmail($input['email']))
			{
				// ... or create a new one.
				$user = new models\User;

				$user->email         = $input['email'];
				$user->active        = 1;
				$user->twitter_login = 0 === strpos($input['twitter'], '@') ? substr($input['twitter'], 1) : $input['twitter'];

				$user->save();
			}

			// Assign the User to the Submission.
			$submission->user_id = $user->id;

			// Save the Submission so all directories and other dependencies get properly created.
			$submission->save();

			// Create a Repository entry for the Submission.
			$repository = new models\repositories\Github;

			$repository->url           = $input['github_url'];
			$repository->user_id       = $user->id;
			$repository->submission_id = $submission->id;

			$repository->save();

			// Move the zip packages.
			$zip = new \ZipArchive;

			// Move the zip to the game directory.
			Input::file('file')->move($submission->path(), $submission->slug.'.zip');

			// Extract it.
			if($zip->open($submission->path().$submission->slug.'.zip') === true)
			{
				$zip->extractTo($submission->path());
				$zip->close();
			}
			else
			{
				App::abort(500, 'Zip extraction failed, please notify the Js13kgames administrator.');
			}

			// Now push the images to the Submission's assets directory.
			$imagine = new Imagine\Gd\Imagine();

			$imagine->open(Input::file('small_screenshot')->getRealPath())
				->resize(new Imagine\Image\Box(160, 160))
				->save($submission->path().'__small.jpg');

			$imagine->open(Input::file('big_screenshot')->getRealPath())
				->resize(new Imagine\Image\Box(400, 250))
				->save($submission->path().'__big.jpg');

			// Assign the categories to the database entry.
			foreach(Input::get('categories') as $inputCat) $submission->categories()->attach($inputCat);

			return $this->display('entries.submission.success', [
				'submission' => $submission
			]);
		}

		/**
		 *
		 */

		public function prepareForm()
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

		/**
		 *
		 */

		protected function validateCaptcha()
		{
			// Reduce some overhead.
			$input = Input::all();

			// Before we do anything else, first ensure the 'captcha' was correct.
			Validator::extend('compare', function($attribute, $value, $parameters) use($input)
			{
				return ((int) $value === Session::get($input['token']));
			});

			$validator = Validator::make($input,
			[
				'token' => 'required',
				'spam'  => 'required|compare',
			],
			[
				'token.required' => 'You seem to be using some hacky way to submit the form. Not cool bro, not cool.',
				'spam.required'  => 'You didn\'t do the math. Please fill the spam protection field.',
				'spam.compare'   => 'Your math is off. Please try again. Harder, this time.',
			]);

			if($validator->fails()) {
				dd('captcha', $validator->fails(), $validator->messages(), $input, Session::all());
			}

			// If validation failed, return the Validator instance so we get access to the messages. Otherwise
			// just return true.
			return $validator->fails() ? $validator : true;
		}

		/**
		 *
		 */

		protected function validateEditionTimeframe()
		{
			$edition = $this->getEdition();
			$now     = new Carbon;

			return !($now < new Carbon($edition->starts_at) or $now > new Carbon($edition->ends_at));
		}

		/**
		 *
		 */

		protected function renderForm(array $data = [])
		{
			return $this->display('entries.submission.form', array_merge(['form' => $this->prepareForm()], $data));
		}
	}