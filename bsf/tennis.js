var code_to_club = {
    "AST" : "Astley & Tyldesley",
    "BAR" : "Barrow Bridge",
    "BRA" : "Bradshaw",
    "CHO" : "Chorley",
    "CLA" : "Claremont",
    "DAR" : "Darwen",
    "DLB" : "DL Bolton Arbitare",
    "DLC" : "DL Chorley",
    "EAG" : "Eagley",
    "ELL" : "Ellesmere",
    "ELT" : "Elton Vale",
    "HOL" : "Holcombe Brook",
    "HAW" : "Hawkshaw",
    "LEI" : "Leigh",
    "LOS" : "Lostock",
    "MAR" : "Markland Hill",
    "MEA" : "Meadow Hill",
    "MON" : "Monton",
    "ROE" : "Roe Green",
    "TYL" : "Tyldesley",
    "WAL" : "Walmer",
    "WIN" : "Winton"
};

var div_spec = [["CHO A", "DLC A", "ELL A", "HOL A", "LEI A", "LOS A", "MAR A", "TYL A"],
                ["DAR A", "DLB A", "DLB B", "DLC B", "ELL B", "ELT A", "HAW A", "WAL A"],
                ["BAR A", "EAG A", "HOL B", "LEI B", "LOS B", "MAR B", "ROE A", "WIN"  ],
                ["BRA A", "CHO B", "CLA A", "DLB C", "DLB D", "EAG B", "HAW B", "WAL B"],
                ["AST",   "BRA B", "ELT B", "HAW C", "LOS C", "MAR C", "MEA A", "MON"  ],
                ["BAR B", "BRA C", "CHO C", "EAG C", "ELL C", "HAW D", "HOL C", "TYL B"],
                ["EAG D", "HAW E", "HOL D", "LOS D", "MAR D", "MEA B", "ROE B"]];

function update_teams() {

    var i;

    var n = document.getElementById("Division").value;
    
    if (1 <= n && n <= div_spec.length) {

        var selHome = document.getElementById("HT");
        for (i = selHome.options.length - 1; i >= 0; i--)
            selHome.remove(i);

        var selAway = document.getElementById("AT");
        for (i = selAway.options.length - 1; i >= 0; i--)
            selAway.remove(i);

        var opt1 = document.createElement('option');
        opt1.value = 0;
        opt1.text = "Select Home Team ...";
        selHome.add(opt1);
        selHome.value = 0;

        var opt2 = document.createElement('option');
        opt2.value = 0;
        opt2.text = "Select Away Team ...";
        selAway.add(opt2);
        selAway.value = 0;

        for (i = 0; i < div_spec[n-1].length; i++) {

            var code = div_spec[n-1][i];
            var team = code_to_club[code.substring(0, 3)] + code.substring(3);

            opt1 = document.createElement('option');
            opt1.value = opt1.text = team;
            selHome.add(opt1);

            opt2 = document.createElement('option');
            opt2.value = opt2.text = team;
            selAway.add(opt2);
        }
    }
}

function won_set(p1, p2) {

    var g1 = document.getElementById(p1).value;
    var g2 = document.getElementById(p2).value;

    return (g1 > g2) && (g1 == 6 || g1 == 8);
}
      
function update_scores() {

    var home = 0;
    var away = 0;
    
    for (var i = 1; i <= 9; i++) {
	home += won_set("H" + i, "A" + i);
	away += won_set("A" + i, "H" + i);	
    }

    document.getElementById("HRT").value = home; 
    document.getElementById("ART").value = away;
}
    
function check(element) {
    if(/[0-6]/.test(element.value)) {
	update_scores();
	while (element = element.nextSibling)
	    if (element instanceof HTMLInputElement) {
		element.focus();
		element.select();
		break;
	    }
    } else
	element.value = '';
}

function update_players(teamname, jsfm, start, end) {
    var suffix = teamname.slice(-2);
    if (   suffix == " A" || suffix == " B" || suffix == " C"
	|| suffix == " D" || suffix == " E" || suffix == " F")
	clubname = teamname.slice(0, -2);
    else
	clubname = teamname;
    var args = { clubname : clubname, jsfm : jsfm };
    $.post("players.php", args, null, 'json').done(
	function(data) {
	    for (var i = start; i <= end; i++)
		$("#PL" + i).autocomplete({ source : data });
	}
    );
}
