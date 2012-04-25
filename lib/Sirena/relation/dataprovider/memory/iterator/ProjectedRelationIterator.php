<?php

namespace Sirena\relation\dataprovider\memory\iterator;

use Sirena\relation\relation\RelationInterface;
use Sirena\relation\dataprovider\memory\iterator\KeysIterator;
use \IteratorIterator;
use \ArrayIterator;

/**
* Iterator that return only the given keys
*/
class ProjectedRelationIterator extends IteratorIterator
{
	private $indexes;

	/**
	 * [__construct description]
	 * @param Iterator $iterator The inner iterator
	 * @param array    $keys     The keys to be accepted
	 */
	function __construct($relation, array $keys) {	
		parent::__construct($relation->getIterator());
		$this->indexes = $relation->getAttributeSet()->indexesOfNames($keys);
	}

	public function current() {
		$current = new ArrayIterator(parent::current());
		return new KeysIterator($current, $this->indexes);
	}
}