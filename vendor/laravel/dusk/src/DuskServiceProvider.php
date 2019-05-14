<?php

namespace Laravel\Dusk;

use Exception;
use Illuminate\Support\Str;
use App\File;
use Tests\TestCase;
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

        /*
         |--------------------------------------------------------------------------
         | CUSTOM MACROS
         |--------------------------------------------------------------------------
         |
         | These macros are created to help enhance the running of dusk tests.
         |
         */
        /*
         |--------------------------------------------------------------------------
         | FORM MACROS
         |--------------------------------------------------------------------------
         */
        // Form Elements
        Browser::macro('selectDropdown', function ($element = null, $value = null) {
            $this->script("$('#$element').select2('open');");
            $this->keys('.select2-search__field', $value)
                ->keys('.select2-search__field', '{enter}')
                ->assertSeeIn('#select2-' . $element . '-container', $value);
            return $this;
        });

        Browser::macro('assertDropdownValue', function ($element = null, $value = null) {
            $this->assertSeeIn('#select2-' . $element . '-container', $value);
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
            $value = Str::slug($value);
            $this->click("@radio-$value");
            return $this;
        });

        Browser::macro('uploadFile', function ($element = null, $file_url = false) {
            $file_url ?: $file_url = url('/storage/sample-passport.jpg');
            $this->script("$element.addFile('$file_url')");
            $this->waitUntil('$(\'div[id=' . $element . ']\').text().includes(\'Upload complete\')', 30);
            $file_uuid = $this->value(".filepond--file-wrapper input[name=$element]");

            $file = File::all()->last();
            PHPUnit::assertEquals(json_decode($file_uuid)[0], $file->uuid);

            return $this;
        });

        Browser::macro('submitForm', function ($formId = null) {
            $this->script("$('#$formId button[type=submit]').trigger('click')");
            return $this;
        });

        Browser::macro('textArea', function ($element = null, $text = null) {
            $this->script("$('#$element').summernote('code', '$text')");
            return $this;
        });

        // Form Request
        Browser::macro('assertHasRequiredInputErrors', function ($form_request, array $excluded_ids = []) {
            $required_ids = [];
            foreach ($form_request->rules() as $id => $value) {
                if (strpos($value, 'required') !== false) {
                    $required_ids[] = $id;
                }
            }

            foreach (array_diff($required_ids, $excluded_ids) as $id) {
                PHPUnit::assertContains('required', $this->text("#$id-error"));
            }

            return $this;
        });

        /*
         |--------------------------------------------------------------------------
         | SEE DIALOGS
         |--------------------------------------------------------------------------
         */
        Browser::macro('seeSuccessDialog', function () {
            $this->waitFor('div[data-notify=container]')
                ->assertSeeIn('div[data-notify=container] span[data-notify=message]', 'successfully');
            return $this;
        });

        Browser::macro('seeErrorDialog', function () {
            $this->waitFor('div[data-notify=container]')
                ->assertSeeIn('div[data-notify=container] span[data-notify=message]', 'Please try again.');
            return $this;
        });

        /*
         |--------------------------------------------------------------------------
         | INTERACT WITH ELEMENTS
         |--------------------------------------------------------------------------
         */
        Browser::macro('clickButton', function ($dusk_selector = '') {
            $this->script("$('button[dusk=$dusk_selector]').trigger('click');");
            return $this;
        });

        Browser::macro('downloadFile', function ($download_btn_dusk_selector = '', File $file) {
            $this->script("$('button[dusk=$download_btn_dusk_selector]').trigger('click');");
            return $this;
        });

        Browser::macro('searchTable', function ($table_id = null, $search_value = null) {
            $this->waitFor("#$table_id")
                ->keys("input[aria-controls=$table_id]", $search_value)
                ->keys("input[aria-controls=$table_id]", '{enter}');
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
