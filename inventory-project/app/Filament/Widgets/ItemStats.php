<?php

namespace App\Filament\Widgets;

use App\Models\Item; // Ganti dengan model yang sesuai
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ItemStats extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Item::query()) // Ganti dengan query sesuai kebutuhan
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Barang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Barang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->sortable()
                    ->money(), // Format sebagai uang
                Tables\Columns\TextColumn::make('total_value') // Menggunakan nama kolom dari mutator
                    ->label('Nilai Stok')
                    ->money(),

                

            ])

            
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                // Tambahkan aksi jika diperlukan
            ])
            ->headerActions([
                // Tambahkan aksi header jika diperlukan
            ]);
    }
}