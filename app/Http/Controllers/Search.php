<?php

namespace App\Http\Controllers;

use App\NewsModel;
use Illuminate\Http\Request;
use App\Traits\Content;
use Carbon\Carbon;

class Search extends Controller
{
    use Content;
    public function __construct()
    {
        parent::__construct();
    }
    public function searchGoods(Request $request)
    {
        $data = $this->auth();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $search = $request->search;
        $random_items = $this->makeRandomItems();
        $all = $this->goods->searchGoods($search);
        $result = $this->paginate($all);
        $data['cat'] = $this->getCategories();
        $data['last_news'] = $this->getLastNews();
        $data = array_merge($data, $random_items, $result);
        $data['search'] = array_slice($all, ($data['current_page'] - 1) * 6, 6);
        return view('search-goods', $data);
    }
    public function searchNews(Request $request)
    {
        $search = $request->search;
        $data = $this->auth();
        $data['cat'] = $this->getCategories();
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $news = new NewsModel();
        $data['news'] =  $news->searchNews($search);
        $data['news'] = array_map(function ($item) {
            $item['exerp'] = substr($item['content'], 0, 200).'. . .';
            $item['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('j.m.Y');
            return $item;
        }, $data['news']);
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items);
        $data['last_news'] = $this->getLastNews();
        return view('search-news', $data);
    }
}
