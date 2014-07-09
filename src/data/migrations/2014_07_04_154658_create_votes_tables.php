<?php

	// External dependencies
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	/**
	 * Migration: Create Votes Tables
	 *
	 * @package     Js13kgames\Data\Migrations
	 * @version     0.1.0
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class CreateVotesTables extends Migration
	{
		/**
		 *
		 */

		public function up()
		{
			Schema::create('votes', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('value');
				$table->integer('submission_id');
				$table->integer('user_id');
				$table->timestamps();
			});
		}

		/**
		 *
		 */

		public function down()
		{
			Schema::drop('votes');
		}
	}