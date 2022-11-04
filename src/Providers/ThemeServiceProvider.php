<?php
namespace Waldorfshop4\Providers;
use Plenty\Modules\ContentCache\Contracts\ContentCacheQueryParamsRepositoryContract;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Templates\Twig;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use IO\Extensions\Functions\Partial;
use Plenty\Modules\Webshop\ItemSearch\Helpers\ResultFieldTemplate;
use Plenty\Plugin\ConfigRepository;
use IO\Helper\ComponentContainer;

/**
 * Class ThemeServiceProvider
 * @package Waldorfshop4\Providers
 */
class ThemeServiceProvider extends ServiceProvider
{
    const PRIORITY = 0;
    public function register()
    {
    }
    public function boot(Twig $twig, Dispatcher $dispatcher, ConfigRepository $config)
    {
        $enabledOverrides = explode(", ", $config->get("Waldorfshop4.templates.override"));

        if (in_array("add_style", $enabledOverrides) || in_array("all", $enabledOverrides)) {

            $dispatcher->listen('IO.Resources.Import', function (ResourceContainer $container) {
                // The style is imported in the <head> on the PageDesign.twig of Ceres
                $container->addStyleTemplate('Waldorfshop4::AddStyle');
            }, self::PRIORITY);

        }

        // Add Script
        if (in_array("add_script", $enabledOverrides) || in_array("all", $enabledOverrides)) {

            $dispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
            {
                // The script is imported in the Footer.twig of Ceres
                $container->addScriptTemplate('Waldorfshop4::AddScript');
            }, self::PRIORITY);

        }

        // Override partials
        $dispatcher->listen('IO.init.templates', function (Partial $partial) use ($enabledOverrides)
        {
            $partial->set('head', 'Ceres::PageDesign.Partials.Head');
            $partial->set('header', 'Ceres::PageDesign.Partials.Header.Header');
            $partial->set('page-design', 'Ceres::PageDesign.PageDesign');
            $partial->set('footer', 'Ceres::PageDesign.Partials.Footer');
            if (in_array("head", $enabledOverrides) || in_array("all", $enabledOverrides))
            {
                $partial->set('head', 'Waldorfshop4::PageDesign.Partials.Head');
            }
            if (in_array("header", $enabledOverrides) || in_array("all", $enabledOverrides))
            {
                $partial->set('header', 'Waldorfshop4::PageDesign.Partials.Header.Header');
            }
            if (in_array("page_design", $enabledOverrides) || in_array("all", $enabledOverrides))
            {
                $partial->set('page-design', 'Waldorfshop4::PageDesign.PageDesign');
            }
            if (in_array("footer", $enabledOverrides) || in_array("all", $enabledOverrides))
            {
                $partial->set('footer', 'Waldorfshop4::PageDesign.Partials.Footer');
            }
            return false;
        }, self::PRIORITY);
        // Override homepage
        if (in_array("homepage", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.home', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Homepage.Homepage');
                return false;
            }, self::PRIORITY);
        }
        // Override template for content categories
        if (in_array("category_content", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.category.content', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Category.Content.CategoryContent');
                return false;
            }, self::PRIORITY);
        }
        // Override category view
        if (in_array("category_view", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.category.item', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Category.Item.CategoryItem');
                return false;
            }, self::PRIORITY);
        }
        // Override item card
        $dispatcher->listen("IO.Resources.Import", function(ResourceContainer $container)
        {
            $container->addScriptTemplate('Waldorfshop4::ItemList.Components.CategoryItem');
        },0);
        // Override shopping cart
        if (in_array("basket", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.basket', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Basket.Basket');
                return false;
            }, self::PRIORITY);
        }
        // Override checkout
        if (in_array("checkout", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.checkout', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Checkout.Checkout');
                return false;
            }, self::PRIORITY);
        }
        // Override order confirmation page
        if (in_array("order_confirmation", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.confirmation', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Checkout.OrderConfirmation');
                return false;
            }, self::PRIORITY);
        }
        // Override login page
        if (in_array("login", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.login', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Customer.Login');
                return false;
            }, self::PRIORITY);
        }
        // Override register page
        if (in_array("register", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.register', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Customer.Register');
                return false;
            }, self::PRIORITY);
        }
        // Override single item page
        if (in_array("item", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.item', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Item.SingleItemWrapper');
                return false;
            }, self::PRIORITY);
        }
        // Override search view
        if (in_array("search", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.search', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::ItemList.ItemListView');
                return false;
            }, self::PRIORITY);
        }
        // Override my account
        if (in_array("my_account", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.my-account', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::MyAccount.MyAccount');
                return false;
            }, self::PRIORITY);
        }
        // Override wish list
        if (in_array("wish_list", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.wish-list', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::WishList.WishListView');
                return false;
            }, self::PRIORITY);
        }
        // Override contact page
        if (in_array("contact", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.contact', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Customer.Contact');
                return false;
            }, self::PRIORITY);
        }
        // Override order return view
        if (in_array("order_return", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.order.return', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::OrderReturn.OrderReturnView');
                return false;
            }, self::PRIORITY);
        }
        // Override order return confirmation
        if (in_array("order_return_confirmation", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.order.return.confirmation', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::OrderReturn.OrderReturnConfirmation');
                return false;
            }, self::PRIORITY);
        }
        // Override cancellation rights
        if (in_array("cancellation_rights", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.cancellation-rights', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.CancellationRights');
                return false;
            }, self::PRIORITY);
        }
        // Override cancellation form
        if (in_array("cancellation_form", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.cancellation-form', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.CancellationForm');
                return false;
            }, self::PRIORITY);
        }
        // Override legal disclosure
        if (in_array("legal_disclosure", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.legal-disclosure', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.LegalDisclosure');
                return false;
            }, self::PRIORITY);
        }
        // Override privacy policy
        if (in_array("privacy_policy", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.privacy-policy', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.PrivacyPolicy');
                return false;
            }, self::PRIORITY);
        }
        // Override terms and conditions
        if (in_array("terms_conditions", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.terms-conditions', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.TermsAndConditions');
                return false;
            }, self::PRIORITY);
        }
        // Override item not found page
        if (in_array("item_not_found", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.item-not-found', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.ItemNotFound');
                return false;
            }, self::PRIORITY);
        }
        // Override page not found page
        if (in_array("page_not_found", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.page-not-found', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::StaticPages.PageNotFound');
                return false;
            }, self::PRIORITY);
        }
        // Override newsletter opt-out page
        if (in_array("newsletter_opt_out", $enabledOverrides) || in_array("all", $enabledOverrides))
        {
            $dispatcher->listen('IO.tpl.newsletter.opt-out', function (TemplateContainer $container)
            {
                $container->setTemplate('Waldorfshop4::Newsletter.NewsletterOptOut');
                return false;
            }, self::PRIORITY);
        }

        $enabledResultFields = explode(", ", $config->get("Waldorfshop4.result_fields.override"));
        // Override auto complete list item result fields
        if (in_array("auto_complete_list_item", $enabledResultFields) || in_array("all", $enabledResultFields))
        {
            $dispatcher->listen( 'IO.ResultFields.AutoCompleteListItem', function(ResultFieldTemplate $templateContainer)
            {
                $templateContainer->setTemplate(ResultFieldTemplate::TEMPLATE_AUTOCOMPLETE_ITEM_LIST, 'Waldorfshop4::ResultFields.AutoCompleteListItem');
                return false;
            }, self::PRIORITY);
        }
        // Override basket item result fields
        if (in_array("basket_item", $enabledResultFields) || in_array("all", $enabledResultFields))
        {
            $dispatcher->listen( 'IO.ResultFields.BasketItem', function(ResultFieldTemplate $templateContainer)
            {
                $templateContainer->setTemplate(ResultFieldTemplate::TEMPLATE_BASKET_ITEM, 'Waldorfshop4::ResultFields.BasketItem');
                return false;
            }, self::PRIORITY);
        }
        // Override category tree result fields
        if (in_array("category_tree", $enabledResultFields) || in_array("all", $enabledResultFields))
        {
            $dispatcher->listen( 'IO.ResultFields.CategoryTree', function(ResultFieldTemplate $templateContainer)
            {
                $templateContainer->setTemplate(ResultFieldTemplate::TEMPLATE_CATEGORY_TREE, 'Waldorfshop4::ResultFields.CategoryTree');
                return false;
            }, self::PRIORITY);
        }

        // Override list item result fields
        $resultFieldTemplate = pluginApp(ResultFieldTemplate::class);

        if (in_array('list_item', $enabledResultFields) || in_array('all', $enabledResultFields))
        {
            $resultFieldTemplate->setTemplate(ResultFieldTemplate::TEMPLATE_LIST_ITEM, 'Waldorfshop4::ResultFields.ListItem');
        }

        // Override single item view result fields
        if (in_array("single_item", $enabledResultFields) || in_array("all", $enabledResultFields))
        {
            $dispatcher->listen( 'IO.ResultFields.SingleItem', function(ResultFieldTemplate $templateContainer)
            {
                $templateContainer->setTemplate(ResultFieldTemplate::TEMPLATE_SINGLE_ITEM, 'Waldorfshop4::ResultFields.SingleItem');
                return false;
            }, self::PRIORITY);
        }

        $dispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
        {
            if ($container->getOriginComponentTemplate()=='Ceres::Customer.Components.UserLoginHandler')
            {
                $container->setNewComponentTemplate('Waldorfshop4::Customer.Components.UserLoginHandler');
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
