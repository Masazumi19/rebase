<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        logger($request);
        $message = new Message($request->all());
        $message->user_id = $request->user()->id;
        $message->messageable_id = $product->id;
        $message->messageable_type = 'App\Models\Product';

        try {
            // 登録
            $message->save();
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response('', 500);
        }

        return response($message, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Message $message)
    {
        return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Message $message)
    {
    

        $message->fill($request->all());

        try {
            // 登録
            $message->save();
        } catch (\Throwable $th) {
                    logger($th);
            return response('', 500);
        }

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Message $message)
    {
        
        
        try {
            // 登録
            $message->delete();
        } catch (\Throwable $th) {
            logger($th);
            return response('', 500);
        }

        return response('', 204);
    }
}
