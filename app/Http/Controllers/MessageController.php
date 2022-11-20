<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Product;

class MessageController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, Request $request)
    {
        $message = new Message($request->all());
        $message->messageable_type = 'App\Models\Product';
        $message->messageable_id = $request->messageable_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;

        try {
            // 登録
            $message->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('メッセージ登録処理でエラーが発生しました');
        }

        $product = Product::find($request->messageable_id);

        return redirect()
            ->route('products.show', $product)
            ->with('notice', 'Post your message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Message $message)
    {
        $product = $message->messageable;

        if (Auth::user()->id != $message->user_id) {
            return redirect()->route('products.show', $product)
                ->withErrors('自分のメッセージ以外は削除できません');
        }

        try {
            $message->delete();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('メッセージ削除処理でエラーが発生しました');
        }

        return redirect()->route('products.show', $product)
        ->with('notice', ' メッセージを削除しました');
    }
}
