<table class="table table-striped" id="kladr-recent-queries">
    <caption>Последние запросы:</caption>
    <tr>
        <th>Кол-во запросов</th>
        <th>Последний запрос</th>
        <th>Адрес, найденный по этому запросу</th>
    </tr>
    <?php foreach ($recentQueries as $recentQuery) : ?>
        <tr>
            <td><?= $recentQuery->queryCount ?></td>
            <td><?= $recentQuery->time ?></td>
            <td>
                <a href="<?= \yii\helpers\Url::toRoute(['details', 'id' => $recentQuery->id]) ?>"><?= $recentQuery->fulltext ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<table class="table table-striped" id="kladr-results">
    <caption>Результат поиска:</caption>
    <tr>
        <th>ID</th>
        <th>ZIP</th>
        <th>Полный адрес, наиболее соответствующий этому запросу</th>
    </tr>
    <?php if ($bestResult && $addressValid) : ?>
        <tr>
            <td><?= $bestResult['id'] ?></td>
            <td><?= $bestResult['zip'] ?></td>
            <td><?= $bestResult['fullName'] ?></td>
        </tr>
    <?php elseif (!$bestResult && $addressValid) : ?>
        <tr>
            <td colspan="3">Ничего не найдено...</td>
        </tr>
    <?php else : ?>
        <tr>
            <td colspan="3" style="color: red;">В запросе допускается использование только букв, цифр, а также точки и запятой...</td>
        </tr>
    <?php endif; ?>
</table>