<?php

namespace App\Filament\Widgets;

use App\Models\Supplier;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RingkasanBarangSupplier extends BaseWidget
{
    protected static ?string $heading = 'Ringkasan Barang per Supplier';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Supplier::query()
                    ->withCount('items') // Menghitung jumlah barang per pemasok
                    ->withSum('items', 'price') // Menghitung total nilai barang yang disuplai
            )
            ->columns([
                TextColumn::make('name')->label('Nama Pemasok'),
                TextColumn::make('items_count')->label('Jumlah Barang'), // Menampilkan jumlah barang
                TextColumn::make('items_sum_price')
                    ->label('Total Nilai Barang')
                    ->formatStateUsing(fn($state) => '$' . number_format($state, 2)), // Menampilkan total nilai barang dengan format Rupiah
            ])
            ->emptyStateHeading('Tidak ada data pemasok');
    }
}