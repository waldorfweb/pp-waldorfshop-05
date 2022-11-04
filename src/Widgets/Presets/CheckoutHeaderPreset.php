<?php

namespace Waldorfshop4\Widgets\Presets;

use Ceres\Config\CeresConfig;
use Ceres\Widgets\Helper\PresetHelper;
use Plenty\Modules\ShopBuilder\Contracts\ContentPreset;
use Plenty\Plugin\Application;

class CheckoutHeaderPreset implements ContentPreset
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
        $preset->createWidget("Waldorfshop4::CheckoutHeaderWidget")
            ->withSetting("companyLogoUrl", $companyLogo);


        return $preset->toArray();
    }
}
