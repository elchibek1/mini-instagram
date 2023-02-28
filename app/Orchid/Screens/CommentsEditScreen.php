<?php

namespace App\Orchid\Screens;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CommentsEditScreen extends Screen
{

    public bool $exists = false;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Comment $comment): iterable
    {
        $this->exists = $comment->exists;
        if ($this->exists)
        {
            $this->name = 'Edit comment';
        }
        return [
            'comment' => $comment
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Comment create';
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
                Input::make('comment.text')
                ->title('Text')
                ->placeholder('text')
                ->help('Specify a short descriptive text for this comment')
                ->required(),

                Select::make('comment.approved')
                    ->options([
                        0 => 'false',
                        1 => 'true'
                    ])
                ->title('Approved')
                ->required(),

                Relation::make('comment.user_id')
                ->title('Author')
                ->fromModel(User::class, 'name', 'id')
                ->required(),

                Relation::make('comment.post_id')
                ->title('Id of post')
                ->fromModel(Post::class, 'id', 'id')
                ->required(),

            ])
        ];
    }

    public function createOrUpdate(Comment $comment, Request $request)
    {
        $comment->fill($request->get('comment'))->save();

        Alert::info('You have successfully created or updated a comment');

        return redirect()->route('platform.comments.list');
    }

    public function remove(Comment $comment)
    {
        $comment->delete()
            ? Alert::info('You have successfully deleted a comment')
            : Alert::warning('An error has occurred');

        return redirect()->route('platform.comments.list');
    }
}
