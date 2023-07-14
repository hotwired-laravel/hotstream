<?php

namespace HotwiredLaravel\Hotstream\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Symfony\Component\Process\PhpExecutableFinder;

class InstallCommand extends Command
{
    protected $signature = 'hotstream:install
        {--teams : Indicates if team support should be installed}
        {--api : Indicates if API support should be installed}
        {--verification : Indicates if email verification support should be installed}
        {--composer=global : Absolute path to the Composer binary which should be used to install packages}
    ';

    protected $description = 'Install the Hotstream application starter kit';

    public function handle()
    {
        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'hotstream-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'hotstream-migrations', '--force' => true]);

        $this->callSilent('vendor:publish', ['--tag' => 'fortify-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-support', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'fortify-migrations', '--force' => true]);

        // "Home" Route...
        $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        copy(__DIR__.'/../../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));

        // Fortify Provider...
        $this->installServiceProviderAfter('RouteServiceProvider', 'FortifyServiceProvider');

        // Configure Session...
        $this->configureSession();

        // Configure API...
        if ($this->option('api')) {
            $this->replaceInFile('// Features::api(),', 'Features::api(),', config_path('hotstream.php'));
        }

        // Configure Email Verification...
        if ($this->option('verification')) {
            $this->replaceInFile('// Features::emailVerification(),', 'Features::emailVerification(),', config_path('fortify.php'));
        }

        $this->installHotstreamStack();

        // Emails...
        File::ensureDirectoryExists(resource_path('views/emails'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/emails', resource_path('views/emails'));

        // Tests...
        $stubs = __DIR__.'/../../stubs/tests';

        $this->removeComposerDevPackages(['phpunit/phpunit']);

        if (! $this->requireComposerDevPackages(['pestphp/pest:^2.0', 'pestphp/pest-plugin-laravel:^2.0'])) {
            return 1;
        }

        copy($stubs.'/Pest.php', base_path('tests/Pest.php'));
        copy($stubs.'/Unit/ExampleTest.php', base_path('tests/Unit/ExampleTest.php'));
        copy($stubs.'/Feature/ExampleTest.php', base_path('tests/Feature/ExampleTest.php'));
        copy($stubs.'/Feature/AuthenticationTest.php', base_path('tests/Feature/AuthenticationTest.php'));
        copy($stubs.'/Feature/EmailVerificationTest.php', base_path('tests/Feature/EmailVerificationTest.php'));
        copy($stubs.'/Feature/PasswordConfirmationTest.php', base_path('tests/Feature/PasswordConfirmationTest.php'));
        copy($stubs.'/Feature/PasswordResetTest.php', base_path('tests/Feature/PasswordResetTest.php'));
        copy($stubs.'/Feature/RegistrationTest.php', base_path('tests/Feature/RegistrationTest.php'));

        $this->components->info('Hotstream installed!');

        $this->components->info('To finish your installation, you need to:');

        $this->components->bulletList([
            'Run "php artisan storage:link" (run inside the Sail container if using it)',
            'Run "php artisan tailwindcss:download" to download the Tailwind CLI"',
            'Finally, run "php artisan tailwindcss:build" to build your assets for the first time',
        ]);

        $this->components->info('After that you should be done!');
    }

    private function configureSession(): void
    {
        if (! class_exists('CreateSessionsTable')) {
            try {
                $this->call('session:table');
            } catch (Exception $e) {
                //
            }
        }

        $this->replaceInFile("'SESSION_DRIVER', 'file'", "'SESSION_DRIVER', 'database'", config_path('session.php'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env'));
        $this->replaceInFile('SESSION_DRIVER=file', 'SESSION_DRIVER=database', base_path('.env.example'));
    }

    private function installHotstreamStack(): bool
    {
        // Install Composer packages...
        if (! $this->requireComposerPackages([
            'hotwired-laravel/stimulus-laravel:^0.3',
            'hotwired-laravel/turbo-laravel:2.x-dev',
            'tonysm/importmap-laravel:^1.5',
            'tonysm/tailwindcss-laravel:^0.10',
        ])) {
            return false;
        }

        // Sanctum...
        $this->output->write(
            Process::forever()
                ->path(base_path())
                ->run([$this->phpBinary(), 'artisan', 'vendor:publish', '--provider=Laravel\Sanctum\SanctumServiceProvider', '--force'])
                ->output()
        );

        // Remove the Vite config...
        if (File::exists(base_path('vite.config.js'))) {
            File::delete(base_path('vite.config.js'));
        }

        // Importmaps...
        Process::forever()
            ->path(base_path())
            ->run([$this->phpBinary(), 'artisan', 'importmap:install']);

        // Copy our stub importmap routes file...
        copy(__DIR__.'/../../stubs/routes/importmap.php', base_path('routes/importmap.php'));

        // Tailwind...
        if (File::exists(resource_path('sass'))) {
            File::deleteDirectory(resource_path('sass'));
        }

        File::ensureDirectoryExists(resource_path('css'));
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));

        // Directories...
        File::ensureDirectoryExists(app_path('Actions/Fortify'));
        File::ensureDirectoryExists(app_path('Actions/Hotstream'));
        File::ensureDirectoryExists(app_path('View/Components'));
        File::ensureDirectoryExists(resource_path('css'));
        File::ensureDirectoryExists(resource_path('markdown'));
        File::ensureDirectoryExists(resource_path('views/accounts'));
        File::ensureDirectoryExists(resource_path('views/auth'));
        File::ensureDirectoryExists(resource_path('views/components'));
        File::ensureDirectoryExists(resource_path('views/layouts'));
        File::ensureDirectoryExists(resource_path('views/password'));
        File::ensureDirectoryExists(resource_path('views/profile'));
        File::ensureDirectoryExists(resource_path('views/profile-picture'));
        File::ensureDirectoryExists(resource_path('views/api-tokens'));
        File::ensureDirectoryExists(resource_path('views/two-factor-authentication'));
        File::ensureDirectoryExists(resource_path('views/confirmed-two-factor-authentication'));
        File::ensureDirectoryExists(resource_path('views/recovery-codes'));
        File::ensureDirectoryExists(resource_path('views/device-sessions'));
        File::ensureDirectoryExists(resource_path('views/deleted-device-sessions'));

        // Terms Of Service / Privacy Policy...
        copy(__DIR__.'/../../stubs/resources/markdown/terms.md', resource_path('markdown/terms.md'));
        copy(__DIR__.'/../../stubs/resources/markdown/policy.md', resource_path('markdown/policy.md'));

        // Service Providers...
        copy(__DIR__.'/../../stubs/app/Providers/HotstreamServiceProvider.php', app_path('Providers/HotstreamServiceProvider.php'));
        $this->installServiceProviderAfter('FortifyServiceProvider', 'HotstreamServiceProvider');

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/User.php', app_path('Models/User.php'));

        // Factories...
        copy(__DIR__.'/../../database/factories/UserFactory.php', base_path('database/factories/UserFactory.php'));

        // Actions...
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Fortify/UpdateUserProfileInformation.php', app_path('Actions/Fortify/UpdateUserProfileInformation.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/DeleteUser.php', app_path('Actions/Hotstream/DeleteUser.php'));

        // Components...
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/components', resource_path('views/components'));

        // View Components...
        copy(__DIR__.'/../../stubs/app/View/Components/AppLayout.php', app_path('View/Components/AppLayout.php'));
        copy(__DIR__.'/../../stubs/app/View/Components/GuestLayout.php', app_path('View/Components/GuestLayout.php'));

        // Layouts...
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/layouts', resource_path('views/layouts'));

        // Single Blade Views...
        copy(__DIR__.'/../../stubs/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
        copy(__DIR__.'/../../stubs/resources/views/terms.blade.php', resource_path('views/terms.blade.php'));
        copy(__DIR__.'/../../stubs/resources/views/policy.blade.php', resource_path('views/policy.blade.php'));

        // Other Views...
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/accounts', resource_path('views/accounts'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/auth', resource_path('views/auth'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/components', resource_path('views/components'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/layouts', resource_path('views/layouts'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/profile', resource_path('views/profile'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/password', resource_path('views/password'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/profile', resource_path('views/profile'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/profile-picture', resource_path('views/profile-picture'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/api-tokens', resource_path('views/api-tokens'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/two-factor-authentication', resource_path('views/two-factor-authentication'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/confirmed-two-factor-authentication', resource_path('views/confirmed-two-factor-authentication'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/recovery-codes', resource_path('views/recovery-codes'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/device-sessions', resource_path('views/device-sessions'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/deleted-device-sessions', resource_path('views/deleted-device-sessions'));

        // Routes...
        $this->replaceInFile('auth:api', 'auth:sanctum', base_path('routes/api.php'));

        if (! Str::contains(file_get_contents(base_path('routes/web.php')), "'/dashboard'")) {
            File::append(base_path('routes/web.php'), $this->dashboardRouteDefinition());
        }

        // Assets...
        File::ensureDirectoryExists(resource_path('js/controllers'));
        File::ensureDirectoryExists(resource_path('js/elements'));
        File::ensureDirectoryExists(resource_path('js/helpers'));
        File::ensureDirectoryExists(resource_path('js/libs'));

        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));

        File::copyDirectory(__DIR__.'/../../stubs/resources/js/controllers', resource_path('js/controllers'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/js/elements', resource_path('js/elements'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/js/helpers', resource_path('js/helpers'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/js/libs', resource_path('js/libs'));

        // Tests...
        $stubs = $this->getTestStubsPath();

        copy($stubs.'/Feature/ApiTokenPermissionsTest.php', base_path('tests/Feature/ApiTokenPermissionsTest.php'));
        copy($stubs.'/Feature/BrowserSessionsTest.php', base_path('tests/Feature/BrowserSessionsTest.php'));
        copy($stubs.'/Feature/CreateApiTokenTest.php', base_path('tests/Feature/CreateApiTokenTest.php'));
        copy($stubs.'/Feature/DeleteAccountTest.php', base_path('tests/Feature/DeleteAccountTest.php'));
        copy($stubs.'/Feature/DeleteApiTokenTest.php', base_path('tests/Feature/DeleteApiTokenTest.php'));
        copy($stubs.'/Feature/ProfileInformationTest.php', base_path('tests/Feature/ProfileInformationTest.php'));
        copy($stubs.'/Feature/TwoFactorAuthenticationSettingsTest.php', base_path('tests/Feature/TwoFactorAuthenticationSettingsTest.php'));
        copy($stubs.'/Feature/UpdatePasswordTest.php', base_path('tests/Feature/UpdatePasswordTest.php'));

        // Teams...
        if ($this->option('teams')) {
            $this->installHotstreamTeamsStack();
        }

        // Stimulus...
        Process::forever()
            ->path(base_path())
            ->run([$this->phpBinary(), 'artisan', 'stimulus:publish']);

        $this->components->info('Published Stimulus loading');

        $this->line('');
        $this->components->info('Hotstream scaffolding installed successfully.');

        return true;
    }

    private function dashboardRouteDefinition(): string
    {
        return trim(<<<'PHP'
        Route::middleware([
            'auth:sanctum',
            'verified',
        ])->group(function () {
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');
        });
        PHP);
    }

    private function installHotstreamTeamsStack(): void
    {
        // Other Views...
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/teams', resource_path('views/teams'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/team-invitations', resource_path('views/team-invitations'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/team-user-role', resource_path('views/team-user-role'));
        File::copyDirectory(__DIR__.'/../../stubs/resources/views/team-users', resource_path('views/team-users'));

        // Tests...
        $stubs = $this->getTestStubsPath();

        copy($stubs.'/Feature/CreateTeamTest.php', base_path('tests/Feature/CreateTeamTest.php'));
        copy($stubs.'/Feature/DeleteTeamTest.php', base_path('tests/Feature/DeleteTeamTest.php'));
        copy($stubs.'/Feature/InviteTeamMemberTest.php', base_path('tests/Feature/InviteTeamMemberTest.php'));
        copy($stubs.'/Feature/LeaveTeamTest.php', base_path('tests/Feature/LeaveTeamTest.php'));
        copy($stubs.'/Feature/RemoveTeamMemberTest.php', base_path('tests/Feature/RemoveTeamMemberTest.php'));
        copy($stubs.'/Feature/UpdateTeamMemberRoleTest.php', base_path('tests/Feature/UpdateTeamMemberRoleTest.php'));
        copy($stubs.'/Feature/UpdateTeamNameTest.php', base_path('tests/Feature/UpdateTeamNameTest.php'));

        $this->ensureApplicationIsTeamCompatible();
    }

    private function ensureApplicationIsTeamCompatible(): void
    {
        // Publish Team Migrations...
        $this->callSilent('vendor:publish', ['--tag' => 'hotstream-team-migrations', '--force' => true]);

        // Configuration...
        $this->replaceInFile('// Features::teams([\'invitations\' => true])', 'Features::teams([\'invitations\' => true])', config_path('hotstream.php'));

        // Directories...
        File::ensureDirectoryExists(app_path('Actions/Hotstream'));
        File::ensureDirectoryExists(app_path('Events'));
        File::ensureDirectoryExists(app_path('Policies'));

        // Service Providers...
        copy(__DIR__.'/../../stubs/app/Providers/HotstreamWithTeamsServiceProvider.php', app_path('Providers/HotstreamServiceProvider.php'));

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/Membership.php', app_path('Models/Membership.php'));
        copy(__DIR__.'/../../stubs/app/Models/Team.php', app_path('Models/Team.php'));
        copy(__DIR__.'/../../stubs/app/Models/TeamInvitation.php', app_path('Models/TeamInvitation.php'));
        copy(__DIR__.'/../../stubs/app/Models/UserWithTeams.php', app_path('Models/User.php'));

        // Actions...
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/AddTeamMember.php', app_path('Actions/Hotstream/AddTeamMember.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/CreateTeam.php', app_path('Actions/Hotstream/CreateTeam.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/DeleteTeam.php', app_path('Actions/Hotstream/DeleteTeam.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/DeleteUserWithTeams.php', app_path('Actions/Hotstream/DeleteUser.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/InviteTeamMember.php', app_path('Actions/Hotstream/InviteTeamMember.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/RemoveTeamMember.php', app_path('Actions/Hotstream/RemoveTeamMember.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/UpdateTeamName.php', app_path('Actions/Hotstream/UpdateTeamName.php'));
        copy(__DIR__.'/../../stubs/app/Actions/Hotstream/UpdateUserPicture.php', app_path('Actions/Hotstream/UpdateUserPicture.php'));

        copy(__DIR__.'/../../stubs/app/Actions/Fortify/CreateNewUserWithTeams.php', app_path('Actions/Fortify/CreateNewUser.php'));

        // Policies...
        File::copyDirectory(__DIR__.'/../../stubs/app/Policies', app_path('Policies'));

        // Factories...
        copy(__DIR__.'/../../database/factories/TeamFactory.php', base_path('database/factories/TeamFactory.php'));
    }

    private function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    private function removeComposerDevPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = [$this->phpBinary(), $composer, 'remove', '--dev'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove', '--dev'],
            is_array($packages) ? $packages : func_get_args()
        );

        $result = Process::forever()->path(base_path())->env([
            'COMPOSER_MEMORY_LIMIT' => '-1',
        ])->run($command);

        $this->output->write($result->output());

        return $result->successful();
    }

    private function requireComposerDevPackages($packages)
    {
        return $this->requireComposerPackages($packages, dev: true);
    }

    private function requireComposerPackages($packages, bool $dev = false)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = array_filter([$this->phpBinary(), $composer, 'require', $dev ? '--dev' : null]);
        }

        $command = array_merge(
            $command ?? array_filter(['composer', 'require', $dev ? '--dev' : null]),
            is_array($packages) ? $packages : func_get_args()
        );

        $result = Process::forever()->path(base_path())->env([
            'COMPOSER_MEMORY_LIMIT' => '-1',
        ])->run($command);

        $this->output->write($result->output());

        return $result->successful();
    }

    private function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }

    private function phpBinary()
    {
        return (new PhpExecutableFinder())->find(false) ?: 'php';
    }

    private function getTestStubsPath(): string
    {
        return __DIR__.'/../../stubs/tests';
    }
}
