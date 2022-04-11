<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    protected $table = 'user';

    public function getAllUsers(){

        $users=DB::select('SELECT * FROM user WHERE email=:email',[
            'email' => 'nhathuy@gmail.com'
        ]);

        return $users;

    }

    public function addUser($data){
        DB::insert('INSERT INTO user (fullname, email) VALUES (?, ?)', $data);
    }

    public function getDetail($id){
        return DB::select('SELECT * FROM '.$this->table.' WHERE id = ?',[$id]);
    }

    public function updateUser($data,$id){

        $data = array_merge($data,[$id]);

        return DB::update('UPDATE'.$this->table.'SET fullname=?, email=? WHERE id = ? ',[$data]);
    }

    public function deleteUser($id){
        return DB::delete('DELETE FROM $this->table WHERE id = ?', [$id]);
    }

    public function statementUser($sql){
        return DB::statement($sql);
    }

    public function learnQueryBuilder(){
        // Lấy tất cả bản ghi của table
        $list = DB::table($this->table)->get();
        
        // Lấy 1 bản ghi đầu tiên của table
        $detail = DB::table($this->table)->first();

        

    }

}
