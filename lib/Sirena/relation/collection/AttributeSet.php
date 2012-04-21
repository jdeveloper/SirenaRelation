<?php

namespace Sirena\relation\collection;

use \SplObjectStorage;
use \Exception;
use \ArrayObject;
use Sirena\relation\attribute\Attribute;

/**
  * Class that represents a Set of attributes
  */
class AttributeSet extends ArrayObject
{
	/**
	  * Constructor
	  * @param array $attributes Initial attributes of the set
	  */
	public function __construct($attributes = array()) {
		$this->attributes = array();

		foreach ($attributes as $attribute) {
			$this->add($attribute);
		}
	}

	/**
	 * adds an attribute to the set
	 * @param Attribute $attribute The attribute to add
	 */
	public function add($attribute) {
		$this->append($attribute);
	}

	/**
	 * adds an attribute to the set
	 * @param Attribute $attribute The attribute to add
	 */
	public function append($attribute) {
		$this->assertIsAttribute($attribute);
		$this->assertNameNotPresent($attribute);

		$this[$attribute->getName()] = $attribute;
	}

	private function areAttributeNameInTheSameOrder($attributeNames) {
		$array = $this->getIterator()->getArrayCopy();

		return array_keys($array) === $attributeNames;
	}

	private function assertIsAttribute($attribute) {
		if ( !$attribute instanceof Attribute ) {
			throw new Exception();
		}
	}

	private function assertNameNotPresent($attribute) {
		if( isset($this[$attribute->getName()]) ) {
			throw new Exception();
		}
	}

	/**
	 * Returns the attributes as array
	 * @return array Returns the attributes
	 */
	public function getAttributes() {
		return $this->getIterator()->getArrayCopy();
	}

	public function getAttributesWithNames($attributeNames) {
		$attributes = $this;

		return array_map(function($name) use ($attributes) { return $attributes[$name]; }, $attributeNames);
	}

	/**
	 * Returns the names of the attributes ordered in the order the attributes where added
	 * @return array Array of the names of the attributes
	 */
	public function getKeys() {
		$keys = array();
		
		foreach ($this as $key => $value) {
			$keys[] = $key;
		}

		return $keys;
	}

	/**
	 * Projects the attributes with the given names
	 * @param  array $attributeNames The names of the attributes to be projected
	 * @return AttributeSet          AttributeSet containing all the attributes being projected
	 */
	public function project($attributeNames) {
		if ( empty($attributeNames) ) {
			return new AttributeSet();
		} elseif ( $this->areAttributeNameInTheSameOrder($attributeNames) ) {
			return $this;
		}

		return new AttributeSet($this->getAttributesWithNames($attributeNames));
	}

	/**
	 * Removes all the attributes from the set
	 */
	public function removeAll() {
		$keys = $this->getKeys();

		foreach ($keys as $key) {
			unset($this[$key]);
		}
	}

	/**
	 * Sets the attributes of the sets
	 * @param array $attributes The attributes to be set
	 */
	public function setAttributes($attributes) {
		$this->removeAll();

		foreach ($attributes as $attribute) {
			$this->add($attribute);
		}
	}
}