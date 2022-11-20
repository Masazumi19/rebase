<x-app-layout>
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div class="flex justify-end items-center mb-3">
            <ul class="flex">
            </ul>

        </div>

        <div class="container max-w-7xl mx-auto px-4 md:px-13 pb-3 mt-3">
            <div class="flex flex-wrap text-sm items-center mb-4">
                @foreach ($products as $j)
                    <div class="bg-white w-full sm:w-1/2 md:w-1/3 px-10 py-8 hover:shadow-2xl transition duration-500">
                        <div class="mt-4 ">
                            <div class="border border-gray-900 px-2 h-7 leading-7 rounded-full">
                                {{ $j->category->name }}
                            </div>

                        </div>
                        <h2 class="text-lg text-gray-700 font-semibold">{{ $j->product_name }}
                        </h2>
                        <img class="mb-2" src="{{ $j->image_url }}" width="150px" height="150px" alt="">
                        <p class="mt-4 text-md text-gray-600">
                        
                            {{ Str::limit($j->description, 10, '...') }}
                        </p>

                        <div class="flex justify-between items-center">
                            @if (App\Models\Product::STATUS_DISPLAY == $j->status)
                                <form action="" method="POST">
                                    @csrf
                                    <div class="mt-4 flex items-center space-x-4 py-6 ">
                                        <div class="font-semibold text-2xl">
                                            ${{ $j->price }}
                                            <span class="font-normal ml-2"></span>
                                        </div>
                                    </div>
                                </form>
                            @else
                                    <div class="mt-4 flex items-center space-x-4 py-6 ">
                                <form action=""><input type="button" value="SOLD"
                                        class="bg-gradient-to-r bg-red-600 to-blue-600 hover:bg-gradient-to-l  text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500 w-full sm:w-32">
                                </form>
                                    </div>
                            @endif
                        </div>
                        

                        <div>
                            <a href="{{ route('products.show', $j) }}"
                                class="flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                See more
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
            <div class="block mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
