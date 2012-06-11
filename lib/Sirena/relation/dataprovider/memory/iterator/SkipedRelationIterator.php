<?php

namespace Sirena\relation\dataprovider\memory\iterator;

use \FilterIterator;
use \Iterator;

/**
* Iterator that return only the given keys
*/
class SkipedRelationIterator extends FilterIterator
{
	private $offset;

	/**
	 * [__construct description]
	 * @param Iterator $iterator The inner iterator
	 * @param array    $keys     The keys to be accepted
	 */
	function __construct(Iterator $iterator, $offset) {	
		parent::__construct($iterator);
		$this->offset = $offset;
	}

	public function accept() {
		return $this->offset <= (int)$this->key();
	}
}