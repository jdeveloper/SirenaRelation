<?php

use Sirena\relation\relation\ProjectedRelation;
use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\attribute\Attribute;
use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;

class ProectedRelationTest extends \PHPUnit_Framework_TestCase implements DataProviderInterface
{
	private $relation;
	private $innerRelation;
	private $projectedAttributesSet;

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

		$this->projectedAttributesSet = new AttributeSet(array(
												new Attribute('a'),
												new Attribute('c'),
												new Attribute('e'),
											  ));

		$this->innerRelation = new BaseRelation($attributeSet, $this);
		$this->relation = new ProjectedRelation($this->innerRelation, $this->projectedAttributesSet, $this);
	}

	public function testGetInnerRelation() {
		$this->assertEquals($this->innerRelation, $this->relation->getInnerRelation());
	}
}