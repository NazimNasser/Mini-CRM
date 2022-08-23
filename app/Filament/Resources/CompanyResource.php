<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Resources\CompanyResource\RelationManagers\EmployeesRelationManager;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Livewire\TemporaryUploadedFile;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->required()
                        ->minLength(2)
                        ->maxLength(100)
                        ->placeholder('Company Name'),
                    SpatieMediaLibraryFileUpload::make('logo')->collection('companies'),
                    // FileUpload::make('main_image')
                    // ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    //     $fileName = $file->hashName();
                    //     $name = explode('.', $fileName);
                    //     return (string) str('images/companies/main_image/' .$name[0].'.png');
                    // })
                    // ->label('Logo')
                    // ->image(),
                    TextInput::make('email')
                    ->email()
                    ->unique()
                    ->placeholder('company@example.com'),
                    TextInput::make('website')
                    ->url()
                    ->placeholder('https://example.com'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\ImageColumn::make('main_image'),
                SpatieMediaLibraryImageColumn::make('logo')->collection('companies'),
                TextColumn::make('name')->limit(20)->sortable()->searchable(),
                TextColumn::make('email')->limit(20)->sortable(),
                TextColumn::make('website')->limit(20)->sortable(),
            ])
            ->filters([
                //
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
            EmployeesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
