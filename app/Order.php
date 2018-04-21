<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];
    public function getOrdersById($id, $flag = false)
    {

        $data = $this->join('goods', 'orders.product_id', '=', 'goods.id')
            ->where('orders.customer_id', '=', $id)
            ->where('orders.confirm', '=', $flag)
            ->select('orders.created_at as date', 'goods.*')
            ->get();
        return $data->toArray();
    }
    public function confirm($id)
    {
        $data = $this->where('customer_id', '=', $id)
            ->where('orders.confirm', '=', false)
            ->update(['confirm' => true]);
    }
    public function getAllOrders()
    {
        $data = $data = $this->join('goods', 'orders.product_id', '=', 'goods.id')
            ->where('orders.confirm', '=', true)
            ->select('orders.id', 'orders.customer_email', 'goods.name', 'goods.price')
            ->get();
        return $data->toArray();
    }
    public function getOrdersByProductID($id)
    {

        $data = $this->where('product_id', '=', $id)
           ->get();
        return $data->toArray();
    }
    public function deleteOrders($id)
    {
        $this->find($id)->delete();
        return true;
    }
}
