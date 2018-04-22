<?php

namespace App\Http\Controllers;
use App\Mail;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;
use App\Traits\Content;
use PHPMailer\PHPMailer;

class Orders extends Controller
{
    use Content;
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        $data = $this->auth();
        $data['cat'] = $this->getCategories();
        $data['login'] =Auth::user()->name;
        $random_items = $this->makeRandomItems();
        $orders = $this->getOrders();
        $data['bucket'] =count($orders['orders']);
        $data = array_merge($data, $random_items, $orders);
         return view('cart', $data);
    }

    public function register(Request $request)
    {

        $data = $request->all();
        foreach ($data as $key => $value) {
            if (empty($value)) {
                return json_encode(['message' =>'Заполните все поля']);
            }
            $data[$key] = strip_tags($value);
            $data[$key] = htmlspecialchars($data[$key], ENT_QUOTES);
        };
        Order::create([ 'customer_name' => $data['name'],
                        'customer_email' => $data['email'],
                        'product_id' => $data['id'],
                        'customer_id' => $data['customer']]);
         return json_encode(['message' =>'Заказ зарегистрирован']);
    }
    public function confirm()
    {
         $data = $this->orders->getOrdersById(Auth::user()->id);
         $this->orders->confirm(Auth::user()->id);
         $body='';

        foreach ($data as $item) {
            $body .= "<h2>Cделан заказ</h2>
                      <p>Товар:{$item['name']}</p>
                      <p>Цена:{$item['price']}</p>";
        }
        $headers ='From:Гейммагаз'. "\r\n".
            'MIME-version: 1.0'."\r\n".
            'Content-Type: text/html; charset=UTF-8';
        $mail = new PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host ='smtp.yandex.ru';
        $mail->Username = 'test45792@yandex.ru';
        $mail->Password ='halo45lz';
        $mail->SMTPSecure="ssl";
        $mail->Port = 465;
        $mail->setFrom('test45792@yandex.ru', 'test');
        $mail->addAddress($this->mail(true));
        $mail->AddReplyTo('test45792@yandex.ru', 'First Last');
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = "Order";
        $mail->Body = $body;
        if ($mail->send()) {
            return redirect()->back()->with('message', 'Заказ подтвержден');
        }
        return redirect()->back()->with('message', 'Ошибка: повторите попытку позже');
    }
    public function mail($flag = false)
    {
        if (Auth::user() && Auth::user()->Admin) {
            $data['mail'] =  Mail::find(1)->toArray()['address'];
            if ($flag) {
                return  $data['mail'];
            }
            return view('mail', $data);
        }
        return redirect('/');

    }
    public function changeMail(Request $request)
    {
        Mail::find(1)->update(['address' =>$request->mail]);
        return redirect('/admin/mail')->with('message', 'Адресс изменен');
    }
    public function getOrdersAdmin()
    {
        if (Auth::user() && Auth::user()->Admin) {
            $data['orders'] = $this->orders->getAllOrders();
            return view('orders-list', $data);
        }
        return redirect('/');

    }

}
