# Laravel Blueprint Group

Sometimes, you want to group statements in your migration files. For example, when you want to add 3 new columns to a table and don't want to specify an `->after('...')` on every statement. Now you can use the group method!

# Example

Lets take the following migration as example:

````
Schema::table('table', function (Blueprint $table) {
            
	$table->string('new_column_a')->nullable()->after('some_old_column');
	$table->string('new_column_b')->nullable()->after('new_column_a');
	$table->string('new_column_c')->nullable()->after('new_column_b');

});
````

This can be grouped as follows:

````
Schema::table('table', function (Blueprint $table) {

	$table->group(function($group) {
            
		$group->string('new_column_a');
		$group->string('new_column_b');
		$group->string('new_column_c');

	})->nullable()->after('some_old_column');

});
````

# Installation

Require this package with composer.

````
composer require eelcol/laravel-blueprint-group
````

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

````
Eelcol\LaravelBlueprintGroup\BlueprintGroupServiceProvider::class,
````