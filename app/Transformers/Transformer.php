<?php

namespace App\Transformers;

abstract class Transformer {	

	/*
	 * Transform a collection of objects
	 *
	 */

	public function transformCollection(array $items) 
	{
		return array_map([$this, 'transform'], $items);
	}

	public abstract function transform($item);
}