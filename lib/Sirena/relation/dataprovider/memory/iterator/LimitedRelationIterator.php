<?php

namespace Sirena\relation\dataprovider\memory\iterator;

use \FilterIterator;
use \Iterator;

/**
* Iterator that return as maximum the number of items specified in limit
*/
class LimitedRelationIterator extends FilterIterator
{
	private $limit;
	private $currentOffset;

	/**
	 * [__construct description]
	 * @param Iterator $iterator The inner iterator
	 * @param array    $keys     The keys to be accepted
	 */
	function __construct(Iterator $iterator, $limit) {	
		parent::__construct($iterator);
		$this->limit = $limit;
		$this->currentOffset = 0;
	}

	public function accept() {
		return $this->currentOffset++ < $this->limit;
	}
}