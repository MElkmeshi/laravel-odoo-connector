<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Database\Eloquent\Collection;
use Sefirosweb\LaravelOdooConnector\Http\Models\MrpBom;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductProduct;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductTemplate;
use Sefirosweb\LaravelOdooConnector\Http\Models\StockRoute;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    /**
     * A basic test BelongsTo.
     *
     * @return void
     */
    public function test_belongs_to()
    {
        $product = ProductProduct::first();
        $this->assertNotNull($product, 'ProductProduct instance is null');
        $productTemplate = $product->product_template;
        $this->assertNotNull($productTemplate, 'ProductTemplate relation is null');
        $this->assertInstanceOf(ProductTemplate::class, $productTemplate);

        // Use get multiple data

        $product = ProductProduct::limit(1)->get()->first();
        $this->assertNotNull($product, 'ProductProduct instance is null');
        $productTemplate = $product->product_template;
        $this->assertNotNull($productTemplate, 'ProductTemplate relation is null');
        $this->assertInstanceOf(ProductTemplate::class, $productTemplate);
    }

    /**
     * A basic test HasMany.
     *
     * @return void
     */

    public function test_has_many()
    {
        $product = MrpBom::first()->product_product;
        $this->assertNotNull($product, 'ProductProduct instance is null');
        $mrpBom = $product->mrp_bom;
        $this->assertNotNull($mrpBom, 'MrpBom relation is null');
        $this->assertInstanceOf(Collection::class, $mrpBom);
        $this->assertInstanceOf(MrpBom::class, $mrpBom->first());
        $mrpBom->each(function ($item) {
            $this->assertInstanceOf(MrpBom::class, $item);
        });

        // Use get multiple data

        $product = MrpBom::first()->product_product;
        $this->assertNotNull($product, 'ProductProduct instance is null');
        $mrpBom = $product->mrp_bom;
        $this->assertNotNull($mrpBom, 'MrpBom relation is null');
        $this->assertInstanceOf(Collection::class, $mrpBom);
        $this->assertInstanceOf(MrpBom::class, $mrpBom->first());
        $mrpBom->each(function ($item) {
            $this->assertInstanceOf(MrpBom::class, $item);
        });
    }

    /**
     * A basic test BelongsToMany.
     *
     * @return void
     */

    public function test_belongs_to_many()
    {
        $stockRoute = StockRoute::first();
        $this->assertNotNull($stockRoute, 'StockRoute instance is null');
        $productTemplate = ProductTemplate::where('route_ids', '=', $stockRoute->id)->first();
        $this->assertNotNull($productTemplate, 'ProductTemplate instance is null');
        $stockRoutes = $productTemplate->stock_routes;
        $this->assertNotNull($stockRoutes, 'StockRoutes relation is null');
        $this->assertInstanceOf(Collection::class, $stockRoutes);
        $this->assertInstanceOf(StockRoute::class, $stockRoutes->first());
        $stockRoutes->each(function ($item) {
            $this->assertInstanceOf(StockRoute::class, $item);
        });

        // Use get multiple data

        $stockRoute = StockRoute::first();
        $this->assertNotNull($stockRoute, 'StockRoute instance is null');
        $productTemplate = ProductTemplate::where('route_ids', '=', $stockRoute->id)->first();
        $this->assertNotNull($productTemplate, 'ProductTemplate instance is null');
        $stockRoutes = $productTemplate->stock_routes;
        $this->assertNotNull($stockRoutes, 'StockRoutes relation is null');
        $this->assertInstanceOf(Collection::class, $stockRoutes);
        $this->assertInstanceOf(StockRoute::class, $stockRoutes->first());
        $stockRoutes->each(function ($item) {
            $this->assertInstanceOf(StockRoute::class, $item);
        });
    }
}
