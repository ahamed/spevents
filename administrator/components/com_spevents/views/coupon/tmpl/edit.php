<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen','select',null,array('disable_search_threshold' => 0));
JHtml::_('jquery.framework', false);
?>

<script type="text/javascript">
    var generateRandom = function(length)
    {
        var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var charactersLength = characters.length;
        var randomString = '';
        for (var i = 0; i < length; i++) {
            randomString += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return randomString;
    };
    jQuery(function ($) {
        $('#generator').click(function(e){
            e.preventDefault();
            e.stopPropagation();
            var code = generateRandom(8);
           console.log(code);
           $('#jform_coupon').val(code);
        });
    });
</script>

<form action="<?php echo JRoute::_('index.php?option=com_spevents&view=coupon&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post" class="form-validate">

	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span8">
				<?php echo $this->form->renderFieldset('basic'); ?>
			</div>
			<div class="span4">
				<?php echo $this->form->renderFieldset('options'); ?>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="coupon.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
