<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class AmbangBatas extends BaseWidget
{
    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Item::query()->where('quantity', '<', 5) // Menampilkan barang dengan stok < 5
            )
            ->columns([
                TextColumn::make('name')->label('Nama Produk'),
                TextColumn::make('quantity')->label('Stock'),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($state) => '$ ' . number_format($state, 2)),
            ])
            ->emptyStateHeading('Stok Barang Tidak Ada Yang Di Bawah 5');
    }
}