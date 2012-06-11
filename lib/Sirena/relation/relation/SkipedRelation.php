<?php

namespace Sirena\relation\relation;

use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;
use \EmptyIterator;

/**
* Class that represents a prjected relation
*/
class SkipedRelation extends BaseRelation
{
	/**
	 * The relation from where to project the data
	 * @var RelationInterface
	 */
	private $innerRelation;

	/**
	 * Constructor
	 * @param RelationInterface     $innerRelation 
	 * @param int                   $offset
	 * @param DataProviderInterface $dataProvider  
	 */
	public function __construct(RelationInterface $innerRelation, $offset, DataProviderInterface $dataProvider) {
		parent::__construct($innerRelation->getAttributeSet(), $dataProvider);
		$this->innerRelation = $innerRelation;
		$this->offset = $offset;
	}

	/**
	 * Returns the relation from where the projection is applied
	 * @return RelationInterface 
	 */
	public function getInnerRelation() {
		return $this->innerRelation;
	}

	/**
	 * Returns the offset
	 * @return int offset
	 */
	public function getOffset() {
		return $this->offset;
	}
}