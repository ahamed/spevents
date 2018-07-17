<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_search
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$searchword = $input->get('searchword', '', 'STRING');
$searchtype = $input->get('type', '', 'STRING');

?>

<div id="mod_spmoviedb_search<?php echo $module->id; ?>" class="mod-spmoviedb-search moviedb_search <?php echo $params->get('moduleclass_sfx') ?>">
	<div class="input-group moviedb-search-wrap">
		<form id="moviedb-search">
			<div class="search-panel">
				<div class="select-menu">
					<select name="searchtype" id="searchtype" class="selectpicker">
						<option value="movies" <?php echo ($searchtype == 'movies') ? 'selected="selected"': '';?>>
							<?php echo JText::_('MOD_SPMOVIEDBSEARCH_MOVIES'); ?>
						</option>
						<option value="celebrities" <?php echo ($searchtype == 'celebrities') ? 'selected="selected"': '';?>>
							<?php echo JText::_('MOD_SPMOVIEDBSEARCH_CELEBRITIES'); ?>
						</option>
						<option value="trailers" <?php echo ($searchtype == 'trailers') ? 'selected="selected"': '';?>>
							<?php echo JText::_('MOD_SPMOVIEDBSEARCH_TRAILERS'); ?>
						</option>
						<option value="genres" <?php echo ($searchtype == 'genres') ? 'selected="selected"': '';?>>
							<?php echo JText::_('MOD_SPMOVIEDBSEARCH_GENRES'); ?>
						</option>
					</select>
				</div>
			</div>
			<div class="input-box">
				<input type="hidden" id="rooturl" name="rooturl" value="<?php echo JUri::root(); ?>"> 
				<input type="hidden" id="mid" name="rooturl" value="<?php echo SpmoviedbHelper::getItemid('movies'); ?>"> 
				<input type="hidden" id="cid" name="rooturl" value="<?php echo SpmoviedbHelper::getItemid('celebrities'); ?>"> 
				<input type="hidden" id="tid" name="rooturl" value="<?php echo SpmoviedbHelper::getItemid('trailers'); ?>"> 
				<input type="text" id="searchword" name="searchword" class="spmoviedb-search-input form-control" value="<?php echo $searchword; ?>" placeholder="<?php echo JText::_('MOD_SPMOVIEDBSEARCH_PLACEHOLDER'); ?>" autocomplete="off">
			</div>
			<span class="search-icon">
				<button type="submit" class="spmoviedb-search-submit">
					<span class="spmoviedb-search-icons"> 
						<i class="spmoviedb-icon-search"></i>
					</span>
				</button>
			</span>
		</form>	
		<div class="spmoviedb-search-results"></div>
	</div>
</div>