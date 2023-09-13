function printIt(number) // Función que imprime la imagen en panatalla, recibe el numero de factura a imprimir.
{
    if (number != -1) // Si el numero que llega es distinto de -1.
    {
        var img = document.getElementById("img" + number); // Asigno a la variable img la ID del elemento img + numero de factura.
    }
    else // Si llega -1.
    {
        var img = document.getElementById("img0"); // Estoy viedo la última factura, es la imagen 0, Asigno a la variable img la ID del elemento img0.
    }
    const src = img.src; // Asigno a la constante src la imagen.
    const win = window.open(''); // Asigno a la constante win una nueva ventana abierta.
    win.document.write('<img src="' + src + '" onload="window.print(); window.close();">'); // Escribo en la ventana abierta un elemento img con la imagen a imprimir y la envía a la impresora y al terminar cierra la ventana.
}

function capture(number) // Crea una imagen de la factura del cliente, para descargarla y enviarla por E-mail, Whatsapp, etc.
{
    const print = document.getElementById("printable" + number);
    const image = document.getElementById("image" + number); // Div con ID printable0, contiene la factura.

    html2canvas(print).then((canvas) => {
        const base64image = canvas.toDataURL('image/png'); // genera la imagen base64image a partir del contenido de print, el div que contiene la factura.
        image.setAttribute("href", base64image);
        const img = document.createElement("img");
        img.id = "img" + number;
        img.src = base64image;
        img.alt = "Factura: " + number;
        print.remove();
        image.appendChild(img);
    })
}

function pdfDown(number)
{
    const image = document.getElementById("img" + number); // Div con ID printable0, contiene la factura.

    var doc = new jsPDF();
    doc.addImage(image, 'png', 10, 10, 240, 120, '', 'FAST');
    doc.save();
}

function screen() // Establece el tamaño de las vistas en la pantalla.
{
    let view1 = document.getElementById("view1"); // Recoge las ID de todas las vistas.
    let view2 = document.getElementById("view2");
    let view3 = document.getElementById("view3");
    let view4 = document.getElementById("view4");
    let viewheight = window.innerHeight; // Obtiene el tamaño vertical de la pantalla.

    views(view1, view1.offsetHeight, viewheight);

    if (view2 != null) // Si existe el div view2
    {
        views(view2, view2.offsetHeight, viewheight);
        if (view3 != null)
        {
            views(view3, view3.offsetHeight, viewheight);
            if (view4 != null)
            {
                views(view4, view4.offsetHeight, viewheight);
            }   
        }
    }
}

function views(view, heights, viewheight)
{
    if (heights < viewheight)
    {
        view.style.height = viewheight + "px";
    }
}

function resolution() // Esta función comprueba si el ancho de la pantalla es de Ordenador o de Móvil.
{
    let mobile = document.getElementById("mobile");
    let pc = document.getElementById("pc");
    let width = innerWidth;
    if (width < 965) // Si el ancho es inferior a 965.
    {
        pc.style.visibility = "hidden"; // Oculta el menú de Ordenador
        mobile.style.visibility = "visible"; // Muestra el menú de Teléfono.
    }
    else // Si es mayor o igual a 965;
    {
        pc.style.visibility = "visible"; // Muestra el menú para Ordenador
        mobile.style.visibility = "hidden"; // Oculta el menú para Teléfono.
    }
}

function toast(warn, ttl, msg) // Función para mostrar el Dialogo con los mensajes de alerta, recibe, Código, Título y Mensaje.
{
    var alerta = document.getElementById("alerta"); // La ID del botón del dialogo.
    var title = document.getElementById("title"); // Asigno a la variable title el h4 con id title.
    var message = document.getElementById("message"); // Asigno a la variable message el h5 con id message;
    if (warn == 1) // Si el código es 1, es una alerta.
    {
        title.style.backgroundColor = "#000000"; // Pongo los atributos, color de fondo negro.
        title.style.color = "yellow"; // Y color del texto amarillo.
    }
    else if (warn == 0) // Si no, si el código es 0 es un mensaje satisfactorio.
    {
        title.style.backgroundColor = "#FFFFFF"; // Pongo los atributos, color de fondo blanco.
        title.style.color = "blue"; // Y el color del texto azul.
    }
    else // Si no, viene un 2, es una alerta de error.
    {
        title.style.backgroundColor = "#000000"; // Pongo los atributos, color de fondo negro.
        title.style.color = "red"; // Y color del texto rojo.
    }
    title.innerHTML = ttl; // Muestro el Título del dialogo.
    message.innerHTML = msg; // Muestro los mensajes en el diálogo.
    alerta.click(); // Lo hago aparecer pulsando el botón con ID alerta.
}

function goThere()
{
    var change = document.getElementById("change").value; // Change obtiene el valor en el selector.
    switch(change)
    {
        case "view1":
            window.open("index.php#view1", "_self");
            break;
        case "view2":
            window.open("index.php#view2", "_self");
            break;
        case "view3":
            window.open("index.php#view3", "_self");
            break;
        default :
            window.open("index.php#view4", "_self");
    }
}

function totNumPages() // Función para la paginación
{
    return Math.ceil(window.length / window.qtty); // Calcula la cantidad de páginas que habrá, divide la cantidad de eventos por 5 resultados a mostrar por página.
}

function prev() // Función para ir a la página anterior.
{
    if (window.page > 1) // Si la página actual es mayor que la página 1.
    {
        window.page--; // Decrementa la variable page, página anterior.
        change(window.page, window.qtty, window.from); // Llama a la función change pasandole el número de página a mostrar y la cantidad de eventos a mostrar, siempre es 5.
    }
}

function next() // La Función next muestra la página siguiente.
{
    if (window.page < totNumPages()) // Si la página que estoy mostrando aun es menor que la cantidad total de páginas
    {
        window.page++; // Incrementa la variable page, página siguiente.
        change(window.page, window.qtty, window.from); // Llama a la función change pasandole el número de página a mostrar y la cantidad de eventos a mostrar, siempre es 5.
    }
}

function change(page, qtty) // Función que muestra los resultados de a 5 en una tabla, recibe la pagina page, la cantidad de resultados a mostrar qtty y de donde viene la solicitud from.
{
    window.page = page; // Asigno la variable page, a la variable global window.page.
    window.qtty = qtty; // Asigno la variable qtty, a la variable global window.qtty.
    var btn_next = document.getElementById("next"); // Asigno a la variable btn_next la id del botón con id next, que muestra los resultados siguientes.
    var btn_prev = document.getElementById("prev"); // Asigno a la variable btn_prev la id del botón con id prev, que muestra los resultados anteriores.
    var table = document.getElementById("table"); // Asigno a la variable table la id del div con id table, que muestra los resultados en la tabla en event.php, perfil de Espectador o perfil de empresa.
    var page_span = document.getElementById("page"); // Asigno a la variable page_span la id del span page, que muestra el número de página.
    
    var length = patient.length; // La variable length será del tamaño del array kind.
    var html = "<table><tr><th>Paciente</th><th>Teléfono</th><th>E-mail</th><th>Modificar Datos</th></tr><tr>";
    window.length = length; // Hago global la variable length.
    for (var i = (page - 1) * qtty; i < (page * qtty); i++) // Hago un bucle desde 0 la primera vez, hasta 5 la primera vez, ya que qtty siempre es 5 y page es 1.
    {
        if (i < length) // Mientras i sea menor que la cantidad de eventos.
        {
            html += "<td>" + patient[i] + "</td><td>" + phone[i] + "</td><td>" + email[i] + "</td><td><button class='btn btn-danger btn-sm' onclick='window.open(\"modify.php?id=" + id[i] + "\", \"_self\")'>Modificar/Borrar</button></td></tr><tr>";
        }
        else // Sí i supera a la cantidad de eventos, ya que estoy mostrando los resultados de 5 en 5 y si hay 8 eventos en la segunda página solo muestro 3.
        {
            break; // Hago un break, para romper el bucle.
        }
    }
    html += "</tr></table>"; // Cierro la tabla en la variable $html, en la que concatené todos los resultados de la base de datos.
    table.innerHTML = html; // La muestro en el div con id table.
    if (length > 13) // Si la cantidad de eventos es mayor que 5.
    {
        page_span.innerHTML = "Página: " + page; // Muestro el número de página.
        if (page == 1) // Si la página es la número 1
        {
            btn_prev.style.visibility = "hidden"; // Escondo el Botón con id prev que mostraría los resultados anteriores.
        }
        else // Si no, estoy en otra página.
        {
            btn_prev.style.visibility = "visible"; // Hago visible el botón para mostrar los resultados anteriores.
        }
        if (page == totNumPages()) // Si estoy en la última página.
        {
            btn_next.style.visibility = "hidden"; // Escondo el botón para mostrar los resultados siguientes.
        }
        else // Si no, estoy en una página intermedia o en la primera.
        {
            btn_next.style.visibility = "visible"; // Hago visible el botón para mostrar los resultados siguientes.
        }
    }
    else // Si hay menos de 5 resultados.
    {
        btn_prev.style.visibility = "hidden"; // Escondo los dos botones.
        btn_next.style.visibility = "hidden";
    }
}