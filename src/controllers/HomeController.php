<?php

class HomeController extends BaseController
{
	public function showIndex()
	{
		$submitter = new SubmitController();

		return View::make('index', array(
			'form' => $submitter->prepareForm()
		));
	}

}