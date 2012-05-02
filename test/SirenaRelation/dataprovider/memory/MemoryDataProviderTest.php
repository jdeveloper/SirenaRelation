<?php

use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\attribute\Attribute;
use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;	
use Sirena\relation\dataprovider\memory\MemoryDataProvider;
use \Countable;
use \EmptyIterator;	
use \ArrayObject;
use \ArrayIterator;

class MemoryDataProviderTest extends \PHPUnit_Framework_TestCase implements DataProviderInterface
{
	private $relation;
	private $data;
	private $dataProvider;
	private $initialized = false;

	public function read(RelationInterface $relation) {
		return new ArrayObject($this->data);
	}

	public function getData() {
		return $this->data;
	}

	public function setUp() {
		$this->initialize();
	}

	private function initialize() {
		if($this->initialized) {
			return;
		}

		$this->initialized = true;

		$attributeSet = new AttributeSet(array(
												new Attribute('attributeA'),
												new Attribute('attributeB'),
												new Attribute('attributeC'),
												new Attribute('attributeD'),
												new Attribute('attributeE'),
											  ));

		$this->relation = new BaseRelation($attributeSet, $this);
		$this->data = array(
								array("1,1", "1,2", '1,3', "1,4", "1,5"),
								array("2,1", "2,2", '2,3', "2,4", "2,5"),
								array("3,1", "3,2", '3,3', "3,4", "3,5"),
								array("4,1", "4,2", '4,3', "4,4", "4,5"),
								array("5,1", "5,2", '5,3', "5,4", "5,5")
						   );

		$this->dataProvider = new MemoryDataProvider($this->data);
	}

	public function getProjections() {
		$this->initialize();
		$this->data = array();
		$attributeSet = new AttributeSet(array(
												new Attribute('attributeA'),
												new Attribute('attributeB'),
												new Attribute('attributeC'),
												new Attribute('attributeD'),
												new Attribute('attributeE'),
											  ));
		$this->relation = new BaseRelation($attributeSet, new MemoryDataProvider($this->data));

		return array(
			        	array($this->relation),
			        	array($this->relation->project(array('attributeA', 'attributeC', 'attributeE')))
			       );
	}

	public function testConstructor() {
		$dataProvider = new MemoryDataProvider();

		$this->assertEquals(0, count($dataProvider));
		$this->assertEquals(array(), $dataProvider->getData());

		$this->assertEquals(5, count($this->dataProvider));
		$this->assertEquals($this->data, $this->dataProvider->getData());
	}

	public function testImplementedInterfaces() {
		$dataProvider = new MemoryDataProvider();

		$this->assertTrue($dataProvider instanceof DataProviderInterface);
		$this->assertTrue($dataProvider instanceof Countable);
	}

	/**
     * @dataProvider getProjections
     */
	public function testReadWithNoDataOnTheProviderReturnsEmptyIterator($relation) {
		$dataProvider = new MemoryDataProvider();
		$iterator     = $dataProvider->read($relation);

		$this->assertTrue($iterator instanceof EmptyIterator);
	}


	public function testReadFromABaseRelationReturnAnArrayObjectContaininAllTheData() {
		$iterator     = $this->dataProvider->read($this->relation);

		$this->assertTrue($iterator instanceof ArrayObject);
		$this->assertEquals($this->data, $iterator->getArrayCopy());
	}

	public function testProjection() {
		$projectedRelation = $this->relation->project(array('attributeA', 'attributeC', 'attributeE'));
		$iterator          = $this->dataProvider->read($projectedRelation);
		$expectedData = array(
								array("1,1", '1,3', "1,5"),
								array("2,1", '2,3', "2,5"),
								array("3,1", '3,3', "3,5"),
								array("4,1", '4,3', "4,5"),
								array("5,1", '5,3', "5,5")
						   );
		$values 	  = array();

		foreach ($iterator as $value) {
			$row = array();

			foreach ($value as $col) {
				$row[] = $col;
			}

			$values[] = $row;
		}

		$this->assertEquals($expectedData, $values);
	}
}