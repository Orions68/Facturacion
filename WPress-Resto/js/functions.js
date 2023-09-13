function meal()
{
	window.open("mod_meal");
}

function drink()
{
	window.open("mod_drink");
}

function dessert()
{
	window.open("mod_dessert");
}

function add_meal()
{
	window.open("adding?name=Platos");
}

function add_drink()
{
	window.open("adding?name=Bebidas");
}

function add_dessert()
{
	window.open("adding?name=Postres");
}


function mesas()
{
	window.open("mesas");
}

function add()
{
	window.open("add");
}

var invoices = "";
var kitchen = "";
var array = [];
var array2 = [];
function add_plate()
{
	if (document.getElementById("meal").value !== "")
	{
		invoices += document.getElementById("meal").value + "," + document.getElementById("qtty").value + ",";
		kitchen += document.getElementById("meal").value + " Cantidad : " + document.getElementById("qtty").value + ", ";
		document.getElementById("plate").innerHTML = invoices;
		document.getElementById("platos").innerHTML = kitchen;
		document.getElementById("qtty").value = 1;
		document.getElementById("invoice").value = invoices;
	}
}

function add_bebida()
{
	if (document.getElementById("bev").value !== "")
	{
		invoices += document.getElementById("bev").value + "," + document.getElementById("qtty2").value + ",";
		document.getElementById("plate").innerHTML = invoices;
		document.getElementById("qtty2").value = 1;
		document.getElementById("invoice").value = invoices;
	}
}

function add_postre()
{
	if (document.getElementById("dess").value !== "")
	{
		invoices += document.getElementById("dess").value + "," + document.getElementById("qtty3").value + ",";
		document.getElementById("plate").innerHTML = invoices;
		document.getElementById("qtty3").value = 1;
		document.getElementById("invoice").value = invoices;
	}
}

function addData(invoice)
{
	var invoice2 = 0;
	var array = invoice.split(';');
	if (array[0] == "drink")
	{
		invoice += array[1] + ",";
		document.getElementById("plate").innerHTML = invoice;
		document.getElementById("invoice").value = invoice;
	}
	else
	{
		invoice += array[1] + ",";
		var array2 = array[1].split(',');
		for (i = 0; i < array2.length; i+=3)
		{
			invoice2 += array2[i] + " Cantidad : " + array2[i + 2] + " ";
		}
		document.getElementById("platos").innerHTML = invoice2;
		document.getElementById("plate").innerHTML = invoice;
		document.getElementById("invoice").value = invoice;
	}
}

function modify()
{
	window.open("modify");
}

function mesa(number)
{
	window.open("mesa?table=" + number);
}

function printIt(form)
{
	form.submit();
	var prtContent = document.getElementById("printable");
	var WinPrint = window.open('', '', '');
	WinPrint.document.write('<html><head><title>Print Invoice</title>');
	WinPrint.document.write('<link rel="stylesheet" type="text/css" href="styles/invoice.css" />');
	WinPrint.document.write('</head><body>');
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.write('</body></html>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
}

function arqueo()
{
	window.open("arqueo");
}

function addUser()
{
	window.open("adduser");
}

function invoice()
{
	window.open("viewer");
}

function invoicesearch()
{
	window.open("search");
}

function todas()
{
	window.open("show");
}

function deleting(number)
{
	window.open("delete?table=" + number, "_self");
}

function verify(form)
{
	if (form.pass.value != form.pass2.value)
	{
    	alert(`Las contraseñas no coinciden, por favor escríbelas nuevamente. ${form.pass.value} ${form.pass2.value}`);
    }
    else
    {
    	form.submit();
    }
}

function colseWindow()
{
	window.close();
}