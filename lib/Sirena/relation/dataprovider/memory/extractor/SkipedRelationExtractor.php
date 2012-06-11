<?php

namespace Sirena\relation\dataprovider\memory\extractor;

use Sirena\relation\relation\SkipedRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\dataprovider\memory\iterator\SkipedRelationIterator;
use \EmptyIterator;

/**
* Extracts projected columns
*/
class SkipedRelationExtractor extends AbstractRelationExtractor
{
	/**
	 * Returns if the extractor can handle de relation
	 * @param  RelationInterface $relation 
	 * @return boolean
	 */
	public function canHandle(RelationInterface $relation) {
		return $relation instanceof SkipedRelation;
	}

	protected function doRead(RelationInterface $relation) {
		$dataprovider = $relation->getInnerRelation()->getDataProvider();

		if(count($dataprovider) < $relation->getOffset()) {
			return new EmptyIterator();
		}

		return new SkipedRelationIterator($relation->getInnerRelation()->getIterator()->getIterator(), $relation->getOffset());
	}
}