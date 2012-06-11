<?php

use Sirena\relation\relation\BaseRelation;
use Sirena\relation\relation\RelationInterface;
use Sirena\relation\attribute\Attribute;
use Sirena\relation\collection\AttributeSet;
use Sirena\relation\dataprovider\DataProviderInterface;	
use Sirena\relation\dataprovider\memory\MemoryDataProvider;
use Sirena\relation\dataprovider\memory\extractor\SkipedRelationExtractor;

class SkipedRelationExtractorTest extends \PHPUnit_Framework_TestCase implements DataProviderInterface
{
	private $relation;
	private $data;
	private $dataProvider;
	private $initialized = false;
	private $attributeSet;

	public function read(RelationInterface $relation) {
		return new ArrayObject($this->data);
	}

	public function setUp() {
		$this->initialize();
	}

	private function initialize() {
		if($this->initialized) {
			return;
		}

		$this->initialized = true;

		$this->attributeSet = new AttributeSet(array(
												new Attribute('attributeA'),
												new Attribute('attributeB'),
												new Attribute('attributeC'),
												new Attribute('attributeD'),
												new Attribute('attributeE'),
											  ));

		$this->data = array(
								array("1,1", "1,2", '1,3', "1,4", "1,5"),
								array("2,1", "2,2", '2,3', "2,4", "2,5"),
								array("3,1", "3,2", '3,3', "3,4", "3,5"),
								array("4,1", "4,2", '4,3', "4,4", "4,5"),
								array("5,1", "5,2", '5,3', "5,4", "5,5")
						   );

		$this->relation = new BaseRelation($this->attributeSet, new MemoryDataProvider($this->data));
		

		$this->dataProvider = new MemoryDataProvider($this->data);
	}

	public function testCanHandle() {
		$extractor = new SkipedRelationExtractor();

		$this->assertFalse($extractor->canHandle($this->relation));
		$this->assertTrue($extractor->canHandle($this->relation->skip(1)));
	}

	public function testReadWithNoDataOnTheProviderReturnsEmptyIterator() {
		$extractor      = new SkipedRelationExtractor();
		$this->data     = array();
		$this->relation = new BaseRelation($this->attributeSet, new MemoryDataProvider($this->data));
		$iterator       = $extractor->read($this->relation);

		$this->assertTrue($iterator instanceof EmptyIterator);
	}

	public function testReadFromABaseRelationReturnAnArrayObjectSkipingTheFirstRow() {
		$extractor = new SkipedRelationExtractor();
		$iterator  = $extractor->read($this->relation->skip(1));
		$expectedData = array(
								array("2,1", "2,2", '2,3', "2,4", "2,5"),
								array("3,1", "3,2", '3,3', "3,4", "3,5"),
								array("4,1", "4,2", '4,3', "4,4", "4,5"),
								array("5,1", "5,2", '5,3', "5,4", "5,5")
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