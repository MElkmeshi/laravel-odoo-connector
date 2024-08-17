<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Commands;

use Illuminate\Console\Command;
use Sefirosweb\LaravelOdooConnector\Http\Models\MrpBom;
use Sefirosweb\LaravelOdooConnector\Http\Models\MrpBomLine;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductTemplate;
use Illuminate\Support\Str;

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
        $a = ProductProduct::query()
            ->firstWhere('default_code', '=', 'WP19038-8')
            ->toArray();

        $b = ProductProduct::query()
            ->select('id', 'name', 'default_code', 'display_name', 'barcode', 'sale_ok')
            ->where('name', 'like', 'cabecero')
            ->where('sale_ok', '=', true)
            // ->limit(10)
            ->get()
            ->toArray();

        $c = ProductProduct::query()
            ->select('id', 'name', 'default_code', 'display_name', 'barcode', 'sale_ok')
            ->where('name', 'like', 'cabecero')
            ->where(function ($q) {
                $q->where('name', 'like', '180');
                $q->orWhere('sale_ok', '=', true);
            })
            // ->limit(10)
            ->get()
            ->toArray();

        $d = ProductProduct::query()
            ->whereIn('id', [5766, 5767])
            ->get()
            ->toArray();

        $e = ProductProduct::query()
            ->whereIn('id', [5766, 5767])
            ->with('product_template')
            ->get()
            ->toArray();

        $f = ProductProduct::find(5766);
        $p = $f->product_template->purchase_ok;

        $mrp_bom = MrpBom::find(20);
        $mrp_bom_line = $mrp_bom->mrp_bom_lines->first();

        if ($mrp_bom_line) {
            $mrp_bom_line->product_qty = 5;
            $mrp_bom_line->save();
            $mrp_bom_line->delete();
        }

        $mrp_bom_line = new MrpBomLine();
        $mrp_bom_line->product_id = 5765;
        $mrp_bom_line->product_qty = 66;
        $mrp_bom_line->mrp_bom()->associate($mrp_bom);
        $mrp_bom_line->save();

        $product = ProductProduct::onlyTrashed()->first();
        $product = ProductProduct::where('purchase_ok', '=', false)->first();
        $product->delete();
        $product->forceDelete();

        $prod = ProductTemplate::withTrashed()
            ->select('id', 'name', 'active')
            ->where(function ($q) {
                $q->where('name', 'like', 'roble');
            })
            ->orWhere(function ($q) {
                $q->where('name', 'like', 'mesita');
                $q->orWhere('name', 'like', '200');
            })
            ->get()
            ->groupBy(function ($item) {
                if (strpos(Str::lower($item->name), 'roble') !== false) {
                    return 'roble';
                }

                if (strpos(Str::lower($item->name), 'mesita') !== false) {
                    return 'mesita';
                }

                return '200';
            })
            ->toArray();

        $z = ProductProduct::get_all('id');

        return Command::SUCCESS;
    }
}
