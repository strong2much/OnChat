<div class="chat-btn"></div>

<div class="chat-contener">
	
	<div class="chat-list">
		
		<?php
		if(count($items)>0) 
		{
			foreach ($items as $item) 
			{
				$this->render('_item', array('item'=>$item));
			}
		}
		?>
		
	</div>
	
	<div class="chat-form">
		
		<?php 		
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'chat-form',
			'action'=>$this->url,
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'focus'=>array($model, 'text'),
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true,
			),
		));
		?>
		
		<table width="100%" height="100%">
			<tr>
				<td>
					<?php echo $form->textArea($model,'text'); ?>
				</td>
				<td align="center">
					<?php echo CHtml::submitButton('Send', array('class'=>'submit-btn')); ?>
				</td>
			</tr>
		</table>
		<?php echo $form->error($model,'text'); ?>
		
		<?php $this->endWidget(); ?>
		
	</div>
	
</div>

<div class="chat-clear"></div>