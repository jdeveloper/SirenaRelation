<?php

namespace Sirena\relation\relation;

use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;
use \EmptyIterator;

/**
* Class that represents a prjected relation
*/
class ProjectedRelation extends BaseRelation
{
	/**
	 * The relation from where to project the data
	 * @var RelationInterface
	 */
	private $innerRelation;

	/**
	 * Constructor
	 * @param RelationInterface     $innerRelation 
	 * @param AttributeSet          $attributeSet  
	 * @param DataProviderInterface $dataProvider  
	 */
	public function __construct(RelationInterface $innerRelation, AttributeSet $attributeSet, DataProviderInterface $dataProvider)
	{
		parent::__construct($attributeSet, $dataProvider);
		$this->innerRelation = $innerRelation;
	}

	/**
	 * Returns the relation from where the projection is applied
	 * @return RelationInterface 
	 */
	public function getInnerRelation() {
		return $this->innerRelation;
	}
}