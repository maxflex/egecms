<?php

namespace App\Models;

use App\Traits\Exportable;
use DB;
use Schema;
use Shared\Model;

class Page extends Model
{
   use Exportable;
   protected $commaSeparated = ['subjects'];

   protected $fillable = [
        'keyphrase',
        'url',
        'title',
        'keywords',
        'desc',
        'published',
        'h1',
        'html',
        'position',
        'sort',
        'place',
        'subjects',
        'station_id',
        'seo_desktop',
        'seo_mobile',
        'variable_id',
        'hidden_filter',
    ];

    protected static $hidden_on_export = [
        'id',
        'position',
        'created_at',
        'updated_at'
    ];

    protected static $selects_on_export = [
        'id',
        'keyphrase',
    ];

    protected static $long_fields = [
        'html'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setVariableIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['variable_id'] = null;
        } else {
            $this->attributes['variable_id'] = $value;
        }
    }

    private static function _getNextPosition()
    {
        return DB::table('pages')->max('position') + 1;
    }

    protected static function boot()
    {
        static::creating(function($model) {
            $model->position = static::_getNextPosition();
        });
    }

    public static function search($search)
    {
        $query = static::query();

        if (!empty($search->tags)) {
            foreach(Tag::getIds($search->tags) as $tag_id) {
                $query->whereHas('tags', function($query) use ($tag_id) {
                    $query->whereId($tag_id);
                });
            }
        }

        return $query;
    }
}
