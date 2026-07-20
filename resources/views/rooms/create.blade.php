<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Room</h2>
    </x-slot>

    <div class="max-w-lg mx-auto">
        <div class="bg-white p-6 shadow-sm rounded-xl border border-gray-100">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('rooms.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">Room Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">Description</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Price per Night (₱)</label>
                        <input type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night') }}" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium text-sm text-gray-700">Capacity (pax)</label>
                        <input type="number" name="capacity" value="{{ old('capacity', 2) }}" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 font-medium text-sm text-gray-700">Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-400 mt-1">Paste a direct image link (e.g. from Unsplash).</p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">
                        Add Room
                    </button>
                    <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>