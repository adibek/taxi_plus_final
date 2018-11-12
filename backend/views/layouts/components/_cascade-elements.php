<?
    $cascade = $data['data'];
    $first = (new \yii\db\Query())
        ->select("*")
        ->from($data[0])
        ->all();

    function CacadeRecursion() {

    }
?>


<ul class="list list-icons no-margin-bottom">
    <li>
        <? foreach ($first as $value) { ?>
            <a href = "#"><i class="icon-arrow-right32"></i> <?=$value['name']?></a>
            <i data-type="global" data-table="calcitem" data-title="Добавить" title="Добавить" data-rodid="1" data-rodfield="rod_select_calc" style="font-size:1em; margin-right:5px;" class="action-button text-success-600 ml-10 cursor-pointer icon-plus2"></i>
            <i data-begin="Calc" data-type="global" data-table="Calc" data-id="1" data-title="Редактировать" title="Редактировать" data-rodid="1" data-rodfield="rod_select_calc" style="font-size:0.8em;" class="action-button cursor-pointer icon-pencil"></i>
            <ul data-step="0" class="list" style="display: block;">
                <li>
                    <a href = ""><i class="icon-arrow-right32"></i> asd</a>
                    <ul data-step="0" class="list" style="display: block;">

                    </ul>
                </li>
            </ul>
        <? } ?>
    </li>
</ul>