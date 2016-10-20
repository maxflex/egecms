<?php

namespace App\Models;

use Excel;
use DB;
use Schema;
use Shared\Model;

class Page extends Model
{
    const UPLOAD_FOLDER = 'storage/app/public';

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
        'subjects',
        'html',
        'created_at',
        'updated_at'
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

    public static function fieldsToExport()
    {
        return array_diff(Schema::getColumnListing('pages'), static::$hidden_on_export);
    }

    public static function export()
    {
        return Excel::create('pages_'.date('Y-d-m_H-i-s'), function($excel){
            $excel->sheet('pages', function($sheet) {
                $sheet->with(self::select(static::fieldsToExport())->get());
            });
        })->download('xls');
    }

    /**
     * Импорт данных из excel файла.
     *
     */
    public static function import($pathToFile = false)
    {
        if ($pathToFile) {
            Excel::load($pathToFile, function($reader){
                $pages = $reader->all()->toArray();

                foreach ($pages as $page) {
                    self::where('id', $page['id'])->update($page);
                }
            });
        }
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
