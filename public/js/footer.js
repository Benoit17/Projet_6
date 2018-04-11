// canvas visualization of Official Doctor Who's scarf from
// http://kottke.org/15/12/official-bbc-instructions-for-knitting-doctor-whos-scarf

var pattern = ["8 purple", "52 camel", "16 bronze", "10 mustard", "22 rust", "8 purple", "20 green", "8 mustard", "28 camel", "14 rust", "8 bronze", "10 purple", "42 green", "8 mustard", "16 gray", "8 rust", "54 camel", "10 purple", "12 green", "8 mustard", "18 rust", "8 purple", "38 bronze", "10 camel", "8 gray", "40 rust", "14 mustard", "20 green", "8 purple", "42 camel", "12 bronze", "20 gray", "8 rust", "12 purple", "6 camel", "14 mustard", "54 green", "16 rust", "12 gray", "8 mustard", "20 bronze", "10 purple", "12 camel", "32 grey", "10 rust", "16 mustard"];

var colors = {
    purple:"#663399",
    camel:"#c19a6b",
    bronze:"#cd7f32",
    mustard:"#ffcb0c",
    rust:"#b7410e",
    gray:"#808080",
    green:"#808000"
};

// data setup
var rows = [];
for(var i=0; i<pattern.length; i++){
    var set = pattern[i].split(' ');
    for(var s=0;s<set[0];s++){
        rows.push(set[1]);
    }
};

//size setup
var caston = 60;
var dip = 1.25;
var stsWidth = 3.75;
var stsHeight = 5.75;

//setup canvas
var canvas = document.getElementById('scarf');
var ctx = canvas.getContext('2d');
canvas.width = rows.length*(stsHeight-dip);
canvas.height = caston*stsWidth;

drawSts();

// Call knit() to draw pattern on canvas.
function drawSts(){
    for(var y = 0; y<rows.length;y++){
        for(var x=0; x<caston; x++){
            var color = colors[rows[y]];
            knit(y*(stsHeight-dip), x*stsWidth, color);
        }
    }
}

// Draw V shape on specified x:y coordinates
function knit(x, y, fill){
    ctx.beginPath();
    ctx.moveTo(x+stsHeight, y);
    ctx.lineTo(x+dip,y);
    ctx.lineTo(x,y+(stsWidth/2));
    ctx.lineTo(x+(stsHeight-dip),y+(stsWidth/2));
    ctx.lineTo(x+(stsHeight),y);
    ctx.fillStyle = fill;
    ctx.fill();

    ctx.beginPath();
    ctx.moveTo(x+stsHeight, y+stsWidth);
    ctx.lineTo(x+dip,y+stsWidth);
    ctx.lineTo(x,y+(stsWidth/2));
    ctx.lineTo(x+(stsHeight-dip),y+(stsWidth/2));
    ctx.lineTo(x+stsHeight, y+stsWidth);
    ctx.fillStyle = fill;
    ctx.fill();
}
