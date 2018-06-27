<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('Restricted access');

class SppagebuilderAddonTestimonialpro extends SppagebuilderAddons {

    public function render() {

        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';

        //Options
        $autoplay = (isset($this->addon->settings->autoplay) && $this->addon->settings->autoplay) ? ' data-sppb-ride="sppb-carousel"' : '';
        $controls = (isset($this->addon->settings->controls) && $this->addon->settings->controls) ? $this->addon->settings->controls : 0;
        $interval = (isset($this->addon->settings->interval) && $this->addon->settings->interval) ? ((int) $this->addon->settings->interval * 1000) : 5000;
        $avatar_shape = (isset($this->addon->settings->avatar_shape) && $this->addon->settings->avatar_shape) ? $this->addon->settings->avatar_shape : 'sppb-avatar-circle';
        $show_quote = (isset($this->addon->settings->show_quote)) ? $this->addon->settings->show_quote : true;
        $avatar_on_top = (isset($this->addon->settings->avatar_on_top)) ? $this->addon->settings->avatar_on_top : 0;

        //Output
        $output = '<div id="sppb-testimonial-pro-' . $this->addon->id . '" data-interval="' . $interval . '" class="sppb-carousel sppb-testimonial-pro sppb-slide sppb-text-center ' . $class . '"' . $autoplay . '>';

        if ($controls) {
            $output .= '<ol class="sppb-carousel-indicators">';
            foreach ($this->addon->settings->sp_testimonialpro_item as $key1 => $value) {
                $output .= '<li data-sppb-target="#sppb-carousel-' . $this->addon->id . '" ' . (($key1 == 0) ? ' class="active"' : '' ) . '  data-sppb-slide-to="' . $key1 . '"></li>' . "\n";
            }
            $output .= '</ol>';
        }

        if($show_quote){
            $output .= '<span class="fa fa-quote-left"></span>';
        }
        $output .= '<div class="sppb-carousel-inner">';

        foreach ($this->addon->settings->sp_testimonialpro_item as $key => $value) {
            $output .= '<div class="sppb-item ' . (($key == 0) ? ' active' : '') . '">';
            $name = (isset($value->title) && $value->title) ? $value->title : '';
            
            if($avatar_on_top==1){
                $output .= (isset($value->avatar) && $value->avatar) ? '<img src="' . $value->avatar . '" class="' . $avatar_shape . '" alt="' . $name . '">' : '';
            }
            $output .= '<div class="sppb-testimonial-message">' . $value->message . '</div>';
            $output .= '<div class="sppb-addon-testimonial-pro-footer">';
            if($avatar_on_top!=1){
                $output .= (isset($value->avatar) && $value->avatar) ? '<img src="' . $value->avatar . '" class="' . $avatar_shape . '" alt="' . $name . '">' : '';
            }
            $output .= $name ? '<strong>' . $name . '</strong>' : '';
            $output .= (isset($value->url) && $value->url) ? '&nbsp;<span class="sppb-addon-testimonial-pro-client-url">' . $value->url . '</span>' : '';
            $output .= '</div>';

            $output .= '</div>';
        }
        $output .= '</div>';

        $output .= '</div>';

        return $output;
    }

    public function css() {
        $addon_id = '#sppb-addon-' . $this->addon->id;
        $avatar_size = (isset($this->addon->settings->avatar_width) && $this->addon->settings->avatar_width) ? $this->addon->settings->avatar_width : '32';
        $css = '';

        $speed = (isset($this->addon->settings->speed) && $this->addon->settings->speed) ? $this->addon->settings->speed : 600;
        $css .= $addon_id . ' .sppb-carousel-inner > .sppb-item{-webkit-transition-duration: ' . $speed . 'ms; transition-duration: ' . $speed . 'ms;}';
        
        $css .= $addon_id . ' .sppb-addon-testimonial-pro-footer img{width:'.$avatar_size.'px; height:'.$avatar_size.'px;}';
        $css .= $addon_id . ' .sppb-item > img{width:'.$avatar_size.'px; height:'.$avatar_size.'px;}';
        
        $icon_style = '';
        $icon_style_sm = '';
        $icon_style_xs = '';

        $icon_style .= (isset($this->addon->settings->icon_color) && $this->addon->settings->icon_color) ? "color: " . $this->addon->settings->icon_color . ";" : "";
        $icon_style .= (isset($this->addon->settings->icon_size) && $this->addon->settings->icon_size) ? "font-size: " . $this->addon->settings->icon_size . "px;" : "";
        $icon_style_sm .= (isset($this->addon->settings->icon_size_sm) && $this->addon->settings->icon_size_sm) ? "font-size: " . $this->addon->settings->icon_size_sm . "px;" : "";
        $icon_style_xs .= (isset($this->addon->settings->icon_size_xs) && $this->addon->settings->icon_size_xs) ? "font-size: " . $this->addon->settings->icon_size_xs . "px;" : "";

        if($icon_style){
            $css .= '#sppb-addon-' . $this->addon->id . ' .sppb-testimonial-pro .fa-quote-left{ ' . $icon_style . ' }';
        }

        if($icon_style_sm){
            $css .= '@media (min-width: 768px) and (max-width: 991px) {#sppb-addon-' . $this->addon->id . ' .sppb-testimonial-pro .fa-quote-left{ ' . $icon_style_sm . ' }}';
        }

        if($icon_style_xs){
            $css .= '@media (max-width: 767px) {#sppb-addon-' . $this->addon->id . ' .sppb-testimonial-pro .fa-quote-left{ ' . $icon_style_xs . ' }}';
        }

        return $css;
    }

    public static function getTemplate() {

        $output = '
            <#
                let interval = (data.interval)? (data.interval*1000):5000
                let autoplay = (data.autoplay)? \'data-sppb-ride="sppb-carousel"\':""
                let avatar_size = data.avatar_width || 32
                let avatar_shape = data.avatar_shape || "sppb-avatar-circle"

            #>
            <style type="text/css">
                #sppb-addon-{{ data.id }} .sppb-item > img,
                #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer img{
                    width: {{avatar_size}}px;
                    height: {{avatar_size}}px;
                }
                <# if(data.show_quote){ #>
                    #sppb-addon-{{ data.id }} .sppb-testimonial-pro .fa-quote-left{
                        <# if(_.isObject(data.icon_size)){ #>
                            font-size: {{ data.icon_size.md }}px;
                        <# } #>
                        color: {{ data.icon_color }};
                    }
                <# } #>
                @media (min-width: 768px) and (max-width: 991px) {
                    <# if(data.show_quote){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-pro .fa-quote-left{
                            <# if(_.isObject(data.icon_size)){ #>
                                font-size: {{ data.icon_size.sm }}px;
                            <# } #>
                        }
                    <# } #>
                }
                @media (max-width: 767px) {
                    <# if(data.show_quote){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-pro .fa-quote-left{
                            <# if(_.isObject(data.icon_size)){ #>
                                font-size: {{ data.icon_size.xs }}px;
                            <# } #>
                        }
                    <# } #>
                }
            </style>
            <div id="sppb-testimonial-pro-{{ data.id }}" data-interval="{{ interval }}" class="sppb-carousel sppb-testimonial-pro sppb-slide sppb-text-center {{ data.class }}" {{{ autoplay }}}>

                <# if(data.controls) { #>
                    <ol class="sppb-carousel-indicators">
                    <#
                    _.each(data.sp_testimonialpro_item, function(item,key){
                        let activeClass
                        if (key == 0) {
                            activeClass = "class=active"
                        }else{
                            activeClass = ""
                        }
                    #>
                        <li data-sppb-target="#sppb-testimonial-pro-{{ data.id }}" {{ activeClass }} data-sppb-slide-to="{{ key }}"></li>
                    <# }) #>
                    </ol>
                <# } #>

                <# if(data.show_quote){ #>
                    <span class="fa fa-quote-left"></span>
                <# } #>
                <div class="sppb-carousel-inner">
                    <#
                    _.each(data.sp_testimonialpro_item, function(itemSlide, index) {
                        let slideActClass = ""
                        if (index == 0) {
                            slideActClass = " active"
                        } else {
                            slideActClass = ""
                        }
                    #>

                        <div class="sppb-item{{ slideActClass }}">
                            <# if (data.avatar_on_top == 1) { 
                            if (!_.isEmpty(itemSlide.avatar)) { #>
                                <# if(itemSlide.avatar.indexOf("https://") == -1 && itemSlide.avatar.indexOf("http://") == -1){ #>
                                    <img class="{{ avatar_shape }}" src=\'{{ pagebuilder_base + itemSlide.avatar }}\' alt="">
                                <# } else { #>
                                    <img class="{{ avatar_shape }}" src=\'{{ itemSlide.avatar }}\' alt="">
                                <# } #>
                            <# }
                            } #>
                            <div class="sppb-testimonial-message sp-editable-content" id="addon-message-{{data.id}}-{{index}}" data-id={{data.id}} data-fieldName="sp_testimonialpro_item-{{index}}-message">{{{ itemSlide.message }}}</div>

                            <div class="sppb-addon-testimonial-pro-footer">
                            <# if (data.avatar_on_top !== 1) { 
                            if (!_.isEmpty(itemSlide.avatar)) { #>
                                <# if(itemSlide.avatar.indexOf("https://") == -1 && itemSlide.avatar.indexOf("http://") == -1){ #>
                                    <img class="{{ avatar_shape }}" src=\'{{ pagebuilder_base + itemSlide.avatar }}\' alt="">
                                <# } else { #>
                                    <img class="{{ avatar_shape }}" src=\'{{ itemSlide.avatar }}\' alt="">
                                <# } #>
                            <# }
                            } #>
                            <# if( !_.isEmpty(itemSlide.title) ) { #>
                            <strong>{{ itemSlide.title }}</strong>
                            <# if( !_.isEmpty(itemSlide.url) ) { #>
                                &nbsp;<span class="sppb-addon-testimonial-pro-client-url">{{ itemSlide.url }}</span>
                            <# } #>
                            <# } #>
                            </div>
                        </div>

                    <# }) #>
                </div>
            </div>
            ';

        return $output;
    }

}