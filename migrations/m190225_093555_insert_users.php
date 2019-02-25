<?php

use yii\db\Migration;

/**
 * Class m190225_093555_insert_users
 */
class m190225_093555_insert_users extends Migration {
    /**
     * @return bool|void
     */
    public function safeUp() {
        $this->insert(
            'user',
            [
                'id'                   => 1,
                'username'             => 'admin',
                'auth_key'             => 'gVxFEg86ZiKZbg_BGW7zWUjxIpGrISsD',
                'password_hash'        => '$2y$13$Jc7Z3dA44wLsGAZRHpd0U.GtoLpIbbvY3k223ZBK/YCv.sl3iON4G',
                'email'                => 'admin@admin.ru',
                'status'               => '10',
                'created_at'           => '1551085821',
                'updated_at'           => '1551085821',
                'sum'                  => '9000',
            ]
        );
        
        $this->insert(
            'user',
            [
                'id'                   => 2,
                'username'             => 'Ivanov',
                'auth_key'             => '2Rdgr1sXXyblALvVJhYOgpKDMLmwQ5Xn',
                'password_hash'        => '$2y$13$S0k9M2NAluqBe./jDNwPsenp5dOt/Zb08STEwrTqeEjWNYIEL2z5a',
                'email'                => 'Ivanov@admin.ru',
                'status'               => '10',
                'created_at'           => '1551086156',
                'updated_at'           => '1551086156',
                'sum'                  => '50000',
            ]
        );
        
        $this->insert(
            'user',
            [
                'id'                   => 3,
                'username'             => 'Sidorov',
                'auth_key'             => 'I7zZzunz1sIid5Imx_5mv',
                'password_hash'        => '$2y$13$Amevh4N0yOnP0uCqfpp0uum.pE8IYiKSkPhvqYy5s8ekUTY/7qZqa',
                'email'                => 'sidorov@admin.ru',
                'status'               => '10',
                'created_at'           => '1551086170',
                'updated_at'           => '1551086170',
                'sum'                  => '1000',
            ]
        );
        
        $this->insert(
            'user',
            [
                'id'                   => 4,
                'username'             => 'user',
                'auth_key'             => 'N0OJsSKFPIJ-AC8kGLY1TTf5742Yah4y',
                'password_hash'        => '$2y$13$zJXD1bb5kgzP8o6LjOwWdOtBegBKGbCwL0FO.3mgX/S/PPPfdbGoe',
                'email'                => 'user@admin.ru',
                'status'               => '10',
                'created_at'           => '1551086175',
                'updated_at'           => '1551086175',
                'sum'                  => '100',
            ]
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m190225_093555_insert_users cannot be reverted.\n";
        
        return false;
    }
}
