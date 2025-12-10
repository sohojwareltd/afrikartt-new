<div class="mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="flex  border-b border-gray-200">
            <button @click="tab = 'personal'"
                :class="tab === 'personal' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Shop Info
            </button>
            <button @click="tab = 'shop'"
                :class="tab === 'shop' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Personal
            </button>
            <button @click="tab = 'security'"
                :class="tab === 'security' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Security
            </button>
            <button @click="tab = 'business'"
                :class="tab === 'business' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Business
            </button>
            <button @click="tab = 'production'"
                :class="tab === 'production' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Production
            </button>
            <button @click="tab = 'shipping'"
                :class="tab === 'shipping' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Shipping
            </button>
            <button @click="tab = 'payment'"
                :class="tab === 'payment' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Payment
            </button>
            <button @click="tab = 'documents'"
                :class="tab === 'documents' ? 'border-primary-500 text-primary-600' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="tab-button relative min-w-0 flex-shrink-0 px-6 py-4 text-sm font-medium border-b-2 focus:outline-none transition-all duration-200">
                Documents
            </button>
        </div>
    </div>
</div>
