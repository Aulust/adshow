<? if($statisticShow == 'all' || $statisticShow == 'shows'):?>
    <div id="statShows" class="statistics"></div>
    <div>Shows: <?= $stat['showsSum'];?></div>
<? endif ?>
<? if($statisticShow == 'all' || $statisticShow == 'clicks'):?>
    <div id="statClicks" class="statistics"></div>
    <div>Clicks: <?= $stat['clicksSum'];?></div>
<? endif ?>
<script>
    var shows = <?= $stat['shows'] ? json_encode($stat['shows'], JSON_NUMERIC_CHECK) : 'null' ?>;
    var clicks = <?= $stat['clicks'] ? json_encode($stat['clicks'], JSON_NUMERIC_CHECK) : 'null' ?>;
    printStatistics(shows, clicks);
</script>
