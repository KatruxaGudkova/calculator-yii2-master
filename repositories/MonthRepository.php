<?php

namespace app\repositories;


use yii\db\Query;
use yii\helpers\ArrayHelper;

class MonthRepository 
{
    public function getMonthNames(): array
    {
        $month = (new Query())
        ->select('name')
        ->from('months')
        ->all();


        return ArrayHelper::getColumn($month,'name');
    }

    public function create(string $name): void
    {
       (new Query())->createCommand()->insert('months', [
        'name'=>$name
       ])->execute();
    }
}

