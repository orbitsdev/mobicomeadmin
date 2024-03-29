<?php

namespace App\Livewire\Teacher\Management;

use Filament\Tables;
use App\Models\Student;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListOfHandledStudent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->columns([

                TextColumn::make('user')->formatStateUsing(function ($state) {
                    return $state->getFullName();
                })
                    ->label('Student Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('enrolled_section.section.title')
                    ->searchable(),
                TextColumn::make('remove_request.message')->formatStateUsing(function ($state) {
                    return $state ? 'For Remove' : '';
                })->label('Status')->badge()->color('danger'),

                //    ToggleColumn::make('is_approved')
                //    ->label('Status')
                //        ->onColor('success')
                //        ->offColor('danger')
                //        ->afterStateUpdated(function ($record, $state) {

                //            $message  = "Not Active";
                //            if ($state) {
                //                $message  = "Was set to Active";
                //            } else {
                //                $message  = "Was Set to Not Active";
                //            }
                //            Notification::make()
                //                ->title($message)
                //                ->success()
                //                ->send();
                //            // Runs after the state is saved to the database.
                //        })

                // Runs after the state is saved to the database.

            ])
            ->filters([
                SelectFilter::make('enrolled_section')
                    ->relationship('enrolled_section.section', 'title', fn (Builder $query) => $query->whereHas('enrolled_section.teacher.user', function ($query) {
                        $query->where('id', Auth::user()->id);
                    }))

                // SelectFilter::make('created_by')
                //     ->options([
                //         'Teacher' => 'Teacher',
                //         'Admin' => 'Admin',
                //     ])
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Action::make('view')
                    ->color('primary')
                    ->label('View Profile')

                    ->button()
                    ->outlined()
                    ->url(function (Student $record) {
                        return route('enrolled-view-student', ['record' => $record]);
                    }),
                Action::make('Request To Remove Studebt')
                    ->color('danger')
                    ->modalHeading('Request For Removal')
                    ->button()
                    // ->disableCreateAnother()
                  
                    ->outlined()
                    ->form([

                        Textarea::make('message')
                            ->rows(10)
                            ->cols(20)
                            ->required()

                    ])
                    ->action(function (array $data, Model $record): void {
                        
                      
                        if(!$record->remove_request){
                            $record->remove_request()->create([
                                'teacher_id'=> Auth::user()->id,
                                'student_id'=> $record->id,
                                'message'=>$data['message'],
                            ]);


                            Notification::make()
                            ->title('Send successfully')
                            ->success()
                            ->send();                        }   
                        // $record->author()->associate($data['authorId']);
                        // $record->save();
                    })
                    ->label('Request To Remove')
                    ->hidden(function(Model $record){
                        return $record->remove_request ? true : false;
                    })
                    ,
                Action::make('Cancel ')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->button()
                    // ->disableCreateAnother()
                  
                    ->outlined()
                    
                    ->action(function (array $data, Model $record): void {
                        
                      
                        if($record->remove_request){
                            
                            $record->remove_request->delete();
                                                
                        }   
                        Notification::make()
                        ->title('Send successfully')
                        ->success()
                        ->send();  
                        // $record->author()->associate($data['authorId']);
                        // $record->save();
                    })
                    ->label('Cancel Request')
                    ->hidden(function(Model $record){
                        return $record->remove_request ? false : true;
                    })
                    ,


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('enrolled_section.teacher.user', function ($query) {
                $query->where('id', auth()->user()->id);
            }));
    }

    public function render(): View
    {
        return view('livewire.teacher.management.list-of-handled-student');
    }
}
