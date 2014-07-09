<?php

	// External dependencies
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	/**
	 * Migration: Create Competition Tables
	 *
	 * @package     Js13kgames\Data\Migrations
	 * @version     0.1.0
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class CreateCompetitionTables extends Migration
	{
		/**
		 *
		 */

		public function up()
		{
			Schema::create('editions', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 50);
				$table->string('slug', 50);
				$table->timestamp('starts_at');
				$table->timestamp('ends_at');
			});

			Schema::create('categories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 50);
				$table->string('slug', 50);
				$table->integer('edition_id');
			});

			Schema::create('categories_submissions', function(Blueprint $table)
			{
				$table->integer('category_id');
				$table->integer('submission_id');
			});

			Schema::create('submissions', function(Blueprint $table)
			{
				$table->increments('id');
				$table->boolean('active')->default(0);
				$table->string('title', 50);
				$table->string('slug', 50);
				$table->string('website_url', 100);
				$table->string('server_url', 100);
				$table->text('description')->nullable();
				$table->integer('user_id');
				$table->integer('edition_id');
				$table->timestamps();
			});

			Schema::create('repositories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('type');
				$table->string('url', 255);
				$table->integer('user_id');
				$table->integer('submission_id');
				$table->timestamps();
			});
		}

		/**
		 *
		 */

		public function down()
		{
			Schema::drop('editions');
			Schema::drop('categories');
			Schema::drop('submissions');
			Schema::drop('repositories');
			Schema::drop('categories_submissions');
		}
	}