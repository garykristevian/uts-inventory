<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\Category;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RingkasanKategori extends BaseWidget
{
    protected static ?string $heading = 'Ringkasan Per Kategori';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Category::query() // Query untuk mendapatkan setiap kategori dengan ringkasan data barang
                    ->select('categories.id', 'categories.name')
                    ->selectRaw('COUNT(items.id) as total_items')
                    ->selectRaw('SUM(items.quantity * items.price) as total_stock_value')
                    ->selectRaw('AVG(items.price) as average_price')
                    ->leftJoin('items', 'categories.id', '=', 'items.category_id')
                    ->groupBy('categories.id', 'categories.name')
            )
            ->columns([
                TextColumn::make('name')->label('Kategori'),
                TextColumn::make('total_items')->label('Jumlah Barang')
                    ->formatStateUsing(fn($state) => $state ?? '0'), // Format jika tidak ada barang
                TextColumn::make('total_stock_value')
                    ->label('Total Nilai Stok')
                    ->formatStateUsing(fn($state) => '$' . number_format($state ?? 0, 2)),
                TextColumn::make('average_price')
                    ->label('Rata-rata Harga')
                    ->formatStateUsing(fn($state) => '$' . number_format($state ?? 0, 2)),
            ])
            ->emptyStateHeading('Tidak ada data kategori');
    }
}