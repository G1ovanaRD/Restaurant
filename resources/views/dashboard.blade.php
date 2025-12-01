<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex">
            <div class="w-1/2 flex flex-col justify-center px-24">
                <h1 class="text-7xl font-semibold text-accent-secondary">{{ __('Welcome to Foody Dashboard. The best food page') }}</h1>   
                <div class="flex gap-4">
                    <button>
                        <a href="{{ route('platillos.index') }}" class="mt-6 inline-block rounded-lg bg-green-600 px-6 py-3 text-lg font-medium text-white hover:bg-green-700">
                            {{ __('View Menu') }}
                        </a>
                    </button>  
                    <button>
                        <a href="{{ route('platillos.index') }}" class="mt-6 inline-block rounded-lg bg-black-food px-6 py-3 text-lg font-medium text-white hover:bg-[#2C2C2C]">
                            {{ __('Book Table') }}
                        </a>
                    </button>        
                </div>
            </div>
            <div class="w-1/2 flex items-center justify-center">
                <img src="{{ asset('images/banner.png') }}" alt="Food Delivery" />
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
                    @foreach($platillos as $platillo)
                    <div class="flex-none w-80 snap-start">
                        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 hover:shadow-xl transition-shadow">
                            <img src="{{ $platillo->imagen }}" alt="{{ $platillo->nombre }}" class="w-full h-48 object-cover">
                            
                            <div class="p-4 space-y-3">
                                <div>
                                    <flux:heading size="lg">{{ $platillo->nombre }}</flux:heading>
                                    <flux:badge size="sm" color="lime" class="mt-1 text-black">{{ $platillo->categoria }}</flux:badge>
                                </div>
                                <flux:text class="line-clamp-1">{{ $platillo->descripcion }}</flux:text>
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
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
    
    scrollLeft.addEventListener('click', function(e) {
        e.preventDefault();
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
    
    scrollRight.addEventListener('click', function(e) {
        e.preventDefault();
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
});
</script>