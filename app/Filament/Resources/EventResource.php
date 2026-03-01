<?php
namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Événements';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Infos')
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Titre')->required()->maxLength(255),
                    Forms\Components\TextInput::make('slug')->helperText('Laissez vide pour générer automatiquement'),
                    Forms\Components\Textarea::make('description')->rows(6),
                    Forms\Components\TextInput::make('location')->label('Lieu'),
                    Forms\Components\FileUpload::make('image_path')->image()->directory('events'),
                ])->columns(2),
            Forms\Components\Section::make('Paramètres')
                ->schema([
                    Forms\Components\Toggle::make('is_private')->label('Privé'),
                    Forms\Components\TextInput::make('capacity')->numeric()->minValue(1)->label('Capacité')->hint('Optionnel'),
                    Forms\Components\DateTimePicker::make('starts_at')->label('Début'),
                    Forms\Components\DateTimePicker::make('ends_at')->label('Fin'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_private')->boolean()->label('Privé'),
                Tables\Columns\TextColumn::make('starts_at')->dateTime('d/m/Y H:i')->label('Début')->sortable(),
                Tables\Columns\TextColumn::make('registrations_count')->counts('registrations')->label('Inscriptions'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
