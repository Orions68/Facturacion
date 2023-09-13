function moreFields(num)
{
    let show = document.getElementById("container");
    let html = "<br><br>";

    for (i = 0; i < num; i++)
    {
        html += "<label><input type='text' name='input" + i + "'> Material</label>&nbsp;&nbsp;&nbsp;<label><input type='text' name='input" + i + "'> Introduce el Precio</label><br><br>";
    }
    show.innerHTML = html;
}

function screen() // Establece el tamaño de las vistas en la pantalla.
{
    let view1 = document.getElementById("view1"); // Recoge las ID de todas las vistas.
    let view2 = document.getElementById("view2");
    let view3 = document.getElementById("view3");
    let view4 = document.getElementById("view4");
    let view5 = document.getElementById("view5");
    let viewheight = window.innerHeight; // Obtiene el tamaño vertical de la pantalla.

    views(view1, viewheight);

    if (view2 != null) // Si existe el div view2
    {
        views(view2, viewheight);
        if (view3 != null)
        {
            views(view3, viewheight);
            if (view4 != null)
            {
                views(view4, viewheight);
                if (view5 != null)
                {
                    views(view5, viewheight);
                }
            }   
        }
    }
}

function views(view, viewheight)
{
    height = view.offsetHeight
    if (height < viewheight)
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