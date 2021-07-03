<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients'; // Obrigatório somente se não seguirmos as convenções
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email']; 
}
