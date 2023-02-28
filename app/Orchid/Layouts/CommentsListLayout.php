<?php

namespace App\Orchid\Layouts;

use App\Models\Comment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CommentsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'comments';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('text', 'Text'),
            TD::make('approved', 'Is approved')
                ->render(function (Comment $comment)
                {
                    return Link::make($comment->approved)->route('platform.comments.edit', compact('comment'));
                })->filter(TD::FILTER_NUMERIC),
            TD::make('created_at', 'Created')->sort(),
            TD::make('updated_at', 'Last edit')->sort()
        ];
    }
}
