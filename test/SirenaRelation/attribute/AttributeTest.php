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

	public function testAttributeGetterReturnsValuePastToConstructorIfNotSetterCalled() {
		$attribute = new Attribute("attributeName");

		$this->assertEquals("attributeName",$attribute->getName());
	}

	public function nonAlphanumericalChars() {
		return array(
						array(','),
						array('.')
					);
	}
}
?>