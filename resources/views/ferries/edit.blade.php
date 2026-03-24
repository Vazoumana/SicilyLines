<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h1 class="text-2xl font-bold text-center mb-6 text-blue-900 underline">
                        Modifier le bateau : {{ $ferry->name }}
                    </h1>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('ferries.update', $ferry->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-6">
                            <div class="mb-6">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Nom du Ferry</label>
                                <input type="text" name="name" value="{{ old('name', $ferry->name) }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" required>
</div>
                            <div class="mb-6">
                                <h3 class="font-bold text-lg mb-2">Caractéristiques :</h3>
                                <div class="flex gap-4">
                                    <div class="w-1/3">
                                        <label class="text-sm text-gray-600">Longueur</label>
                                        <input type="number" step="0.01" name="length" value="{{ old('length', $ferry->length) }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" required>
                                    </div>
        
        <div class="w-1/3">
            <label class="text-sm text-gray-600">Largeur</label>
            <input type="number" step="0.01" name="width" 
                   value="{{ old('width', $ferry->width) }}"
                   class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" required>
        </div>

        <div class="w-1/3">
            <label class="text-sm text-gray-600">Vitesse</label>
            <input type="number" step="0.1" name="speed" 
                   value="{{ old('speed', $ferry->speed) }}"
                   class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" required>
        </div>
    </div>
</div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">Modifier l'equipement :</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach($equipments as $equipment)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="eq_{{ $equipment->id }}" 
                                               name="equipments[]" 
                                               value="{{ $equipment->id }}"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm"
                                               @if($ferry->equipments->contains($equipment->id)) checked @endif>
                                        
                                        <label for="eq_{{ $equipment->id }}" class="ml-2 text-sm text-gray-600">
                                            {{ $equipment->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">Image du ferry :</h3>
                            
                            @if($ferry->image_path)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-500 mb-1">Image actuelle :</p>
                                    <img src="{{ asset('storage/' . $ferry->image_path) }}" class="h-20 rounded border">
                                </div>
                            @endif

                            <input type="file" name="image" class="text-sm text-gray-500 mt-2
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-600 file:text-white
                                hover:file:bg-blue-700">
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('dashboard') }}" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800">
                                Mettre à jour
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>