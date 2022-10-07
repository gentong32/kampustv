function clear_1() {
    var x = document.getElementById("keterangan");
      x.innerHTML = "";
}

function clear_2() {
  var x = document.getElementById("email_result");
    x.innerHTML = "";
}

function cekdaftar(idx) {
  
  if (idx==1)
  {
    document.getElementById("l_register").style.display = "block";
    document.getElementById("tbdaftar").style.display = "none";
    document.getElementById("l_login").style.display = "none";
    document.getElementById("tblogin").style.display = "block";
  }
  else if (idx==2)
  {
    document.getElementById("l_register").style.display = "none";
    document.getElementById("tbdaftar").style.display = "block";
    document.getElementById("l_login").style.display = "block";
    document.getElementById("tblogin").style.display = "none";
  }
  else if (idx==0)
  {
    window.open('/','_self');
  }
}

function kelogin()
{
  window.open('/login','_self');
}

function kedepan()
{
  window.open('/','_self');
}