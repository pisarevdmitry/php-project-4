<?php

namespace App\Http\Controllers;


use App\NewsModel;
use App\Traits\Content;
use Illuminate\Http\Request;

class Home extends Controller
{
    use Content;
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {

        $data = $this->auth();
        $all = $this->getGoods();
        $result = $this->paginate($all);
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $result, $random_items);
        $data['cat'] = $this->getCategories();
        $data['last_news'] = $this->getLastNews();
        $data['goods'] = array_slice($all, ($data['current_page'] - 1) * 6, 6);
         return view('index', $data);
    }


}
