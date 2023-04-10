<?php

namespace App\Models\Knowledge;

use Illuminate\Database\Eloquent\Model;

class KnowledgeSubcategory extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    
    protected $table = 'knowledge_subcategories';

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
    
    protected $fillable = [
        'name',
        'knowledge_category_id',
    ];
}
