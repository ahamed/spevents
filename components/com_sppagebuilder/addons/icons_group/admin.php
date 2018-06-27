<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('resticted aceess');

SpAddonsConfig::addonConfig(
        array(
            'type' => 'repeatable',
            'addon_name' => 'sp_icons_group',
            'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICONS_GROUP'),
            'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_ICONS_GROUP_DESC'),
            'category' => 'Media',
            'attr' => array(
                'general' => array(
                    'admin_label' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
                        'std' => ''
                    ),
                    //Styling
                    'size' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_FONT_SIZE'),
                        'std' => array('md' => 34),
                        'max' => 400,
                        'responsive' => true
                    ),
                    'margin' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_BUTTON_GROUP_GUTTER'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_BUTTON_GROUP_GUTTER_DESC'),
                        'responsive' => true,
                        'max' => 100,
                        'std' => array('md' => 5),
                    ),
                    'icon_alignment' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICON_ALIGNMENT'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_ICON_ALIGNMENT_DESC'),
                        'values' => array(
                            'sppb-text-left' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                            'sppb-text-center' => JText::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
                            'sppb-text-right' => JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                        ),
                        'std' => 'sppb-text-center',
                    ),
                    'class' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
                        'std' => ''
                    ),
                    // End styling
                    'sp_icons_group_item' => array(
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICONS_GROUP_ITEM'),
                        'attr' => array(
                            'title' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
                                'std' => ''
                            ),
                            'icon_name' => array(
                                'type' => 'icon',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_ICON_NAME'),
                                'std' => 'fa-cogs'
                            ),
                            'icon_link' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
                                'placeholder' => 'http://www.facebook.com/joomshaper',
                                'std' => '#',
                            ),
                            'width' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
                                'std' => array('md' => 80),
                                'max' => 500,
                                'responsive' => true
                            ),
                            'height' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
                                'std' => array('md' => 80),
                                'max' => 500,
                                'responsive' => true
                            ),
                            'border_width' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                'placeholder' => '3',
                                'responsive' => true
                            ),
                            'border_style' => array(
                                'type' => 'select',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_STYLE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_STYLE_DESC'),
                                'values' => array(
                                    'solid' => JText::_('COM_SPPAGEBUILDER_GLOBAL_SOLID'),
                                    'dotted' => JText::_('COM_SPPAGEBUILDER_GLOBAL_DOTTED'),
                                    'dashed' => JText::_('COM_SPPAGEBUILDER_GLOBAL_DASHED'),
                                    'double' => JText::_('COM_SPPAGEBUILDER_GLOBAL_DOUBLE'),
                                    'none' => JText::_('COM_SPPAGEBUILDER_GLOBAL_NONE'),
                                ),
                                'std' => 'solid',
                                'depends' => array(array('border_width', '!==', 0))
                            ),
                            'border_radius' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                'placeholder' => '5',
                                'max' => 500,
                                'responsive' => true,
                                'depends' => array(array('border_width', '!==', 0))
                            ),
                            'color' => array(
                                'type' => 'color',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                            ),
                            'background' => array(
                                'type' => 'color',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR'),
                            ),
                            'border_color' => array(
                                'type' => 'color',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR')
                            ),
                            'padding' => array(
                                'type' => 'padding',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
                                'placeholder' => '10px',
                                'responsive' => true,
                                'std' => '20px 20px 20px 20px',
                            ),
                            'show_label' => array(
                                'type' => 'checkbox',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICON_SHOW_LABEL'),
                                'std' => 0,
                            ),
                            'label_position' => array(
                                'type' => 'select',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICON_LABEL_POSITION'),
                                'values' => array(
                                    'top' => JText::_('COM_SPPAGEBUILDER_GLOBAL_TOP'),
                                    'right' => JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                                    'bottom' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BOTTOM'),
                                ),
                                'depends' => array(
                                    array('show_label', '=', 1)
                                ),
                                'std' => 'top',
                            ),
                            'label_text' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICON_LABEL_TEXT'),
                                'depends' => array(
                                    array('show_label', '=', 1)
                                ),
                                'placeholder' => 'Facebook',
                            ),
                            'label_size' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LABEL_FONT_SIZE'),
                                'max' => 400,
                                'depends' => array(
                                    array('show_label', '=', 1)
                                ),
                                'std' => array('md' => 16),
                                'responsive' => true
                            ),
                            'label_margin' => array(
                                'type' => 'margin',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICONS_GROUP_MARGIN'),
                                'placeholder' => '10',
                                'responsive' => true,
                                'depends' => array(
                                    array('show_label', '=', 1)
                                ),
                            ),
                            'separator' => array(
                                'type' => 'separator',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_MOUSE_HOVER_OPTIONS')
                            ),
                            'use_hover' => array(
                                'type' => 'checkbox',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ICON_USE_HOVER'),
                                'std' => 0,
                            ),
                            'hover_background' => array(
                                'type' => 'color',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_COLOR_HOVER'),
                                'depends' => array(
                                    array('use_hover', '=', 1)
                                )
                            ),
                            'hover_color' => array(
                                'type' => 'color',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_COLOR_HOVER'),
                                'depends' => array(
                                    array('use_hover', '=', 1)
                                )
                            ),
                            'hover_border_color' => array(
                                'type' => 'color',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_COLOR_HOVER'),
                                'depends' => array(
                                    array('use_hover', '=', 1)
                                )
                            ),
                            'hover_border_width' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_WIDTH'),
                                'responsive' => true,
                                'depends' => array(
                                    array('use_hover', '=', 1)
                                )
                            ),
                            'hover_border_radius' => array(
                                'type' => 'slider',
                                'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
                                'max' => 500,
                                'responsive' => true,
                                'depends' => array(
                                    array('use_hover', '=', 1)
                                )
                            ),
                            'icon_class' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
                                'placeholder' => 'custom class',
                                'std' => '',
                            ),
                        )
                    ),
                ),
            )
        )
);
