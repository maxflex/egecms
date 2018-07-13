<?php

namespace App\Traits;

use Schema;
use Excel;
use DB;

trait Exportable
{
    public static function getExportableFields()
    {
        return array_values(
                    array_merge(
                        array_diff(
                            collect(Schema::getColumnListing((new static)->getTable()))->sort()->all(),
                            isset(static::$hidden_on_export) ? static::$hidden_on_export : []
                        ),
                        isset(static::$with_comma_on_export) ? static::$with_comma_on_export : []
                    )
        );
    }

    /**
     * Экспорт данных в excel файл
     *
     */
    public static function export($request) {
        $table_name = (new static)->getTable();
        return Excel::create($table_name . '_' . date('Y-m-d_H-i-s'), function($excel) use ($request, $table_name) {
            $excel->sheet($table_name, function($sheet) use ($request, $table_name) {

                $export_fields = explode(',', $request->fields);
                array_unshift($export_fields, 'id');

                $data = DB::table($table_name)
                    ->select($export_fields)
                    ->orderBy('keyphrase')
                    ->get();

                $exportData = [];
                foreach($data as $index => $d) {
                    foreach($d as $field => $value) {
                        if (in_array($field, static::$long_fields)) {
                            $exportData[$index][$field] = strlen($value);
                        } else {
                            $exportData[$index][$field] = $value;
                        }
                    }
                }

                $sheet->fromArray($exportData, null, 'A1', true);
            });
        })->download('xls');
    }

    /**
     * Импорт данных из excel файла
     *
     */
    public static function import($request) {
        if ($request->hasFile('imported_file')) {
            Excel::load($request->file('imported_file'), function($reader){
                $fillable = (new static)->getFillable();
                $fillable[] = 'id';
                
                foreach ($reader->all()->toArray() as $model) {
                    if (isset(static::$long_fields)) {
                        foreach (static::$long_fields as $field) {
                            unset($model[$field]);
                        }
                    }

                    if (isset(static::$with_comma_on_export) && $elem = static::find($model['id'])) {
                        foreach (static::$with_comma_on_export as $field) {
                            if (array_key_exists($field, $model)) {
                                $model[$field] && $elem->$field()->sync(explode(',', str_replace('.', ',', $model[$field]))); // 5,6 => 5.6 fix
                                unset($model[$field]);
                            }
                        }
                    }

                    foreach ($model as $key => $field) { // numbers app fix
                        if (! $key || ! in_array($key, $fillable)) {
                            unset($model[$key]);
                        }
                    }

                    static::whereId($model['id'])->update($model);
                }
            });
        } else {
            abort(400);
        }
    }
}
