function printStatistics(shows, clicks){
    if(shows) {
        var shows = $.jqplot('stat_shows', [shows], {
            title:'Shows statistics',
            axes:{
                xaxis:{
                    renderer:$.jqplot.DateAxisRenderer,
                    tickOptions:{
                        formatString:'%Y-%m-%d'                
                    }
                },
                yaxis:{
                    min: 0,
                    tickOptions:{
                        formatString:'%d'
                    }
                }
            },
            highlighter: {
                show: true,
                sizeAdjust: 7.5,
                formatString: '%s<br><center><b>%s</b></center>'              
            },
            cursor: {
            show: false
            }
        });
    } 
    if(clicks) {
        var clicks = $.jqplot('stat_clicks', [clicks], {
            title:'Clicks statistics',
            axes:{
                xaxis:{
                    renderer:$.jqplot.DateAxisRenderer,
                    tickOptions:{
                        formatString:'%Y-%m-%d'
                    }
                },
                yaxis:{
                    min: 0,
                    tickOptions:{
                        formatString:'%d'
                    }
                }
            },
            highlighter: {
                show: true,
                sizeAdjust: 7.5,
                formatString: '%s<br><center><b>%s</b></center>'              
            },
            cursor: {
            show: false
            }
        });
    }
}
