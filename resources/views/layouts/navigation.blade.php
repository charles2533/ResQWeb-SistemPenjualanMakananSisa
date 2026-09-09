<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 shadow-sm backdrop-blur">
    @php
        $pendingSellerOrders = Auth::user()->role === 'seller'
            ? \App\Models\Order::where('status', 'pending')
                ->whereHas('food', fn ($query) => $query->where('seller_id', Auth::id()))
                ->count()
            : 0;
    @endphp

    <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
        <div class="flex min-h-16 items-center justify-between gap-3 py-3">
            <div class="flex min-w-0 items-center gap-3 sm:gap-8">
                <div class="flex shrink-0 items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-500">
                            <span class="text-white font-bold text-sm">R</span>
                        </div>
                        <span class="hidden text-lg font-extrabold tracking-tight text-gray-900 sm:block">ResQ-Food</span>
                        <span class="ml-1 rounded bg-orange-100 px-2 py-1 text-[10px] font-extrabold uppercase tracking-wider text-orange-600">
                            {{ Auth::user()->role }}
                        </span>
                    </a>
                </div>

                <div class="hidden h-full space-x-6 sm:flex">
                    @if(Auth::user()->role == 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('seller.dashboard') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">Keuangan</a>
                        <a href="{{ route('seller.inventory') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('seller.inventory') || request()->routeIs('food.create') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">Stok Makanan</a>
                        <a href="{{ route('seller.donations') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('seller.donations') || request()->routeIs('seller.donations.create') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">Donasi</a>
                        <a href="{{ route('seller.orders') }}" class="inline-flex items-center gap-2 px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('seller.orders') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">
                            <span>Pesanan Masuk</span>
                            @if($pendingSellerOrders > 0)
                                <span class="inline-flex min-w-5 items-center justify-center rounded-full bg-orange-500 px-1.5 py-0.5 text-[10px] font-extrabold leading-none text-white">
                                    {{ $pendingSellerOrders }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if(Auth::user()->role == 'customer')
                        <a href="{{ route('katalog.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('katalog.index') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">Katalog</a>
                        <a href="{{ route('order.history') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('order.history') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">Pesanan Saya</a>
                    @endif

                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('admin.dashboard') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">Dashboard</a>
                    @endif

                    <a href="{{ Auth::user()->role === 'seller' ? route('terms.seller') : route('terms.customer') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold transition duration-150 ease-in-out {{ request()->routeIs('terms.show') || request()->routeIs('terms.customer') || request()->routeIs('terms.seller') ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-orange-500 hover:border-orange-300' }}">T&C</a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-6">
                <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-500 hover:text-orange-500 transition">
                    Halo, {{ Auth::user()->name }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition">
                        Keluar
                    </button>
                </form>
            </div>

            <button
                @click="open = ! open"
                class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white p-2 text-gray-500 shadow-sm transition hover:bg-gray-50 hover:text-orange-500 sm:hidden"
            >
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-gray-100 bg-white px-3 pb-4 pt-3 shadow-sm sm:hidden">
        <div class="mx-auto max-w-7xl space-y-2">
            @if(Auth::user()->role == 'seller')
                <a href="{{ route('seller.dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('seller.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">Keuangan</a>
                <a href="{{ route('seller.inventory') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('seller.inventory') || request()->routeIs('food.create') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">Stok Makanan</a>
                <a href="{{ route('seller.donations') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('seller.donations') || request()->routeIs('seller.donations.create') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">Donasi</a>
                <a href="{{ route('seller.orders') }}" class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('seller.orders') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">
                    <span>Pesanan Masuk</span>
                    @if($pendingSellerOrders > 0)
                        <span class="inline-flex min-w-5 items-center justify-center rounded-full bg-orange-500 px-1.5 py-0.5 text-[10px] font-extrabold leading-none text-white">
                            {{ $pendingSellerOrders }}
                        </span>
                    @endif
                </a>
            @endif

            @if(Auth::user()->role == 'customer')
                <a href="{{ route('katalog.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('katalog.index') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">Katalog</a>
                <a href="{{ route('order.history') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('order.history') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">Pesanan Saya</a>
            @endif

            @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">Dashboard</a>
            @endif

            <a href="{{ Auth::user()->role === 'seller' ? route('terms.seller') : route('terms.customer') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold {{ request()->routeIs('terms.show') || request()->routeIs('terms.customer') || request()->routeIs('terms.seller') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50 hover:text-orange-500' }}">T&C</a>

            <div class="rounded-2xl border border-gray-100 bg-gray-50 px-4 py-4">
                <a href="{{ route('profile.edit') }}" class="block text-sm font-semibold text-gray-700 hover:text-orange-500">
                    Halo, {{ Auth::user()->name }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-gray-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-gray-800">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
