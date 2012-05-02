<?php

namespace Sirena\relation\dataprovider\memory\extractor;

use Sirena\relation\relation\ProjectedRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\dataprovider\memory\iterator\ProjectedRelationIterator;
use \EmptyIterator;

/**
* Abstract extractor
*/
abstract class AbstractRelationExtractor
{
	/**
	 * Returns if the extractor can handle de relation
	 * @param  RelationInterface $relation 
	 * @return boolean
	 */
	abstract public function canHandle(RelationInterface $relation);

	/**
	 * Return the projected columns of the given relation
	 * @param  RelationInterface $relation 
	 * @return Iterator
	 */
	public function read(RelationInterface $relation) {
		$dataProvider = $relation->getDataProvider();

		if( count($dataProvider) === 0 ) {
			return new EmptyIterator();
		} else {
			return $this->doRead($relation);
		}
	}

	abstract protected function doRead(RelationInterface $relation);
}