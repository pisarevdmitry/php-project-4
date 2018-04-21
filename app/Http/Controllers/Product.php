<?php
namespace App\Http\Controllers;
use App\Categories;
use App\Goods;
use App\Order;
use Illuminate\Http\Request;
use App\Traits\Content;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Auth;

class Product extends Controller
{
    use Content;
    protected $goods;
    public function index($id)
    {

        $data = $this->auth();
        $data['cat'] = Categories::all()->toArray();
        $this->goods = new Goods();
        $product = $this->goods->getGoodsById($id);
        $data['product'] = $product[0];
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items);

        return view('product', $data);
    }
    public function productList()
    {
        if (Auth::user() && Auth::user()->Admin) {
            $this->goods = new Goods();
            $data['product'] = $this->goods->getAllGoods();
            return view('product-list', $data);
        }
        return redirect('/');

    }
    public function storeShow()
    {
        $data=['title' => "Создание Товара",
            'route' => '/admin/product/store',
             'product' => [
                'name' => '',
                'description' => '',
                'price' => '',
                'categories_name' => '',
                'id' => 'none'
            ],
            'btn' => 'Cоздать'];
        return view('product-form',$data);
    }
    public function delete($id, $flag=false)
    {
        $order =new Order();
        $product =  Goods::find($id)->toArray()['photo'];
        $data = $order->getOrdersByProductID($id);
        foreach ($data as $key => $value) {
            $order->deleteOrders($value['id']);
        }
        if (file_exists("./img/cover/$product")) {
            unlink("./img/cover/$product");
        }
        Goods::find($id)->delete();
        if ($flag) {
            return true;
        }
        return redirect('/admin/product');
    }
    public function editShow($id)
    {
        $this->goods = new Goods();
        $data['product'] = $this->goods->getGoodsById($id)[0];
        $data['title'] = "Редактирование товара Товара";
        $data['btn'] = "Изменить";
        $data['route'] = '/admin/product/edit';
        return view('product-form', $data);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return redirect('/admin/product/store-form')->with('message', 'Заполните все поля');
            }
            if ($key === 'price' && !is_numeric($value)) {
                return redirect('/admin/product/store-form')->with('message', 'Цена должна быть числом');
            }
            if ($key !== 'file') {
                $data[$key] = strip_tags($value);
                $data[$key] = htmlspecialchars($data[$key], ENT_QUOTES);
            }
        }
        $category = new Categories();
        $cat = $category->getCategoryByName($data['category']);
        if (count($cat) < 1) {
            return redirect('/admin/product/store-form')->with('message', 'Категория не существует');
        };
        $this->goods = new Goods();
        $product = $this->goods->checkGoods($data['name'], $cat[0]['id']);
        if (count($product) > 0) {
            return redirect('/admin/product/store-form')->with('message', 'Товар в данной категории уже существует');
        };
        $file = $request->file;
        $type = $file->getClientMimeType();

        if (preg_match('/jpg/', $_FILES['file']['name']) or preg_match('/png/', $_FILES['file']['name'])) {
            if (preg_match('/jpg/', $type) or preg_match('/png/', $type)
                or preg_match('/jpeg/', $type)) {
                do {
                    $name = md5(microtime() . rand(0, 9999));
                    $filesource ="./img/cover/$name.jpg";
                } while (file_exists($filesource));
                $this->goods->create([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'photo' => "$name.jpg",
                    'description' =>$data['description'],
                    'category_id' => $cat[0]['id']
                ]);
                $image = Image::make($file->getRealPath());
                $image ->resize(600, 300)->save("./img/cover/$name.jpg");
                return redirect('/admin/product/store-form')->with('message', 'Товар создан');
            } else {
                return redirect('/admin/product/store-form')->with('message', 'Не поддерживаемый тип файлов');

            }
        } else {
                    return redirect('/admin/product/store-form')->with('message', 'Не поддерживаемое расширение файла');
        }
    }
    public function edit(Request $request)
    {
         $data = $request->all();
         foreach ($data as $key => $value) {
            if (empty($value)) {
                return redirect("/admin/product/edit-form/{$data['id']}")->with('message', 'Заполните все поля');
            }
            if ($key === 'price' && !is_numeric($value)) {
                return redirect("/admin/product/edit-form/{$data['id']}")->with('message', 'Цена должна быть числом');
            }
            if ($key !== 'file') {
                $data[$key] = strip_tags($value);
                $data[$key] = htmlspecialchars($data[$key], ENT_QUOTES);
            }
        }
        $category = new Categories();
        $cat = $category->getCategoryByName($data['category']);
        if (count($cat) < 1) {
            return redirect("/admin/product/edit-form/{$data['id']}")->with('message', 'Категория не существует');
        };
        $this->goods = new Goods();
        $product = $this->goods->checkGoods($data['name'], $cat[0]['id']);
        if (count($product) > 0 && $data['name'] !== $data['old_name']) {
            return redirect("/admin/product/edit-form/{$data['id']}")
                   ->with('message', 'Товар в данной категории уже существует');
        };
        $file = $request->file;
        $type = $file->getClientMimeType();
        if (preg_match('/jpg/', $_FILES['file']['name']) or preg_match('/png/', $_FILES['file']['name'])) {
            if (preg_match('/jpg/', $type) or preg_match('/png/', $type)
                or preg_match('/jpeg/', $type)) {
                $old_file = $this->goods->find($data['id'])->toArray()['photo'];
                if (file_exists("./img/cover/$old_file")) {
                    unlink("./img/cover/$old_file");
                }
                do {
                    $name = md5(microtime() . rand(0, 9999));
                    $filesource ="./img/cover/$name.jpg";
                } while (file_exists($filesource));
                $this->goods->goodsUpdate($data['id'], [
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'photo' => "$name.jpg",
                    'description' =>$data['description'],
                    'category_id' => $cat[0]['id']
                ]);
                $image = Image::make($file->getRealPath());
                $image ->resize(600, 300)->save("./img/cover/$name.jpg");
                return redirect("/admin/product/edit-form/{$data['id']}")->with('message', 'Товар Изменен');
            } else {
                return redirect("/admin/product/edit-form/{$data['id']}")
                    ->with('message', 'Не поддерживаемый тип файлов');

            }
        } else {
            return redirect("/admin/product/edit-form/{$data['id']}")
                ->with('message', 'Не поддерживаемое расширение файла');
        }
    }
}
