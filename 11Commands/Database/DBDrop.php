<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DBDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop a MySQL database based on the database config file or the provided name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schemaName = $this->argument('name') ?: config("database.connections.mysql.database");
        config(["database.connections.mysql.database" => null]);
//        $dbs = DB::statement("SELECT `schema_name` from INFORMATION_SCHEMA.SCHEMATA where schema_name = '$schemaName'");

        $query = "DROP DATABASE IF EXISTS $schemaName;";

        $ret = DB::statement($query);
        config(["database.connections.mysql.database" => $schemaName]);

        $this->info(sprintf('Successfully removed %s database', $schemaName));
    }
}
