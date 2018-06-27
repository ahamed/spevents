<?php

defined('_JEXEC') or die('resticted aceess');

SpAddonsConfig::addonConfig(
    array(
        'type' => 'content',
        'addon_name' => 'sp_latest_post',
        'category' => 'Eventum',
        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS'),
        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_DESC'),
        'attr' => array(
            'general' => array(
                'title' => array(
                    'type' => 'text',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
                    'std' => '',
                ),
                'heading_selector' => array(
                    'type' => 'select',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
                    'values' => array(
                        'h1' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
                        'h2' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
                        'h3' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
                        'h4' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
                        'h5' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
                        'h6' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
                    ),
                    'std' => 'h3',
                ),
                'title_fontsize' => array(
                    'type' => 'number',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
                    'std' => '',
                ),
                'title_text_color' => array(
                    'type' => 'color',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                ),
                'title_margin_top' => array(
                    'type' => 'number',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
                    'placeholder' => '10',
                ),
                'title_margin_bottom' => array(
                    'type' => 'number',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
                    'placeholder' => '10',
                ),
                'count' => array(
                    'type' => 'number',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_LIMIT'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_LIMIT_DESC'),
                    'std' => '5',
                ),
                'intro_text_limit' => array(
                    'type' => 'number',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_SF_INTROTEXT_LIMIT'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_SF_INTROTEXT_LIMIT_DESC'),
                    'std' => '100',
                ),
                'category' => array(
                    'type' => 'category',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_SELECT_CATEGORY'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_LATEST_POSTS_SELECT_CATEGORY_DESC'),
                    'std' => '',
                ),
                'ordering' => array(
                    'type' => 'select',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_ORDERING'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_ORDERING_DESC'),
                    'values' => array(
                        'latest' => JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_ORDERING_LATEST'),
                        'oldest' => JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_ORDERING_OLDEST'),
                        'hits' => JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_ORDERING_POPULAR'),
                        'featured' => JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_ORDERING_FEATURED'),
                    ),
                    'std' => 'latest',
                ),
                'post_type' => array(
                    'type' => 'select',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_DESC'),
                    'values' => array(
                        '' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_ALL'),
                        'standard' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_STANDARD'),
                        'audio' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_AUDIO'),
                        'video' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_VIDEO'),
                        'gallery' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_GALLERY'),
                        'link' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_LINK'),
                        'quote' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_QUOTE'),
                        'status' => JText::_('COM_SPPAGEBUILDER_ADDON_POST_TYPE_STATUS'),
                    ),
                    'std' => 'h3',
                ),
                'class' => array(
                    'type' => 'text',
                    'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                    'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
                    'std' => '',
                ),
            ),
        ),
        )
    );
