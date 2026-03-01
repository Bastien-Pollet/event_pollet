<?php
namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Inscriptions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            Forms\Components\Select::make('rsvp')->options([
                'yes' => 'Je viens',
                'no' => 'Je ne viens pas',
                'maybe' => 'Peut-être',
            ])->required(),
            Forms\Components\TextInput::make('dietary')->label('Contraintes alimentaires'),
            Forms\Components\TextInput::make('guests_count')->numeric()->label('Invités +'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('event.title')->label('Événement')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\BadgeColumn::make('rsvp')->colors([
                'success' => 'yes',
                'warning' => 'maybe',
                'danger' => 'no',
            ])->formatStateUsing(fn($state)=> strtoupper($state)),
            Tables\Columns\TextColumn::make('guests_count')->label('+')->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->label('Créé le'),
        ])->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}
