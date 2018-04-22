<?php

namespace App\Http\Controllers;
use App\Traits\Content;

class About extends Controller
{
    protected $goods;
    use Content;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = $this->auth();
        $data['cat'] = $this->getCategories();
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items);
        return view('about', $data);
    }
}
