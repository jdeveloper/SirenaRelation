<?php

use Sirena\relation\dataprovider\memory\iterator\KeysIterator;
use \ArrayObject;
use \Arrayiterator;

class KeyIteratorTest extends \PHPUnit_Framework_TestCase
{
	public function testShoulOnlyReturnTheKeysGiven() {
		$array         = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
		$arrayObject   = new ArrayObject($array);
		$keysIterator  = new KeysIterator($arrayObject->getIterator(),array('a', 'c', 'e'));
		$values        = array();

		foreach ($keysIterator as $value) {
			$values[] = $value;
		}

		$this->assertEquals(array(1, 3, 5), $values);
	}
}