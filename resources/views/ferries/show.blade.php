<x-app-layout>
    <div class="min-h-screen bg-blue-400 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                
                <div class="p-6 pb-0 flex justify-center">
                    @if($ferry->image_path)
                        <img src="{{ asset('storage/' . $ferry->image_path) }}" 
                             alt="{{ $ferry->name }}" 
                             class="rounded-lg max-h-80 object-cover w-full shadow-sm">
                    @else
                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                            Pas d'image disponible
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    
                    <h1 class="text-3xl font-bold text-center text-black mb-6">
                        {{ $ferry->name }}
                    </h1>

                    <div class="border-t-4 border-[#1e3a8a] w-full mb-6"></div>

                    <div class="flex justify-center text-lg font-bold text-black pb-6 border-b-4 border-[#1e3a8a] mb-6">
                        
                        <div class="text-right pr-6 border-r-2 border-black w-1/2">
                            <p class="mb-1">Longueur : {{ $ferry->length }} m</p>
                            <p>Largeur : {{ $ferry->width }} m</p>
                        </div>

                        <div class="text-left pl-6 w-1/2">
                            <p class="mb-1">Vitesse : {{ $ferry->speed }} noeuds</p>
                           
                        </div>
                    </div>

                    <div class="text-left px-4">
                        <h3 class="text-black font-medium mb-2">Equipement :</h3>
                        <ul class="pl-4 space-y-1 text-black text-sm">
                            @foreach($ferry->equipments as $equipment)
                                <li>{{ $equipment->name }}</li>
                            @endforeach
                            
                            @if($ferry->equipments->isEmpty())
                                <li class="text-gray-400 italic">Aucun équipement</li>
                            @endif
                        </ul>
                    </div>

                    <div class="mt-10 flex justify-between items-center px-4">

                       <a href="{{ route('ferries.edit', $ferry) }}" class="bg-[#1e4078] hover:bg-blue-800 text-white font-bold py-2 px-6 rounded text-sm shadow inline-block">
                        Modifier les informations
                    </a>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('ferry.pdf', $ferry->id) }}" class="text-xs text-gray-400 hover:text-gray-600 underline">
                            Télécharger en PDF
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>