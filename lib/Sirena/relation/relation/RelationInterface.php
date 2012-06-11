<?php

namespace Sirena\relation\relation;

use \IteratorAggregate;

/**
 * Represents the interface of a relacion
 */
interface RelationInterface extends IteratorAggregate
{
	/**
	 * Projects the relation
	 * @param  array  $attributes Attributes to be projectedd
	 * @return ProjectedRelation  A projected relation
	 */	
	public function project(array $attributes);

	/**
	 * Returns the data provider
	 * @return DataProviderInterface 
	 */
	public function getDataProvider();

	/**
	 * Skips records
	 * @param  int records to skip
	 * @return SkipedRelation  A skiped relation
	 */
	public function skip($offset);
}