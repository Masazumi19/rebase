<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Error\Notice;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->query();
        $products = Product::search($params)//->published()
            ->with(['masa', 'category'])->latest()->paginate(5);

        $products->appends($params);

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product($request->all());
        $file = $request->file('image');
        // dd($product);
        // dd($file);
        $product->image = self::createFileName($file);
        $product->masa_id = Auth::user()->masa->id;

                    // 画像アップロード
            if (!Storage::putFileAs('images/products', $file, $product->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }

        
        try {
            // 登録
            $product->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors($e->getMessage());
            // ->withErrors('求人情報登録処理でエラーが発生しました');
        }

        return redirect()
            ->route('products.show', $product)
            ->with('notice', '求人情報を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $messages = $product->messages->load('user');
        $product->status = Product::STATUS_DISPLAY;
        $product->save();
        return view('products.show', compact('product', 'messages'));
        

        // return redirect()->route('job_offers.show', $job_offer)
        //     ->with('notice', '');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (Auth::user()->cannot('update', $product)) {
            return redirect()->route('products.show', $product)
                ->withErrors('自分の求人情報以外は更新できません');
        }
        $product->fill($request->all());
        try {
            $product->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('求人情報更新処理でエラーが発生しました');
        }
        return redirect()->route('products.show', $product)
            ->with('notice', '求人情報を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (Auth::user()->cannot('delete', $product)) {
            return redirect()->route('products.show', $product)
                ->withErrors('自分の求人情報以外は削除できません');
        }

        try {
            $product->delete();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('求人情報削除処理でエラーが発生しました');
        }

        return redirect()->route('products.index')
            ->with('notice', '求人情報を削除しました');
    }

    public function approval(Product $product)
    {
    // dd($product);
    $messages = $product->messages->load('user');
    // dd($product);
    $product->status = Product::STATUS_PURCHASED;
        $product->save();
        Session::flash('notice', '購入ありがとうございました');
    // dd($product);

        return view('products.show', compact('product', 'messages'))
            ->with('notice', '購入ありがとうございました');
        
        // return redirect()->route('products.show', $product)
        //     ->with('notice', '購入ありがとうございました');
    }

    private static function createFileName($file)
    {
    // dd($file);
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }

    
}
