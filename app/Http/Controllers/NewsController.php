<?php

namespace App\Http\Controllers;

use App\NewsModel;
use App\Traits\Content;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class NewsController extends Controller
{
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
        $news = $this->getNews();
        $data['news'] = array_map(function ($item) {
            $item['exerp'] = substr($item['content'], 0, 200).'. . .';
            $item['date'] = Carbon::createFromFormat('Y-m-d H:i:s', $item['created_at'])->format('j.m.Y');
            return $item;
        }, $news);

        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items);
        $data['last_news'] = $this->getLastNews();
        return view('news-page', $data);
    }
    public function article($id)
    {
        $data = $this->auth();
        $data['cat'] = $this->getCategories();
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $news = $this->getNews();
        $data['news'] = NewsModel::find($id)->toArray();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items);
        $data['last_news'] = $this->getLastNews();
        //dd($data);
        return view('news-item', $data);
    }
    public function newsList()
    {
        $data['news'] = $this->getNews();

        foreach ($data['news'] as $key => $value) {
            $data['news'][$key]['date'] =Carbon::createFromFormat('Y-m-d H:i:s', $value['created_at'])->format('j.m.Y');
        }

        return view('news-list', $data);
    }
    public function storeShow()
    {
        $data=['title' => "Создание Новости",
            'route' => '/admin/news/store',
            'news' => [
                'header' => '',
                'content' => '',
                'id' => 'none',

            ],
            'btn' => 'Cоздать'];

        return view('news-form', $data);
    }
    public function editShow($id)
    {
        $data['news']= NewsModel::find($id)->toArray();
        $data['title'] = "Редактирование Новость";
        $data['btn'] = "Изменить";
        $data['route'] = '/admin/news/edit';
        return view('news-form', $data);
    }
    public function delete($id)
    {
        NewsModel::find($id)->delete();
        Cache::forget('news');
        return redirect('/admin/news');
    }
    public function store(Request $request)
    {
        $request->validate([
            'header' => 'required',
            'content' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg'
        ], [
            'header.required' => 'Введите Заголовок Новости',
            'content.required' => 'Введите Текст Новости',
            'file.required' => ' Загрузите изображение ',
            'file.image' => ' Не поддерживаемое расширение файла',
            'file.mimes' => ' Не поддерживаемый тип файлов',
        ]);
        $data = $request->all();
        $news = new NewsModel();
        $cat = $news->getNewsByName($data['header']);
        if (count($cat) > 0) {
            return redirect('/admin/news/store-form')->with('message', 'Новость уже существует');
        };
        $file = $request->file;
        do {
            $name = md5(microtime() . rand(0, 9999));
            $filesource ="./img/news/$name.jpg";
        } while (file_exists($filesource));
        $news->create([
            'header' => $data['header'],
            'photo' => "$name.jpg",
            'content' =>$data['content'],
        ]);
        $image = Image::make($file->getRealPath());
        $image ->resize(600, 300)->save("./img/news/$name.jpg");
        Cache::forget('news');
        return redirect('/admin/news/store-form')->with('message', 'Новость создана');

    }
    public function edit(Request $request)
    {
        $request->validate([
            'header' => 'required',
            'content' => 'required',
            'file' => 'required|image|mimes:jpg,png,jpeg'
        ], [
            'header.required' => 'Введите Заголовок Новости',
            'content.required' => 'Введите Текст Новости',
            'file.required' => ' Загрузите изображение ',
            'file.image' => ' Не поддерживаемое расширение файла',
            'file.mimes' => ' Не поддерживаемый тип файлов',
        ]);
        $data = $request->all();
        $news = new NewsModel();
        $cat = $news->getNewsByName($data['header']);
        if (count($cat) > 0 && $data['header'] !== $data['old_name']) {
            return redirect('/admin/news/store-form')->with('message', 'Новость уже существует');
        };
        $file = $request->file;
        $old_file =$news->find($data['id'])->toArray()['photo'];
        if (file_exists("./img/news/$old_file")) {
            unlink("./img/news/$old_file");
        }
        do {
            $name = md5(microtime() . rand(0, 9999));
            $filesource ="./img/news/$name.jpg";
        } while (file_exists($filesource));

        $news->updateNews($data['id'], [
            'header' => $data['header'],
            'photo' => "$name.jpg",
            'content' =>$data['content'],
        ]);
        $image = Image::make($file->getRealPath());
        $image ->resize(600, 300)->save("./img/news/$name.jpg");
        Cache::forget('news');
        return redirect('/admin/news/store-form')->with('message', 'Новость Изменена');

    }
}
