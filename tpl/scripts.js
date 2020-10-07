
function my_getbyid(id)
{
	itm = null;

	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}

	return itm;
}

function toggle_div_hide(id)
{
	if ( ! id ) return;
	
	if ( itm = my_getbyid(id) )
	{
		if (itm.style.display == "none")
		{
			my_show_div(itm);
		}
		else
		{
			my_hide_div(itm);
		}
	}
}

//==========================================
// Set DIV ID to hide
//==========================================

function my_hide_div(itm)
{
	if ( ! itm ) return;	
	itm.style.display = "none";
}

//==========================================
// Set DIV ID to show
//==========================================

function my_show_div(itm)
{
	if ( ! itm ) return;	
	itm.style.display = "";
}

//==========================================
// Insert BB tags to input
//==========================================
