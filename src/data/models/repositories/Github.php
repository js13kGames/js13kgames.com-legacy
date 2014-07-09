<?php namespace js13kgames\data\models\repositories;

	// Internal dependencies
	use js13kgames\data\models;

	/**
	 * Github Repository Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Github extends models\Repository
	{
		const TYPE = models\Repository::TYPE_GITHUB;
	}