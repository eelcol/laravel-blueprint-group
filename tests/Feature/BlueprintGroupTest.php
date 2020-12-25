<?php

namespace Eelcol\LaravelBlueprintGroup\Tests\Feature;

use Eelcol\LaravelBlueprintGroup\Tests\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class BlueprintGroupTest extends TestCase
{
	use RefreshDatabase;

	public $group;

	/** @test */
	public function set_columns_to_nullable()
	{
		try {
			Schema::table('test', function (Blueprint $table) {

				$this->group = $table->group(function ($group) {

					$group->string('test1');
					$group->string('test2');

				})->nullable();
	        });
	    } catch(\Exception $e) {
	    	//
	    }

	    // now debug the blueprint
	    $columns = $this->group->getBlueprint()->getColumns();

	    $this->assertEquals($columns[0]->type, 'string');
	    $this->assertEquals($columns[0]->name, 'test1');
	    $this->assertTrue($columns[0]->nullable);

	    $this->assertEquals($columns[1]->type, 'string');
	    $this->assertEquals($columns[1]->name, 'test2');
	    $this->assertTrue($columns[1]->nullable);
	}

	/** @test */
	public function set_columns_order()
	{
		try {
			Schema::table('test', function (Blueprint $table) {

				$this->group = $table->group(function ($group) {

					$group->string('test1');
					$group->string('test2');

				})->after('id');
	        });
	    } catch(\Exception $e) {
	    	//
	    }

	    // now debug the blueprint
	    $columns = $this->group->getBlueprint()->getColumns();

	    $this->assertEquals($columns[0]->type, 'string');
	    $this->assertEquals($columns[0]->name, 'test1');
	    $this->assertEquals($columns[0]->after, 'id');

	    $this->assertEquals($columns[1]->type, 'string');
	    $this->assertEquals($columns[1]->name, 'test2');
	    $this->assertEquals($columns[1]->after, 'test1');
	}
}