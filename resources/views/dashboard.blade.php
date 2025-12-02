<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0">
            <div class="w-full md:w-1/2 flex flex-col justify-center px-6 md:px-12 lg:px-24">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-semibold text-accent-secondary">{{ __('Welcome to Foody Dashboard. The best food page') }}</h1>   
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-4">
                    <button class="w-full sm:w-auto">
                        <a href="{{ route('platillos.index') }}" class="block text-center rounded-lg bg-green-600 px-6 py-3 text-base md:text-lg font-medium text-white hover:bg-green-700">
                            {{ __('View Menu') }}
                        </a>
                    </button>  
                    <button class="w-full sm:w-auto">
                        <a href="{{ route('reservaciones.index') }}" class="block text-center rounded-lg bg-black-food px-6 py-3 text-base md:text-lg font-medium text-white hover:bg-[#2C2C2C]">
                            {{ __('Book Table') }}
                        </a>
                    </button>       
                </div>
            </div>
            <div class="w-full md:w-1/2 flex items-center justify-center px-6 md:px-0">
                <img src="{{ asset('images/banner.png') }}" alt="Food Delivery" class="max-w-full h-auto" />
            </div>
        </div>
        <!-- Carrusel de Platillos -->
        <div class="mt-5 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-3xl font-bold">{{ __('Featured Dishes') }}</h2>
                <div class="flex gap-2">
                    <button id="scroll-left" class="bg-black-food hover:bg-zinc-700 text-white p-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button id="scroll-right" class="bg-black-food hover:bg-zinc-700 text-white p-3 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="relative overflow-hidden">
                <div id="carrusel-container" class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth scrollbar-hide">
                    <!-- Los platillos se cargarán dinámicamente desde la API -->
                </div>
            </div>
        </div>
    </div>
    
</x-layouts.app>

<style>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('carrusel-container');
    const scrollLeft = document.getElementById('scroll-left');
    const scrollRight = document.getElementById('scroll-right');
    const scrollAmount = 350;
    
    // Botones de scroll
    scrollLeft.addEventListener('click', function(e) {
        e.preventDefault();
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
    
    scrollRight.addEventListener('click', function(e) {
        e.preventDefault();
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
    
    // Cargar platillos desde la API
    fetch('http://localhost:8001/api/platillo')
        .then(response => response.json())
        .then(data => {
            // Tomar solo los primeros 5 registros
            const platillos = data.slice(0, 5);
            
            // Renderizar los platillos
            container.innerHTML = platillos.map(platillo => `
                <div class="flex-none w-80 snap-start">
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 hover:shadow-xl transition-shadow">
                        <img src="${platillo.imagen}" alt="${platillo.nombre}" class="w-full h-48 object-cover">
                        
                        <div class="p-4 space-y-3">
                            <div>
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">${platillo.nombre}</h3>
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium bg-lime-100 text-black dark:bg-lime-900 dark:text-lime-100 mt-1">${platillo.categoria}</span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">${platillo.descripcion}</p>
                            <p class="text-lg font-bold text-green-600 dark:text-green-food">$${platillo.precio}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error('Error al cargar los platillos:', error);
            container.innerHTML = '<p class="text-red-500">Error al cargar los platillos</p>';
        });
});
</script>