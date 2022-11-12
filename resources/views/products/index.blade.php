<x-app-layout>
    <div class="container mx-auto w-3/5 my-8 px-4 py-4">
        <div class="flex justify-end items-center mb-3">
            <h4 class="text-gray-400 text-sm">並び替え</h4>
            <ul class="flex">
            </ul>
        </div>
    <div id="navArea">
    <nav>
    <div class="inner">
    {{-- <ul> --}}
        <div class="flex justify-between">
            <div class="w-2/5">
        {{-- <li> --}}<h3 class="mb-3 text-gray-400 text-sm">検索条件</h3>{{-- <li> --}}
                <ul>
                    {{-- <li> --}}<li class="mb-2">
                        <a href="/"
                            class="hover:text-blue-500 {{ Request::get('category_id') ?: 'text-green-500 font-bold' }}">
                            全て
                        </a>
                    {{-- <li> --}}
                    {{-- <li> --}}
                    </li>
                    @foreach ($categories as $o)
                        <li class="mb-2">
                            <a href="/?category_id={{ $o->id }}"
                                class="hover:text-blue-500 {{ Request::get('category_id') == $o->id ? 'text-green-500 font-bold' : '' }}">
                                {{ $o->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
    </div>
            <div class="w-full">
                @foreach ($products as $j)
                    <div class="bg-white w-full px-10 py-8 hover:shadow-2xl transition duration-500">
                        <div class="mt-4">
                            <div class="flex justify-between text-sm items-center mb-4">
                                <div class="border border-gray-900 px-2 h-7 leading-7 rounded-full">
                                    {{ $j->category->name }}
                                </div>
                                
                            </div>
                            <h2 class="text-lg text-gray-700 font-semibold">{{ $j->product_name }}
                            </h2>
                            <img class="w-full mb-2" src="{{ $j->image_url }}" alt="">
                            <p class="mt-4 text-md text-gray-600">
                                {{ Str::limit($j->description, 50, '...') }}
                            </p>
                            <div class="flex justify-between items-center">
                                <div class="mt-4 flex items-center space-x-4 py-6">
                                    {{-- ここは消していい --}}
                                    {{-- <div>
                                            <img class="h-8 w-8 rounded-full object-cover"
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                src="{{ $j->masa->profile_photo_url }}" alt="{{ $j->masa->name }}" />
                                        @endif
                                    </div> --}}
                                    {{-- ここまで --}}
                                    <div class="text-sm font-semibold">
                                        ${{ $j->price }}
                                        <span class="font-normal ml-2"></span>
                                    </div>
                                    <div class="text-sm font-semibold">
                                        {{-- {{ $j->masa->name }} --}}
                                        
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('products.show', $j) }}"
                                        class="flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600 hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 mt-4 px-5 py-3 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
                                        detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                <div class="block mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
