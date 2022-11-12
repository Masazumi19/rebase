<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-indigo-900 shadow-md rounded-md">
        <h2 class="text-center text-lg text-white font-bold pt-6 tracking-widest">求人情報更新</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('products.update', $product) }}" method="POST" class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-white mb-2" for="product_name">
                    タイトル
                </label>
                <input type="text" name="product_name"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('product_name', $product->product_name) }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="category_id">
                    職種
                </label>
                <select name="category_id"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required>
                    <option disabled selected value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == old('category_id', $product->category_id)) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="description">
                    詳細
                </label>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="price">
                    </label>
                    <input type=”number” name="price" min="0"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                        required placeholder="希望価格" value="{{ old('price') }}">
                </div>
                <textarea name="description" rows="10"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="詳細">{{ old('description', $product->description) }}</textarea>
            </div>
            <input type="submit" value="更新"
                class="w-full flex justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout>
