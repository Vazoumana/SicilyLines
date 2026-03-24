<x-app-layout>
  

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <h3 class="text-blue-900 font-bold text-lg mb-4">Ferry</h3>
                <hr class="border-blue-900 mb-6">

                <div class="space-y-6">
                    @foreach($ferries as $ferry)
                        <div class="flex items-center justify-between border-b pb-4 border-gray-300">
                            
                            <div class="text-gray-700 font-medium w-1/3">
                                {{ $ferry->name }}
                            </div>
                            
                            <div class="flex space-x-4 w-2/3 justify-end">
                                <form action="{{ route('ferries.destroy', $ferry) }}" method="POST" onsubmit="return confirm('Etes-vous sûr ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-6 rounded shadow">
                                        Supprimer
                                    </button>
                                </form>

                                <a href="{{ route('ferries.show', $ferry) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 px-8 rounded shadow">
                                    Voir
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 flex items-center justify-between">
                    <div class="flex space-x-4">
                        <a href="{{ route('ferries.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow">
                            Ajouter
                        </a>
                        
                        <a href="{{ route('ferries.pdf_all') }}" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow text-sm">
                            Generer les fiches details des ferry en pdf
                        </a>
                    </div>

                    <div>   
                        {{ $ferries->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>