<?php

	// External dependencies
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	/**
	 * Migration: Create Access Tables
	 *
	 * @package     Js13kgames\Data\Migrations
	 * @version     0.1.0
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class CreateAccessTables extends Migration
	{
		/**
		 *
		 */

		public function up()
		{
			Schema::create('roles', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 50);
				$table->integer('edition_id')->nullable();      // Roles can be bound to a specific edition.
			});

			Schema::create('users_roles', function(Blueprint $table)
			{
				$table->integer('user_id')->index();
				$table->integer('role_id');
			});
		}

		/**
		 *
		 */

		public function down()
		{
			Schema::drop('roles');
			Schema::drop('users_roles');
		}
	}