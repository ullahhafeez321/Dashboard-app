<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;

class ClockWidget extends Widget
{
    protected static ?int $sort = -2;
    protected int|string|array $columnSpan = ['md' => 2, 'xl' => 2];
    protected static bool $isLazy = false;
    protected string $view = 'filament::filament.widgets.clock-widget';

    public $weatherData;
    public $currentTime;
    public $isLoading = true;
    public $hasError = false;

    public function mount(): void
    {
        $this->currentTime = now()->format('h:i A');
        $this->loadWeatherData();
    }

    public function loadWeatherData(): void
    {
        try {
            $response = Http::timeout(5)->retry(2, 100)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => 25.1262, // Gwadar coordinates
                'longitude' => 62.3278,
                'current_weather' => 'true',
                'temperature_unit' => 'celsius',
                'windspeed_unit' => 'kmh',
                'timezone' => 'auto',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['current_weather'])) {
                    $code = $data['current_weather']['weathercode'];
                    $data['current_weather']['description'] = $this->getWeatherDescription($code);
                    $data['current_weather']['icon'] = $this->getWeatherIcon($code);
                    $this->weatherData = $data;
                    $this->hasError = false;
                } else {
                    $this->hasError = true;
                }
            } else {
                $this->hasError = true;
            }
        } catch (\Exception $e) {
            $this->hasError = true;
        } finally {
            $this->isLoading = false;
        }
    }

    private function getWeatherDescription($code): string
    {
        return match($code) {
            0 => 'Clear Sky',
            1 => 'Mainly Clear', 
            2 => 'Partly Cloudy',
            3 => 'Overcast',
            45, 48 => 'Foggy',
            51, 53, 55 => 'Drizzle',
            61, 63, 65 => 'Rain',
            66, 67 => 'Freezing Rain',
            71, 73, 75 => 'Snow',
            77 => 'Snow Grains',
            80, 81, 82 => 'Rain Showers',
            85, 86 => 'Snow Showers', 
            95 => 'Thunderstorm',
            96, 99 => 'Thunderstorm with Hail',
            default => 'Unknown',
        };
    }

    private function getWeatherIcon($code): string
    {
        return match($code) {
            0 => '☀️',
            1, 2 => '🌤️',
            3 => '☁️',
            45, 48 => '🌫️',
            51, 53, 55 => '🌦️',
            61, 63, 65 => '🌧️',
            71, 73, 75 => '❄️',
            80, 81, 82 => '🌦️',
            85, 86 => '🌨️',
            95, 96, 99 => '⛈️',
            default => '🌈',
        };
    }
}