<?php

namespace Sirena\relation\dataprovider\memory\extractor;

use Sirena\relation\relation\ProjectedRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\dataprovider\memory\iterator\ProjectedRelationIterator;
use \EmptyIterator;

/**
* Extracts projected columns
*/
class ProjectedRelationExtractor extends AbstractRelationExtractor
{
	/**
	 * Returns if the extractor can handle de relation
	 * @param  RelationInterface $relation 
	 * @return boolean
	 */
	public function canHandle(RelationInterface $relation) {
		return $relation instanceof ProjectedRelation;
	}

	protected function doRead(RelationInterface $relation) {
		return new ProjectedRelationIterator($relation->getInnerRelation(), $relation->getAttributeSet()->getKeys());
	}
}