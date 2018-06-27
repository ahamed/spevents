<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2017 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('resticted aceess');

class SppagebuilderAddonPricing extends SppagebuilderAddons {

    public function render() {

        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

        //Options
        $price = (isset($this->addon->settings->price) && $this->addon->settings->price) ? $this->addon->settings->price : '';
        $duration = (isset($this->addon->settings->duration) && $this->addon->settings->duration) ? $this->addon->settings->duration : '';
        $pricing_content = (isset($this->addon->settings->pricing_content) && $this->addon->settings->pricing_content) ? $this->addon->settings->pricing_content : '';
        $button_text = (isset($this->addon->settings->button_text) && $this->addon->settings->button_text) ? $this->addon->settings->button_text : '';
        $button_url = (isset($this->addon->settings->button_url) && $this->addon->settings->button_url) ? $this->addon->settings->button_url : '';
        $button_classes = (isset($this->addon->settings->button_size) && $this->addon->settings->button_size) ? ' sppb-btn-' . $this->addon->settings->button_size : '';
        $button_classes .= (isset($this->addon->settings->button_type) && $this->addon->settings->button_type) ? ' sppb-btn-' . $this->addon->settings->button_type : '';
        $button_classes .= (isset($this->addon->settings->button_shape) && $this->addon->settings->button_shape) ? ' sppb-btn-' . $this->addon->settings->button_shape : ' sppb-btn-rounded';
        $button_classes .= (isset($this->addon->settings->button_appearance) && $this->addon->settings->button_appearance) ? ' sppb-btn-' . $this->addon->settings->button_appearance : '';
        $button_classes .= (isset($this->addon->settings->button_block) && $this->addon->settings->button_block) ? ' ' . $this->addon->settings->button_block : '';
        $button_icon = (isset($this->addon->settings->button_icon) && $this->addon->settings->button_icon) ? $this->addon->settings->button_icon : '';
        $button_icon_position = (isset($this->addon->settings->button_icon_position) && $this->addon->settings->button_icon_position) ? $this->addon->settings->button_icon_position : 'left';
        $button_position = (isset($this->addon->settings->button_position) && $this->addon->settings->button_position) ? $this->addon->settings->button_position : '';
        $button_attribs = (isset($this->addon->settings->button_target) && $this->addon->settings->button_target) ? ' target="' . $this->addon->settings->button_target . '"' : '';
        $button_attribs .= (isset($this->addon->settings->button_url) && $this->addon->settings->button_url) ? ' href="' . $this->addon->settings->button_url . '"' : '';
        $alignment = (isset($this->addon->settings->alignment) && $this->addon->settings->alignment) ? $this->addon->settings->alignment : '';
        $featured = (isset($this->addon->settings->featured) && $this->addon->settings->featured) ? $this->addon->settings->featured : '';


        if ($button_icon_position == 'left') {
            $button_text = ($button_icon) ? '<i class="fa ' . $button_icon . '"></i> ' . $button_text : $button_text;
        } else {
            $button_text = ($button_icon) ? $button_text . ' <i class="fa ' . $button_icon . '"></i>' : $button_text;
        }

        $button_output = ($button_text) ? '<a' . $button_attribs . ' id="btn-' . $this->addon->id . '" class="sppb-btn' . $button_classes . '">' . $button_text . '</a>' : '';

        //Output
        $output = '<div class="sppb-addon sppb-addon-pricing-table ' . $alignment . ' ' . $class . '">';
        $output .= '<div class="sppb-pricing-box ' . $featured . '">';
        $output .= '<div class="sppb-pricing-header">';
        $output .= ($price) ? '<span class="sppb-pricing-price">' . $price . '</span>' : '';
        $output .= ($duration) ? '<span class="sppb-pricing-duration">' . $duration . '</span>' : '';
        $output .= ($title) ? '<div class="sppb-pricing-title">' . $title . '</div>' : '';
        $output .= '</div>';

        if ($pricing_content) {
            $output .= '<div class="sppb-pricing-features">';
            $output .= '<ul>';

            $features = explode("\n", $pricing_content);

            foreach ($features as $feature) {
                $output .= '<li>' . $feature . '</li>';
            }

            $output .= '</ul>';
            $output .= '</div>';
        }

        $output .= '<div class="sppb-pricing-footer">';
        $output .= $button_output;
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    public function css() {
        $addon_id = '#sppb-addon-' . $this->addon->id;
        $css = '';
        $background = (isset($this->addon->settings->background) && $this->addon->settings->background) ? $this->addon->settings->background . ';' : '';

        $background_image = (isset($this->addon->settings->background_image) && $this->addon->settings->background_image) ? $this->addon->settings->background_image : '';
        $color = (isset($this->addon->settings->color) && $this->addon->settings->color) ? $this->addon->settings->color : '';

        $style = '';
        if ($background)
            $style .= 'background-color:' . $background . ';';
        if ($background_image)
            $style .= 'background-image: url(' . JURI::base(true) . '/' . $background_image . ');';
        if ($color)
            $style .= 'color:' . $color . ';';

        if ($style) {
            $css .= $addon_id . ' .sppb-pricing-box {';
            $css .= $style;
            $css .= '}';
        }

        // Button css
        $layout_path = JPATH_ROOT . '/components/com_sppagebuilder/layouts';
        $css_path = new JLayoutFile('addon.css.button', $layout_path);
        $css .= $css_path->render(array('addon_id' => $addon_id, 'options' => $this->addon->settings, 'id' => 'btn-' . $this->addon->id));

        return $css;
    }

    public static function getTemplate() {
        $output = '
            <#
                let contentClass = (!_.isEmpty(data.class) && data.class) ? data.class : "";
                let title = (!_.isEmpty(data.title) && data.title) ? data.title : "";
                let heading_selector = (!_.isEmpty(data.heading_selector) && data.heading_selector) ? data.heading_selector : "h3";

                let price = (!_.isEmpty(data.price) && data.price) ? data.price : "";
                let duration = (!_.isEmpty(data.duration) && data.duration) ? data.duration : "";
                let pricing_content = (!_.isEmpty(data.pricing_content) && data.pricing_content) ? data.pricing_content : "";
                let button_text = (!_.isEmpty(data.button_text) && data.button_text) ? data.button_text : "";
                let button_url = (!_.isEmpty(data.button_url) && data.button_url) ? data.button_url : "";
                let button_classes = (!_.isEmpty(data.button_size) && data.button_size) ? \' sppb-btn-\' + data.button_size : "";
                button_classes += (!_.isEmpty(data.button_type) && data.button_type) ? \' sppb-btn-\' + data.button_type : "";
                button_classes += (!_.isEmpty(data.button_shape) && data.button_shape) ? \' sppb-btn-\' + data.button_shape : " sppb-btn-rounded";
                button_classes += (!_.isEmpty(data.button_appearance) && data.button_appearance) ? \' sppb-btn-\' + data.button_appearance : "";
                button_classes += (!_.isEmpty(data.button_block) && data.button_block) ? \' \' + data.button_block : "";
                let button_icon = (!_.isEmpty(data.button_icon) && data.button_icon) ? data.button_icon : "";
                let button_icon_position = (!_.isEmpty(data.button_icon_position) && data.button_icon_position) ? data.button_icon_position : "left";
                let button_position = (!_.isEmpty(data.button_position) && data.button_position) ? data.button_position : "";
                let button_attribs = (!_.isEmpty(data.button_target) && data.button_target) ? \' target="\' + data.button_target + \'"\' : "";
                button_attribs += (!_.isEmpty(data.button_url) && data.button_url) ? \' href="\' + data.button_url + \'"\' : "";
                let alignment = (!_.isEmpty(data.alignment) && data.alignment) ? data.alignment : "";
                let featured = (!_.isEmpty(data.featured) && data.featured) ? data.featured : "";

                if (button_icon_position == "left") {
                    button_text = (button_icon) ? \'<i class="fa \' + button_icon + \'"></i> \' + button_text : button_text;
                } else {
                    button_text = (button_icon) ? button_text + \' <i class="fa \' + button_icon + \'"></i>\' : button_text;
                }

                let button_output = (button_text) ? \'<a\' + button_attribs + \' id="btn-\' + data.id + \'" class="sppb-btn\' + button_classes + \'">\' + button_text + \'</a>\' : "";

                let background = (!_.isEmpty(data.background) && data.background) ? data.background : "";
                let background_image = (!_.isEmpty(data.background_image) && data.background_image) ? data.background_image : "";
                let color = (!_.isEmpty(data.color) && data.color) ? data.color : "";

                let style = "";
                if (background){
                    style += \'background-color:\' + background + \';\';
                }
                if (background_image){
                    style += \'background-image: url(\' + background_image + \');\';
                }
                if (color){
                    style += \'color:\' + color + \';\';
                }

            #>
                <div class="sppb-addon sppb-addon-pricing-table {{alignment}} {{contentClass}}">
                <div class="sppb-pricing-box {{featured}}" style="{{style}}">
                <div class="sppb-pricing-header">
                <# if(price) { #>
                    <span class="sppb-pricing-price">{{price}}</span>
                <# }
                if(duration) {
                #>
                    <span class="sppb-pricing-duration">{{duration}}</span>
                <# }
                if(title) {
                #>
                    <div class="sppb-pricing-title">{{{title}}}</div>
                <# } #>
                </div>

                <# if (pricing_content) { #>
                    <div class="sppb-pricing-features">
                    <ul>
                    <#
                    let features = pricing_content.split(" ");

                    _.each (features, function(feature) {
                    #>
                        <li>{{{feature}}}</li>
                    <# }) #>

                    </ul>
                    </div>
                <# } #>

                <div class="sppb-pricing-footer">
                {{{button_output}}}
                </div>
                </div>
                </div>
                ';
        return $output;
    }

}
