<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posts extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id','title', 'url', 'author', 'paragraph', 'image'
    ];

    public function create($fields){
        return parent::create([
            'title' => $fields['title'], 
            'url' => $fields['url'], 
            'author' => $fields['author'],
            'paragraph' => $fields['paragraph'], 
            'image' => $fields['image']
        ]);
    }

    public function index(){
        return DB::select('SELECT * FROM posts');
    }

    public function show($id){
        return DB::select("SELECT * FROM posts WHERE id = " . $id);
    }
}