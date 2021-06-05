<?php

namespace App\Services;

use App\Models\TableToExclude;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DBService
{
    public function createDatabase(array $data): array
    {
        if (strpos(' ', $data['subdomain'])) {
            return [];
        }
        try {
            $db_name = env('SUBDOMAIN_DB_NAME_PREFIX').$data['subdomain'];
            $db_username = env('SUBDOMAIN_DB_USERNAME_PREFIX').$data['subdomain'];
            $db_password = Str::random(10);

            DB::statement('CREATE DATABASE '.$db_name);

            DB::statement('CREATE USER '.$db_username.'@'.env('db_host').' IDENTIFIED BY "'.$db_password.'"');
            DB::statement('GRANT ALL PRIVILEGES ON '.$db_name.'.* TO "'.$db_username.'"@"'.env('db_host').'"');

            $data['db_password'] = $db_password;
            $data['db_name'] = $db_name;
            $data['db_username'] = $db_username;

            return $this->copyTables($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return [];
        }
    }

    private function copyTables(array $data): array
    {
        Config::set('database.connections.subdomain.host', env('db_host'));
        Config::set('database.connections.subdomain.database', $data['db_name']);
        Config::set('database.connections.subdomain.username', $data['db_username']);
        Config::set('database.connections.subdomain.password', $data['db_password']);

        $tables = DB::select(DB::raw('SHOW TABLES'));

        $tables_to_exclude = TableToExclude::all()->pluck('name')->toArray();

        foreach ($tables as $table) {
            $table = $table->Tables_in_mytask;
            if (! in_array($table, $tables_to_exclude, true)) {
                $show_table_query = 'SHOW CREATE TABLE '.$table;
                $show_table_result = DB::select(DB::raw($show_table_query));

                foreach ($show_table_result as $show_table_row) {
                    $show_table_row = (array) $show_table_row;
                    DB::connection('subdomain')->insert(DB::raw($show_table_row['Create Table']));
                }
            }
        }

        return $data;
    }

    public function allTables(): array
    {
        $db_tables = [];

        $tables = DB::select(DB::raw('SHOW tables'));

        foreach ($tables as $table) {
            $table = (array) $table;
            $db_tables[]['name'] = $table['Tables_in_'.env('db_database')];
        }

        return $db_tables;
    }

    public function getTablesToExclude(): array
    {
        return TableToExclude::all()->toArray();
    }

    public function updateTablesToExclude(array $data)
    {
        try {
            TableToExclude::all()->each->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        foreach ($data['tables_to_exclude'] as $table) {
            TableToExclude::query()->create([
                'name' => $table,
            ]);
        }
    }
}
