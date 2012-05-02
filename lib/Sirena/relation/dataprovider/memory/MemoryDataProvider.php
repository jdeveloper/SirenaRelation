<?php

namespace Sirena\relation\dataprovider\memory;

use \Countable;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\relation\ProjectedRelation;
use Sirena\relation\dataprovider\DataProviderInterface;
use Sirena\relation\dataprovider\memory\iterator\KeysIterator;
use Sirena\relation\dataprovider\memory\iterator\ProjectedRelationIterator;
use Sirena\relation\dataprovider\memory\extractor\BaseRelationExtractor;
use Sirena\relation\dataprovider\memory\extractor\ProjectedRelationExtractor;

use \Iterator;
use EmptyIterator;
use ArrayObject;


/**
* Memory data provider
*/
class MemoryDataProvider implements Countable, DataProviderInterface
{
	private $data;
	private $extractors;

	/**
	 * constructor
	 * @param arraya data
	 */
	function __construct($data = array())
	{
		$this->data = $data;

		$this->extractors = array(
									new ProjectedRelationExtractor(),
									new BaseRelationExtractor()
								 );
	}

	/**
	 * Counts the number of rows
	 * @return int 
	 */
	public function count() {
		return count($this->data);
	}

	/**
	 * Returns the data
	 * @return array data
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Return the data that validate the conditions of the given relation
	 * @param  RelationInterface $relation 
	 * @return Iterator
	 */
	public function read(RelationInterface $relation) {
		foreach ($this->extractors as $extractor) {
			if( $extractor->canHandle($relation) ) {
				return $extractor->read($relation);
			}
		}
	}
}