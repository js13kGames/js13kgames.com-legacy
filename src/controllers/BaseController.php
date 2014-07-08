<?php

class BaseController extends Controller
{
	protected function setupLayout()
	{
		if(null !== $this->layout)
		{
			$this->layout = View::make($this->layout);
		}
	}

}