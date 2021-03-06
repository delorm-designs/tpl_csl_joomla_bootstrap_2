<?php
defined('_JEXEC') or die;
JHtml::stylesheet('com_sermonspeaker/sermonspeaker.css', '', true);
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
$user		= JFactory::getUser();
$fu_enable	= $this->params->get('fu_enable');
$canEdit	= ($fu_enable and $user->authorise('core.edit', 'com_sermonspeaker'));
$canEditOwn	= ($fu_enable and $user->authorise('core.edit.own', 'com_sermonspeaker'));
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$limit 		= (int)$this->params->get('limit', '');
$player		= SermonspeakerHelperSermonspeaker::getPlayer($this->items);
$version	= new JVersion;
$j30		= ($version->isCompatible(3.0)) ? '30' : '';
?>
<div class="category-list<?php echo $this->pageclass_sfx;?> ss-sermons-container<?php echo $this->pageclass_sfx; ?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif;
if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
	<h2>
		<?php echo $this->escape($this->params->get('page_subheading'));
		if ($this->params->get('show_category_title')) : ?>
			<span class="subheading-category"><?php echo $this->category->title;?></span>
		<?php endif; ?>
	</h2>
<?php endif;
if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		<?php endif;
		if ($this->params->get('show_description') && $this->category->description) :
			echo JHtml::_('content.prepare', $this->category->description);
		endif; ?>
		<div class="clearfix"></div>
	</div>
<?php endif;
if (in_array('sermons:player', $this->columns) and count($this->items)) : ?>
	<div class="ss-sermons-player">
		<hr class="ss-sermons-player" />
		<?php if ($player->player != 'PixelOut'): ?>
			<div id="playing">
				<img id="playing-pic" class="picture" src="" alt="" />
				<span id="playing-duration" class="duration"></span>
				<div class="text">
					<span id="playing-title" class="title"></span>
					<span id="playing-desc" class="desc"></span>
				</div>
				<span id="playing-error" class="error"></span>
			</div>
		<?php endif;
		echo $player->mspace;
		echo $player->script;
		?>
		<hr class="ss-sermons-player" />
	<?php if ($player->toggle): ?>
		<div>
			<img class="pointer btn" src="media/com_sermonspeaker/images/Video.png" onclick="Video()" alt="Video" title="<?php echo JText::_('COM_SERMONSPEAKER_SWITCH_VIDEO'); ?>" />
			<img class="pointer btn" src="media/com_sermonspeaker/images/Sound.png" onclick="Audio()" alt="Audio" title="<?php echo JText::_('COM_SERMONSPEAKER_SWITCH_AUDIO'); ?>" />
		</div>
	<?php endif; ?>
	</div>
<?php endif; ?>
<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" id="adminForm" name="adminForm" class="form-inline">
	<?php if ($this->params->get('filter_field') or $this->params->get('show_pagination_limit')) :
		echo $this->loadTemplate('filters'.$j30);
	endif;
	if (!count($this->items)) : ?>
		<div class="no_entries"><?php echo JText::sprintf('COM_SERMONSPEAKER_NO_ENTRIES', JText::_('COM_SERMONSPEAKER_SERMONS')); ?></div>
	<?php else : ?>
		<table class="category table table-striped table-hover table-condensed">
		<!-- Create the headers with sorting links -->
			<thead><tr>
				<?php if (in_array('sermons:num', $this->columns)) : ?>
					<th class="num">
						<?php if (!$limit) :
							echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_SERMONNUMBER', 'sermon_number', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_SERMONNUMBER');
						endif; ?>
					</th>
				<?php endif; ?>
				<th class="ss-title">
					<?php if (!$limit) :
						echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'sermon_title', $listDirn, $listOrder);
					else :
						echo JText::_('JGLOBAL_TITLE');
					endif; ?>
				</th>
				<?php if (in_array('sermons:scripture', $this->columns)) : ?>
					<th class="ss-col ss-scripture">
						<?php if (!$limit) :
							echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_FIELD_SCRIPTURE_LABEL', 'book', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_FIELD_SCRIPTURE_LABEL');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:speaker', $this->columns)) : ?>
					<th class="ss-col ss-speaker">
						<?php if (!$limit) :
							echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_SPEAKER', 'name', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_SPEAKER');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:date', $this->columns)) : ?>
					<th class="ss-col ss-date">
						<?php if (!$limit) :
							echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_FIELD_DATE_LABEL', 'sermon_date', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_FIELD_DATE_LABEL');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:length', $this->columns)) : ?>
					<th class="ss-col ss-length">
						<?php if (!$limit) :
							 echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_FIELD_LENGTH_LABEL', 'sermon_time', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_FIELD_LENGTH_LABEL');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:series', $this->columns)) : ?>
					<th class="ss-col ss-series">
						<?php if (!$limit) :
							 echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_SERIES', 'series_title', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_SERIES');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:addfile', $this->columns)) : ?>
					<th class="ss-col ss-addfile">
						<?php if (!$limit) :
							echo JHtml::_('grid.sort', 'COM_SERMONSPEAKER_ADDFILE', 'addfileDesc', $listDirn, $listOrder);
						else :
							echo JText::_('COM_SERMONSPEAKER_ADDFILE');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:hits', $this->columns)) : ?>
					<th class="ss-col ss-hits">
						<?php if (!$limit) :
							echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'hits', $listDirn, $listOrder);
						else :
							echo JText::_('JGLOBAL_HITS');
						endif; ?>
					</th>
				<?php endif;
				if (in_array('sermons:download', $this->columns)) : 
					$prio	= $this->params->get('fileprio'); ?>
					<th class="ss-col ss-dl">Download</th>
				<?php endif; ?>
			</tr></thead>
		<!-- Begin Data -->
			<tbody>
				<?php foreach($this->items as $i => $item) : ?>
					<tr id="sermon<?php echo $i; ?>" class="<?php echo ($i % 2) ? "odd" : "even"; ?>">
						<?php if (in_array('sermons:num', $this->columns)) : ?>
							<td class="num">
								<?php echo $item->sermon_number; ?>
							</td>
						<?php endif; ?>
						<td class="ss-title">
							<?php echo SermonspeakerHelperSermonspeaker::insertSermonTitle($i, $item, $player);
							if ($canEdit or ($canEditOwn and ($user->id == $item->created_by))) : ?>
								<ul class="actions">
									<li class="edit-icon">
										<?php echo JHtml::_('icon.edit', $item, $this->params, array('type' => 'sermon')); ?>
									</li>
								</ul>
							<?php endif; ?>
						</td>
						<?php if (in_array('sermons:scripture', $this->columns)) : ?>
							<td class="ss-col ss-scripture">
								<?php $scriptures = SermonspeakerHelperSermonspeaker::insertScriptures($item->scripture, '<br />');
								echo JHtml::_('content.prepare', $scriptures); ?>
							</td>
						<?php endif;
						if (in_array('sermons:speaker', $this->columns)) : ?>
							<td class="ss-col ss-speaker">
								<?php if ($item->speaker_state):
									echo SermonspeakerHelperSermonSpeaker::SpeakerTooltip($item->speaker_slug, $item->pic, $item->name);
								else :
									echo $item->name;
								endif; ?>
							</td>
						<?php endif;
						if (in_array('sermons:date', $this->columns)) : ?>
							<td class="ss-col ss-date">
								<?php if ($item->sermon_date != '0000-00-00 00:00:00'):
									echo JHtml::date($item->sermon_date, JText::_($this->params->get('date_format')), true);
								endif; ?>
							</td>
						<?php endif;
						if (in_array('sermons:length', $this->columns)) : ?>
							<td class="ss-col ss-length">
								<?php echo SermonspeakerHelperSermonspeaker::insertTime($item->sermon_time); ?>
							</td>
						<?php endif;
						if (in_array('sermons:series', $this->columns)) : ?>
							<td class="ss-col ss-series">
								<?php if ($item->series_state): ?>
									<a href="<?php echo JRoute::_(SermonspeakerHelperRoute::getSerieRoute($item->series_slug)); ?>">
										<?php echo $item->series_title; ?>
									</a>
								<?php else:
									echo $item->series_title;
								endif; ?>
							</td>
						<?php endif;
						if (in_array('sermons:addfile', $this->columns)) : ?>
							<td class="ss-col ss-addfile">
								<?php echo SermonspeakerHelperSermonspeaker::insertAddfile($item->addfile, $item->addfileDesc); ?>
							</td>
						<?php endif;
						if (in_array('sermons:hits', $this->columns)) : ?>
							<td class="ss-col ss-hits">
								<?php echo $item->hits; ?>
							</td>
						<?php endif;
						if (in_array('sermons:download', $this->columns)) : 
							$type = ($item->videofile && ($prio || !$item->audiofile)) ? 'video' : 'audio';
							$filesize = $type.'filesize'; ?>
							<td class="ss-col ss-dl">
								<?php echo SermonspeakerHelperSermonspeaker::insertdlbutton($item->slug, $type, 1, $item->$filesize); ?>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif;
	if ($this->params->get('show_pagination') && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->get('show_pagination_results', 1)) : ?>
				<p class="counter">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif;
			echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php endif; ?>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
</form>
<?php if (!empty($this->children[$this->category->id]) and $this->maxLevel != 0) : ?>
	<div class="cat-children">
		<h3>
			<?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
		</h3>
		<?php echo $this->loadTemplate('children'); ?>
	</div>
<?php endif; ?>
</div>