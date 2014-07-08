<?php

class AdminController extends Controller
{
	public function showIndex($category = null)
	{
		if(true !== $access = $this->requestAccess()) return $access;

		$edition = Edition::find(Config::get('games.edition'));

		$votes = array();

		foreach(Auth::user()->votes as $vote)
		{
			$votes[$vote->submission_id] = $vote->value;
		}

		if(null !== $category)
		{
			$category = Category::find($category);
			$submissions = $category->submissions()->orderBy('score', 'DESC')->get(array('id', 'score', 'title', 'slug', 'active'));
		}
		else
		{
			$category = new StdClass();
			$category->id = 0;
			$category->title = 'All';
			$submissions = $edition->submissions()->orderBy('created_at', 'DESC')->get(array('id', 'score', 'title', 'slug', 'active'));
		}

		return View::make('admin/index', array(
			'edition'     => $edition,
			'category'    => $category,
			'categories'  => $edition->categories,
			'submissions' => $submissions,
			'votes'       => $votes
		));
	}

	public function showEntry($slug)
	{
		if(true !== $access = $this->requestAccess()) return $access;

		if(!$submission = Submission::with(array('votes', 'categories'))->where('slug', '=', trim($slug, '/'))->first())
		{
			App::abort(404);
		}

		return View::make('admin.entries.view', array(
			'entry' => $submission
		));
	}

	public function showMails()
	{
		if(true !== $access = $this->requestAccess()) return $access;

		return View::make('admin.mails', array(
			'mails' => Edition::find(Config::get('games.edition'))->submissions()->get()
		));
	}

	public function voteEntry($slug)
	{
		if(true !== $access = $this->requestAccess()) return $access;

		if(!$submission = Submission::where('slug', '=', trim($slug, '/'))->first()) App::abort(404);

		if($vote = Vote::where('user_id', '=', Auth::user()->id)->where('submission_id', '=', $submission->id)->first())
		{
			$vote->value = (int) Input::get('value');
			$vote->save();
		}
		else
		{
			$vote = new Vote;
			$vote->user_id = Auth::user()->id;
			$vote->submission_id = $submission->id;
			$vote->value = Input::get('value');

			$vote->save();
		}

		// Calculate the current total average score of the Submission.
		$tempScore = 0;

		if($count = $submission->votes->count())
		{
			foreach($submission->votes as $vote)
			{
				$tempScore += $vote->value;
			}

			$tempScore = round($tempScore / $count);
		}

		// Store the current average score in the Submissions table as well for easier sorting and lookups.
		$submission->score = $tempScore;
		$submission->save();

		return View::make('admin.entries.view', array(
			'entry' => $submission
		));
	}

	public function rejectEntry($slug)
	{
		if(true !== $access = $this->requestAccess()) return $access;
		if(Auth::user()->level < 10) App::abort(403);
		if(!$submission = Submission::where('slug', '=', trim($slug, '/'))->first()) App::abort(404);

		// Notify the contest owner.
		Mail::send('emails.submit.rejected', array('submission' => $submission), function($message) use($submission)
		{
			$message->to($submission->email)->subject('[Js13kgames] Your submission has been rejected.');
		});

		$submission->delete();

		return Redirect::to('/admin');
	}

	public function acceptEntry($slug)
	{
		if(true !== $access = $this->requestAccess()) return $access;
		if(Auth::user()->level < 10) App::abort(403);
		if(!$submission = Submission::where('slug', '=', trim($slug, '/'))->first()) App::abort(404);

		// Notify the contest owner.
		Mail::send('emails.submit.accepted', array('submission' => $submission), function($message) use($submission)
		{
			$message->to($submission->email)->subject('[Js13kgames] Your submission has been accepted.');
		});

		$submission->active = 1;
		$submission->save();

		return Redirect::to('/admin');
	}

	public function requestAccess()
	{
		if(Auth::check()) return true;

		return $this->showForm();
	}

	public function attempt()
	{
		if($user = User::where("email", "=", Input::get('email'))->where("password", "=", Input::get('password'))->first())
		{
			Auth::login($user, true);

			return Redirect::to('/admin');
		}
		else
		{
			return $this->showForm();
		}
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

	protected function showForm()
	{
		return View::make('admin/login');
	}
}