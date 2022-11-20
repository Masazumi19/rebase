<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::latest()->paginate($request->per_page);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product($request->all());
       
        $file = $request->file('image');
        $product->image = self::createFilename($file);
        $product->masa_id = 11;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $product->save();

            // 画像アップロード
            if (!Storage::putFileAs('images/products', $file, $product->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            logger($e->getMessage());
            return response(status: 500);
        }

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        $product->load('messages');

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)

    {

        $file = $request->file('image');
        if ($file) {
            $delete_file_path = $product->image_path;
            $product->image = self::createFilename($file);
        }
        $product->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $product->save();

            if ($file) {
                // 画像アップロード
                if (!Storage::putFileAs('images/products', $file, $product->image)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }

                // 画像削除
                if (!Storage::delete($delete_file_path)) {
                    //アップロードした画像を削除する
                    Storage::delete($product->image_path);
                    //例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            logger($e->getMessage());
            return response(status: 500);
        }

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {


        // トランザクション開始
        DB::beginTransaction();
        try {
            $product->delete();

            // 画像削除
            if (!Storage::delete($product->image_path)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの削除に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            logger($e->getMessage());
            return response(status: 500);
        }

        return response()->json($product, 204);
    }

    private static function createFilename($file)
    {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
