<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome to Your Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Dashboard Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <p class="text-xl font-bold text-blue-700">245</p>
                        <p class="text-gray-600">Active Users</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg text-center">
                        <p class="text-xl font-bold text-green-700">$12,800</p>
                        <p class="text-gray-600">Monthly Revenue</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg text-center">
                        <p class="text-xl font-bold text-yellow-700">38</p>
                        <p class="text-gray-600">Pending Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
