<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Traits\Content;
use Illuminate\Support\Facades\Cache;

class Home extends Controller
{
    use Content;
    protected $goods;
    public function index()
    {
        $data = $this->auth();
        $this->goods = new Goods();
        $all = $this->getGoods();
        $result = $this->paginate($all);
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $result, $random_items);
        $data['cat'] = $this->getCategories();
        $data['goods'] = array_slice($all, ($data['current_page'] - 1) * 6, 6);
         return view('index', $data);
    }

}
