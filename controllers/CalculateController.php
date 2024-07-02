<?php

namespace app\commands;

use app\components\calculator\queue\ResultRenderer;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use app\models\CalculationRepository;

class CalculateController extends Controller
{
    public $month;

    public $tonnage;

    public $type;

    public function options($actionID): array
    {
        return ['month', 'tonnage', 'type'];
    }

    public function actionIndex(): void
    {
        if (empty($this->month) === true) {
            $this->stdout("Необходимо указать месяц\n", Console::FG_RED);
            exit(ExitCode::UNSPECIFIED_ERROR);
        }

        if (empty($this->tonnage) === true) {
            $this->stdout("Необходимо указать тоннаж\n", Console::FG_RED);
            exit(ExitCode::UNSPECIFIED_ERROR);
        }

        if (empty($this->type) === true) {
            $this->stdout("Необходимо указать тип сырья\n", Console::FG_RED);
            exit(ExitCode::UNSPECIFIED_ERROR);
        }

        $this->month = mb_strtolower($this->month);
        $this->type = mb_strtolower($this->type);

        $state = [
            'request' => [
                'month' => $this->month,
                'tonnage' => $this->tonnage,
                'type' => $this->type,
            ],
        ];

        $repository = new CalculationRepository(
            \Yii::$app->params['lists'],
            \Yii::$app->params['prices'],
        );

        $isPriceExists = $repository->isPriceExists(
            $this->month,
            (int) $this->tonnage,
            $this->type,
        );

        if ($isPriceExists === true) {

            $state['result']['price'] = $repository->getPrice(
                $this->month,
                (int) $this->tonnage,
                $this->type,
            );

            $state['result']['price_list'] = $repository->getPriceListByRawType($this->type);
        }

        if ($isPriceExists === false) {
            $state['error'] = 'Стоимость для указанных параметров отсутствует';
        }

        (new ResultRenderer($this))->render($state);
    }
}