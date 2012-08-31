<?php
$options = array(
  'button' => __('Save'),
  'isMultipart' => true,
);

if ($form->isNew())
{
  $title = __('Post a diary');
  $url = url_for('diary_create');
}
else
{
  $title = __('Edit the diary');
  $url = url_for('diary_update', $diary);
}
?>
<div class="row">
  <div class="gadget_header span12"><?php echo __($title) ?></div>
</div>

<div class="row">
  <div class="span12">
    <?php echo form_tag($sf_request->getCurrentUri()); ?>
    <?php foreach ($form as $field): ?>
    <?php if (!$field->isHidden()): ?>
      <div class="control-group<?php echo $field->hasError()? ' error' : '' ?>">
        <label class="control-label"><?php echo $field->renderLabel() ?></label>
        <div class="controls">
        <?php if ($field->hasError()): ?>
        <span class="label label-important label-block"><?php echo __($field->renderError()); ?></span>
        <?php endif ?>
        <?php echo $field->render(array('class' => 'span12')) ?>
        <span class="help-block"><?php echo $field->renderHelp(); ?></span>    
        </div>
      </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="<?php echo __('Send') ?>" class="btn btn-primary span12" />
    <?php echo $form->renderHiddenFields(); ?>
    </form>
  </div>
</div>
