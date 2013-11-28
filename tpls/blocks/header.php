<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$sitename = $this->params->get('sitename') ? $this->params->get('sitename') : JFactory::getConfig()->get('sitename');
$slogan = $this->params->get('slogan');
$logotype = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', '') : '';
if ($logoimage) {
  $logoimage = JURI::base(true).'/'.$logoimage;
}
?>

<!-- HEADER -->
<header id="t3-header" class="container t3-header">
  <div class="row">

    <!-- LOGO -->
    <div class="span4 logo">
      <div class="logo-<?php echo $logotype ?>">
        <a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>"><img src="<?php echo $logoimage ?>" />
          <span><?php echo $sitename ?></span>
        </a>
        <small class="site-slogan hidden-phone"><?php echo $slogan ?></small>
      </div>
    </div>
    <!-- //LOGO -->

    <div class="span5" data-default="span5" data-tablet="span8">
      <?php if ($this->countModules('header-1')) : ?>
        <div class="header-1<?php $this->_c('header-1')?>">
          <jdoc:include type="modules" name="<?php $this->_p('header-1') ?>" style="raw" />
        </div>
      <?php endif ?>
    </div>

    <div class="span3 hidden-phone">
      <?php if ($this->countModules('header-2')) : ?>
        <div class="header-2<?php $this->_c('header-2')?>">
          <jdoc:include type="modules" name="<?php $this->_p('header-2') ?>" style="raw" />
        </div>
      <?php endif ?>
    </div>

  </div>
</header>
<!-- //HEADER -->
