<?php
Yii::import('ext.onchat.models.ChatModel');
/**
 * OnChat extension for Yii.
 *
 * @author Denis Tatarnikov <strong2much@gmail.com>
 * @version 0.1
 *
 */
class OnChat extends CWidget 
{
	/**
	 * Default CSS class for the list container
	 */
	const CSS_CLASS='onChat';
	
	/**
	 * @var string url.
	 */
	public $url;
	
	/**
	 * @var integer numberOfRecords.
	 */
	public $numberOfRecords = 15;
	
	/**
	 * @var string updateTime time to request server asking for new messages in ms.
	 * Default to 5000 (means 5 sec).
	 */
	public $updateTime = 5000;
	
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile;
	
	/**
	 * @var array additional HTML options to be rendered in the container tag.
	 */
	public $htmlOptions = array();
	
	/**
	 * @var array additional Javascript options to be put in widget.
	 */
	public $options = array();
	
	/**
     * @var string name of the chat view to be rendered
     */
    private $_chatView = 'chat';
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$htmlOptions=$this->htmlOptions;
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=$this->getId();
		if(!isset($htmlOptions['class']))
			$htmlOptions['class']=self::CSS_CLASS;
		
		$this->registerClientScript($htmlOptions['id']);
		
		$model = new ChatModel;
		$items = ChatModel::model()->lastLimit($this->numberOfRecords)->findAll();
		
		echo CHtml::openTag('div', $htmlOptions)."\n";
		$this->render($this->_chatView, array('model'=>$model,'items'=>$items));
		echo CHtml::closeTag('div');
	}

	/**
	 * Registers the needed CSS and JavaScript.
	 * @param $id string <br>element id
	 */
	protected function registerClientScript($id)
	{
		$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
		$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
		
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl . '/jquery.onchat.'.(!YII_DEBUG ? 'min.' : '').'js');
		
		$this->options['url'] = $this->url;
		$this->options['updateTime'] = $this->updateTime;
		$this->options['numberOfRecords'] = $this->numberOfRecords;
		$jsOptions = CJavaScript::encode($this->options);
		$cs->registerScript(__CLASS__ . '#' . $id, "jQuery(\"#{$id}\").onChat($jsOptions);", CClientScript::POS_LOAD);
		
		if($this->cssFile!==false) {
			if($this->cssFile===null)
				$this->cssFile=$baseUrl.'/onchat.css';
			$cs->registerCssFile($this->cssFile, 'screen');
		}
	}
	
    protected function t($message, $params=array ( ))
    {
        return Yii::t('onchat.widget', $message, $params);
    }

}
