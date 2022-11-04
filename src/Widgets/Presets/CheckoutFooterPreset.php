<?php

namespace Waldorfshop4\Widgets\Presets;

use Ceres\Config\CeresConfig;
use Ceres\Widgets\Helper\PresetHelper;
use Plenty\Modules\ShopBuilder\Contracts\ContentPreset;
use Plenty\Plugin\Application;

class CheckoutFooterPreset implements ContentPreset
{
    /**
     * Get the widget configurations of the presets to be assigned to the created content.
     *
     * @return mixed
     */
    public function getWidgets()
    {
        /** @var PresetHelper $preset */
        $preset = pluginApp(PresetHelper::class);


        $preset->createWidget("Waldorfshop4::FooterListWidget")
               ->withSetting("displayInline", true)
               ->withSetting("entries", [
                   [
                       "text" => "Item 1",
                       "url"  => [
                           "value" => "https://one-dot.de",
                           "type"  => "external"
                       ]
                   ],
                   [
                       "text" => "Item 2",
                       "url"  => [
                           "value" => "https://one-dot.de",
                           "type"  => "external"
                       ]
                   ],
                   [
                       "text" => "Item 3",
                       "url"  => [
                           "value" => "https://one-dot.de",
                           "type"  => "external"
                       ]
                   ],
               ]);


        $preset->createWidget("Waldorfshop4::ImageListWidget")
               ->withSetting("entries", []);

        return $preset->toArray();
    }
}
