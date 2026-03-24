<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h1 class="text-2xl font-bold text-center mb-6 text-blue-900">Ajouter un nouveau Ferry</h1>

                    <form action="{{ route('ferries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block font-bold text-sm text-gray-700 mb-2">Nom du Ferry</label>
                            <input type="text" name="name" placeholder="Ex: Titanic" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   required>
                        </div>

                        <div class="mb-6 flex gap-4">
                            <div class="w-1/3">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Longueur (m)</label>
                                <input type="number" step="0.01" name="length" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="w-1/3">
                                <label class="block font-bold text-sm text-gray-700 mb-2">Largeur (m)</label>
                                <input type="number" step="0.01" name="width" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
    <div class="w-1/3">
        <label class="block font-bold text-sm text-gray-700 mb-2">Vitesse (noeuds)</label>
        <input type="number" step="0.1" name="speed" class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>
</div>

                        <div class="mb-6">
                            <h3 class="font-bold text-lg mb-2">Equipements :</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach($equipments as $equipment)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="eq_{{ $equipment->id }}" name="equipments[]" value="{{ $equipment->id }}" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <label for="eq_{{ $equipment->id }}" class="ml-2 text-sm text-gray-600">{{ $equipment->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block font-bold text-sm text-gray-700 mb-2">Image</label>
                            <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow">
                                Créer le bateau
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>