<?php

namespace Sirena\relation\dataprovider\memory\extractor;

use Sirena\relation\relation\LimitedRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\dataprovider\memory\iterator\LimitedRelationIterator;
use \EmptyIterator;

/**
* Extracts Limited relations
*/
class LimitedRelationExtractor extends AbstractRelationExtractor
{
	/**
	 * Returns if the extractor can handle de relation
	 * @param  RelationInterface $relation 
	 * @return boolean
	 */
	public function canHandle(RelationInterface $relation) {
		return $relation instanceof LimitedRelation;
	}

	protected function doRead(RelationInterface $relation) {
		if($relation->getLimit() == 0) {
			return new EmptyIterator();
		}

		return new LimitedRelationIterator($relation->getInnerRelation()->getIterator()->getIterator(), $relation->getLimit());
	}
}