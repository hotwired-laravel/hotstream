<?php

namespace HotwiringLaravel\Hotstream;

use HotwiringLaravel\Hotstream\Contracts\AddsTeamMembers;
use HotwiringLaravel\Hotstream\Contracts\CreatesTeams;
use HotwiringLaravel\Hotstream\Contracts\DeletesTeams;
use HotwiringLaravel\Hotstream\Contracts\DeletesUsers;
use HotwiringLaravel\Hotstream\Contracts\InvitesTeamMembers;
use HotwiringLaravel\Hotstream\Contracts\RemovesTeamMembers;
use HotwiringLaravel\Hotstream\Contracts\UpdatesTeamNames;
use HotwiringLaravel\Hotstream\Contracts\UpdatesUserPictures;
use Illuminate\Support\Arr;

class Hotstream
{
    /**
     * Indicates if Hotstream routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * The roles that are available to assign to users.
     *
     * @var array
     */
    public static $roles = [];

    /**
     * The permissions that exist within the application.
     *
     * @var array
     */
    public static $permissions = [];

    /**
     * The default permissions that should be available to new entities.
     *
     * @var array
     */
    public static $defaultPermissions = [];

    /**
     * The user model that should be used by Hotstream.
     *
     * @var string
     */
    public static $userModel = 'App\\Models\\User';

    /**
     * The team model that should be used by Hotstream.
     *
     * @var string
     */
    public static $teamModel = 'App\\Models\\Team';

    /**
     * The membership model that should be used by Hotstream.
     *
     * @var string
     */
    public static $membershipModel = 'App\\Models\\Membership';

    /**
     * The team invitation model that should be used by Hotstream.
     *
     * @var string
     */
    public static $teamInvitationModel = 'App\\Models\\TeamInvitation';

    /**
     * Determine if Hotstream has registered roles.
     *
     * @return bool
     */
    public static function hasRoles()
    {
        return count(static::$roles) > 0;
    }

    /**
     * Find the role with the given key.
     *
     * @return \Laravel\Hotstream\Role
     */
    public static function findRole(string $key)
    {
        return static::$roles[$key] ?? null;
    }

    /**
     * Specify the user model that should be used by Hotstream.
     *
     * @return static
     */
    public static function useUserModel(string $model)
    {
        static::$userModel = $model;

        return new static;
    }

    /**
     * Define a role.
     *
     * @return \Laravel\Hotstream\Role
     */
    public static function role(string $key, string $name, array $permissions)
    {
        static::$permissions = collect(array_merge(static::$permissions, $permissions))
            ->unique()
            ->sort()
            ->values()
            ->all();

        return tap(new Role($key, $name, $permissions), function ($role) use ($key) {
            static::$roles[$key] = $role;
        });
    }

    /**
     * Determine if any permissions have been registered with Hotstream.
     *
     * @return bool
     */
    public static function hasPermissions()
    {
        return count(static::$permissions) > 0;
    }

    /**
     * Define the available API token permissions.
     *
     * @return static
     */
    public static function permissions(array $permissions)
    {
        static::$permissions = $permissions;

        return new static;
    }

    /**
     * Define the default permissions that should be available to new API tokens.
     *
     * @return static
     */
    public static function defaultApiTokenPermissions(array $permissions)
    {
        static::$defaultPermissions = $permissions;

        return new static;
    }

    /**
     * Return the permissions in the given list that are actually defined permissions for the application.
     *
     * @return array
     */
    public static function validPermissions(array $permissions)
    {
        return array_values(array_intersect($permissions, static::$permissions));
    }

    public static function hasTermsAndPrivacyPolicyFeature()
    {
        return true;
    }

    /**
     * Find a user instance by the given ID.
     *
     * @param  int  $id
     * @return mixed
     */
    public static function findUserByIdOrFail($id)
    {
        return static::newUserModel()->where('id', $id)->firstOrFail();
    }

    public static function localizedMarkdownPath(string $name)
    {
        $localName = preg_replace('#(\.md)$#i', '.'.app()->getLocale().'$1', $name);

        return Arr::first([
            resource_path('markdown/'.$localName),
            resource_path('markdown/'.$name),
        ], function ($path) {
            return file_exists($path);
        });
    }

    /**
     * Determine if a given user model utilizes the "HasTeams" trait.
     *
     * @param  \Illuminate\Database\Eloquent\Model
     * @return bool
     */
    public static function userHasTeamFeatures($user)
    {
        return (array_key_exists(HasTeams::class, class_uses_recursive($user)) ||
                method_exists($user, 'currentTeam')) &&
                static::hasTeamFeatures();
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return string
     */
    public static function userModel()
    {
        return static::$userModel;
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return mixed
     */
    public static function newUserModel()
    {
        $model = static::$userModel;

        return new $model;
    }

    /**
     * Find a user instance by the given email address or fail.
     *
     * @return mixed
     */
    public static function findUserByEmailOrFail(string $email)
    {
        return static::newUserModel()->where('email', $email)->firstOrFail();
    }

    /**
     * Get the name of the team model used by the application.
     *
     * @return string
     */
    public static function teamModel()
    {
        return static::$teamModel;
    }

    /**
     * Get a new instance of the team model.
     *
     * @return mixed
     */
    public static function newTeamModel()
    {
        $model = static::teamModel();

        return new $model;
    }

    /**
     * Get a new instance of the team model.
     *
     * @return mixed
     */
    public static function newTeamInvitationModel()
    {
        $model = static::teamInvitationModel();

        return new $model;
    }

    /**
     * Get the name of the membership model used by the application.
     *
     * @return string
     */
    public static function membershipModel()
    {
        return static::$membershipModel;
    }

    /**
     * Get the name of the team invitation model used by the application.
     *
     * @return string
     */
    public static function teamInvitationModel()
    {
        return static::$teamInvitationModel;
    }

    /**
     * Determine if Hotstream is managing profile photos.
     *
     * @return bool
     */
    public static function managesProfilePhotos()
    {
        return Features::managesProfilePhotos();
    }

    /**
     * Determine if Hotstream is supporting API features.
     *
     * @return bool
     */
    public static function hasApiFeatures()
    {
        return Features::hasApiFeatures();
    }

    /**
     * Determine if Hotstream is supporting Team features.
     *
     * @return bool
     */
    public static function hasTeamFeatures()
    {
        return Features::hasTeamFeatures();
    }

    /**
     * Register a class / callback that should be used to create teams.
     *
     * @return void
     */
    public static function createTeamsUsing(string $class)
    {
        return app()->singleton(CreatesTeams::class, $class);
    }

    /**
     * Register a class / callback that should be used to update team names.
     *
     * @return void
     */
    public static function updateTeamNamesUsing(string $class)
    {
        return app()->singleton(UpdatesTeamNames::class, $class);
    }

    /**
     * Register a class / callback that should be used to add team members.
     *
     * @return void
     */
    public static function addTeamMembersUsing(string $class)
    {
        return app()->singleton(AddsTeamMembers::class, $class);
    }

    /**
     * Register a class / callback that should be used to add team members.
     *
     * @return void
     */
    public static function inviteTeamMembersUsing(string $class)
    {
        return app()->singleton(InvitesTeamMembers::class, $class);
    }

    /**
     * Register a class / callback that should be used to remove team members.
     *
     * @return void
     */
    public static function removeTeamMembersUsing(string $class)
    {
        return app()->singleton(RemovesTeamMembers::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete teams.
     *
     * @return void
     */
    public static function deleteTeamsUsing(string $class)
    {
        return app()->singleton(DeletesTeams::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete users.
     *
     * @return void
     */
    public static function deleteUsersUsing(string $class)
    {
        return app()->singleton(DeletesUsers::class, $class);
    }

    /**
     * Register a class / callback that should be used to update user's profile picture.
     *
     * @return void
     */
    public static function updateUserPictureUsing(string $class)
    {
        return app()->singleton(UpdatesUserPictures::class, $class);
    }

    /**
     * Configure Hotstream to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes(): self
    {
        static::$registersRoutes = false;

        return new static;
    }
}
