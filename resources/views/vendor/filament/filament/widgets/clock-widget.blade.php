<x-filament-widgets::widget>
    <x-filament::card class="!p-0 overflow-hidden">
        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
            
            <!-- Weather Section -->
            <div class="flex items-center space-x-4">
                @if ($this->weatherData && isset($this->weatherData['current_weather']))
                    <div class="text-4xl">
                        {{ $this->weatherData['current_weather']['icon'] }}
                    </div>
                    <div>
                        <p class="text-xs uppercase font-semibold tracking-wider opacity-80">Gwadar Weather</p>
                        <div class="flex items-center space-x-2">
                            <p class="text-lg font-bold">{{ $this->weatherData['current_weather']['temperature'] }}°C</p>
                            <span class="text-blue-200">•</span>
                            <p class="text-sm font-medium">{{ $this->weatherData['current_weather']['description'] }}</p>
                        </div>
                        <p class="text-xs opacity-75 mt-1">
                            Wind: {{ $this->weatherData['current_weather']['windspeed'] }} km/h
                        </p>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <div class="text-4xl animate-pulse">🌤️</div>
                        <div>
                            <p class="text-xs uppercase font-semibold tracking-wider opacity-80">Gwadar Weather</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Time Section -->
            <div class="text-right">
                <p class="text-xs uppercase font-semibold tracking-wider opacity-80">Current Time</p>
                <p id="clock" class="text-2xl font-mono font-bold tracking-tight">
                    {{ $this->currentTime }}
                </p>
                <p id="date" class="text-xs opacity-75 mt-1">
                    {{ now()->format('D, M j, Y') }}
                </p>
            </div>

        </div>
    </x-filament::card>

    <script>
        function updateClock() {
            const now = new Date();
            
            // Update time
            const hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const displayHours = hours % 12 || 12;
            
            document.getElementById('clock').innerText = 
                `${displayHours}:${minutes} ${ampm}`;
            
            // Update date
            const options = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
            document.getElementById('date').innerText = 
                now.toLocaleDateString('en-US', options);
        }

        // Update immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);
    </script>

    <style>
        .font-mono {
            font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;
        }
    </style>
</x-filament-widgets::widget>