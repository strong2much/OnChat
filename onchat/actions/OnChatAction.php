<?php
Yii::import('ext.onchat.models.ChatModel');

/**
 * OnChatAction
 * =============
 * Basic chat functionality for an action used by the OnChat extension.
 *
 * @version 0.1
 * @author Denis Tatarnikov
 */
class OnChatAction extends CAction 
{
	/**
     * @var string name of the item view to be rendered
     */
    private $_itemView = 'ext.onchat.views._item';
	
    /**
     * The main action that handles the chat request.
	 * 
     * @since 0.1
     */
    public function run( ) 
    {
        if(Yii::app()->request->isAjaxRequest)
		{
			if(Yii::app()->request->isPostRequest && isset($_POST['ChatModel']))
			{
				$model = new ChatModel;
				$model->text = $_POST['ChatModel']['text'];
				$model->username = Yii::app()->user->isGuest ? 'Guest' : Yii::app()->user->getName();
				
				if($model->validate())
				{
					$model->save(false);
					
					$data["status"] = "success";
					$data["message"] = $this->getItemsByLastId($_POST['last'],$_POST['items']);
				}
				else 
				{
					$data["status"] = "error";
				}
				
				echo CJSON::encode($data);
			}
			
			if(isset($_GET['_method']) && $_GET['_method']=='update')
			{
				$data["status"] = "success";
				$data["message"] = $this->getItemsByLastId($_GET['last'],$_GET['items']);
				
				echo CJSON::encode($data);
			}
		}
		else
		{
			throw new CHttpException(400, Yii::t('zii', 'Invalid request. Please do not repeat this request again.'));
		}
    }
	
	/**
	 * Finds records in ChatModel starting from the given id
	 * @param integer last ID of the model to start from
	 * @param integer limit count. Default to 15
	 * @param boolean return data as a string. Default to true
	 */
	protected function getItemsByLastId($id, $count = 15, $isText = true)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('id>'.$id);
		
		$items = ChatModel::model()->lastLimit($count)->findAll($criteria);
		
		if($isText) {
			$text = "";
			if(count($items)>0) 
			{
				foreach ($items as $item) 
				{
					$text .= $this->controller->renderPartial($this->_itemView, array('item'=>$item), true);
				}
			}
			
			return $text;
		}
		else {
			return $items;
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ChatModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('zii','The requested page does not exist.'));
		return $model;
	}
	
}
