<?php
use Sirena\relation\attribute\Attribute;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
	private $attribute;

	public function setUp()
	{
		$this->attribute = new Attribute("attributeName");
	}

	/**
	  * @expectedException Exception
	  */
	public function testAttributeConstructorMustHaveParameterOfTheName() {
		$attribute = new Attribute();
	}

	/**
	  * @expectedException Exception
	  */
	public function testNameOfTheAttributeCantBeAnEmptyString()
	{
		$attribute = new Attribute('');
	}

	/**
	  * @expectedException Exception
	  */
	public function testNameOfTheAttributeCantBeOnlySpaces()
	{
		$attribute = new Attribute('   ');
	}

	/**
	  * @expectedException Exception
	  */
	public function testParameterPassedToSetNameCantBeNULL() {
		$this->attribute->setName();
	}

	/**
	  * @expectedException Exception
	  */
	public function testParameterPassedToSetNameCantBeAnEmptyString()
	{
		$$this->attribute->setName('');
	}

	/**
	  * @expectedException Exception
	  */
	public function testParameterPassedToSetNameCantBeBeOnlySpaces()
	{
		$this->attribute->setName('    ');
	}

	/**
     * @dataProvider nonAlphanumericalChars
     * @expectedException Exception
     */
	public function testConstructorDoesNotAcceptStringsContainingNonAlphanumericalChars($value) {
		$attribute = new Attribute($value);
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