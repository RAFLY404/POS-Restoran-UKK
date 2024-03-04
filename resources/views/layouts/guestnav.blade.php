<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex-shrink-0">
                <a href="{{ route('home.index') }}" class="text-black text-xl font-bold">Restoran RM</a>
            </div>
            <div class="md:hidden">
                <!-- Mobile Menu Icon -->
                <button id="mobileMenuButton" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
            <div id="mobileMenu" class="hidden md:flex md:items-center md:ml-4">
                <!-- Mobile Menu Items -->
                <a href="{{ route('login') }}" class="text-black hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
            </div>
        </div>
    </div>
</nav>

<script>
    // JavaScript for mobile menu toggle
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
