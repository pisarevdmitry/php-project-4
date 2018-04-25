<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $guarded = ['id'];
    public function getNewsByName($name)
    {
        $data = $this->where("header", '=', $name)->get();
        return $data->toArray();
    }
    public function updateNews($id, $data)
    {
        $this->find($id)->update($data);
        return true;
    }
    public function getAllNews()
    {
        $data = $this->orderBy('created_at', 'desc')->get();
        return $data->toArray();
    }
    public function searchNews($search)
    {
        $data = $this->where('header', 'LIKE', "%$search%") ->get();
        return $data->toArray();
    }
}
