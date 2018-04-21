<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    protected $guarded = ['id'];
    public function getCategoryByName($name)
    {
        $data = $this->where("name", '=', $name)->get();
        return $data->toArray();
    }
    public function updateCategory($id,$data)
    {
        $data = $this->find($id)->update($data);
        return true;
    }
}
