<?php

namespace Sirena\relation\dataprovider\memory\extractor;

use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\RelationInterface;
use \EmptyIterator;
use \ArrayObject;

/**
* Extracts all data
*/
class BaseRelationExtractor extends AbstractRelationExtractor
{
	/**
	 * Returns if the extractor can handle de relation
	 * @param  RelationInterface $relation 
	 * @return boolean
	 */
	public function canHandle(RelationInterface $relation) {
		return $relation instanceof BaseRelation;
	}

	protected function doRead(RelationInterface $relation) {
		return new ArrayObject($relation->getDataProvider()->getData());
	}
}