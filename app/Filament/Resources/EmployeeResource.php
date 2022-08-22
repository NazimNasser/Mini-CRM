<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $recordTitleAttribute = 'firstname';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                TextColumn::make('firstname')->limit(20)->sortable()->searchable(),
                TextColumn::make('lastname')->limit(20)->sortable()->searchable(),
                TextColumn::make('email')->limit(20)->sortable(),
                TextColumn::make('phone')->limit(20)->sortable(),
            ])
            ->filters([
                SelectFilter::make('company')->relationship('company', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
