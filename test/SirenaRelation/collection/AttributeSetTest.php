<?php

use Sirena\relation\collection\AttributeSet;
use Sirena\relation\attribute\Attribute;

class AttributeSetTest extends \PHPUnit_Framework_TestCase
{
	private $attributeSet;

	public function setUp() {
		$this->attributeSet = new AttributeSet(array(
														new Attribute('a'),
														new Attribute('b'),
														new Attribute('c'),
														new Attribute('d'),
														new Attribute('e'),
													));	
	}

	public function testConstructorWithNoArgumentHasNoElement() {
		$attributeSet = new AttributeSet();

		$this->assertEquals(0,count($attributeSet));
	}

	/**
	  * @expectedException Exception
	  */
	public function testConstructorEnsureArrayOfAttributes() {
		new AttributeSet(array(new Attribute('a'),new stdClass));
	}

	public function testCount($value='') {
		$this->assertEquals(5,count($this->attributeSet));

		$this->attributeSet->add(new Attribute('f'));
		$this->assertEquals(6,count($this->attributeSet));		
	}

	/**>
	  * @expectedException Exception
	  */
	public function testNamesOfAttributesMustBeUnique() {
		new AttributeSet(array(
									 new Attribute('a'),
									 new Attribute('b'),
									 new Attribute('c')
							   ));
	}

	public function testGetAttributes() {
		$attributes = array(
								'a' => new Attribute('a'),
								'b' => new Attribute('b'),
								'c' => new Attribute('c'),
								'd' => new Attribute('d'),
								'e' => new Attribute('e'),
							);

		$this->assertEquals($attributes, $this->attributeSet->getAttributes());
	}

	public function testGetKeys() {
		$this->assertEquals(array('a','b','c','d','e'),$this->attributeSet->getKeys());

		$this->attributeSet->removeAll();

		$this->assertEquals(array(),$this->attributeSet->getKeys());
	}

	public function testRemoveAll() {
		$this->attributeSet->removeAll();

		$this->assertEquals(0,count($this->attributeSet));
	}

	public function testSetAttributes() {
		$attributes = array(
								'a2' => new Attribute('a2'),
								'b2' => new Attribute('b2'),
								'c2' => new Attribute('c2'),
								'd2' => new Attribute('d2'),
								'e2' => new Attribute('e2'),
							);

		$this->attributeSet->setAttributes(array_values($attributes));

		$this->assertEquals($attributes, $this->attributeSet->getAttributes());
	}

	/**
     * @dataProvider getProjectionsMap
     */
	public function testProjection($projections,$result) {

		$this->assertEquals($result,$this->attributeSet->project($projections));
	}

	/**
	  * @expectedException Exception
	  */
	public function testThrowExceptionInProjectionIfOneAttributeNameNotPresent($value='') {
		$this->attributeSet->project(array('g'));
	}

	function testIndexesOfNames() {
		$indexes = $this->attributeSet->indexesOfNames(array('a', 'c', 'e'));
		$this->assertEquals(array(0,2,4), $indexes);

		$indexes = $this->attributeSet->indexesOfNames(array('e', 'c', 'a'));
		$this->assertEquals(array(4,2,0), $indexes);
	}

	/**
	 * @expectedException Exception
	 */
	public function testIndexOfNamesThrowsExceptionIfNoAttributesHasAName() {
		$indexes = $this->attributeSet->indexesOfNames(array('a', 'c', 'e', 'z'));
	}

	public function getProjectionsMap() {
		return array(
						array(array(),new AttributeSet(array())),
						array(array('a'),new AttributeSet(array(new Attribute('a')))),
						array(array('a','c','e'),new AttributeSet(array(
														new Attribute('a'),
														new Attribute('c'),
														new Attribute('e'),
													))),
						array(array('a','b','c','d','e'),new AttributeSet(array(
																					new Attribute('a'),
																					new Attribute('b'),
																					new Attribute('c'),
																					new Attribute('d'),
																					new Attribute('e'),
																				))),
						array(array('e','d','c','b','a'),new AttributeSet(array(
																				new Attribute('e'),
																				new Attribute('d'),
																				new Attribute('c'),
																				new Attribute('b'),
																				new Attribute('a'),
																			   )))			,
					);	
	}
}