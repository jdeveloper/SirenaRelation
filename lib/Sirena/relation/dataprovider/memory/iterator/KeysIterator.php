<?php

namespace Sirena\relation\dataprovider\memory\iterator;

use \FilterIterator;
use \Iterator;

/**
* Iterator that return only the given keys
*/
class KeysIterator extends FilterIterator
{
	private $keys;

	/**
	 * [__construct description]
	 * @param Iterator $iterator The inner iterator
	 * @param array    $keys     The keys to be accepted
	 */
	function __construct(Iterator $iterator, array $keys) {	
		parent::__construct($iterator);
		$this->keys = $keys;
	}

	public function accept() {
		return in_array($this->key(), $this->keys);
	}
}