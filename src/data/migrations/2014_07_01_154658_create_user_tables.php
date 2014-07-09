<?php

	// External dependencies
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	/**
	 * Migration: Create User Tables
	 *
	 * Note: We are not using our own registration system. User accounts are created via oAuth logins only, thus
	 * no (in)active accounts nor passwords in the database.
	 *
	 * @package     Js13kgames\Data\Migrations
	 * @version     0.1.0
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class CreateUserTables extends Migration
	{
		/**
		 *
		 */

		public function up()
		{
			Schema::create('users', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('email', 100);
				$table->string('name', 30)->nullable();
				$table->string('surname', 50)->nullable();
				$table->string('remember_token', 255)->nullable();
				$table->timestamps();
			});

			Schema::create('users_profiles', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('type');                    // Provider type
				$table->string('uid');                      // Provider UID
				$table->integer('user_id')->index();
				$table->string('email', 100)->default('');
				$table->string('avatar', 255)->default('');
				$table->timestamps();
			});
		}

		/**
		 *
		 */

		public function down()
		{
			Schema::drop('users');
			Schema::drop('users_profiles');
		}
	}