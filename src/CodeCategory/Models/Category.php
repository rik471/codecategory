<?php

namespace CodePress\CodeCategory\Models;

use CodePress\CodeUser\Models\User;
use CodePress\CodePosts\Models\Post;
use Illuminate\Validation\Validator;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;


class Category extends Model implements SluggableInterface
{
    use SluggableTrait;

    private $validator;

    protected $table = "codepress_categories";

    protected $sluggable = [
      'build_from' => 'name',
      'save_to' => 'slug',
      'unique' => true
    ];

    protected $fillable = [
          'name', 'slug', 'active', 'parent_id' // categoria poderá ter outra categoria como pai
    ];

    public function categorizable() //O método categorizable será útil para permitir categorizar todos outros tipos de model.
    {
        return $this->morphTo();
    }

    public function posts() //O método categorizable será útil para permitir categorizar todos outros tipos de model.
    {
        return $this->morphedByMany(Post::class, 'categorizable', 'codepress_categorizables');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

     public function setValidator( Validator $validator){
         $this->validator = $validator;
     }

     public function getValidator(){
        return $this->validator;
    }

    public function isValid(){
        $validator = $this->validator;
        $validator->setRules(['name' => 'requires|max:255']);
        $validator->setData(
            $this->attributes// Método do eloquent que retorna os atributos da instância atual
        );//Se não receber um atributo name o teste irá falhar

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}