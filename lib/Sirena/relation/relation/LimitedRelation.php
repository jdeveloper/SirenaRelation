<?php

namespace Sirena\relation\relation;

use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;
use \EmptyIterator;

/**
* Class that represents a prjected relation
*/
class LimitedRelation extends BaseRelation
{
	/**
	 * The relation from where to project the data
	 * @var RelationInterface
	 */
	private $innerRelation;

	/**
	 * Constructor
	 * @param RelationInterface     $innerRelation 
	 * @param int                   $limit
	 * @param DataProviderInterface $dataProvider  
	 */
	public function __construct(RelationInterface $innerRelation, $limit, DataProviderInterface $dataProvider) {
		parent::__construct($innerRelation->getAttributeSet(), $dataProvider);
		$this->innerRelation = $innerRelation;
		$this->limit = $limit;
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
	public function getLimit() {
		return $this->limit;
	}
}