<?php

defined('_JEXEC') or die('resticted aceess');

require_once JPATH_ROOT . '/components/com_sppagebuilder/helpers/articles.php';

class SppagebuilderAddonLatest_post extends SppagebuilderAddons
{
    public function render()
    {
        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
        $title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
        $heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';
        $count = (isset($this->addon->settings->count) && $this->addon->settings->count) ? $this->addon->settings->count : '';
        $ordering = (isset($this->addon->settings->ordering) && $this->addon->settings->ordering) ? $this->addon->settings->ordering : '';
        $catid = (isset($this->addon->settings->category) && $this->addon->settings->category) ? $this->addon->settings->category : '';
        $post_type = (isset($this->addon->settings->post_type) && $this->addon->settings->post_type) ? $this->addon->settings->post_type : '';

        $items = SppagebuilderHelperArticles::getArticles($count, $ordering, $catid, true, $post_type);

        // Start output
        $output = '';
        $output .= '<div class="sppb-addon sppb-addon-latest-posts ' . $class . '">';
        $output .= '<div class="sppb-addon-content">';
        $output .= '<div class="latest-posts clearfix">';

        $output .= '<div class="sppb-row">';

        foreach ($items as $item) {

            $image = '';

            if (isset($item->image_thumbnail) && $item->image_thumbnail) {
                $image = $item->image_thumbnail;
            } elseif (isset($item->image_intro) && !empty($item->image_intro)) {
                $image = $item->image_intro;
            } elseif (isset($item->image_fulltext) && !empty($item->image_fulltext)) {
                $image = $item->image_fulltext;
            }

            $output .= '<div class="latest-post sppb-col-sm-4">';

            $output .= '<div class="latest-post-inner">';

            if ($image) {
                $output .= '<a href="' . $item->link . '"><img class="sppb-blog-image" src="' . $image . '" alt="' . $item->title . '"></a>';
            }

            $output .= '<span class="entry-date"> ' . JHtml::_('date', $item->created, 'DATE_FORMAT_LC3') . '</span>';
            $output .= '<' . $heading_selector . ' class="entry-title"><a href="' . $item->link . '">' . $item->title . '</a></' . $heading_selector . '>';

            $output .= '</div>';

            $output .= '</div>'; //.sppb-col-sm
        }
        $output .= '</div>'; //.sppb-row

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
