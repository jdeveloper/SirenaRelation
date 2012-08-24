<?php

use Sirena\relation\dataprovider\DataProviderInterface;
use Sirena\relation\dataprovider\memory\iterator\LimitedRelationIterator;
use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\attribute\Attribute;
use Sirena\relation\collection\AttributeSet;
use \ArrayObject;

class LimitedRelationIteratorTest extends \PHPUnit_Framework_TestCase implements RelationInterface, DataProviderInterface
{
	private $relation;

	public function read(RelationInterface $relation) {
		return new ArrayObject(array(
										array("1,1", "1,2", '1,3', "1,4", "1,5"),
										array("2,1", "2,2", '2,3', "2,4", "2,5"),
										array("3,1", "3,2", '3,3', "3,4", "3,5"),
										array("4,1", "4,2", '4,3', "4,4", "4,5"),
										array("5,1", "5,2", '5,3', "5,4", "5,5")
					)				);
	}

	public function getIterator() {
		return 	$this->read($this->relation);
	}

	public function getDataProvider() {
		return $this;
	}

	public function project(array $attributes) {
		
	}

	public function skip($offset) {
		
	}

	public function setUp() {
		$attributeSet = new AttributeSet(array(
												new Attribute('A'),
												new Attribute('B'),
												new Attribute('C'),
												new Attribute('D'),
												new Attribute('E'),
											  ));

		$this->relation = new BaseRelation($attributeSet, $this);
	}

	public function testShoulOnlyShowTheFirstRow() {
		$expectedData = array(
								array("1,1", "1,2", '1,3', "1,4", "1,5")
							  );
		$values       = array();
		$iterator     = new LimitedRelationIterator($this->relation->getIterator()->getIterator(),1);

		foreach ($iterator as $value) {
			$row = array();

			foreach ($value as $column) {
				$row[] = $column;
			}

			$values[] = $row;
		}

		$this->assertEquals($expectedData, $values);
	}
}