<?php

defined ('_JEXEC') or die('resticted aceess');

class SppagebuilderAddonEventum_speakers extends SppagebuilderAddons{
    public function render(){
			$speaker_type = (isset($this->addon->settings->speaker_type) && $this->addon->settings->speaker_type) ? $this->addon->settings->speaker_type : '';
			$count 				= (isset($this->addon->settings->count) && $this->addon->settings->count) ? $this->addon->settings->count : '';
			$column 			= (isset($this->addon->settings->column) && $this->addon->settings->column) ? $this->addon->settings->column : '';
			$class 				= (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';

			$speakers = $this->getSpeakers($speaker_type, $count);
			$result		= $this->getMenuid();
			$Itemid = '';
			if(count($result)) {
				$Itemid = '&Itemid=' . $result;
			}


			// Output
			$output  = '<div class="sp-event-speakers ' . $class . '">';

			if(count($speakers)) {
				$output .= '<div class="row">';

				foreach ($speakers as $key=>$speaker) {
					$output .= '<div class="col-sm-' . round(12/$column) . '">';

					$output .= '<div class="sp-speaker">';
					$output .= '<div class="speaker-image">';

					// Social Icons
					$socials = array();

					if(isset($speaker->social_twitter) && $speaker->social_twitter) {
						$socials[] = array('twitter', 'https://twitter.com/' . $speaker->social_twitter);
					}

					if(isset($speaker->social_facebook) && $speaker->social_facebook) {
						$socials[] = array('facebook', 'https://www.facebook.com/' . $speaker->social_facebook);
					}

					if(isset($speaker->social_googleplus) && $speaker->social_googleplus) {
						$socials[] = array('google-plus', 'https://plus.google.com/' . $speaker->social_googleplus);
					}

					if(isset($speaker->social_pinterest) && $speaker->social_pinterest) {
						$socials[] = array('pinterest', 'https://www.pinterest.com/' . $speaker->social_pinterest);
					}

					if(isset($speaker->social_linkedin) && $speaker->social_linkedin) {
						$socials[] = array('linkedin', $speaker->social_linkedin);
					}

					if(isset($speaker->social_dribbble) && $speaker->social_dribbble) {
						$socials[] = array('dribbble', 'https://dribbble.com/' . $speaker->social_dribbble);
					}

					if(isset($speaker->social_behance) && $speaker->social_behance) {
						$socials[] = array('behance', 'https://www.behance.net/' . $speaker->social_behance);
					}

					if(isset($speaker->social_flickr) && $speaker->social_flickr) {
						$socials[] = array('flickr', 'https://www.flickr.com/people/' . $speaker->social_flickr);
					}

					if(isset($speaker->social_youtube) && $speaker->social_youtube) {
						$socials[] = array('youtube', 'https://www.youtube.com/user/' . $speaker->social_youtube);
					}

					if(isset($speaker->social_vimeo) && $speaker->social_vimeo) {
						$socials[] = array('vimeo', 'https://vimeo.com/' . $speaker->social_vimeo);
					}

					if(isset($speaker->social_github) && $speaker->social_github) {
						$socials[] = array('github', 'https://github.com/' . $speaker->social_github);
					}

					if(isset($speaker->social_skype) && $speaker->social_skype) {
						$socials[] = array('skype', 'skype:' . $speaker->social_skype . '?chat');
					}

					// Limit social icons
					if(count($socials)>4) {
						$socials = array_slice($socials, 0, 4);
					}

					$output .= '<div class="speaker-image-wrapper">';
					$output .= '<img src="' . $speaker->image . '" alt="' . $speaker->title . '">';
					if(count($socials)) {
						$output .= '<div class="social-icons">';
						$output .= '<ul class="social-links-' . count($socials) . '">';
						foreach ($socials as $key => $social) {
							$output .= '<li class="social-' . ($key+1) . '">';
							$output .= '<a target="_blank" class="social-' . $social[0] . '" href="' . $social[1] . '"><i class="fa fa-' . $social[0] . '"></i></a>';
							$output .= '</li>';
						}
						$output .= '</ul>';
						$output .= '</div>';
					}
					$output .= '</div>';

					$output .= '</div>'; //.speaker-image

					$output .= '<h4 class="speaker-title"><a href="' . JRoute::_('index.php?option=com_speventum&view=speaker&id=' . $speaker->speventum_speaker_id . ':' . $speaker->slug . $Itemid ) . '">' . $speaker->title . '</a></h4>';
					$output .= '<p class="speaker-designation">' . $speaker->designation . '</p>';

					$output .= '</div>'; //.sp-speaker

					$output .= '</div>';
				}

				$output .= '</div>';
			}

			$output .= '</div>';

			return $output;

		}

		private function getSpeakers($speaker_type, $count = 8){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( array('a.*') );
		    $query->from($db->quoteName('#__speventum_speakers', 'a'));
		    if($speaker_type==2) {
			    $query->where($db->quoteName('a.keynote')." = ".$db->quote('1'));
		    } else if($speaker_type==2) {
			    $query->where($db->quoteName('a.keynote')." != ".$db->quote('1'));
		    }

		    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));

		    //Language
				$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
			    //Access
				$query->where($db->quoteName('a.access')." IN (" . implode( ',', JFactory::getUser()->getAuthorisedViewLevels() ) . ")");
		    $query->order($db->quoteName('a.ordering') . ' ASC');
		    $query->setLimit($count);
		    $db->setQuery($query);
				$speakers = $db->loadObjectList();

				return $speakers;
		}

		private function getMenuid(){
			// ItemId
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('id')));
			$query->from($db->quoteName('#__menu'));
			$query->where($db->quoteName('link') . ' LIKE '. $db->quote('%option=com_speventum&view=speakers%'));
			$query->where($db->quoteName('published') . ' = '. $db->quote('1'));
			$db->setQuery($query);
			$result = $db->loadResult();

			return $result;
		}
}
