<?php

/*
 * This file is part of SirenaRelation.
 *
 * (c) José Ramón Fernandez Leis <jdeveloper.inxenio@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sirena\relation\attribute;

use \Exception;

/**
  * Class that represents an attribute
  */
class Attribute
{
	private static $ALFANUMERICAL_REGEX = "/^[a-zA-Z0-9]+$/";

	/**
	  * Name of the attribute
	  */
	private $name;

    /**
      * The constructor
      *
      * @param string $name The name of the attribute
      */
	public function __construct($name = NULL) {
		$this->setName($name);
	}

	/**
      * Returns the name of the attribute
      *
      * @return string 
      */
	public function getName() {
		return $this->name;
	}

	/**
	  * Set the name of the attribute
	  * @param string $name The name of the attribute
	  */
	public function setName($name = NULL) {
		$this->assertOnlyAlphanumericalChars($name);

		$this->name = $name;
	}

	private function assertOnlyAlphanumericalChars($value) {
		if( !preg_match(self::$ALFANUMERICAL_REGEX, $value) ) {
			throw new Exception();	
		}
	}
}