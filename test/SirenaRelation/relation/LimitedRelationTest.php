<?php

use Sirena\relation\relation\LimitedRelation;
use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\attribute\Attribute;
use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;

class LimitedRelationTest extends \PHPUnit_Framework_TestCase implements DataProviderInterface
{
	private $relation;
	private $innerRelation;

	public function read(RelationInterface $relation) {
	}

	public function setUp() {
		$attributeSet = new AttributeSet(array(
												new Attribute('a'),
												new Attribute('b'),
												new Attribute('c'),
												new Attribute('d'),
												new Attribute('e'),
											  ));

		$this->innerRelation = new BaseRelation($attributeSet, $this);
		$this->relation = new LimitedRelation($this->innerRelation, 2, $this);
	}

	public function testGetInnerRelation() {
		$this->assertEquals($this->innerRelation, $this->relation->getInnerRelation());
	}

	public function testGetOffset() {
		$this->assertEquals(2,$this->relation->getLimit());
	}
}