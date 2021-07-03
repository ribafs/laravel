<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedore extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendedores';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'email'];

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    
}
