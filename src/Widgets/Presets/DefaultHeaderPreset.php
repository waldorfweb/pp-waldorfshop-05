<?php

namespace Waldorfshop4\Widgets\Presets;

use Ceres\Config\CeresConfig;
use Ceres\Widgets\Helper\PresetHelper;
use Plenty\Modules\ShopBuilder\Contracts\ContentPreset;
use Plenty\Plugin\Application;

class DefaultHeaderPreset implements ContentPreset
{
    /**
     * Get the widget configurations of the presets to be assigned to the created content.
     *
     * @return mixed
     */
    public function getWidgets()
    {
        /** @var CeresConfig $config */
        $config = pluginApp(CeresConfig::class);

        /** @var PresetHelper $preset */
        $preset = pluginApp(PresetHelper::class);


        $companyLogo = $config->header->companyLogo;
        if (strpos($companyLogo, 'http') !== 0 && strpos($companyLogo, 'layout/') !== 0) {
            $companyLogo = pluginApp(Application::class)->getUrlPath('Ceres') . '/' . $companyLogo;
        }
        $preset->createWidget("Waldorfshop4::HeaderWidget")
               ->withSetting("enableLanguageSelect", true)
               ->withSetting("enableShippingCountrySelect", true)
               ->withSetting("enableCurrencySelect", true)
               ->withSetting("enableLogin", true)
               ->withSetting("enableRegistration", true)
               ->withSetting("enableWishList", true)
               ->withSetting("enableBasketPreview", true)
               ->withSetting("basketValues", $config->header->basketValues)
               ->withSetting("showItemImages", false)
               ->withSetting("forwardToSingleItem", $config->search->forwardToSingleItem)
               ->withSetting("megaMenuCategoryIds", "")
               ->withSetting("megaMenuLevels", 2)
               ->withSetting("showOnHomepage", false)
               ->withSetting("showOnMyAccount", false)
               ->withSetting("showOnCheckout", false)
               ->withSetting("showOnContentCategory", false)
               ->withSetting("companyLogoUrl", $companyLogo);


        return $preset->toArray();
    }
}
