<? if($statistic_show == 'all' || $statistic_show == 'shows'):?>
    <div id="stat_shows" style="height:300px;width:1000px; "></div>
    <div>Shows: <?= $stat['shows_sum'];?></div>
<? endif ?>
<? if($statistic_show == 'all' || $statistic_show == 'clicks'):?>
    <div id="stat_clicks" style="height:300px;width:1000px; "></div>
    <div>Clicks: <?= $stat['clicks_sum'];?></div>
<? endif ?>
<script>
    var shows = [<?= $stat['shows'] ? $stat['shows'] : false ?>];
    var clicks = [<?= $stat['clicks'] ? $stat['clicks'] : false ?>];
</script>
<script src="/js/statistic/print.js"></script>