<nav class="bg-[#0d4e80] border-b border-blue-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
          <div class="flex items-center">
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('images/logo-sicilylines.png') }}" alt="Sicily Lines Logo" class="h-16 w-auto">
    </a>
</div>

            <div class="flex items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-4 py-2 rounded flex items-center shadow-lg transition duration-150 ease-in-out">
                        Déconnexion
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</nav>