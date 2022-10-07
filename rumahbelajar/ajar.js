function showhide()
{
    var div = document.getElementById("tampil");
	if (div.style.display !== "none") 
	{
    	div.style.display = "none";
	}
	else 
	{
    	div.style.display = "block";
	}
}