<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employee';

    protected static ?string $recordTitleAttribute = 'firstname';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->required()
                    ->minLength(2)
                    ->maxLength(100)
                    ->placeholder('First Name'),
                TextInput::make('lastname')
                    ->required()
                    ->minLength(2)
                    ->maxLength(100)
                    ->placeholder('Last Name'),
                TextInput::make('email')
                    ->email()
                    ->unique()
                    ->placeholder('company@example.com'),
                TextInput::make('phone')
                    ->numeric()
                    ->placeholder('55 555 555'),
                Select::make('company_id')
                    ->relationship('company', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname')->limit(20)->sortable(),
                TextColumn::make('lastname')->limit(20)->sortable(),
                TextColumn::make('email')->limit(20)->sortable(),
                TextColumn::make('phone')->limit(20)->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
