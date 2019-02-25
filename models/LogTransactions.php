<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_transactions".
 *
 * @property int $id
 * @property string $data
 * @property int $from_user_id
 * @property int $to_user_id
 * @property string $sum
 * @property int $transferred
 * @property int $rollback
 *
 * @property User $fromUser
 * @property User $toUser
 */
class LogTransactions extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'log_transactions';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['data', 'from_user_id', 'to_user_id', 'sum'], 'required'],
            [['data'], 'safe'],
            [['from_user_id', 'to_user_id', 'transferred', 'rollback'], 'integer'],
            [['sum'], 'number'],
            [['from_user_id'], 'exist', 'skipOnError'     => true, 'targetClass' => User::className(),
                                        'targetAttribute' => ['from_user_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError'     => true, 'targetClass' => User::className(),
                                      'targetAttribute' => ['to_user_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id'           => 'ID',
            'data'         => 'Data',
            'from_user_id' => 'From User ID',
            'to_user_id'   => 'To User ID',
            'sum'          => 'Sum',
            'transferred'  => 'Transferred',
            'rollback'     => 'Rollback',
        ];
    }
    
    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function getAllTransations() {
        $sql = "SELECT username, to_user_id, log_transactions.sum, log_transactions.transferred, data FROM user LEFT JOIN log_transactions ON user.id = log_transactions.from_user_id";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }
    
    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function getNotTransfer() {
        $sql = "SELECT * from log_transactions WHERE transferred = 0 and data <= now()";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }
    
    /**
     * @param $userToId
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function getToUser($userToId) {
        return Yii::$app->db->createCommand('SELECT sum FROM user WHERE id=:id')
            ->bindParam(':id', $userToId)->queryOne();
    }
    
    /**
     * @param $userFromId
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function getFromUser($userFromId) {
        return Yii::$app->db->createCommand('SELECT sum FROM user WHERE id=:id')
            ->bindParam(':id', $userFromId)->queryOne();
    }
    
    /**
     * @param $idTransact
     * @throws \yii\db\Exception
     */
    public function setTransfered($idTransact) {
        Yii::$app->db->createCommand('UPDATE log_transactions SET transferred = true WHERE id=:id')
            ->bindParam(':id', $idTransact)->execute();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getFromUser() {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }*/
    
    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getToUser() {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }*/
}
