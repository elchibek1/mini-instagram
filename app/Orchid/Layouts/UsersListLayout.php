<?php

namespace App\Orchid\Layouts;

use App\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UsersListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'users';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', "ID")->sort(),
            TD::make('name', 'Name'),
            TD::make('admin', 'Is Admin')
                ->render(function (User $user){
                    return Link::make($user->admin)
                        ->route('platform.users.edit', compact('user'));
                })->filter(TD::FILTER_NUMERIC),
            TD::make('created_at', 'Created')->sort(),
            TD::make('updated_at', 'Last edit')->sort()
        ];
    }
}
