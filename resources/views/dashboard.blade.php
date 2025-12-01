<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex">
            <div class="w-1/2 flex flex-col justify-center px-24">
                <h1 class="text-7xl font-semibold text-accent-secondary">{{ __('Welcome to Foody Dashboard') }}</h1>   
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

    </div>
</x-layouts.app>