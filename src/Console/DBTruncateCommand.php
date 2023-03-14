<?php


use App\Facades\Schema;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DBTruncateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate {--except= : Tables to exclude from truncation (comma-separated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'truncates all table except the ones specified in the --except option';

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
     * @return int
     */
    public function handle()
    {
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        if ($this->option('except')) {
            $except = explode(',', $this->option('except'));
            $tableNames = $tableNames->reject(function ($table) use ($except) {
                $this->alert('Skipping table: ' . $table);
                return in_array($table, $except);
            });
        }

        $this->alert('Disabling foreign key checks...');
        Schema::disableForeignKeyConstraints();

        foreach ($tableNames as $name) {
            $this->info('Truncating '.$name);
            DB::table($name)->truncate();
            $this->info('Truncated '.$name);
        }

        $this->alert('Enabling foreign key checks...');
        Schema::enableForeignKeyConstraints();
        return 1;
    }
}
