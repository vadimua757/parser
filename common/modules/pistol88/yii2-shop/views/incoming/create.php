<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use pistol88\shop\models\Product;
use pistol88\shop\models\PriceType;

$this->title = 'Новое поступление';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\shop\assets\CreateIncomingAsset::register($this);
\pistol88\shop\assets\BackendAsset::register($this);

$priceTypes = [];

foreach(PriceType::find()->all() as $priceType) {
    $priceTypes[] = ['id' => $priceType->id, 'name' => $priceType->name];
}

$this->registerJs(
    "
    pistol88.createincoming.shopPriceTypesArray = ".json_encode($priceTypes)."
    
    $('.incoming-delete').on('click', function() {
        
    });
    
    $('.incoming select[name=incomingproduct]').on('change', function() {
        $('.new-input').val($(this).val()).change();
    });"
);
?>
<div class="incoming-create">
    <div class="row">
        <div class="col-md-2">
            
        </div>
        <div class="col-md-10">
            <div class="shop-menu">
                <?=$this->render('../parts/menu');?>
            </div>
        </div>
    </div>
    
    <?php if(Yii::$app->session->hasFlash('success')) { ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php } ?>
    

    
    <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-6">
                    <div class="incoming">
                        <?= Select2::widget([
                            'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
                            'name' => 'incomingproduct',
                            'language' => 'ru',
                            'options' => ['placeholder' => 'Выберите товар ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-lg-6"><input class="new-input" data-info-service="<?=Url::toRoute(['/shop/product/product-info']);?>" type="text" value="" placeholder="Код или артикул + Enter" style="width: 300px;" /></div>
            </div>
        </div>
        <div id="incoming-list" style="width: 800px; padding: 20px;">
        </div>
        
        
        <div class="form-group">
            <textarea name="content" class="form-control" placeholder="Комментарий"></textarea>
        </div>
        
        <div class="form-group">
            <?= Html::submitButton('Добавить поступление', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>