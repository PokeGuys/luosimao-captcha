<?php namespace Pokeguys\Luosimao;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Luosimao class
 *
 * @author     PokeGuys
 * @link       https://github.com/pokeguys
 */
class LuosimaoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->addValidator();
    }

    /**
     * Extends Validator to include a luosimao type
     */
    public function addValidator()
    {
        $this->app->validator->extendImplicit('luosimao', function ($attribute, $value, $parameters) {
            $captcha   = app('luosimao.service');

            return $captcha->check($value);
        }, 'Please ensure that you are a human!');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindLuosimao();
        $this->handleConfig();
    }

    protected function bindLuosimao()
    {
        $this->app->bind('luosimao.service', function () {
            return new Service\CheckbindLuosimao;
        });

    }

    protected function handleConfig()
    {
        $packageConfig     = __DIR__ . '/config/luosimao.php';
        $destinationConfig = config_path('luosimao.php');

        $this->publishes([
            $packageConfig => $destinationConfig,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'luosimao',
        ];
    }
}
