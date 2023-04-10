<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\News\News;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $news = News::with('category')->get();

        return response()->json([
            'data' => $news
        ], Response::HTTP_OK);
    }

    /**
     * Carga la información de las listas del formulario
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLists()
    {
        try {

            $message = trans('messages.list-load-succesfully');

            $categories = \App\Helpers\get_list_details('CATNEWS');//TODO no carga el helper global

        }catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'message' => $message,
            'data' => $categories
        ], Response::HTTP_OK);
    }

    /**
     * Carga la información de todas las noticias Activas en la web
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllNews(Request $request)
    {
        $newsActives = null;

        try {

            $message = 'Noticias Cargadas con éxito';

            $skip = $request->skip;
            $limit = $request->limit;

            $total = News::published()->get()->count();

            $newsActives = News::with('category')
                ->published()
                ->orderBy('id', 'desc')
                ->skip($skip)
                ->take($limit)
                ->get()
                ->toArray();

        }catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'message' => $message,
            'data' => $newsActives,
            'total' => $total
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $message = 'Se creó la noticia con éxito !';
        $status = Response::HTTP_CREATED;
        $news = null;

        try {

            DB::beginTransaction();

            $fileName = null;

            if ($request->hasFile('image')) {
                $fileName = $this->upload($request);
            }

            $requestData = $request->all();

            $requestData['slug'] = Str::kebab($requestData['title']);
            $requestData['image'] = $fileName;
            $requestData['published'] = $requestData['published'] == 'true' ? 1 : 0;
            $requestData['user_id'] = auth()->user()->id;

            $news = News::create($requestData);

            DB::commit();

        } catch (\Exception $e) {
            $message = $e->getMessage().' File: '.$e->getFile(). ' Line: '.$e->getLine();
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            DB::rollBack();
        }

        return response()->json([
            'message' => $message,
            'data' => $news,
        ], $status);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $news = News::with(['category:id,code,name'])->find($id);

        return response()->json([
            'message' => 'Se obtuvo la noticia con éxito!',
            'news' => $news,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $message = 'Se actualizó la noticia con éxito !';
        $status = Response::HTTP_OK;
        $news = null;

        try {

            DB::beginTransaction();

            $fileName = null;

            if ($request->hasFile('image')) {
                $fileName = $this->upload($request);
            }

            $requestData = $request->all();

            $news = News::findOrFail($id);

            $requestData['slug'] = $news->slug;
            $requestData['published'] = $requestData['published'] == 'true' ? 1 : 0;
            $requestData['user_id'] = auth()->user()->id;

            if ($request->hasFile('image')) {
                if ($news->image != $fileName) {
                    $requestData['image'] = $fileName;
                }
            }

            $news->update($requestData);

            DB::commit();

        } catch (\Exception $e) {
            $message = $e->getMessage().' File: '.$e->getFile(). ' Line: '.$e->getLine();
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            DB::rollBack();
        }

        return response()->json([
            'message' => $message,
            'data' => $news,
        ], $status);
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
     * upload()
     *
     * Método privado para subir el archivo de la noticia
     *
     * @hideFromAPIDocumentation
     * @param $requestLocal
     * @return string $fileName
     */
    private function upload($requestLocal)
    {

        $fileName = $requestLocal->file('image')->getClientOriginalName();

        $requestLocal->file('image')->move(
            base_path() . '/public/upload/news/',
            $fileName
        );

        return $fileName;
    }
}
