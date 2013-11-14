//myScript.js
//Clock:
function startTime()
{
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    // add a zero in front of numbers<10
    m=checkTime(m);
    s=checkTime(s);
    document.getElementById('txt').innerHTML=h+":"+m+":"+s;
    t=setTimeout(function(){startTime()},500);
}

function checkTime(i)
{
    if (i<10)
      {
      i="0" + i;
      }
    return i;
}

//password check
function checkPass()
{
    //De wachtwoorden in variabelen zetten
    var pass1 = document.getElementById("pass1");
    var pass2 = document.getElementById("pass2");
    var button = document.getElementById("button");
    //Bevestegingsbericht
    var message = document.getElementById("confirmMessage");
    //De kleuren definieren
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Wachtwoorden vergelijken 
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Correct!" 
        button.disabled=false
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Wachtwoord verschild!"
     }
}
//body resize
function resize()
{
    var windowWidth = $(window).width();
    $('body').css('width', windowWidth);
}




