<?php namespace js13kgames\models;

	/**
	 * Abstract Typable Base Model
	 *
	 * @package     Js13kgames\Data\Models
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	abstract class Typable extends Base
	{
		const TYPE = 0;

		/**
		 *
		 */

		protected static $types = [];

		/**
		 *
		 */

		protected static $typeKey = 'type';

		/**
		 *
		 */

		public static function morph(Base $model = null, $type = null)
		{
			if(null === $model) return static::createOfType([], $type);
			if($model->exists)  return static::getOfType($model->getAttributes(), $type);

			return static::createOfType($model->getAttributes(), $type);
		}

		/**
		 *
		 */

		public static function createOfType(array $attributes = [], $type = null)
		{
			if(isset(static::$types[$type]))
			{
				return new static::$types[$type]($attributes);
			}

			return new static($attributes);
		}

		/**
		 *
		 */

		public static function getOfType($attributes = [], $type = null)
		{
			if(isset(static::$types[$type]))
			{
				$instance = new static::$types[$type];
			}
			else
			{
				$instance = new static;
			}

			$instance->exists = true;
			$instance->setRawAttributes($attributes, true);

			return $instance;
		}

		/**
		 * {@inheritDoc}
		 */

		public function newFromBuilder($attributes = [])
		{
			$attributes = (array) $attributes;

			return static::getOfType($attributes, isset($attributes['type']) ? $attributes['type'] : null);
		}

		/**
		 * {@inheritDoc}
		 */

		public function newInstance($attributes = [], $exists = false, $type = null)
		{
			if($exists) return static::getOfType($attributes, $type);

			return static::createOfType($attributes, $type);
		}


		/**
		 * {@inheritDoc}
		 */

		public function newQuery()
		{
			$query = parent::newQuery();

			// If the type is not set (master class) or it has been changed (updating an existing model) we are not
			// going to limit the query.
			if(!static::TYPE or (isset($this->original[static::$typeKey]) and isset($this->original[static::$typeKey]) and $this->original[static::$typeKey] !== $this->attributes[static::$typeKey]))
			{
				return $query;
			}

			return $query->where('type', '=', static::TYPE);
		}

		/**
		 * {@inheritDoc}
		 */

		public function save(array $options = [])
		{
			$this->{static::$typeKey} = static::TYPE;

			parent::save($options);
		}
	}