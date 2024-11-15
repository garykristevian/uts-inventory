<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\Category;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Filters\SelectFilter;

class LaporanBarang extends BaseWidget
{
    protected static ?string $heading = 'Laporan Barang Berdasarkan Kategori';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Item::query() // Query untuk menampilkan data barang
            )
            ->columns([
                TextColumn::make('name')->label('Nama Produk'),
                TextColumn::make('category.name')->label('Kategori'),
                TextColumn::make('quantity')->label('Stock'),
                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn($state) => '$' . number_format($state, 2)),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(
                        Category::all()->pluck('name', 'id') // Mengambil daftar kategori sebagai opsi filter
                    )
                    ->query(function ($query, $data) {
                        if ($data['value']) {
                            $query->where('category_id', $data['value']); // Filter barang berdasarkan kategori
                        }
                    }),
            ])
            ->emptyStateHeading('Tidak ada barang pada kategori ini');
    }
}