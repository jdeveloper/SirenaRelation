<?php
use Sirena\relation\attribute\Attribute;
use \Exception;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
	private $attribute;

	public function setUp()
	{
		$this->attribute = new Attribute("attributeName");
	}

	public function testAttributeConstructorMustHaveParameterOfTheName() {
		try {
			$attribute = new Attribute();
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	public function testNameOfTheAttributeCantBeAnEmptyString(){
		try {
			$attribute = new Attribute('');
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	public function testNameOfTheAttributeCantBeOnlySpaces() {
		try {
			$attribute = new Attribute('   ');
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	public function testParameterPassedToSetNameCantBeNULL() {
		try {
			$this->attribute->setName();
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	public function testParameterPassedToSetNameCantBeAnEmptyString()
	{
		try {
			$this->attribute->setName('');
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	public function testParameterPassedToSetNameCantBeBeOnlySpaces()
	{
		try {
			$this->attribute->setName('    ');
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	/**
     * @dataProvider nonAlphanumericalChars
     */
	public function testConstructorDoesNotAcceptStringsContainingNonAlphanumericalChars($value) {
		try {
			$attribute = new Attribute($value);
		} catch (Exception $e) {
			return;
		}
		
		$this->fail();
	}

	/**
     * @dataProvider alphanumericalChars
     */
	public function testConstructorDoesAcceptStringsContainingNonAlphanumericalChars($value) {
		$attribute = new Attribute($value);
	}

	public function testAttributeGetterReturnsValuePastToConstructorIfNotSetterCalled() {
		$attribute = new Attribute("attributeName");

		$this->assertEquals("attributeName",$attribute->getName());
	}

	public function nonAlphanumericalChars() {
		$allASCIICodes = range(0, 255);
		$nonAlphanumericalASCIICodes = array_diff($allASCIICodes, $this->getAlphanumericalCharsASCII());

		return array_map(function($ascii) {
							return array(chr($ascii));
						 }, $nonAlphanumericalASCIICodes);
	}

	public function alphanumericalChars() {
		return array_map(function($ascii) {
							return array(chr($ascii));
						 }, $this->getAlphanumericalCharsASCII());
	}

	private function getAlphanumericalCharsASCII() {
		return array_merge(
							range(48, 57),
							range(65, 90),
							range(97, 122)
						  );
	}
}
?>