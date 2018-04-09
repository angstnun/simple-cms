function clickColor($hex, $top, $left)
{
    if (($top+200)>-1 && $left>-1) 
    {
        document.getElementById("selectedhexagon").style.top = $top + "px";
        document.getElementById("selectedhexagon").style.left= $left + "px";
        document.getElementById("selectedhexagon").style.visibility = "visible";
        $div_preview = document.getElementById("divpreview");
        $div_preview.style.backgroundColor = $hex;
        $div_preview.innerHTML = $hex;
        $div_preview.style.visibility = 'visible';
        document.getElementById('color-hex').value = $hex;
  	}
}

function displayColor($hex)
{
    $div_preview = document.getElementById("divpreview");
    $div_preview.style.backgroundColor = $hex;
    $div_preview.innerHTML = $hex;
    $div_preview.style.visibility = 'visible';
    document.getElementById('color-hex').value = $hex;
}

function mouseOverColor($color)
{

}

function mouseOutMap()
{

}