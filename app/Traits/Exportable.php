<?php

namespace App\Traits;

use Schema;
use Excel;


/**
 *
 * using Exportable trait obliges defining $selects_on_export field in classes.
 *
*/
trait Exportable
{
    public static function getExportableFields()
    {
        return array_values(array_diff(collect(Schema::getColumnListing((new static)->getTable()))->sort()->all(), isset(static::$hidden_on_export) ? static::$hidden_on_export : []));
    }

    /**
     * Экспорт данных в excel файл
     *
     */
    public static function export($request) {
        $table_name = (new static)->getTable();
        return Excel::create($table_name . '_' . date('Y-m-d_H-i-s'), function($excel) use ($request, $table_name) {
            $excel->sheet($table_name, function($sheet) use ($request) {
                // если экспортируем HTML, то только длина символов
                static::$selects_on_export[] = isset(static::$long_fields) && in_array($request->field, static::$long_fields) ? \DB::raw("LENGTH({$request->field}) as {$request->field}") : $request->field;

                $sheet->fromArray(static::select(array_unique(static::$selects_on_export))->get(), null, 'A1', true);
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
                foreach ($reader->all()->toArray() as $model) {
                    if (isset(static::$long_fields)) {
                        foreach (static::$long_fields as $field) {
                            unset($model[$field]);
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