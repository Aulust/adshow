<? if($statistic_show == 'all' || $statistic_show == 'shows'):?>
    <div id="stat_shows" class="statistics"></div>
    <div>Shows: <?= $stat['shows_sum'];?></div>
<? endif ?>
<? if($statistic_show == 'all' || $statistic_show == 'clicks'):?>
    <div id="stat_clicks" class="statistics"></div>
    <div>Clicks: <?= $stat['clicks_sum'];?></div>
<? endif ?>
<script>
    var shows = <?= $stat['shows'] ? json_encode($stat['shows'], JSON_NUMERIC_CHECK) : 'null' ?>;
    var clicks = <?= $stat['clicks'] ? json_encode($stat['clicks'], JSON_NUMERIC_CHECK) : 'null' ?>;
    printStatistics(shows, clicks);
</script>
