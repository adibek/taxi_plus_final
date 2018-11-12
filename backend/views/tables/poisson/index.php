
<?=$this->render("/layouts/header/_header")?>

<div class="content">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <input value="Roma" id="firts">
                    <input value="Atalanta" id="second">
                    <a onclick="getMatches()">send</a>
                    <input id="type" type="checkbox" checked data-on-color="success" data-off-color="danger" data-on-text="ITA" data-off-text="ENG" class="switch">
                    <div id="result">
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        $("#type").bootstrapSwitch();
    });

    var exponential = 2.718281828;
    var total = 0;
    var numerator, denominator;


    function getMatches() {
        var team1 = document.getElementById('firts').value;
        var team2 = document.getElementById('second').value;
        var country = '';
        if(document.getElementById("type").checked){
            country = 'it';
        }else{
            country = 'en';
        }
        $.ajax({url: "https://raw.githubusercontent.com/openfootball/football.json/master/2016-17/"+ country + ".1.json",
            type: 'GET',
            success: function(result) {
//                console.log(result);
                var firstGoals = 0;
                var secondGoals = 0;
                var firstPr = 0;
                var secondPr = 0;
                var homeGoals = 0;
                var awayGoals = 0;

                var firstAvScore = 0;
                var firstAvDefeat = 0;
                var secondAvScore = 0;
                var secondAvDefeat = 0;



                var firstAvAtack = 0;
                var firstAvDefence = 0;
                var secondAvAtack = 0;
                var secondAvDefence = 0;


                var res = JSON.parse(result);
                var roundy = res.rounds;
                for(var i = 0; i<roundy.length; i++){
                    var matches = roundy[i].matches;
                    for(var j=0; j < matches.length; j++){
                        if(matches[j].team1.name == team1){
                            firstGoals += matches[j].score1;
                            firstPr += matches[j].score2;
                        }
                        if(matches[j].team2.name == team2){
                            secondGoals += matches[j].score2;
                            secondPr += matches[j].score1;
                        }
                        homeGoals += matches[j].score1;
                        awayGoals += matches[j].score2;

                    }
                }
                firstAvScore = firstGoals / 19;
                secondAvScore = secondGoals / 19;
                firstAvDefeat = firstPr / 19;
                secondAvDefeat = secondPr / 19;

                secondAvAtack = secondAvScore / (awayGoals/380);
                firstAvDefence = firstAvDefeat / (awayGoals/380);
                secondAvDefence = secondAvDefeat / (homeGoals/380);
                firstAvAtack = firstAvScore / (homeGoals/380);

                var nyuAway = secondAvAtack * firstAvDefence * (awayGoals/380);
                var nyuHome = firstAvAtack * secondAvDefence * (homeGoals/380);

                var arrayHome = [];
                var arrayAway = [];
                console.log(nyuHome);
                console.log(nyuAway);
                for(var i = 0; i < 6; i ++){
                    arrayHome.push(poisson(i, nyuHome));
                    arrayAway.push(poisson(i, nyuAway));
                }

                var resultDiv = document.getElementById('result');
                for (var j = 0; j<6; j++){
                    var div = document.createElement('div');
                    div.classList.toggle('col-md-6');
                    var label = document.createElement('label');
                    label.classList.toggle('text-semibold');
                    label.innerHTML = team1 + ' Забьет ' + j + 'голов Вероятность:' + arrayHome[j];
                    var label1 = document.createElement('label1');
                    label1.classList.toggle('text-semibold');
                    label1.innerHTML = team2 + ' Забьет ' + j + 'голов Вероятность:' + arrayAway[j];
                    div.append(label);
                    div.append(label1);
                    resultDiv.appendChild(div);
                }

                var drawKf = 0;
                var winKf = 0;
                var loseKf = 0;

                for (var i = 0; i<6; i++){
                    drawKf += (arrayHome[i] * arrayAway[i]);
                    for(var j = 0; j<6; j++){
                        if(j > i){
                            winKf += arrayHome[j] * arrayAway[i];
                        }
                    }
                }
                var h1 = document.createElement('h1');
                h1.innerHTML = 'Вероятность ничьи: ' + drawKf + ' Вероятность победы команды ' + team1 + ': ' + winKf + ' Вероятность победы команды ' + team2 + ': ' + (1 - (winKf + drawKf));
                resultDiv.appendChild(h1);
            }
        });
    }
    function poisson(k, landa) {
        exponentialPower = Math.pow(exponential, -landa); // negative power k
        landaPowerK = Math.pow(landa, k); // Landa elevated k
        numerator = exponentialPower * landaPowerK;
        if(k == 0){
            denominator = 1;
        }else{
            denominator = factorial(k); // factorial of k.
        }


        return (numerator / denominator);
    }
    function factorial(n) {
        return (n != 1) ? n * factorial(n - 1) : 1;
    }

</script>