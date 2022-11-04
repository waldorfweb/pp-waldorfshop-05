<?php

namespace Waldorfshop4\Widgets\Presets;

use Ceres\Config\CeresConfig;
use Ceres\Widgets\Helper\Factories\PresetWidgetFactory;
use Ceres\Widgets\Helper\PresetHelper;
use Illuminate\Foundation\Console\Presets\Preset;
use Plenty\Modules\ShopBuilder\Contracts\ContentPreset;
use Plenty\Plugin\Application;
use Plenty\Plugin\Translation\Translator;

class DefaultHomepagePreset implements ContentPreset
{
    /** @var PresetHelper */
    private $preset;

    /** @var CeresConfig */
    private $ceresConfig;

    /** @var Translator */
    private $translator;
    /**
     * Get the widget configurations of the presets to be assigned to the created content.
     *
     * @return mixed
     */
    public function getWidgets()
    {
        $this->preset      = pluginApp(PresetHelper::class);
        $this->ceresConfig = pluginApp(CeresConfig::class);
        $this->translator  = pluginApp(Translator::class);


        $this->setupImageBoxWidget($this->preset->createWidget("Ceres::ImageBoxWidget"));
        $this->preset->createWidget("Waldorfshop4::ImageListWidget")
                     ->withSetting("entries", []);


        $this->setupItemListWidget($this->preset->createWidget("Ceres::ItemListWidget"));

        $grid = null;
        $grid = $this->preset->createWidget("Ceres::TwoColumnWidget")
                             ->withSetting("layout", "oneToOne");
        $this->setupImageBoxWidget($grid->createChild("first", "Ceres::ImageBoxWidget"));
        $this->setupImageBoxWidget($grid->createChild("second", "Ceres::ImageBoxWidget"));

        $this->setupItemListWidget($this->preset->createWidget("Ceres::ItemListWidget"));

        return $this->preset->toArray();
    }

    /**
     * @param PresetWidgetFactory $widget
     * @param $categoryId
     * @param $variationId
     * @param $customImagePath
     * @param $style
     */
    private function setupImageBoxWidget($widget, $categoryId = 0, $variationId = 0, $customImagePath = "", $style = "no-caption", $appearance = "primary")
    {
        $widget
            ->withSetting("appearance", $appearance)
            ->withSetting("style", $style)
            ->withSetting("imageSize", "cover")
            ->withSetting("categoryId", $categoryId > 0 ? $categoryId : "")
            ->withSetting("variationId", $variationId > 0 ? $variationId : "")
            ->withSetting("customImagePath", $customImagePath);
    }

    private function setupItemListWidget( $widget, $categoryId = 0, $tagId = 0, $itemSort = "texts.name1_asc" )
    {
        $listType = "last_seen";
        if ( $categoryId > 0 )
        {
            $listType = "category";
        }
        if ( $tagId > 0 )
        {
            $listType = "tag_list";
        }

        $widget
            ->withSetting("appearance", "primary")
            ->withSetting("listType", $listType)
            ->withSetting("categoryId", $categoryId)
            ->withSetting("tagId", $tagId)
            ->withSetting("itemSort", $itemSort)
            ->withSetting("maxItems", 8);
    }
}
