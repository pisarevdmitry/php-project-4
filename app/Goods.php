<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $guarded = ['id'];
    public function getGoods($offset)
    {
        $data = $this->skip($offset)->take(6)->get();
        return $data->toArray();
    }
    public function getGoodsByCategory($id)
    {
        $data = $this->where('category_id', '=', $id)->get();
        return $data->toArray();
    }
    public function getGoodsByCategoryCurrent($id, $offset = 0)
    {
        $data = $this->where('category_id', '=', $id)->skip($offset)->take(6)->get();
        return $data->toArray();
    }
    public function getGoodsById($id)
    {
        $data = $this->join('categories', 'goods.category_id', '=', 'categories.id')
            ->where('goods.id', '=', $id)
            ->select('goods.*', 'categories.name as categories_name')
            ->get();
        return $data->toArray();
    }
    public function checkGoods($name, $id)
    {
        $data = $this->where('category_id', '=', $id)
                    ->where('name', '=', $name)->get();
        return $data->toArray();
    }
    public function getAllGoods()
    {
        $data = $this->join('categories', 'goods.category_id', '=', 'categories.id')
                 ->select('goods.*', 'categories.name as categories_name')
                 ->get();
        return $data->toArray();
    }
    public function goodsUpdate($id, $data)
    {
        $data = $this->find($id)->update($data);
        return true;
    }

}
