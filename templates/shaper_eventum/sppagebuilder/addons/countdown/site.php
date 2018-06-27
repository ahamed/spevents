<?php

defined('_JEXEC') or die('resticted aceess');

class SppagebuilderAddonCountdown extends SppagebuilderAddons {

    public function render() {

        // Options
        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? ' ' . $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $subtitle = (isset($this->addon->settings->subtitle) && $this->addon->settings->subtitle) ? $this->addon->settings->subtitle : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

        $output = '';
        $output .= '<div class="sppb-addon event-countdown sppb-addon-countdown ' . $class . '">';
        $output .= "<div id='countdown-timer' class='sppb-countdown-timer sppb-row'></div>";
        $output .= '<div class="countdown-text-wrap">';
        $output .= ($title) ? '<' . $heading_selector . ' class="sppb-addon-title countdown-timer-title">' . $title . '</' . $heading_selector . '>' : '';
        $output .= '<h3 class="countdown-timer-subtitle">' . $subtitle . '</h3>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    public function scripts() {
        return array(JURI::base(true) . '/components/com_sppagebuilder/assets/js/jquery.countdown.min.js');
    }

    public function js() {
        $date = JHtml::_('date', $this->addon->settings->date, 'Y/m/d');
        //$time 		  			= isset($this->addon->settings->time);
        $finish_text = addslashes(isset($this->addon->settings->finish_text));

        $js = "jQuery(function($){
			var addon_id = '#sppb-addon-'+'" . $this->addon->id . "';
			//console.log(addon_id +' .sppb-addon-countdown .sppb-countdown-timer');
			$( addon_id +' .sppb-addon-countdown .sppb-countdown-timer').each(function () {
					var cdDateFormate = '" . $date . "';
					//console.log(cdDateFormate);
					$(this).countdown(cdDateFormate, function (event) {
							$(this).html(event.strftime('<span class=\"sppb-countdown-number timer-day\">%-D <span class=\"sppb-countdown-text\">%!D: ' + '" . JTEXT::_('COM_SPPAGEBUILDER_DAY') . "' + ',' + '" . JTEXT::_('COM_SPPAGEBUILDER_DAYS') . "' + ';</span></span><span class=\"sppb-countdown-number timer-hour\">%H<span class=\"sppb-countdown-text\">%!H: ' + '" . JTEXT::_('COM_SPPAGEBUILDER_HOUR') . "' + ',' + '" . JTEXT::_('COM_SPPAGEBUILDER_HOURS') . "' + ';</span></span><span class=\"sppb-countdown-number timer-minute\">%M <span class=\"sppb-countdown-text\">%!M:' + '" . JTEXT::_('COM_SPPAGEBUILDER_MINUTE') . "' + ',' + '" . JTEXT::_('COM_SPPAGEBUILDER_MINUTES') . "' + ';</span></span><span class=\"sppb-countdown-number timer-second\">%S <span class=\"sppb-countdown-text\">%!S:' + '" . JTEXT::_('COM_SPPAGEBUILDER_SECOND') . "' + ',' + '" . JTEXT::_('COM_SPPAGEBUILDER_SECONDS') . "' + ';</span></span>'))
							.on('finish.countdown', function () {
									$(this).html('<div class=\"sppb-countdown-finishedtext-wrap sppb-col-xs-12 sppb-col-sm-12 sppb-text-center\"><h3 class=\"sppb-countdown-finishedtext\">' + '" . $finish_text . "' + '</h3></div>');
							});
					});
			});
		})";
        return $js;
    }

    public function css() {
        $addon_id = '#sppb-addon-' . $this->addon->id;

        // Counter
        $counter_style = (isset($this->addon->settings->counter_height) && $this->addon->settings->counter_height) ? "height: " . (int) $this->addon->settings->counter_height . "px; line-height: " . (int) $this->addon->settings->counter_height . "px;" : '';
        $counter_style .= (isset($this->addon->settings->counter_width) && $this->addon->settings->counter_width) ? "width: " . (int) $this->addon->settings->counter_width . "px;" : '';
        $counter_style .= (isset($this->addon->settings->counter_font_size) && $this->addon->settings->counter_font_size) ? "font-size: " . (int) $this->addon->settings->counter_font_size . "px;" : '';
        $counter_style .= (isset($this->addon->settings->counter_text_color) && $this->addon->settings->counter_text_color) ? "color: " . $this->addon->settings->counter_text_color . ";" : '';
        $counter_style .= (isset($this->addon->settings->counter_background_color) && $this->addon->settings->counter_background_color) ? "background-color: " . $this->addon->settings->counter_background_color . ";" : '';
        $counter_style .= (isset($this->addon->settings->counter_border_radius) && $this->addon->settings->counter_border_radius) ? "border-radius: " . $this->addon->settings->counter_border_radius . "px;" : '';
        $use_border = (isset($this->addon->settings->counter_user_border) && $this->addon->settings->counter_user_border) ? 1 : 0;
        if ($use_border) {
            $counter_style .= (isset($this->addon->settings->counter_border_width) && $this->addon->settings->counter_border_width) ? "border-width: " . $this->addon->settings->counter_border_width . "px;" : '';
            $counter_style .= (isset($this->addon->settings->counter_border_style) && $this->addon->settings->counter_border_style) ? "border-style: " . $this->addon->settings->counter_border_style . ";" : '';
            $counter_style .= (isset($this->addon->settings->counter_border_color) && $this->addon->settings->counter_border_color) ? "border-color: " . $this->addon->settings->counter_border_color . ";" : '';
        }

        // Label
        $label_style = (isset($this->addon->settings->label_font_size) && $this->addon->settings->label_font_size) ? "font-size: " . (int) $this->addon->settings->label_font_size . "px;" : '';
        $label_style .= (isset($this->addon->settings->label_color) && $this->addon->settings->label_color) ? "color: " . $this->addon->settings->label_color . ";" : '';

        $css = '';
        if ($counter_style) {
            $css .= $addon_id . ' .sppb-countdown-number, ' . $addon_id . ' .sppb-countdown-finishedtext {';
            $css .= $counter_style;
            $css .= '}';
        }

        if ($label_style) {
            $css .= $addon_id . ' .sppb-countdown-text {';
            $css .= $label_style;
            $css .= '}';
        }

        return $css;
    }

    public static function getTemplate() {
        $output = '
            <#
            let contentClass = (!_.isEmpty(data.class) && data.class) ? " " + data.class : "";
            let title = (!_.isEmpty(data.title) && data.title) ? data.title : "";
            let subtitle = (!_.isEmpty(data.subtitle) && data.subtitle) ? data.subtitle : "";
            let heading_selector = (!_.isEmpty(data.heading_selector) && data.heading_selector) ? data.heading_selector : "h3";
            #>

            <div class="sppb-addon event-countdown sppb-addon-countdown {{contentClass}}">
            <div id="countdown-timer" class="sppb-countdown-timer sppb-row" data-date="{{ data.date }}" data-time="{{ data.time }}" data-finish-text="{{ data.finish_text }}"></div>
            <div class="countdown-text-wrap">
            <# if(title) { #>
                <{{heading_selector}} class="sppb-addon-title countdown-timer-title">{{{title}}}</{{heading_selector}}>
            <# } #>
            <h3 class="countdown-timer-subtitle">{{{subtitle}}}</h3>
            </div>
            </div>
        ';
        return $output;
    }

}
