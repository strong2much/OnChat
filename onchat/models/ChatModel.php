<?
/**
 * This is the model class for table "{{chat}}".
 *
 * The followings are the available columns in table '{{chat}}':
 * @property integer $id
 * @property string $username
 * @property string $datetime
 * @property string $text
 */
class ChatModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{chat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'length', 'max'=>100),
			array('username', 'length', 'max'=>128),
			array('datetime', 'numerical', 'integerOnly'=>true),
			//XSS attack protection
			array('text', 'filter', 'filter'=>array($obj=new CHtmlPurifier(),'purify')),
			array('text', 'filter', 'filter'=>array('CHtml','encode')),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => $this->t('Text'),
			'datetime' => $this->t('Date'),
			'username' => $this->t('User Name'),
		);
	}
	
    public function lastLimit($count)
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'order'=>'datetime DESC',
	        'limit'=>$count,
	    ));
	    return $this;
	}
	
	protected function beforeSave()
    {
         if(parent::beforeSave())
         {
            if($this->isNewRecord)
            {
                $this->datetime = time();
            }

            return true;
         }

        return false;
    }
	
    protected function t($message, $params=array ( ))
    {
        return Yii::t('onchat.widget', $message, $params);
    }
	
}