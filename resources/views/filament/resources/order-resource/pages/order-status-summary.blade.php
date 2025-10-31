<div class="mb-8">
    <div class="grid grid-cols-5 gap-6">
        <!-- Pending Orders Card -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-600 to-amber-600 rounded-2xl blur opacity-30 group-hover:opacity-70 transition duration-300"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-yellow-200 dark:border-yellow-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                            <x-heroicon-o-clock class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Pending</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Awaiting payment</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <span class="text-3xl font-black text-yellow-600 dark:text-yellow-400 tracking-tight">{{ $pending }}</span>
                    <div class="mt-2 h-1 bg-yellow-200 dark:bg-yellow-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-yellow-500 to-amber-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Paid Orders Card -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-green-600 rounded-2xl blur opacity-30 group-hover:opacity-70 transition duration-300"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-green-200 dark:border-green-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl">
                            <x-heroicon-o-currency-dollar class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Paid</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Successfully paid</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <span class="text-3xl font-black text-green-600 dark:text-green-400 tracking-tight">{{ $paid }}</span>
                    <div class="mt-2 h-1 bg-green-200 dark:bg-green-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-green-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- On Its Way Orders Card -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-30 group-hover:opacity-70 transition duration-300"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-blue-200 dark:border-blue-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <x-heroicon-o-truck class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">On Its Way</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Being delivered</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <span class="text-3xl font-black text-blue-600 dark:text-blue-400 tracking-tight">{{ $on_its_way }}</span>
                    <div class="mt-2 h-1 bg-blue-200 dark:bg-blue-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Orders Card -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-rose-600 rounded-2xl blur opacity-30 group-hover:opacity-70 transition duration-300"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-red-200 dark:border-red-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                            <x-heroicon-o-x-circle class="w-6 h-6 text-red-600 dark:text-red-400" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Cancelled</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Orders cancelled</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <span class="text-3xl font-black text-red-600 dark:text-red-400 tracking-tight">{{ $cancelled }}</span>
                    <div class="mt-2 h-1 bg-red-200 dark:bg-red-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-red-500 to-rose-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivered Orders Card -->
        <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl blur opacity-30 group-hover:opacity-70 transition duration-300"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-indigo-200 dark:border-indigo-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                            <x-heroicon-o-check-circle class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">Delivered</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Successfully delivered</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400 tracking-tight">{{ $delivered }}</span>
                    <div class="mt-2 h-1 bg-indigo-200 dark:bg-indigo-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>