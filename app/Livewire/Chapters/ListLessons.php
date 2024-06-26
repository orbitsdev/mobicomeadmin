<?php

namespace App\Livewire\Chapters;

use App\Models\User;
use Filament\Tables;
use App\Models\Lesson;
use App\Models\Chapter;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\Section as FSection;

class ListLessons extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public  Chapter $record;
    public function table(Table $table): Table
    {
        return $table
            ->query(Lesson::query())
            ->columns([



                TextColumn::make('title')
                ->searchable(),
                TextColumn::make('lesson_number.number')->searchable() ->sortable(true),
                // Tables\Columns\ImageColumn::make('image_path'),
                // Tables\Columns\TextColumn::make('video_path')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('lesson_number')
                //     ->numeric()
                //     ->sortable(),

                Tables\Columns\TextColumn::make('user_id')->label('Created by')
                    ->formatStateUsing(function (Model $record) {
                        return $record?->user?->getFullNameWithRole() ?? '';
                    })
                    ->color(fn (Model $record): string => match ($record->user->role) {
                        User::ADMIN => 'info',
                        User::TEACHER => 'success',
                        default => 'gray',

                    })
                    ->badge()
                    ->searchable(),

            ])
            ->filters([
                //
            ])

            ->headerActions([
                Action::make('crete_kessib')
                        ->color('primary')
                        ->icon('heroicon-m-sparkles')
                        ->label('New Lesson')

                        ->url(function(){
                            return route('chapter-create-lesson', ['record'=> $this->record]);
                        })

            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Lesson')
                        ->url(fn (Model $record): string => route('chapter-view-lesson', ['record' => $record])),
                        
                    Action::make('edit')
                        ->color('primary')
                        ->icon('heroicon-m-pencil-square')
                        ->label('Edit Lesson')
                        ->url(fn (Model $record): string => route('chapter-edit-lesson', ['record' => $record]))
                        ->hidden(function (Model $record) {

                            $authenticated_id = Auth::id();

                            if (!empty($record->user_id)) {
                                switch (Auth::user()->role) {
                                    case User::ADMIN:
                                        return false;
                                    case User::TEACHER:
                                        return $record->user_id !== $authenticated_id;
                                    case User::STUDENT:
                                        return true;
                                }
                            } else {
                                return Auth::user()->isStudent();
                            }
                        })
                        ,




                    DeleteAction::make('delete'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                ->label('Actions')
                ,
                ])
        ->modifyQueryUsing(fn (Builder $query) => $query->where('chapter_id', $this->record->id))     ;
    }

    public function render(): View
    {
        return view('livewire.chapters.list-lessons');
    }
}
