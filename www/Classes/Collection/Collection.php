<?php
/*
 * Copyright 2011-2012 [Ryan Parman](http://ryanparman.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


namespace Framework\Classes;

use ArrayAccess;
use ArrayObject;
use BadFunctionCallException;
use Countable;
use IteratorAggregate;
use Serializable;
use stdClass;

/**
 * The Collection class provides an object-oriented, fluid interface for working
 * with arrays.
 */
class Collection
	implements IteratorAggregate, ArrayAccess, Countable, Serializable
{
	/**
	 * Stores the internal representation of the collection.
	 * @var ArrayObject
	 */
	protected $collection;

	/**
	 * Stores the internal representation of the collection.
	 * @var ArrayIterator
	 */
	protected $iterator;


	/*%*********************************************************************%*/
	// MAGIC METHODS

	/**
	 * [__toString description]
	 * @return string [description]
	 */
	public function __toString() {}

	/**
	 * [__clone description]
	 * @return [type] [description]
	 */
	public function __clone()
	{
		$this->collection = clone $this->collection;
		$this->iterator = clone $this->iterator;
	}

	/**
	 * [__call description]
	 * @param  [type] $name      [description]
	 * @param  [type] $arguments [description]
	 * @return [type]            [description]
	 */
	public function __call($name, $arguments) {}

	/**
	 * Default getter. Enables syntax such as `$obj->method->chained_method();`.
	 * Also supports `$object->key`. Matching methods are prioritized over
	 * matching keys.
	 *
	 * @param string $name The name of the method to execute or key to retrieve.
	 * @return mixed The results of calling the function `$name()`, or the value
	 *     of the key `$object`.
	 */
	public function __get($name)
	{
		if (method_exists($this, $name))
		{
			return $this->$name();
		}
		elseif ($this->exists($name))
		{
			return $this[$name];
		}

		return null;
	}

	/**
	 * Default setter.
	 *
	 * @param string $name The name of the method to execute.
	 * @param string $value The value to pass to the method.
	 * @return mixed The results of calling the function, `$name`.
	 */
	public function __set($name, $value)
	{
		if (method_exists($this, $name))
		{
			return $this->$name($value);
		}

		$this[$name] = $value;
		return $this;
	}



	/*%*********************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of a Collection.
	 * @param array $value The array to convert to a Collection.
	 */
	public function __construct($value = array())
	{
		$this->collection = new ArrayObject($value, ArrayObject::ARRAY_AS_PROPS);
		$this->iterator = $this->collection->getIterator();
	}


	/*%*********************************************************************%*/
	// ARRAYACCESS & ARRAYOBJECT INTERFACE METHODS

	/**
	 * Return the current entry in the collection.
	 *
	 * @see ArrayIterator::current()
	 * @return mixed The current entry in the collection.
	 */
	public function current()
	{
		return $this->iterator->current();
	}

	/**
	 * Return the current key in the collection.
	 *
	 * @see ArrayIterator::key()
	 * @return mixed The current key in the collection.
	 */
	public function key()
	{
		return $this->iterator->key();
	}

	/**
	 * Move to the next entry in the collection.
	 *
	 * @see ArrayIterator::next()
	 * @return self A reference to the current collection.
	 */
	public function next()
	{
		$this->iterator->next();
		return $this;
	}

	/**
	 * Rewind pointer back to the beginning of the collection.
	 *
	 * @see ArrayIterator::rewind()
	 * @return self A reference to the current collection.
	 */
	public function rewind()
	{
		$this->iterator->rewind();
		return $this;
	}

	/**
	 * Check whether or not the collection contains more entries.
	 *
	 * @see ArrayIterator::valid()
	 * @return boolean A value of `true` indicates that the collection contains
	 *     more entries. A value of `false` indicates that there are no
	 *     remaining entries.
	 */
	public function valid()
	{
		return $this->iterator->valid();
	}

	/**
	 * Retrieve an external iterator.
	 *
	 * @see ArrayIterator
	 * @return boolean A value of `true` indicates that the collection contains
	 *     more entries. A value of `false` indicates that there are no
	 *     remaining entries.
	 */
	public function getIterator()
	{
		return $this->iterator;
	}

	/**
	 * {@inheritdoc exists()}
	 * @alias exists()
	 */
	public function offsetExists($offset)
	{
		return $this->collection->offsetExists($offset);
	}

	/**
	 * {@inheritdoc get()}
	 * @alias get()
	 */
	public function offsetGet($offset)
	{
		if ($this->collection->offsetExists($offset))
		{
			return $this->collection->offsetGet($offset);
		}

		return null;
	}

	/**
	 * {@inheritdoc set()}
	 * @alias set()
	 */
	public function offsetSet($offset, $value)
	{
		$this->collection->offsetSet($offset, $value);
		return $this;
	}

	/**
	 * {@inheritdoc remove()}
	 * @alias remove()
	 */
	public function offsetUnset($offset)
	{
		$this->collection->offsetUnset($offset);
		return $this;
	}

	/**
	 * Seek to a specific position in the collection.
	 *
	 * @see ArrayIterator::seek()
	 * @param integer $position The location in the collection to seek to.
	 * @return self A reference to the current collection.
	 */
	public function seek($position)
	{
		$this->iterator->seek($position);
		return $this;
	}


	/*%*********************************************************************%*/
	// COUNTABLE INTERFACE METHODS

	/**
	 * Count the number of elements in a collection.
	 *
	 * @see ArrayObject::count()
	 * @return integer The number of elements in a collection.
	 */
	public function count()
	{
		return $this->collection->count();
	}


	/*%*********************************************************************%*/
	// SERIALIZABLE INTERFACE METHODS

	/**
	 * Serializes the collection into a string.
	 *
	 * @return string A string representation of the collection.
	 */
	public function serialize()
	{
		$serialized_collection = clone $this;

		foreach ($serialized_collection->collection as &$entry)
		{
			if (is_object($entry) && is_a($entry, 'SimpleXMLElement'))
			{
				$entry = '&SimpleXMLElement&' . Object::type($entry) .
				         '&' . str_replace("\n", '', $entry->asXML());
			}
		}

		return serialize($serialized_collection->collection);
	}

	/**
	 * Unserializes a string into a collection.
	 *
	 * @param string $serialized Object that has been serialized into a string.
	 * @return mixed Object represented by the serialized string.
	 */
	public function unserialize($serialized)
	{
		$this->collection = unserialize($serialized);

		foreach ($this->collection as &$entry)
		{
			if (is_string($entry) &&
			    substr($entry, 0, 18) === '&SimpleXMLElement&')
			{
				$xml = substr($entry, 18);

				if (substr($xml, 0, 5) !== '<?xml')
				{
					$xml_position = strpos($xml, '<?xml') - 1;
					$custom_class = substr($xml, 0, $xml_position);
					$xml = substr($xml, $xml_position + 1);
				}

				$entry = simplexml_load_string($xml, $custom_class);
			}
		}

		$this->iterator = $this->collection->getIterator();
	}


	/*%*********************************************************************%*/
	// ALIAS METHODS

	/**
	 * Check whether or not a specific offset exists.
	 *
	 * @see ArrayIterator::offsetExists()
	 * @param integer $offset The location in the collection to verify the
	 *     existence of.
	 * @return boolean A value of `true` indicates that the collection offset
	 *     exists. A value of `false` indicates that it does not.
	 */
	public function exists($offset)
	{
		return $this->collection->offsetExists($offset);
	}

	/**
	 * Get the value for a specific offset.
	 *
	 * @see ArrayIterator::offsetGet()
	 * @param integer $offset The location in the collection to retrieve the
	 *     value for.
	 * @return mixed The value of the collection offset. `NULL` is returned if
	 *     the offset does not exist.
	 */
	public function get($offset)
	{
		if ($this->collection->offsetExists($offset))
		{
			return $this->collection->offsetGet($offset);
		}

		return null;
	}

	/**
	 * Set the value for a specific offset.
	 *
	 * @see ArrayIterator::offsetSet()
	 * @param integer $offset The location in the collection to set a new
	 *     value for.
	 * @param mixed $value The new value for the collection location.
	 * @return self A reference to the current collection.
	 */
	public function set($offset, $value)
	{
		$this->collection->offsetSet($offset, $value);
		return $this;
	}

	/**
	 * Unset the value for a specific offset.
	 *
	 * @see ArrayIterator::offsetUnset()
	 * @param integer $offset The location in the collection to unset.
	 * @return self A reference to the current collection.
	 */
	public function remove($offset)
	{
		if (!is_null($offset) && $this->collection->offsetExists($offset))
		{
			$this->collection->offsetUnset($offset);
		}

		return $this;
	}

	/**
	 * {@inheritdoc count()}
	 * @alias count()
	 */
	public function length()
	{
		return $this->collection->count();
	}

	/**
	 * {@inheritdoc count()}
	 * @alias count()
	 */
	public function size()
	{
		return $this->collection->count();
	}


	/*%*********************************************************************%*/
	// ENUMERATION METHODS

	/**
	 * Passes each element in the current collection through a function, and
	 * produces a new collection containing the return values.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @todo Leverage array_map() for better performance.
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return self A new collection containing the return values.
	 */
	public function map($callback)
	{
		$items = $this->to_array();
		$collect = array();

		if (is_callable($callback))
		{
			foreach ($items as $key => $item)
			{
				$collect[] = call_user_func($callback, $item, $key);
			}
		}
		else
		{
			foreach ($items as $key => &$item)
			{
				if (
				    is_object($item) && (
				        method_exists($item, $callback) ||
				        isset($item->$callback)
				    )
				)
				{
					$collect[] = $item->$callback;
				}
				else
				{
					$collect[] = $item;
				}
			}
		}

		return new self($collect);
	}

	/**
	 * {@inheritdoc map()}
	 * @alias map()
	 */
	public function collect($callback)
	{
		return $this->map($callback);
	}

	/**
	 * Filters the list of nodes by passing each value in the current collection
	 * object through a function. The node will be removed from the results if
	 * the function returns `false`.
	 *
	 * For the opposite result, see {@see reject()}.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @todo Leverage array_filter() for better performance.
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return self A new collection containing the return values.
	 */
	public function filterBy($callback)
	{
		$items = $this->to_array();
		$collect = array();

		if (is_callable($callback))
		{
			foreach ($items as $key => $item)
			{
				if (call_user_func($callback, $item, $key))
				{
					$collect[$key] = $item;
				}
			}
		}
		else
		{
			foreach ($items as $key => &$item)
			{
				if (
				    is_object($item) && (
				        method_exists($item, $callback) ||
				        isset($item->$callback)
				    ) &&
				    $item->$callback
				)
				{
					$collect[$key] = $item;
				}
			}
		}

		return new self($collect);
	}

	/**
	 * {@inheritdoc filterBy()}
	 * @alias filterBy()
	 */
	public function findAll($callback)
	{
		return $this->filterBy($callback);
	}

	/**
	 * {@inheritdoc filterBy()}
	 * @alias filterBy()
	 */
	public function select($callback)
	{
		return $this->filterBy($callback);
	}

	/**
	 * Filters the list of nodes by passing each value in the current collection
	 * object through a function. The node will be removed from the results if
	 * the function returns `true`.
	 *
	 * For the opposite result, see <filterBy()>.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @todo Leverage array_filter() for better performance.
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return self A new collection containing the return values.
	 */
	public function reject($callback)
	{
		$items = $this->to_array();
		$collect = array();

		if (is_callable($callback))
		{
			foreach ($items as $key => $item)
			{
				if (!call_user_func($callback, $item, $key))
				{
					$collect[$key] = $item;
				}
			}
		}
		else
		{
			foreach ($items as $key => &$item)
			{
				if (!(
				    is_object($item) && (
				        method_exists($item, $callback) ||
				        isset($item->$callback)
				    ) &&
				    $item->$callback
				))
				{
					$collect[$key] = $item;
				}
			}
		}

		return new self($collect);
	}

	/**
	 * {@inheritdoc reject()}
	 * @alias reject()
	 */
	public function exclude($callback)
	{
		return $this->reject($callback);
	}

	/**
	 * Returns the largest value in the collection. Only scalar values are
	 * compared; non-scalars are ignored. String values rank higher than
	 * numeric values.
	 *
	 * Optionally, a callback function can be supplied. The results of the
	 * callback function will be used in the comparison.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @todo Leverage max() for better performance.
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return mixed The largest value in the collection, or the object
	 *     represented by the largest value in the collection.
	 */
	public function max($callback = null)
	{
		$callback = $callback ?:
			function($item) {
				return (is_scalar($item) ? $item : null);
			};

		$copy = clone $this;
		$copy->sort_by($callback);

		return $copy->last();
	}

	/**
	 * Returns the smallest value in the collection. Only scalar values are
	 * compared; non-scalars are ignored. Numeric values rank lower than string
	 * values.
	 *
	 * Optionally, a callback function can be supplied. The results of the
	 * callback function will be used in the comparison.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @todo Leverage min() for better performance.
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return mixed The smallest value in the collection, or the object
	 *     represented by the smallest value in the collection.
	 */
	public function min($callback = null)
	{
		$callback = $callback ?:
			function($item) {
				return (is_scalar($item) ? $item : null);
			};

		$copy = clone $this;
		$copy->sort_by($callback);

		return $copy->first();
	}

	/**
	 * Separates falsey values (e.g., false, null, 0, empty strings) from truthy
	 * values (everything else) and returns both sets.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return Collection A new collection containing two items: `truthy` and
	 *     `falsey`. Each of these is also a collection of matching values.
	 */
	public function partition($callback = null)
	{
		$truthy = array();
		$falsey = array();
		$callback = $callback ?:
			function($value, $key) {
				return (boolean) $value;
			};

		$this->rewind();
		while ($this->valid())
		{
			if (is_callable($callback))
			{
				if (call_user_func($callback, $this->current(), $this->key()))
				{
					$truthy[] = $this->current();
				}
				else
				{
					$falsey[] = $this->current();
				}
			}
			else
			{
				if (
					is_object($this->current()) && (
						method_exists($this->current(), $callback) ||
						isset($this->current()->$callback)
					)
				)
				{
					if ($this->current()->$callback)
					{
						$truthy[] = $this->current();
					}
					else
					{
						$falsey[] = $this->current();
					}
				}
				elseif ($this->current())
				{
					$truthy[] = $this->current();
				}
				else
				{
					$falsey[] = $this->current();
				}
			}

			$this->next();
		}

		return new self(array(
			'truthy' => new self($truthy),
			'falsey' => new self($falsey)
		));
	}

	/**
	 * Determines whether every single item passes the test provided by
	 * `$callback`. If any individual result returns `false`, it will
	 * immediately stop and return `false`.
	 *
	 * For the opposite result, see {@see any()}.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return boolean A value of `true` indicates that every item in the
	 *     collection passed the test. A value of false `false` indicates that
	 *     at least one item in the collection failed the provided test.
	 */
	public function every($callback)
	{
		$items = $this->to_array();

		if (is_string($callback))
		{
			return $this->ungrep($callback)->is_empty();
		}
		else
		{
			foreach ($items as $key => &$item)
			{
				if (call_user_func($callback, $item, $key) === false)
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * {@inheritdoc every()}
	 * @alias every()
	 */
	public function all($callback)
	{
		return $this->every($callback);
	}

	/**
	 * Determines whether at least one item passes the test provided by
	 * `$callback`. If any individual result returns `true`, it will immediately
	 * stop and return `true`.
	 *
	 * For the opposite result, see {@see every()}.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return boolean A value of `true` indicates that at least one item in the
	 *     collection passed the test. A value of `false` indicates that no
	 *     items in the collection passed the test.
	 */
	public function any($callback)
	{
		$items = $this->to_array();

		if (is_string($callback))
		{
			return !$this->grep($callback)->is_empty();
		}
		else
		{
			foreach ($items as $key => &$item)
			{
				if (call_user_func($callback, $item, $key) !== false)
				{
					return true;
				}
			}

			return false;
		}
	}

	/**
	 * Return the first item that passes the provided test.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @param mixed $fallback The fallback value to use for instances where
	 *     there is no match. The default value is `false`.
	 * @return mixed The first item in the collection that passes the test.
	 */
	public function find($callback, $fallback = false)
	{
		$this->rewind();

		while ($this->valid())
		{
			if (call_user_func($callback, $this->current(), $this->key()))
			{
				return $this->current();
			}

			$this->next();
		}

		return $fallback;
	}

	/**
	 * Compares the current collection to the passed collection to determine
	 * whether or not they are identical.
	 *
	 * If a callback function is used, it takes two parameters:
	 * * mixed `$collection` The collection to manipulate.
	 *
	 * @param Collection $collection A collection that should be compared
	 *     to the current collection.
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return boolean Whether or not the current collection is identical to the
	 *     passed collection.
	 */
	public function is(Collection $collection, $callback = 'serialize')
	{
		$_this = is_callable($callback) ?
			call_user_func($callback, $this) :
			$this->$callback;

		$_collection = is_callable($callback) ?
			call_user_func($callback, $collection) :
			$collection->$callback;

		return ($_this === $_collection);
	}

	/**
	 * {@inheritdoc is()}
	 * @alias is
	 */
	public function identicalTo(Collection $collection, $callback = 'serialize')
	{
		return $this->is($collection, $callback);
	}

	/**
	 * Find the duplicate values between two collections.
	 *
	 * @param Collection $collection A collection that should be compared to the
	 *     current collection.
	 * @return Collection A collection containing the items that are duplicated
	 *     between both collections.
	 */
	public function intersect(Collection $collection)
	{
		$primary_collection = $this->to_array();
		$secondary_collection = $collection->to_array();

		return new self(
			array_intersect($primary_collection, $secondary_collection)
		);
	}

	/**
	 * Find the different values between two collections.
	 *
	 * @param Collection $collection A collection that should be compared to the
	 *     current collection.
	 * @return Collection A collection containing the items that are different
	 *     between both collections.
	 */
	public function diff(Collection $collection)
	{
		$primary_collection = $this->to_array();
		$secondary_collection = $collection->to_array();

		$diff_from_first = new self(
			array_diff($primary_collection, $secondary_collection)
		);

		$diff_from_second = new self(
			array_diff($secondary_collection, $primary_collection)
		);

		return $diff_from_first->merge($diff_from_second)->unique();
	}

	/**
	 * Returns a new collection by joining this collection with another
	 * collection, removing duplicates. Accepts one or more (1..n) parameters.
	 *
	 * @param Collection $collection A collection to join with the current
	 *     collection.
	 * @return Collection A new collection containing the unionized collections.
	 */
	public function union(Collection $collection)
	{
		$arguments = func_get_args();
		$merged = call_user_func_array(array($this, 'merge'), $arguments);

		return $merged->unique()->reindex();
	}


	/*%*********************************************************************%*/
	// SELECTABLE METHODS

	/**
	 * Gets the first result (or first set of results) in the collection.
	 *
	 * For the opposite result, see {@see last()}.
	 *
	 * @param integer $count The number of indicies to return from the beginning
	 *     of the collection.
	 * @return mixed The first result in the collection. Returns `false` if
	 *     there are no items in the collection.
	 */
	public function first($count = 1)
	{
		$collection = $this->to_array();

		if ($count > 1)
		{
			return new self(array_slice($collection, 0, $count));
		}
		elseif (!$this->is_empty())
		{
			$this->rewind();
			return $this->current();
		}

		return null;
	}

	/**
	 * Gets the first key (or first set of key) in the collection.
	 *
	 * For the opposite result, see {@see lastKey()}.
	 *
	 * @param integer $count The number of keys to return from the beginning of
	 *     the collection.
	 * @return mixed The first key in the collection. Returns `false` if there
	 *     are no items in the collection.
	 */
	public function firstKey($count = 1)
	{
		return self::factory(array_keys($this->to_array()))->first($count);
	}

	/**
	 * Gets the last result (or last set of results) in the collection.
	 *
	 * For the opposite result, see {@see first()}.
	 *
	 * @param integer $count The number of indicies to return from the end of
	 *     the collection.
	 * @return mixed The last result in the collection. Returns `false` if there
	 *     are no items in the collection.
	 */
	public function last($count = 1)
	{
		if ($count > 1)
		{
			return new self(array_slice($this->to_array(), ($count * -1)));
		}
		elseif (!$this->is_empty())
		{
			$items = $this->to_array();
			return $this->count() ? end($items) : false;
		}

		return null;
	}

	/**
	 * Gets the last key (or last set of keys) in the collection.
	 *
	 * For the opposite result, see {@see firstKey()}.
	 *
	 * @param integer $count The number of keys to return from the end of the
	 *     collection.
	 * @return mixed The last key in the collection. Returns `false` if there
	 *     are no items in the collection.
	 */
	public function lastKey($count = 1)
	{
		return self::factory(array_keys($this->to_array()))->last($count);
	}

	/**
	 * Applies a PCRE regular expression pattern to each of the items in the
	 * collection and returns a new collection containing all matching items.
	 *
	 * Only applies to values that are strings.
	 *
	 * For the opposite result, see {@see ungrep()}.
	 *
	 * @param string $pattern A regular expression to test the item with.
	 * @param boolean $test_key Test the key instead of the value.
	 * @return Collection A collection containing all matching items.
	 */
	public function grep($pattern, $test_key = false)
	{
		$collect = array();
		$collection = $this->to_array();

		foreach ($collection as $key => $item)
		{
			if (preg_match($pattern, ($test_key ? $key: $item)))
			{
				$collect[$key] = $item;
			}
		}

		return new self($collect);
	}

	/**
	 * Applies a PCRE regular expression pattern to each of the items in the
	 * collection and returns a new collection containing all non-matching items.
	 *
	 * Only applies to values that are strings.
	 *
	 * For the opposite result, see {@see grep()}.
	 *
	 * @param string $pattern A regular expression to test the item with.
	 * @param boolean $test_key Test the key instead of the value.
	 * @return Collection A collection containing all non-matching items.
	 */
	public function ungrep($pattern, $test_key = false)
	{
		$collect = array();
		$collection = $this->to_array();

		foreach ($collection as $key => $item)
		{
			if (!preg_match($pattern, ($test_key ? $key: $item)))
			{
				$collect[$key] = $item;
			}
		}

		return new self($collect);
	}

	/**
	 * Applies a PCRE regular expression pattern to each of the keys in the
	 * collection and returns a new collection containing all matching items.
	 *
	 * Only applies to values that are strings.
	 *
	 * For the opposite result, see {@see ungrepKey()}.
	 *
	 * @param string $pattern A regular expression to test the key with.
	 * @return Collection A collection containing all matching items.
	 */
	public function grepKey($pattern)
	{
		return $this->grep($pattern, true);
	}

	/**
	 * Applies a PCRE regular expression pattern to each of the keys in the
	 * collection and returns a new collection containing all non-matching items.
	 *
	 * Only applies to values that are strings.
	 *
	 * For the opposite result, see {@see grepKey()}.
	 *
	 * @param string $pattern A regular expression to test the key with.
	 * @return Collection A collection containing all non-matching items.
	 */
	public function ungrepKey($pattern)
	{
		return $this->ungrep($pattern, true);
	}


	/*%*********************************************************************%*/
	// SUBSET METHODS

	/**
	 * Extract a slice of the collection.
	 *
	 * @param integer $begin If `$begin` is a positive number, the slice will
	 *     begin at that position in the collection. If `$begin` is a negative
	 *     number, the slice will begin in that position from the end of the
	 *     collection.
	 * @param integer $length If `$length` is given and is a positive number,
	 *     the slice will have that many items in it. If `$length` is given and
	 *     is a negative number, the slice will stop that many items from the
	 *     end of the collection. If it is omitted, the slice will have
	 *     everything from `$begin` up until the end of the collection.
	 * @param boolean $preserve By default, the resulting collection is
	 *     reindexed. This behavior can be changed by setting `$preserve` to
	 *     `true`.
	 * @return mixed The last result in the collection. Returns `false` if there
	 *     are no items in the collection.
	 */
	public function slice($begin, $length = null, $preserve = false)
	{
		return new self(
			array_slice($this->to_array(), $begin, $length, $preserve)
		);
	}

	/**
	 * Group items by a shared value. For example, if all items have a
	 * `status()` method, and "status" is passed as the parameter, the items
	 * will be grouped by their statuses (e.g., starting, available,
	 * shutting-down, terminated).
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return Collection A collection containing a set of sub-collections, each
	 *     of which containing groups of items.
	 */
	public function groupBy($callback)
	{
		$collect = array();

		foreach ($this as $k => &$item)
		{
			if (is_callable($callback))
			{
				$key = call_user_func($callback, $item, $k);
			}
			elseif (
				is_object($item) && (
					method_exists($item, $callback) ||
					isset($item->$callback)
				)
			)
			{
				$key = $item->$callback;
			}

			$key = !is_string($key) ? serialize($key) : $key;

			if (!isset($collect[$key]))
			{
				$collect[$key] = new self(array());
			}

			$collect[$key][] = $item;
		}

		return new self($collect);
	}


	/*%*********************************************************************%*/
	// DESTRUCTIVE METHODS

	/**
	 * Removes all `null` values from a collection.
	 *
	 * @return Collection The collection with falsey values removed.
	 */
	public function compress()
	{
		return array_filter($this->collection->getArrayCopy());
	}

	/**
	 * Reindexes the collection, starting from zero.
	 *
	 * @return Collection The collection with indexes starting at zero.
	 */
	public function reindex()
	{
		return array_values($this->collection->getArrayCopy());
	}

	/**
	 * Flattens all arrays in the collection. Objects and scalar values are not
	 * modified. The original keys are **not** preserved.
	 *
	 * Performing a _deep_ flattening will also flatten any {@see php:Object}
	 * that implements the {@see php:Traversable} interface. This includes
	 * {@see php:ArrayObject}, {@see php:ArrayIterator}, and all
	 * {@see php:SPL.Iterators}, as well as all instances of `Collection`.
	 *
	 * @param boolean $deep Whether or not to perform a deep flattening of the
	 *     collection. A value of `true` will flatten all arrays and
	 *     implementations of the `Traversable` interface. A value of `false`
	 *     will limit the flattening to arrays. The default value is `false`.
	 * @return Collection The collection with all flattenable entities flattened
	 *     and indexes starting at zero.
	 */
	public function flatten($deep = false)
	{
		$collection = $this->collection->getArrayCopy();
		$flattened = array();

		$make_flat = $deep ?
			function($item) use (&$flattened, &$make_flat)
			{
				if (
					is_object($item) &&
					$item instanceof Traversable
				)
				{
					array_walk_recursive($item, $make_flat);
				}
				else
				{
					$flattened[] = $item;
				}
			} :
			function($item) use (&$flattened)
			{
				$flattened[] = $item;
			};

		return new self(array_walk_recursive($collection, $make_flat));
	}

	/**
	 * Push one or more elements onto the end of the collection. Accepts one or
	 * more (1..n) parameters.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * For the opposite result, see {@see pop()}.
	 *
	 * @param mixed $value An entry to push onto the end of the collection.
	 * @return Collection A new collection with the pushed items appended.
	 */
	public function push($value)
	{
		$arguments = func_get_args();

		foreach ($arguments as $argument)
		{
			$this[] = $argument;
		}

		return $this;
	}

	/**
	 * Remove one item from the end of a collection and return it.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * For the opposite result, see {@see push()}.
	 *
	 * @return mixed The last item from the collection.
	 */
	public function pop()
	{
		$last = $this->last();
		$this->remove($this->last_key());

		return $last;
	}

	/**
	 * Remove one item from the end of a collection and return the remainder of
	 * the collection.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * @return Collection The collection with the remaining items.
	 */
	public function popped()
	{
		$this->remove($this->last_key());
		return $this;
	}

	/**
	 * Push one or more elements onto the beginning of the collection. Accepts
	 * one or more (1..n) parameters.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * For the opposite result, see {@see shift()}.
	 *
	 * @param mixed $value An entry to push onto the beginning of the collection.
	 * @return Collection The collection with the unshifted items prepended.
	 */
	public function unshift($value)
	{
		$arguments = func_get_args();
		$collection = $this->collection->getArrayCopy();

		foreach ($arguments as $argument)
		{
			array_unshift($collection, $argument);
		}

		$this->collection = new ArrayObject($collection, ArrayObject::ARRAY_AS_PROPS);
		$this->iterator = $this->collection->getIterator();

		return $this;
	}

	/**
	 * Remove one item from the beginning of a collection and return it.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * For the opposite result, see {@see unshift()}.
	 *
	 * @return mixed The first item from the collection.
	 */
	public function shift()
	{
		$collection = $this->to_array();
		$first = array_shift($collection);

		$this->collection = new ArrayObject($collection, ArrayObject::ARRAY_AS_PROPS);
		$this->iterator = $this->collection->getIterator();

		return $first;
	}

	/**
	 * Remove one item from the beginning of a collection and return the
	 * remainder of the collection.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * @return Collection The collection with the remaining items.
	 */
	public function shifted()
	{
		$collection = $this->to_array();
		array_shift($collection);

		$this->collection = new ArrayObject($collection, ArrayObject::ARRAY_AS_PROPS);
		$this->iterator = $this->collection->getIterator();

		return $this;
	}

	/**
	 * Remove all duplicate values from the collection.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * @return Collection The collection with all duplicate values removed.
	 */
	public function unique()
	{
		return array_unique($this->collection->getArrayCopy(), SORT_REGULAR);
	}

	/**
	 * Sort a collection by a specific property.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * This is a _destructive_ action, and will alter the original collection.
	 *
	 * NOTE: If two members compare as equal, their order in the sorted array is
	 * undefined.
	 *
	 * @param string|callable $callback In order of priority: A custom callback
	 *     function, a global function, a parameter-less method to call on the
	 *     item, or a property of the item -- the return value of which will be
	 *     added to the returning collection.
	 * @return Collection A new collection containing the return values.
	 */
	public function sortBy($callback)
	{
		$array_copy = $this->collection->getArrayCopy();

		$keys = is_callable($callback) ?
			($this->map($callback)) :
			(
				$this->map(function($item) use (&$callback)
				{
					if (
						is_object($item) && (
							method_exists($item, $callback) ||
							isset($item->$callback)
						)
					)
					{
						return $item->$callback;
					}
					elseif (is_array($item))
					{
						if (count($item) > 0 && isset($item[0]))
						{
							return $item[0];
						}
						elseif (count($item) > 0 && !isset($item[0]))
						{
							$keys = array_keys($item);
							return $item[$keys[0]];
						}
						else
						{
							return '';
						}
					}

					return $item;
				})
			);

		$sortable = array_combine($keys->to_array(), $array_copy);

		uksort($sortable, function($a, $b)
		{
			$a = strtolower($a);
			$b = strtolower($b);

			if ($a == $b)
			{
				// @codeCoverageIgnoreStart
				return 0;
				// @codeCoverageIgnoreEnd
			}

			return ($a > $b) ? 1 : -1;
		});

		return new self($sortable);
	}

	/**
	 * Reverse the order of the contents of the collection.
	 *
	 * @param boolean $preserve_keys A value of `true` will preserve the order
	 *     of the keys. A value of `false` will not.
	 * @return Collection A collection with the contents in the reverse order.
	 */
	public function reverse($preserve_keys = false)
	{
		return new self(array_reverse($this->to_array(), $preserve_keys));
	}

	/**
	 * Shuffles the contents by placing them in a randomized order.
	 *
	 * @return Collection A new collection with the contents shuffled.
	 */
	public function shuffle()
	{
		$list = $this->to_array();
		shuffle($list);
		return new self($list);
	}

	/**
	 * Merge one or more collections into the current collection. Accepts one or
	 * more (1..n) parameters.
	 *
	 * @param Collection $collection A collection whose items should be appended
	 *     to the current collection.
	 * @return Collection A new collection containing the merged collections.
	 */
	public function merge(Collection $collection)
	{
		$first_collection = $this->collection->getArrayCopy();
		$arguments = func_get_args();

		foreach ($arguments as $collection)
		{
			foreach ($collection as $key => $item)
			{
				if (is_string($key))
				{
					$first_collection[$key] = $item;
				}
				else
				{
					$first_collection[] = $item;
				}
			}
		}

		return new self($first_collection);
	}


	/*%*********************************************************************%*/
	// FINDING METHODS

	/**
	 * Checks whether a collection is empty or not.
	 *
	 * @return boolean A value of `true` indicates that the collection is empty.
	 *     A value of `false` indicates that the collection is not empty.
	 */
	public function isEmpty()
	{
		return (boolean) !$this->count();
	}

	/**
	 * Checks whether any truthy values exist in the collection, and if not
	 * returns `true` (i.e., yes, there are none).
	 *
	 * @return boolean A value of `true` indicates that there are no truthy
	 *     values in the collection. A value of `false` indicates that there are
	 *     one or more truthy values in the collection.
	 */
	public function none()
	{
		return $this->partition()->truthy->is_empty();
	}

	/**
	 * Checks whether there is only truthy value in the collection, and if so
	 * returns `true`.
	 *
	 * @return boolean A value of `true` indicates that there is only one truthy
	 *     value in the collection. A value of `false` indicates that there zero
	 *     or two or more truthy values in the collection.
	 */
	public function one()
	{
		return ($this->partition()->truthy->count() === 1);
	}

	/**
	 * Returns a list of all of the keys in the collection.
	 *
	 * @return Collection A collection containing all of the keys in the
	 *     original collection.
	 */
	public function keys()
	{
		return new self(array_keys($this->to_array()));
	}

	/**
	 * Checks whether the collection contains one or more specific items. If
	 * testing multiple items, the collection must contain _all_ of them in
	 * order to return `true`. Accepts one or more (1..n) parameters.
	 *
	 * @todo Leverage array_filter() for better performance.
	 * @param mixed $item (Required) The item to check for inside the collection.
	 * @return boolean A value of `true` indicates that the item(s) exist(s) in
	 *     the collection. A value of `false` indicates that one or more of the
	 *     items are missing from the collection.
	 */
	public function has($item)
	{
		$arguments = func_get_args();
		$items = $this->to_array();

		foreach ($arguments as $argument)
		{
			if (!in_array($argument, $items))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Checks whether the collection contains one or more specific keys. If
	 * testing multiple keys, the collection must contain _all_ of them in order
	 * to return `true`. Accepts one or more (1..n) parameters.
	 *
	 * @todo Leverage array_filter() for better performance.
	 * @param mixed $key (Required) The key to check for inside the collection.
	 * @return boolean A value of `true` indicates that the key(s) exist(s) in
	 *     the collection. A value of `false` indicates that one or more of the
	 *     items are missing from the collection.
	 */
	public function hasKey($key)
	{
		$arguments = func_get_args();
		$keys = array_keys($this->to_array());

		foreach ($arguments as $argument)
		{
			if (!in_array($argument, $keys))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Searches the collection for a given value and returns the corresponding
	 * key if successful.
	 *
	 * Whereas {@see index_of()} and {@see last_index_of()} return single values,
	 * it returns a collection of all matching values.
	 *
	 * @todo Leverage array_search() for better performance.
	 * @param mixed $value The value to check for inside the collection.
	 * @return Collection If the item value is found, a collection containing
	 *     the corresponding key will be returned. If the value is found more
	 *     than once, an collection of key names will be returned. If the item
	 *     value is not found, the method will return an empty collection.
	 */
	public function search($value)
	{
		$collection = $this->to_array();
		$keys = array_keys($collection, $value);

		if (count($keys) > 1)
		{
			return new self($keys);
		}
		elseif (count($keys) === 1)
		{
			return new self(array($keys[0]));
		}

		return new self(array());
	}

	/**
	 * Searches the collection for a given value and returns the corresponding
	 * key for the first match if successful.
	 *
	 * Whereas {@see search()} returns a collection of all matching values,
	 * it returns a single value for the first match.
	 *
	 * @param mixed $value The value to check for inside the collection.
	 * @return mixed If the item value is found, the corresponding key for the
	 *     first match will be returned. If the item value is not found, the
	 *     method will return `null`.
	 */
	public function indexOf($value)
	{
		return $this->search($value)->first();
	}

	/**
	 * Searches the collection for a given value and returns the corresponding
	 * key for the last match if successful.
	 *
	 * Whereas {@see search()} returns a collection of all matching values,
	 * it returns a single value for the last match.
	 *
	 * @param mixed $value The value to check for inside the collection.
	 * @return mixed If the item value is found, the corresponding key for the
	 *     last match will be returned. If the item value is not found, the
	 *     method will return `null`.
	 */
	public function lastIndexOf($value)
	{
		return $this->search($value)->last();
	}


	/*%*********************************************************************%*/
	// STRINGIFICATION METHODS

	/**
	 * Merges all items in the collection together as a string, delimited by
	 * `$delimiter`. Optionally, you can pass a callback function as the final
	 * argument. This callback function will be applied to each item in the
	 * collection prior to producing the string.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param string $delimiter The delimiting string to use when joining the
	 *     collection's items together as a string.
	 * @return string Returns a string containing a string representation of all
	 *     the array elements in the same order, with the delimiter string
	 *     between each element.
	 */
	public function join($delimiter = '')
	{
		$arguments = new self(func_get_args());
		$callback = function($value) { return $value; };

		if (is_callable($arguments->last()))
		{
			$callback = $arguments->pop();
		}

		$delimiter = '';
		if ($arguments->exists(0))
		{
			$delimiter = $arguments->get(0);
		}

		$list = $this->map($callback);
		return implode($delimiter, $list->to_array());
	}

	/**
	 * Converts a list of strings into an English-formatted sentence. Default
	 * settings avoid using the Oxford comma at the end of the list.
	 *
	 * Optionally, you can pass a callback function as the final argument. This
	 * callback function will be applied to each item in the collection prior to
	 * producing the sentence.
	 *
	 * The callback function takes two parameters:
	 * * mixed `$value` The value of the item in the collection.
	 * * mixed `$key`   The key for the item in the collection.
	 *
	 * @param array $options A set of options that can be used to alter the
	 *     sentence.
	 * * string `word_separator` A delimiter between all words except for the
	 *       second-to-last and the last. Requires three or more items in the
	 *       collection in order to be used. The default value is `, `.
	 * * string `last_word_separator` A delimiter between second-to-last and
	 *       the last words. Requires two or more items in the collection in
	 *       order to be used. The default value is ` and `.
	 * @return string An English sentence of the list of string items.
	 */
	public function toSentence($options = array())
	{
		$word_separator = ', ';
		$last_word_separator = ' and ';

		$arguments = new self(func_get_args());
		$callback = function($value) { return $value; };

		if (is_callable($arguments->last()))
		{
			$callback = $arguments->pop();
		}

		if ($arguments->exists(0) && is_array($arguments->get(0)))
		{
			extract($options);
		}

		$items = $this->map($callback);
		$last = $items->pop();

		if (count($items) > 0 && $last)
		{
			return $items->join($word_separator) . $last_word_separator . $last;
		}
		elseif ($items->count() === 0 && $last)
		{
			return $last;
		}
		else // 0
		{
			return '';
		}
	}


	/*%*********************************************************************%*/
	// MERGE METHODS FOR OTHER TYPES

	/**
	 * Merges the contents of a standard array into the collection. Performs a
	 * deep conversion.
	 *
	 * @param array $array The standard array to merge into the collection.
	 * @return Collection A new collection containing the merged data.
	 */
	public function mergeArray(array $array)
	{
		return $this->merge(new self($array, true));
	}

	/**
	 * Merges the contents of a JSON document into the collection. Performs a
	 * deep conversion.
	 *
	 * @param string $json The JSON document to merge into the collection.
	 * @return Collection A new collection containing the merged data.
	 */
	public function mergeJSON($json)
	{
		$array = json_decode($json, true);
		return $this->merge(new self($array, true));
	}

	/**
	 * Merges the contents of a {@see php:stdClass} object into the collection.
	 * Performs a deep conversion.
	 *
	 * @param stdClass $stdclass The `stdClass` object to merge into the
	 *     collection.
	 * @return Collection A new collection containing the merged data.
	 */
	public function mergeStdClass(stdClass $stdclass)
	{
		$array = json_decode(json_encode($stdclass), true);
		return $this->merge(new self($array, true));
	}


	/*%*********************************************************************%*/
	// CREATE FROM OTHER TYPES

	/**
	 * Creates a collection from a JSON document. Performs a deep conversion.
	 *
	 * @param string $json The JSON document to create the collection from.
	 * @return Collection A new collection that represents the input data.
	 */
	public static function fromJSON($json)
	{
		$array = json_decode($json, true);
		return new self($array, true);
	}

	/**
	 * Creates a collection from a {@see php:stdClass} object. Performs a deep
	 * conversion.
	 *
	 * @param stdClass $stdclass The `stdClass` object to merge into the
	 *     collection, as a string.
	 * @return Collection A new collection that represents the input data.
	 */
	public static function fromStdClass(stdClass $stdclass)
	{
		$array = json_decode(json_encode($stdclass), true);
		return new self($array, true);
	}
}
