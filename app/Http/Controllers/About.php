<?php

namespace App\Http\Controllers;
use App\Categories;
use App\Goods;
use Illuminate\Http\Request;
use App\Traits\Content;

class About extends Controller
{
    protected $goods;
    use Content;
    public function index()
    {
        $data = $this->auth();
        $data['cat'] = $this->getCategories();;
        $this->goods = new Goods();
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items);
        return view('about', $data);
    }
}
