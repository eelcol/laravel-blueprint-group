<?php 

namespace Eelcol\LaravelBlueprintGroup;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class BlueprintGroup
{
	/** @var Illuminate\Database\Schema\Blueprint */
	private $blueprint;

	/** @var array */
	private $columns = [];

	/**
	* @method __construct
	* @param \Illuminate\Database\Schema\Blueprint
	*/
	public function __construct(Blueprint $blueprint)
	{
		$this->blueprint = $blueprint;
	}

	/**
	* @method __call
	* Forward calls to the blueprint or to the group of columns
	*/
	public function __call($method, $params)
	{
		// check if the method exists on the blueprint class
		// if so, forward the call to the blueprint
		if(method_exists($this->blueprint, $method))
		{
			$return = call_user_func_array([$this->blueprint, $method], $params);
			if(is_a($return, ColumnDefinition::class))
			{
				// a new column is added
				// save to the array with columns
				$this->columns[] = $return;
			}

			return $return;
		}
		
		// the method doesnt exist on the blueprint class
		// forward the call to all the individual columns
		$this->forwardCallToColumns($method, $params);
		
		return $this;
	}

	/**
	* @method forwardCallToColumns
	* Forward a method call to all columns
	*/
	private function forwardCallToColumns($method, $params)
	{
		// when using the 'after' method, save the name of the last column
		$last_column_name = NULL;

		// loop all columns to apply this call to
		foreach($this->columns AS $column)
		{
			if(strtolower($method) == "after")
			{
				// call to the method 'after'
				// this column should be updated with every row to keep the correct order
				call_user_func([$column, $method], $last_column_name ?? $params[0]);
				$last_column_name = $column->get('name');
				continue;
			}

			// all other calls should be forwarded directly to the column
			call_user_func_array([$column, $method], $params);			
		}
	}

	public function getBlueprint(): Blueprint
	{
		return $this->blueprint;
	}
}