<?php

use Sirena\relation\relation\RelationInterface;
use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\ProjectedRelation;
use Sirena\relation\dataprovider\DataProviderInterface;
use Sirena\relation\attribute\Attribute;
use Sirena\relation\collection\AttributeSet;
use \Iterator;
use \EmptyIterator;

class BaseRelationSetTest extends \PHPUnit_Framework_TestCase implements DataProviderInterface
{
	private $relation;
	private $numberOfTimesCalledRead = 0;

	public function read(RelationInterface $relation) {
		$this->numberOfTimesCalledRead++;
	}

	public function setUp() {
		$attributeSet = new AttributeSet(array(
												new Attribute('a'),
												new Attribute('b'),
												new Attribute('c'),
												new Attribute('d'),
												new Attribute('e'),
											  ));	

		$this->relation = new BaseRelation($attributeSet, $this);
	}

	public function testConstructor() {
		$relation = new BaseRelation(null, $this);

		$this->assertNull($relation->getAttributeSet());

		$attributeSet = new AttributeSet(array(new Attribute('anattribute')));

		$relation = new BaseRelation($attributeSet, $this);

		$this->assertEquals($attributeSet,$relation->getAttributeSet());
	}

	public function testIsInstanceOfRelationInterface($value='') {
		$this->assertTrue($this->relation instanceof RelationInterface);
	}

	public function testGetDataProvider() {
		$dataProvider = $this->relation->getDataProvider();

		$this->assertTrue($dataProvider instanceof DataProviderInterface);
	}

	public function testCallingGetIteratorCallsInternarlyMethodReadFromTheDataprovicer() {
		$this->numberOfTimesCalledRead = 0;

		$iterator = $this->relation->getIterator();

		$this->assertEquals(1, $this->numberOfTimesCalledRead);
	}

	public function testProjection() {
		$newRelation = $this->relation->project(array('a','c','e'));

		$this->assertTrue($newRelation instanceof ProjectedRelation);

		$this->assertEquals($newRelation->getAttributeSet(),new AttributeSet(array(
																					new Attribute('a'),
																					new Attribute('c'),
																					new Attribute('e'),
																				  )));
	}
}