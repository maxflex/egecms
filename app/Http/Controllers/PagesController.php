<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;
use App\Http\Requests;
use App\Models\Page;
use App\Models\Variable;
use App\Models\Tag;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.index')->with(ngInit([
            'current_page'      => $request->page,
            'exportable_fields' => Page::getExportableFields('id'),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create')->with(ngInit([
            'model' => new Page
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.edit')->with(ngInit(compact('id')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Экспорт данных в excel файл
     *
     */
    public function export(Request $request) {
        return Excel::create('pages_' . date('Y-m-d_H-i-s'), function($excel) use ($request) {
            $excel->sheet('pages', function($sheet) use ($request) {
                $sheet->with(Page::select('id', $request->field)->get());
            });
        })->download('xls');
    }

    /**
     * Импорт данных из excel файла
     *
     */
    public function import(Request $request) {
        if ($request->hasFile('pages')) {
            Excel::load($request->file('pages'), function($reader){
                foreach ($reader->all()->toArray() as $page) {
                    Page::whereId($page['id'])->update($page);
                }
            });
        } else {
            abort(400);
        }
    }
}
