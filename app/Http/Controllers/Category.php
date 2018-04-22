<?php

namespace App\Http\Controllers;
use App\Categories;
use App\Goods;
use App\Http\Requests\CategoryReq;
use App\Traits\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class Category extends Controller
{
    use Content;
    protected $goods;
    public function index($id)
    {
        $data = $this->auth();
        $all = $this->getCategories();
        $all_goods = $this->getGoods();
        foreach ($all_goods as $key => $value) {
            if ($value['category_id'] == $id) {
                $current_goods[] = $value;
            }
        }
        foreach ($all as $key => $value) {
            if ($value['id'] == $id) {
                $data['category'] = $value;
            }
        }
        if (!isset($current_goods)) {
            $current_goods = [];
        }
        $this->goods = new Goods();
        $result = $this->paginate($current_goods);
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $result, $random_items);
        $data['cat'] = $this->getCategories();
        $current = array_slice($current_goods, ($data['current_page'] - 1) * 6, 6);
        $data['goods'] = $current;
        return view('category', $data);
    }
    public function CategoryList()
    {
        if (Auth::user() && Auth::user()->Admin) {
            $data['cat'] = Categories::all()->toArray();
            return view('category-list', $data);
        }
        return redirect('/');
    }

    public function storeShow()
    {
        $data=['title' => "Создание категории",
                'route' => '/admin/category/store',
                 'cat' => [
                    'name' => '',
                    'description' => '',
                    'id' => 'not exist'
                ],
                'btn' => 'Cоздать'];
        return view('form-category', $data);
    }
    public function delete($id)
    {
        $this->goods = new Goods();
        $data = $this->goods->getGoodsByCategory($id);
        $product = new Product();
        foreach ($data as $key => $value) {
            $product->delete($value['id'], true);
        }
        Categories::find($id)->delete();
        Cache::forget('Categories');
        return redirect('/admin/category');
    }
    public function editshow($id)
    {
        $data['cat'] = Categories::find($id)->toArray();
        $data['route'] ="/admin/category/edit";
        $data['title'] = "Создание категории";
        $data['btn'] = 'Изменить';
        $data['edit'] =true;
        return view('form-category', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ], [
            'name.required' => 'Введите Название категории',
            'description.required' => 'Введите Описание категории',
        ]);
        $data = $request->all();
        $category = new Categories();
        $cat = $category->getCategoryByName($request->name);
        if (count($cat) > 0) {
            return redirect('/admin/category/store-form')->with('message', 'Категория уже существует');
        };
        foreach ($data as $key => $value) {
            $data[$key] = strip_tags($value);
            $data[$key] = htmlspecialchars($data[$key], ENT_QUOTES);
        }
        $category->create(['name' => $data['name'],
                            'description' => $data['description']]);
        Cache::forget('Categories');
        return redirect('/admin/category/store-form')->with('message', 'Категория создана');
    }
    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ], [
            'name.required' => 'Введите Название категории',
            'description.required' => 'Введите Описание категории',
        ]);
        $data = $request->all();
        foreach ($data as $key => $value) {
            $data[$key] = strip_tags($value);
            $data[$key] = htmlspecialchars($data[$key], ENT_QUOTES);
        }
        $category = new Categories();
        $cat = $category->getCategoryByName($data['name']);
        if (count($cat) > 0 && $data['name'] !== $data['old_name']) {
            return redirect("/admin/category/edit-form/{$request->id}")->with('message', 'Категория уже существует');
        };
        $category->updateCategory($data['id'], ['name'=> $data['name'],
                                                'description' => $data['description']]);
        Cache::forget('Categories');
        return redirect("/admin/category/edit-form/{$data['id']}")->with('message', 'Категория Изменена');
    }
}
