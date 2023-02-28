<?php

namespace App\Orchid\Screens;

use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class UsersEditScreen extends Screen
{
    public bool $exists = false;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(User $user): iterable
    {
        $this->exists = $user->exists;
        if ($this->exists) {
            $this->name = 'Edit user';
        }
        return [
            'user' => $user
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'User create';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create comment')
                ->icon('icon-pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('icon-note')
                ->method('createOrUpdate'),

            Button::make('Remove')
                ->icon('icon-trash')
                ->method('remove')
        ];

    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('user.name')
                    ->title('Text')
                    ->placeholder('text')
                    ->help('Specify a short descriptive text for this comment'),

                Input::make('user.email')
                    ->title('Email')
                    ->placeholder('email'),

                Input::make('user.password')
                    ->title('Password'),

                Input::make('user.admin')
                    ->title('Approved'),

            ])
        ];
    }

    public function createOrUpdate(Request $request, User $user)
    {
        $user->fill($request->get('user'))->save();

        Alert::info('You have successfully created or updated a user');

        return redirect()->route('platform.users.list');
    }

    public function remove(User $user)
    {
        $user->delete()
            ? Alert::info('You have successfully deleted a comment')
            : Alert::warning('An error has occurred');

        return redirect()->route('platform.users.list');
    }
}
