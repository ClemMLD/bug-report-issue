<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB as BaseDB;

class DB
{
    /** @var array<string, Connection> The cached database connection instances */
    protected static $connections = [];

    /**
     * Get a connection to the testing database for a given existing connection.
     */
    public static function mockConnection(string $name): Connection
    {
        if (isset(static::$connections[$name])) {
            return static::$connections[$name];
        }

        $dbDriver = BaseDB::connection($name)->getDriverName();

        return static::mockConnectionUsing($dbDriver, Str::replace('-', '_', $name));
    }

    /**
     * Get a connection to the testing database for a given driver and with a given table prefix.
     */
    public static function mockConnectionUsing(string $driver, string $prefix): Connection
    {
        return (clone BaseDB::connection("{$driver}"))->setTablePrefix("{$prefix}_");
    }

    /**
     * Drop tables of a given data repository (by prefix) in the testing database.
     */
    public static function wipeRepository(string $driver, string $prefix): void
    {
        $schema = static::mockConnectionUsing($driver, $prefix)->getSchemaBuilder();
        $allTables = collect($schema->getAllTables())->map->tablename;

        foreach ($allTables as $table) {
            if (Str::startsWith($table, "{$prefix}_")) {
                $schema->drop(Str::after($table, "{$prefix}_"));
            }
        }
    }
}
