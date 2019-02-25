<?php

namespace app\commands;

use app\models\LogTransactions;
use app\models\User;
use yii\console\Controller;

class TransactController extends Controller {
    /**
     * @throws \yii\db\Exception
     */
    public function actionIndex() {
        $currData = strtotime(date("Y-m-d H:i:s"));
        
        $transactModel = new LogTransactions();
        $notTransfer   = $transactModel->getNotTransfer();
        $users         = new User();
        
        foreach ($notTransfer as $item) {
            $data = strtotime($item['data']);
            if (($currData >= $data) && $transactModel->transferred == 0) {
                $idFromUser = $item['from_user_id'];
                $idToUser   = $item['to_user_id'];
                
                $sumFromUser = $transactModel->getFromUser($idFromUser);
                $sum         = (int)$item['sum'];
                
                $valid = $this->consloleValidator($sumFromUser, $sum);
                if ($valid == true) {
                    $sumToUser = (int)$transactModel->getToUser($idToUser);
                    $users->updateSumTransact($idFromUser, $sumFromUser - $sum);
                    $users->updateSumTransact($idToUser, $sumToUser + $sum);
                    
                    $transactModel->setTransfered($item['id']);
                }
                
            }
        }
    }
    
    /**
     * @param $sumFromUser
     * @param $sum
     * @return bool
     */
    private function consloleValidator($sumFromUser, $sum) {
        $checkSum = $sumFromUser - $sum;
        
        if ($checkSum <= 0) {
            var_dump('Недостаточно средств');
            return false;
        }
        
        return true;
    }
}