<?php

declare(strict_types=1);

namespace Sefirosweb\LaravelOdooConnector\Http\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrder extends OdooModel
{
    protected $table = 'sale.order';

    public function sale_order_lines(): HasMany
    {
        $relation = config('laravel-odoo-connector.SaleOrderLine');
        return $this->hasMany($relation, 'order_id', 'id');
    }

    public function partner(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->belongsTo($relation, 'partner_id', 'id');
    }

    public function partner_invoice(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->belongsTo($relation, 'partner_invoice_id', 'id');
    }

    public function partner_shipping(): BelongsTo
    {
        $relation = config('laravel-odoo-connector.ResPartner');
        return $this->belongsTo($relation, 'partner_shipping_id', 'id');
    }

    public function stock_pickings(): HasMany
    {
        $relation = config('laravel-odoo-connector.StockPicking');
        return $this->hasMany($relation, 'sale_id', 'id');
    }

    public function action_cancel()
    {
        $saleOrderCancel = new SaleOrderCancel();
        $saleOrderCancel->order_id = $this->id;
        $saleOrderCancel->save();

        $saleOrderCancel->action('action_cancel');
        $this->state = 'cancel';
    }

    public function action_clear_order_lines()
    {
        $salesOrder = SaleOrder::select('id', 'order_line', 'state')->findOrFail($this->id);

        if (!in_array($salesOrder->state, ['draft'])) {
            throw new \Exception('Only draft orders can be cleared');
        }

        $salesOrder->order_line = array_map(function ($orderLine) {
            return [2, $orderLine];
        }, $salesOrder->order_line);
        $salesOrder->save();
        $this->order_line = [];
    }
}
