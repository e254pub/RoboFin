<?php

/* @var $this yii\web\View
 * @var $loginCheck bool
 * @var $userName string
 * @var $sumCurrent
 */

$this->title = '';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
<link href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css"
      rel="stylesheet"/>

<div class="site-index">
    <?php if ($loginCheck == true): ?>
        <h4>Здравствуйте, <?= $userName ?></h4>
        <h5>На вашем счету:</h5>
        <div class="row">
            <div class="col-md-2"><?= $sumCurrent ?></div>
            <div class="col-md-1"><?= "Рублей" ?></div>
        </div>
        <h3>Отложенный перевод</h3>
        <?php $form = yii\widgets\ActiveForm::begin(['action' => ['site/data'], 'options' => ['method' => 'post']]) ?>
        <table>
            <tr>
                <td>
                    <input placeholder="Кому перевести (usernameId)" name="nameId" class="form-control"/>
                    <br>
                    <input placeholder="Сумма перевода" name="sum" class="form-control"/>
                </td>
                <td style="vertical-align: top;">
                    <div class='input-group date' id='datetimepicker1' style="width: 300px;">
                        <input type='text' name="data" class="form-control"/>
                        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
           </span>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <p><input type="submit"/></p>
        <?php $form = yii\widgets\ActiveForm::end() ?>
        <?php if ($message): ?>
            <h2 style="color: red"><?= $message ?></h2>
        <?php else: ?>
        <?php endif; ?>
        <hr/>
        <div class="row">
            <?php if (!empty($logTransations)): ?>
                <h3>Показать на сайте список всех пользователей и информацию об их одном последнем переводе с помощью
                    одного SQL-запроса к БД. </h3>
                <?php foreach ($logTransations as $item): ?>
                    <div class="col-xs-8">
                        <div class="row">
                            <div class="col-md-4">Кто перевел (username): <?= (empty($item['username'])) ? 'Пусто'
                                    : $item['username'] ?></div>
                            <div class="col-md-4">Кому перевел (to_user_id): <?= (empty($item['to_user_id'])) ? 'Пусто'
                                    : $item['to_user_id'] ?></div>
                            <div class="col-md-4">Сумма (sum): <?= (empty($item['sum']))
                                    ? 'Пусто'
                                    : $item['sum']
                                      . ' рублей' ?>
                            </div>
                            <div class="col-md-4">Дата (data): <?= (empty($item['data'])) ? 'Пусто'
                                    : $item['data'] ?></div>
                            <div class="col-md-4">Переведено? (transferred): <?= (empty($item['transferred'])) ? 'Нит'
                                    : $item['transferred'] ?></div>
                        </div>
                    </div>
                    <br> <br> <br>
                <?php endforeach; ?>
            <?php else: ?>
                <h4>Транзанкций нет</h4>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <h4>Здравствуйте, чтобы продолжить работу, пожалуйста авторизуйтесь</h4>
    <?php endif; ?>
</div>

<script>
    $('#datetimepicker1').datetimepicker({
        locale: 'ru'
    });
</script>

<style>
    table {
        width: 50%;
    }

    h4 {
        margin-top: 10px
    }

    h4 span {
        font-size: 13px;
        color: grey;
    }

    [class^="col-"] {
        background-color: #eee;
        border: 1px solid #ddd;
        overflow: hidden;
    }

    [class^="form-control"] {
        width: 250px;
    }
</style>