<?php

declare(strict_types=1);

use App\Orchid\Screens\CommentsEditScreen;
use App\Orchid\Screens\CommentsListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\UsersEditScreen;
use App\Orchid\Screens\UsersListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');




// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));


//Route::screen('idea', Idea::class, 'platform.screens.idea');

Route::screen('comment/{comment?}', CommentsEditScreen::class)->name('platform.comments.edit');

Route::screen('comments', CommentsListScreen::class)
    ->name('platform.comments.list')
    ->breadcrumbs(function (Trail $trail)
    {
        return $trail->parent('platform.index')->push('Comments');
    });

Route::screen('user/{user?}', UsersEditScreen::class)->name('platform.users.edit');

Route::screen('users', UsersListScreen::class)
    ->name('platform.users.list');
