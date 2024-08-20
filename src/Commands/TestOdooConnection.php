<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Commands;

use Illuminate\Console\Command;
use Sefirosweb\LaravelOdooConnector\Http\Models\MrpImmediateProductionLine;
use Sefirosweb\LaravelOdooConnector\Http\Models\MrpProduction;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct;
use Sefirosweb\LaravelOdooConnector\Http\Models\SaleOrder;

class TestOdooConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:odoo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run test odoo connection';

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

        $a = MrpProduction::first()->mrp_immediate_production_lines;
        if (!$a) {
            $this->error('No data found');
            return Command::FAILURE;
        }

        dd($a->toArray());
        return Command::SUCCESS;
    }
}
