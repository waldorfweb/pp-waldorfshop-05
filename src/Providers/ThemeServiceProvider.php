<?php
namespace Waldorfshop5\Providers;
use IO\Helper\ResourceContainer;
use Plenty\Modules\Webshop\Template\Providers\TemplateServiceProvider;
use Plenty\Modules\ContentCache\Contracts\ContentCacheQueryParamsRepositoryContract;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\ConfigRepository;
use IO\Helper\ComponentContainer;

/**
 * Class ThemeServiceProvider
 * @package Waldorfshop5\Providers
 */
class ThemeServiceProvider extends TemplateServiceProvider
{
    const PRIORITY = 0;

    public function register()
    {

    }

    public function boot(Twig $twig, Dispatcher $dispatcher, ConfigRepository $config)
    {
        $this->overrideTemplate('Ceres::PageDesign.PageDesign', 'Waldorfshop5::PageDesign.PageDesign');
        $this->overrideTemplate('Ceres::PageDesign.Partials.Footer', 'Waldorfshop5::PageDesign.Partials.Footer');
        $this->overrideTemplate('Ceres::PageDesign.Partials.Head', 'Waldorfshop5::PageDesign.Partials.Head');
        $this->overrideTemplate('Ceres::Widgets.Header.TopBarWidget', 'Waldorfshop5::Widgets.Header.TopBarWidget');

        $dispatcher->listen("IO.Resources.Import", function(ResourceContainer $container)
        {
            $container->addScriptTemplate('Waldorfshop5::ItemList.Components.CategoryItem');
        },0);

        $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
        {
            if ($container->getOriginComponentTemplate()=='Ceres::Customer.Components.UserLoginHandler')
            {
                $container->setNewComponentTemplate('Waldorfshop5::Customer.Components.UserLoginHandler');
            }
        }, self::PRIORITY);

        /** @var ContentCacheQueryParamsRepositoryContract $contentCacheQueryParamsRepository */
        $contentCacheQueryParamsRepository = pluginApp(ContentCacheQueryParamsRepositoryContract::class);
        $contentCacheQueryParamsRepository->registerExcluded([
            'gclid',
            'dclid',
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
            'wbraid',
            'fbclid',

            'vmtrack_id',
            'vmst_id',
            'idealoid',
            'li_fat_id',
            'msclkid',
        ]);
    }
}
