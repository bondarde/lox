<?php

namespace BondarDe\LaravelToolbox;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LaravelToolboxViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerBladeDirectives();
    }

    private function registerBladeDirectives()
    {
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('group', function ($arguments) {
                [$group, $guard] = explode(',', $arguments . ',');

                return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasGroup({$group})){?>";
            });

            $bladeCompiler->directive('elsegroup', function ($arguments) {
                [$group, $guard] = explode(',', $arguments . ',');

                return "<?php }else if(auth({$guard})->check() && auth({$guard})->user()->hasGroup({$group})){?>";
            });

            $bladeCompiler->directive('endgroup', function () {
                return '<?php } ?>';
            });

            $bladeCompiler->directive('permission', function ($arguments) {
                [$permission, $guard] = explode(',', $arguments . ',');

                return "<?php if(auth({$guard})->check() && auth({$guard})->user()->hasPermission({$permission})){?>";
            });

            $bladeCompiler->directive('elsepermission', function ($arguments) {
                [$permission, $guard] = explode(',', $arguments . ',');

                return "<?php }else if(auth({$guard})->check() && auth({$guard})->user()->hasPermission({$permission})){?>";
            });

            $bladeCompiler->directive('endpermission', function () {
                return '<?php } ?>';
            });
        });
    }
}
