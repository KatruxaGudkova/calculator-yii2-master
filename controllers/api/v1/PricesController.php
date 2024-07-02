<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\BadRequestHttpException;

class PricesController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        return [
            'class' => \app\components\filters\TokenAuthMiddleware::class,
            'verbFilter' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                ],
            ],
        ];
    }

    // public function actionIndex(): array
    // {
    //     $request = Yii::$app->request;
 
    //     $type = $request->get('type');   
        

    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    //     return \Yii::$app->params['prices'][$type];
    // }


    public function actionIndex(): array
    {
        $request = Yii::$app->request;
        $type = $request->get('type');
        
        if ($type === null) {
            throw new BadRequestHttpException('Parameter "type" is required.');
        }

        $prices = Yii::$app->params['prices'] ?? [];
        
        if (!isset($prices[$type])) {
            throw new BadRequestHttpException('Invalid type specified.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $prices[$type];
    }
}