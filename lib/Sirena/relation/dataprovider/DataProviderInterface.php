<?php

namespace Sirena\relation\dataprovider;

use Sirena\relation\relation\RelationInterface;

interface DataProviderInterface {
	public function read(RelationInterface $relation);
}