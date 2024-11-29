<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Sefirosweb\LaravelOdooConnector\Http\Models\MrpBom;
use Sefirosweb\LaravelOdooConnector\Http\Models\MrpBomLine;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductTemplate;
use Tests\TestCase;
use Illuminate\Support\Str;
use Sefirosweb\LaravelOdooConnector\Http\Models\PurchaseOrder;
use Sefirosweb\LaravelOdooConnector\Http\Models\PurchaseOrderLine;
use Sefirosweb\LaravelOdooConnector\Http\Models\SaleOrder;
use Sefirosweb\LaravelOdooConnector\Http\Models\SaleOrderLine;

class RandomTests extends TestCase
{
    /**
     * A basic test BelongsTo.
     *
     * @return void
     */
    public function test_random_Tests()
    {
        $a = SaleOrderLine::query()->first()->purchase_order_lines->first()->sale_order;

        $line = $a->sale_order_lines->first();

        /*
        $a = SaleOrder::query()
            ->first();
        $b = $a->partner;
        $b = $a->partner_invoice;
        $b = $a->partner_shipping;

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

        $saleOrder = SaleOrder::select('id', 'state', 'name')->where('state', '=', 'draft')->first();
        if ($saleOrder) {
            // $res = $saleOrder->action('action_confirm');
            SaleOrder::model_action('action_confirm', [[$saleOrder->id]]);
        }

        $a = ProductTemplate::query()
            ->select('id', 'name', 'route_ids')
            ->with(['stock_routes' => function ($q) {
                $q->select('id', 'name');
            }])
            ->limit(3)
            ->get();

        $a = ProductProduct::limit(2)->with('product_template')->get();
        */
    }
}
