<?php

namespace Laravel\Dusk;

use Exception;
use App\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\Assert as PHPUnit;


class DuskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/_dusk/login/{userId}/{guard?}', [
            'middleware' => 'web',
            'uses' => 'Laravel\Dusk\Http\Controllers\UserController@login',
        ]);

        Route::get('/_dusk/logout/{guard?}', [
            'middleware' => 'web',
            'uses' => 'Laravel\Dusk\Http\Controllers\UserController@logout',
        ]);

        Route::get('/_dusk/user/{guard?}', [
            'middleware' => 'web',
            'uses' => 'Laravel\Dusk\Http\Controllers\UserController@user',
        ]);

        Browser::macro('selectDropdown', function ($element = null, $value = null) {
            $this->script("$('#$element').select2('open');");
            $this->keys('.select2-search__field', $value)
                 ->keys('.select2-search__field', '{enter}')
                 ->assertSeeIn('#select2-'.$element.'-container', $value);
            return $this;
        });

        Browser::macro('assertDropdownValue', function ($element = null, $value = null) {
                $this->assertSeeIn('#select2-'.$element.'-container', $value);
            return $this;
        });

        Browser::macro('selectDate', function ($element = null, $value = 'YYYY-mm-dd') {
            $this->script("$('#$element').datepicker('show');");
            $this->script("$('#$element').datepicker('update', '$value');");
            $this->script("$('#$element').datepicker('hide');");
            $this->assertInputValue("#$element", $value);
            return $this;
        });

        Browser::macro('selectRadio', function ($value = null) {
            $this->click("label[for=$value]");
            return $this;
        });

        Browser::macro('submitForm', function ($formId = null) {
            $this->script("$('#$formId button[type=submit]').trigger('click')");
            return $this;
        });

        Browser::macro('seeSuccessDialog', function () {
            $this->waitFor('div[data-notify=container]')
                ->assertSeeIn('div[data-notify=container] span[data-notify=message]','successfully!');
            return $this;
        });

        Browser::macro('seeErrorDialog', function () {
            $this->waitFor('div[data-notify=container]')
                ->assertSeeIn('div[data-notify=container] span[data-notify=message]','Please try again.');
            return $this;
        });

        Browser::macro('uploadFile', function($element = null, $filepond_const = null, $file_url) {
            $this->script("$filepond_const.addFile('$file_url')");
            $this->waitForText('Upload complete', 10);
            $file_uuid = $this->value($element);

            $file = File::all()->last();
            PHPUnit::assertEquals(json_decode($file_uuid)[0], $file->uuid);

            return $this;
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     * @throws Exception
     */
    public function register()
    {
        if ($this->app->environment('production')) {
            throw new Exception('It is unsafe to run Dusk in production.');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
                Console\DuskCommand::class,
                Console\DuskFailsCommand::class,
                Console\MakeCommand::class,
                Console\PageCommand::class,
                Console\ComponentCommand::class,
            ]);
        }
    }
}
