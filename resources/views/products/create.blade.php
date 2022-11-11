<x-app-layout>
    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-indigo-900 shadow-md rounded-md">
        <h2 class="text-center text-lg text-white font-bold pt-6 tracking-widest">商品情報登録</h2>

        <x-validation-errors :errors="$errors" />

        <form action="{{ route('products.store') }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-white mb-2" for="title">
                    タイトル
                </label>
                <input type="text" name="product_name"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="タイトル" value="{{ old('title') }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="categories_id">
                    カテゴリー
                </label>
                <select name="category_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3" required>
                    <option disabled selected value="">選択してください</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($category->id == old('category_id')) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="due_date">
                    募集期限（後で消すよ）
                </label>
                <input type="date" name="due_date"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="募集期限" value="{{ old('due_date') }}">
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="description">
                    詳細
                </label>
                <textarea name="description" rows="10"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-pink-600 w-full py-2 px-3"
                    required placeholder="詳細">{{ old('description') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-white mb-2" for="description">
                    公開状況（後で消すよ）
                </label>
                @foreach (App\Models\Product::STATUS_LIST as $value => $name)
                    <input type="radio" name="is_published" value="{{ $value }}" required>
                    <label class="text-white mr-2">{{ $name }}</label>
                @endforeach
            </div>
            <input type="submit" value="登録"
                class="w-full flex justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:bg-gradient-to-l hover:from-purple-500 hover:to-pink-600 text-gray-100 p-2 rounded-full tracking-wide font-semibold shadow-lg cursor-pointer transition ease-in duration-500">
        </form>
    </div>
</x-app-layout>

