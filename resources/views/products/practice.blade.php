@if (App\Models\Product::STATUS_DISPLAY == $product->status) {{-- もし一致したら--}}
<form action="" method="POST">
@csrf

<div class="mt-4 flex items-center space-x-4 py-6 ">
                                <div class="font-semibold text-2xl">
                                    ${{ $price }}{{-- 値段の表示 --}}
                                    <span class="font-normal ml-2"></span>
                                </div>
                            </div>
@else<form action=""><input type="button" value="SOLD" class="bg-gradient-to-r bg-red-600 to-blue-600 hover:bg-gradient-to-l  text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
        </form>

