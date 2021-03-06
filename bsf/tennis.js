var code_to_club = {
    "AST" : "Astley & Tyldesley",
    "BAR" : "Barrow Bridge",
    "BEL" : "Bellingham",
    "BRA" : "Bradshaw",
    "CHO" : "Chorley",
    "CLA" : "Claremont",
    "DAR" : "Darwen",
    "DLB" : "David Lloyd Abitare",
    "DLC" : "David Lloyd (Chorley)",
    "EAG" : "Eagley",
    "ELL" : "Ellesmere",
    "ELT" : "Elton Vale",
    "HOL" : "Holcombe Brook",
    "HAW" : "Hawkshaw",
    "LEI" : "Leigh",
    "LOS" : "Lostock",
    "LON" : "Longsight St Catherines",
    "MAR" : "Markland Hill",
    "MEA" : "Meadow Hill",
    "MON" : "Monton",
    "ROE" : "Roe Green",
    "TYL" : "Tyldesley",
    "WAL" : "Walmer",
    "WIY" : "Winstanley",
    "WIN" : "Winton"
};

var div_mens = [["CHO A", "DLC A", "ELL A", "HOL A", "LEI A", "LOS A", "MAR A", "TYL A"],
                ["DAR A", "DLB A", "DLB B", "DLC B", "ELL B", "ELT A", "HAW A", "WAL A"],
                ["BAR A", "EAG A", "HOL B", "LEI B", "LOS B", "MAR B", "ROE A", "WIN"  ],
                ["BRA A", "CHO B", "CLA A", "DLB C", "DLB D", "EAG B", "HAW B", "WAL B"],
                ["AST",   "BRA B", "ELT B", "HAW C", "LOS C", "MAR C", "MEA A", "MON"  ],
                ["BAR B", "BRA C", "CHO C", "EAG C", "ELL C", "HAW D", "HOL C", "TYL B"],
                ["EAG D", "HAW E", "HOL D", "LOS D", "MAR D", "MEA B", "ROE B"]];

var div_mixed = [["BRA A", "DLB A", "HAW A", "HOL A", "LOS A", "MAR A", "MAR B", "WAL A"],
                 ["BRA B", "CHO",   "DLB B", "ELL",   "HAW B", "HOL B", "LOS B"],
                 ["BAR A", "DLC",   "ELT",   "HAW C", "HOL C", "LON A", "MAR C"],
                 ["DLB C", "DLB D", "LOS C", "LOS D", "MAR D", "MEA",   "WAL B"],
		 ["BAR B", "BRA C", "HAW D", "HAW E", "HOL D", "LOS E"]];

var div_junior = [["BEL", "BRA A", "HOL A", "MAR A", "MAR B", "WIY"],
                  ["BRA B", "CHO",   "DLB", "HAW A", "HOL B", "LOS A"],
                  ["HAW B", "HOL B", "LOS B", "MAR C", "TYL"]];

var div_after = [["DLB A", "DLB B","HOL","LOS A","LOS B", "WAL"]];				  
 
function update_teams(div_spec) {

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

function unplayed(p1, p2) {

    var g1 = document.getElementById(p1).value;
    var g2 = document.getElementById(p2).value;

    return (g1 == "" && g2 == "") || (g1 == 0 && g2 == 0);
}

function won_set(p1, p2) {

    var g1 = document.getElementById(p1).value;
    var g2 = document.getElementById(p2).value;

    if (g1 == "" || g2 == "")
	return 0;

    if (g1 == 6 && g2 == 6)
	return 0.5;

    return g1 >= 6 && g1 > g2;
}

function is_valid(p1, p2, type) {

    var g1 = document.getElementById(p1).value;
    var g2 = document.getElementById(p2).value;

    if (g1 == "" || g2 == "")
	return false;

    if (type == "afternoon")
	return true;
    
    if (g1 < 6 && g2 < 6)
	return false;

    if (g1 > 7 || g2 > 7)
	return false;

    tot = parseInt(g1) + parseInt(g2);

    if ((g1 == 7 || g2 == 7) && tot < 12)
	return false;
    
    if (type == "mens")
	return tot <= 10 || (tot >= 12 && g1 != g2);
    else if (type == "mixed")
	return g1 <= 6 && g2 <= 6 && tot <= 11;
    else if (type == "junior")
	return tot <= 10 || tot == 12;

    // unknown type
    return false;
}

function update_set_totals(n) {

    reset_border();
    
    var home = 0;
    var away = 0;
    
    for (var i = 1; i <= n; i++) {
	home += won_set("SCH" + i, "SCA" + i);
	away += won_set("SCA" + i, "SCH" + i);	
    }

    document.getElementById("SCH").value = home; 
    document.getElementById("SCA").value = away;
}

function games(id) {
    var str = document.getElementById(id).value;
    if (str == "") return 0; else return parseInt(str);
}

function update_game_totals(n) {

    reset_border();

    var home = 0;
    var away = 0;
    
    for (var i = 1; i <= n; i++) {
	home += games("SCH" + i);
	away += games("SCA" + i);
    }

    document.getElementById("SCH").value = home; 
    document.getElementById("SCA").value = away;
}

function set_border(i, str) {
    document.getElementById("SCH" + i).style.border = str;
    document.getElementById("SCA" + i).style.border = str;
}

var red_border = 0;

function reset_border() {
    if (red_border) 
	set_border(red_border, "none");
    red_border = 0;
}

function validate_scores(n, type) {

    reset_border();
    var all_played = true;
    
    for (var i = 1; i <= n; i++) {
	if (unplayed("SCH"+i, "SCA"+i))
	    all_played = false;
	else if (!is_valid("SCH"+i, "SCA"+i, type)) {
	    alert("There is an invalid set score");
	    document.getElementById("SCH" + i).focus();
	    document.getElementById("SCH" + i).select();
	    set_border(i, "thin solid red");
	    red_border = i;
	    return false;
	}
    }

    return all_played || confirm("Some sets were unplayed. Is this correct?\n\nPress Cancel to return. Press OK to submit.");
}

function select_input(element) {
    if (element instanceof HTMLInputElement)
	element.select();
}

function check(element) {
    var parent = element.parentNode;
    if (element instanceof HTMLInputElement) {
	if (/[0-7]/.test(element.value)) {
	    while (element = element.nextSibling)
		if (element instanceof HTMLInputElement) {
		    element.focus();
		    element.select();
		    return;
		}
	    $(parent).trigger('change');
	} else
	    element.value = '';
    }
}

function check_after(element) {
    if (element instanceof HTMLInputElement) {
	if (/^[0-9]*$/.test(element.value)) {
	    //do nothing
	} else
	    element.value = element.value.replace(/\D/g,'');
    }
}

function update_players(teamname, last_input) {

    var prefix = "#" + last_input.slice(0, -1);
    var num    = parseInt(last_input.slice(-1));
    var jsfm   = last_input.slice(3, -1);

    var suffix = teamname.slice(-2);
    if (   suffix == " A" || suffix == " B" || suffix == " C"
	|| suffix == " D" || suffix == " E" || suffix == " F")
	clubname = teamname.slice(0, -2);
    else
	clubname = teamname;
    
    var args = { clubname : clubname, jsfm : jsfm };
    $.post("players.php", args, null, 'json').done(
	function(data) {
	    for (var i = 1; i <= num; i++)
		$(prefix + i).autocomplete({ source : data });
	}
    );
}
