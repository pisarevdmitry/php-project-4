<?php
namespace App\Traits;
use App\Goods;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
trait Content
{
    protected function auth()
    {
        if (Auth::user()) {
            $data['login'] =Auth::user()->name;
            $data['id'] =Auth::user()->id;
            $data['email'] =Auth::user()->email;
            $data['admin'] =Auth::user()->Admin;
            return $data;
        } else {
            $data['login'] =false;
            $data['id'] ='';
            $data['email'] ='';
            $data['admin'] =false;
            return $data;
        }
    }
    protected function makeRandomItems()
    {
        $all_goods = $this->goods->all()->toArray();
        $random = rand(0, count($all_goods)-1);
        $num = count($all_goods);
        for ($i= 1,$count = $num; $i <= 3; $i++) {
            if ($count < 1) {
                $data["our_goods"][] =[
                    'name' => '',
                    'id' => '',
                    'photo' => '',
                    'price' => ''
                ];
            } else {
                $data["our_goods"][] = $all_goods[ $random];
            }
            $count--;
        }
        if ($num < 1) {
            $data['rand_goods'] = ['name' => '',
                'id' => '',
                'photo' => '',
                'price' => ''];
        } else {
            $data['rand_goods'] = $all_goods[$random];
        }

        return $data;
    }
    protected function paginate($all)
    {
        $data['count'] = (int)ceil(count($all) / 6);
        if (isset($_GET['page'])) {
            if ($_GET['page'] < 1) {
                $page =1;
            } elseif ($_GET['page'] >$data['count']) {
                $page =$data['count'];
            } else {
                $page = $_GET['page'];
            }
        } else {
            $page =1;
        }
        $data['current_page'] = $page;
        return $data;
    }
    protected function getOrders()
    {

        if (Auth::user()) {
            $data['orders'] = $this->orders->getOrdersById(Auth::user()->id);
            $data['sum'] = 0;
            foreach ($data['orders'] as $key => $value) {
                $data['sum'] += $value['price'];
                $data['orders'][$key]['date'] =Carbon::createFromFormat('Y-m-d H:i:s', $value['date'])->format('j.m.Y');
            }
            return $data;
        } else {
            $data['orders'] = [];
            return $data;
        }
    }

}