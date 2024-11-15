<?php

namespace App\Filament\Widgets;

use App\Models\User; 
use App\Models\Category; 
use App\Models\Supplier; 
use App\Models\Item; 
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Item::count()) 
                ->description('Jumlah total barang yang terdaftar') 
                ->color('primary'), 
            Stat::make('Total Category', Category::count()) 
                ->description('Jumlah total category yang terdaftar') 
                ->color('primary'), 
            Stat::make('Total Supplier', Supplier::count()) 
                ->description('Jumlah total supplier yang terdaftar')
                ->color('primary'), 
            Stat::make('Total Barang', Item::count()) 
                ->description('Jumlah total barang yang terdaftar')
                ->color('primary'), 
                Stat::make('Total Stok Keseluruhan', '$' . number_format(Item::sum('price'), 2))
                ->description('Nilai total dari semua barang yang ada')
                ->color('primary'),
            Stat::make('Total User', User::count()) 
                ->description('Jumlah total user yang terdaftar')
                ->color('primary'), 
        ];
    }
}