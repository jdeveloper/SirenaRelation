<?php

namespace Sirena\relation\relation;

use Sirena\relation\collection\AttributeSet;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\dataprovider\DataProviderInterface;
use \Iterator;

/**
* Class that representes the base relation
*/
class BaseRelation implements RelationInterface
{
	private $attributeSet;
	private $dataProvider;

	/**
	 * Constructor
	 * @param AttributeSet $attributeSet The attribute set
	 */
	function __construct(AttributeSet $attributeSet = null, DataProviderInterface $dataProvider)
	{
		$this->attributeSet = $attributeSet;
		$this->dataProvider = $dataProvider;
	}

	/**
	 * Returns the attribute set
	 * @return AttributeSet 
	 */
	public function getAttributeSet() {
		return $this->attributeSet;
	}

	/**
	 * returns the date provider
	 * @return DataProviderInterface The data provider
	 */
	public function getDataProvider() {
		return $this->dataProvider;
	}

	/**
	 * Returns an iterator to iterate the data
	 * @return Iterator 
	 */
	public function getIterator() {
		return$this->getDataProvider()->read($this);
	}

	/**
	 * Projects the relation
	 * @param  array  $attributes Attributes to be projectedd
	 * @return ProjectedRelation  A projected relation
	 */
	public function project(array $attributes) {
		return new ProjectedRelation($this, $this->getAttributeSet()->project($attributes), $this->dataProvider);
	}

	/**
	 * Skips records
	 * @param  int records to skip
	 * @return SkipedRelation  A skiped relation
	 */
	public function skip($offset) {
		return new SkipedRelation($this, $offset, $this->dataProvider);
	}
}