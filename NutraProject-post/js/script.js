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

function goThere() // Cuando cambia el selector del menú para Móvil.
{
    var change = document.getElementById("change").value; // Change obtiene el valor en el selector.
    switch(change)
    {
        case "contact":
            window.open("contact.php", "_blank");
        break;
        case "request":
            window.open("request.php", "_self");
        break;
        case "profile":
            window.open("profile.php", "_self");
        break;
        case "view4":
            window.open("index.php#view4", "_self");
        break;
        case "view3":
            window.open("index.php#view3", "_self");
        break;
        case "view2":
            window.open("index.php#view2", "_self");
        break;
        default :
            window.open("index.php#view1", "_self");
        break;
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

function carToast(article, price, qtty) // Timer para mostrar mensajes por 5 segundos.
{
    let btnopen = document.getElementById("addtocar");
    let btnclose = document.getElementById("close_add_dialog");
    let title = document.getElementById("titlecar");
    let message = document.getElementById("messagecar");
    title.innerHTML = "Has Agregado: ";
    message.innerHTML = qtty + " - " + article + " Precio: " + price + " Total: " + (qtty * price).toFixed(2) + " €"; // Muestro mensajes en el diálogo para agregar artículos al carro.
    btnopen.click(); // Lo hago aparecer pulsando el botón con ID addtocar.
    setTimeout(function() // La función para esperar 5 segundos.
    {
        btnclose.click(); // Después de 5 segundos se pulsa el botón para cerrar el diálogo.
    }, 5000);
}

var valor = ""; // Contiene los artículos agregados para facturar.
var valor2 = ""; // Contiene el texto que se muestra mientras se van agregando artículos para facturar.

function add_article() // Agrega un artículo a la facturación, lo usa el script clients.php, usado por el Administrador para facturar.
{
	let product = document.getElementById("product"); // ID del select product.
    if (product.value != "") // Si hay algo en el selector.
    {
        let factura = document.getElementById("factura");
        let qtty = document.getElementById("qtty"); // Obtengo en qtty la ID del selector de cantidad, qtty.
        let invoice = document.getElementById("invoice"); // Obtengo en invoice la ID del input tipo hidden de invoice, donde se concatenan los artículos agregados al carro.
        let show = document.getElementById("productList"); // Obtengo en show la ID del div donde se muestra lo que se está agregando a la factura.

        factura.style.visibility = "visible";
        var array = product.value.split(","); // En la variable array hago un split por la "," de lo que hay en el selector con ID product, están concatenados la ID, el artículo, y el precio.
        valor += product.value + "," + qtty.value + ","; // Concateno en la variable valor lo que hay en product más lo que hay en qtty separandolo por la ",".
        valor2 += array[1] + " Cantidad: " + qtty.value + ", "; // En valor2 pongo la cadena que se muestra a medida que se agregan artículos para facturar.
        show.innerHTML = valor2; // Muestra en el div con ID productList el contenido de value2.
        product.value = ""; // Limpio el contenido del selector.
        qtty.value = "1"; // Pongo a 1 la cantidad seleccionada en el selector qtty.
        invoice.value = valor; // pongo en el input de tipo hidden con ID invoice el contenido de la variable valor.
    }
}

function getStock() // Obtiene la ID del producto selecionado en el selector, la envía para obtener el stock del producto seleccionado, tengo que enviar también: username, el nombre del usuario a facturar, toda la cadena del producto seleccionado y si las variable de javascript valor y valor2 contienen datos, también las envio por el formulario, usado por el Administrador para facturar, en el script clients.php.
{
    let product = document.getElementById("product"); // ID del select de los productos.
    let form = document.createElement("form"); // Creo un formulario.
    let input = document.createElement("input"); // Asigno a la variable input la creación de un input.
    let input2 = document.createElement("input"); // Asigno a la variable input2 la creación de un input.
    let input3 = document.createElement("input"); // Asigno a la variable input3 la creación de un input.
    let input4 = document.createElement("input"); // Asigno a la variable input4 la creación de un input.
    let input5 = document.createElement("input"); // Asigno a la variable input5 la creación de un input.
    let input6 = document.createElement("input"); // Asigno a la variable input6 la creación de un input.
    let input7 = document.createElement("input"); // Asigno a la variable input7 la creación de un input.
    let input8 = document.createElement("input"); // Asigno a la variable input8 la creación de un input.

    var id = product.value.split(","); // Exploto lo que hay en el selector de producto en el array id, solo necesitaré la ID, viene: ID, Nombre, Precio.

    form.action = ""; // Donde irá el formulario, en blanco a la misma página.
    form.method = "post"; // Por el método post.

    input.type = "hidden"; // Lo hago de tipo hidden, oculto.
    input.name = "username"; // Le asigno el nombre username.
    input.value = username; // Al input hidden le asigno el valor de la variable de javascript username, declarada en el script client.php.
    form.appendChild(input); // Lo agrego al formulario.

    input2.type = "hidden"; // Lo hago de tipo hidden, oculto.
    input2.name = "id"; // Le asigno el nombre id.
    input2.value = id[0]; // Al segundo le pongo el valor de la ID del producto seleccionado.
    form.appendChild(input2);

    input3.type = "hidden";
    input3.name = "product"; // Le asigno el nombre product.
    input3.value = product.value; // Al tercero le pongo el producto seleccionado como está en el option: ID, Nombre, Precio.
    form.appendChild(input3);

    input6.type = "hidden";
    input6.name = "article";
    input6.value = article;
    form.appendChild(input6);

    input7.type = "hidden";
    input7.name = "which";
    input7.value = which;
    form.appendChild(input7);

    input8.type = "hidden";
    input8.name = "position"; // Le asigno el nombre position.
    input8.value = product.selectedIndex; // Le asigno la posición del artículo en el selector.
    form.appendChild(input8);

    if (valor != "") // Si la variable de javascript valor tiene algún valor.
    {
        input4.type = "hidden"; // Lo hago de tipo hidden, oculto.
        input4.name = "invoice"; // Le asigno el nombre invoice.
        input4.value = valor; // Al cuarto input le asigno el valor de la variable de javascript valor, es lo que se concatena en invoice.
        form.appendChild(input4);

        input5.type = "hidden";
        input5.name = "productList";
        input5.value = valor2; // Al quinto le pongo el valor de la variable valor2, es lo que se muestra en el h2 con ID productList.
        form.appendChild(input5);
    }

    document.body.appendChild(form); // Agrego el formulario al body.

    form.submit(); // Lo envío.
}

function getProduct(which) // Función getProduct(cual), recibe lo seleccionado, marca o tipo, usado por el Administrador para facturar, en el script clients.php.
{
    let election = document.getElementById(which); // Asigno a election la ID del selector que envió la selección, kind o brand.
    let form = document.createElement("form"); // Creo un formulario.
    let input = document.createElement("input"); // Asigno a la variable input la creación de un input.
    let input1 = document.createElement("input"); // Asigno a la variable input1 la creación de un input.
    let input2 = document.createElement("input"); // Asigno a la variable input2 la creación de un input.
    let input4 = document.createElement("input"); // Asigno a la variable input4 la creación de un input.
    let input5 = document.createElement("input"); // Asigno a la variable input5 la creación de un input.

    form.action = ""; // Donde irá el formulario, en blanco a la misma página.
    form.method = "post"; // Por el método post.

    input.type = "hidden"; // Lo hago de tipo hidden, oculto.
    input.name = "username"; // Le asigno el nombre username.
    input.value = username; // Al input hidden le asigno el valor de la variable de javascript username, declarada en el script client.php.
    form.appendChild(input); // Lo agrego al formulario.

    input1.type = "hidden";
    input1.name = "article"; // Le asigno el nombre article.
    input1.value = election.value; // Pongo en el input1 el contenido del selector de kind/tipo o brand/marca, puede ser: Proteínas, Vitamínas o Nutraproject, Muscletech, etc..
    form.appendChild(input1);

    input2.type = "hidden";
    input2.name = "which"; // Le asigno el nombre which al input2.
    input2.value = which; // EL valor en input2 será lo que se seleccionó, kind o brand.
    form.appendChild(input2);

    if (valor != "") // Si la variable de javascript valor tiene algún valor.
    {
        input4.type = "hidden"; // Lo hago de tipo hidden, oculto.
        input4.name = "invoice"; // Le asigno el nombre invoice.
        input4.value = valor; // Al cuarto input le asigno el valor de la variable de javascript valor, es lo que se concatena en invoice.
        form.appendChild(input4);

        input5.type = "hidden";
        input5.name = "productList";
        input5.value = valor2; // Al quinto le pongo el valor de la variable valor2, es lo que se muestra en el div con ID productList.
        form.appendChild(input5);
    }

    document.body.appendChild(form); // Agreo el formulario al body.

    form.submit(); // Lo envío.
}

function verify() // Función para validar las contraseñas de registro de ciente y las de modificación de datos del perfil del cliente.
{
    var pass = document.getElementById("pass0"); // pass es la ID del input pass0.
    var pass2 = document.getElementById("pass1"); // pass2 es la ID del input pass1.
    if (pass.value != pass2.value) // Verifico si los valores en los input pass y pass2 no coinciden.
    {
        toast(1, "Hay un Error", "Las contraseñas no coinciden, has escrito: " + pass.value + " y " + pass2.value); // Si no coinciden muestro error.
        return false; // devulvo false, el formulario no se envía.
    }
    else // Si son iguales.
    {
        return true; // Devuelvo true, envía el formulario.
    }
}

function changeit() // Función para la página de contacto.
{
    var button = document.getElementById("change"); // En la variable button obtengo la ID del input type submit change.
    var contact = document.getElementById("contact"); // En la variable contact obtengo el id del selector.
    var phone = document.getElementById("phone");
    var email = document.getElementById("email");
    var ph = document.getElementById("ph");
    var em = document.getElementById("em");

    if (contact.value != "") // Si el valor en el selector ha cambiado.
    {
        switch (contact.value) // Hago un switch al valor en el selector.
        {
            case "Teléfono":
                email.style.visibility = "hidden";
                phone.style.visibility = "visible";
                em.required = false;
                ph.required = true;
                button.value = "Llámame!";
                break;
            case "Whatsapp":
                email.style.visibility = "hidden";
                phone.style.visibility = "visible";
                em.required = false;
                ph.required = true;
                button.value = "Envíame un Watsapp";
                break;
            default:
                email.style.visibility = "visible";
                phone.style.visibility = "hidden";
                ph.required = false;
                ph.value = 1;
                em.required = true;
                button.value = "Espero tu E-mail";
                break;
        }
    }
}

function connect(how) // Función para enviar un Whatsapp a la tienda, para que se ponga en contacto con el cliente, recibe la forma de comunicación, Teléfono o E-mail.
{
    let mssg = document.getElementById('mssg').value;
    let num = +34617822401;
    console.log("La forma de contacto es: " + how);
    if (how == "E-mail") // Esto es solo para que aparezca cpntactame a en lugar de al.
    {
        var win = window.open(`https://wa.me/${num}?text=Por Favor contactame por: ${how} a: ${mssg} Mi nombre es: `, '_blank');
    }
    else
    {
        var win = window.open('https://wa.me/' + num + '?text=Por Favor contactame por: ' + how + ' al: ' + mssg + ' Mi nombre es: ', '_blank');
    }
}

function showEye(which) // Función para mostrar el ojo de los input de las contraseñas, recibe el número del elemento que contiene el ojo.
{
    let eye = document.getElementById("togglePassword" + which); // Asigno a eye la id del elemento que contiene el ojo.
    eye.style.visibility = "visible"; // Hago visible el elemento, el ojo.
}

function spy(which) // Función para el ojito de las Contraseñas al hacer click en el ojito, recibe el número de la ID del input de la password.
{
    const togglePassword = document.querySelector('#togglePassword' + which); // Asigno a la constante togglePassword el input con ID togglePassword + which.
    const password = document.querySelector('#pass' + which); // Asigno a password la ID del input con ID pass + which.
    
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password'; // Asigno a type el resultado de un operador ternario, si presiono el ojito y el tipo del input es password
    // lo cambia a text, si es text lo cambia a password.
    password.setAttribute('type', type); // Le asigno el atributo al input password.
    togglePassword.classList.toggle('fa-eye-slash'); // Cambia el aspecto del ojito, al cambiar el input a tipo texto, el ojo aparece con una raya.
}

function showCar(size) // Función para mostrar el carro de la compra, recibe el tamaño del array de sesión del carro.
{
    if (size > 0) // Si se ha agregado algún artículo.
    {
        let container = document.getElementById("container"); // ID del div contenedor.
        let btnopen = document.getElementById("car"); // Id del botón para mostrar el carro de la compra.
        for (i = 0; i < size / 5; i++) // Bucle al tamaño del array de sesión car dividido por 5 ya que el array contiene: ID, qtty, stock, product and price.
        {
            var span = document.createElement("span"); // Creo el span que contiene los datos del producto agregado al carro.
            var input = document.createElement("input");
            var input1 = document.createElement("input");
            var input2 = document.createElement("input");
            var input3 = document.createElement("input");
            var input4 = document.createElement("input");
            var button = document.createElement("button"); // Creo el botón para quitar un artículo que no quiera.

            input.className = "clear";
            input.type = "number";
            input.id = ids[i];
            input.name = "qtty" + i;
            input.min = 1;
            input.max = stock[i] + qtty[i];
            input.value = qtty[i];
            input.style.width = "64px";
            input.onchange=function(){updateStock(this.id, document.getElementById(this.id).value)};
            container.appendChild(input);

            input1.className = "clear";
            input1.type = "hidden";
            input1.name = "id" + i;
            input1.value = ids[i];
            container.appendChild(input1);

            input2.className = "clear";
            input2.type = "hidden";
            input2.name = "price" + i;
            input2.value = price[i];
            container.appendChild(input2);

            input3.className = "clear";
            input3.type = "hidden";
            input3.name = "product" + i;
            input3.value = product[i];
            container.appendChild(input3);

            input4.className = "clear";
            input4.type = "hidden";
            input4.name = "stock" + i;
            input4.value = stock[i] + qtty[i];
            container.appendChild(input4);

            span.className = "clear";
            span.innerHTML = product[i] + " a: " + price[i] + "€ Total = " + (qtty[i] * price[i]).toFixed(2) + " €"; // Creo un span con los contenidos de los array de javascript qtty, product and price.
            container.appendChild(span);

            button.id = i + "-" + ids[i]; // Le asigno al botón el indice y la ID del artículo.
            button.className = "btn btn-danger clear";
            button.style.fontSize = "10px"; // Le doy estilo al texto del botón para hacerlo más pequeño.
            button.style.float = "right"; // Lo pongo a la derecha del span.
            button.onclick=function(){removeArticle(this.id)}; // Le asigno la función removeArticle on click, le paso la ID del botón (ID del artículo) y el índice.
            console.log("El ID es: " + ids[i]);
            button.innerHTML = "Quitar"; // Le pongo el texto Quitar.
            container.appendChild(button);

            var br = document.createElement("br"); // Creo dos saltos de línea y los agrego al contenedor.
            br.className = "clear";
            container.appendChild(br);

            var br2 = document.createElement("br");
            br2.className = "clear";
            container.appendChild(br2);
        }
        btnopen.click(); // Click en el botón para mostrar el diálogo.
    }
    else // Si no se agregó nada.
    {
        var btnopen = document.getElementById("addtocar"); // Botón del diálogo para mostrar lo que se agregó al carro de la compra.
        var btnclose = document.getElementById("close_add_dialog");
        var addMessage = document.getElementById("messagecar");
        addMessage.innerHTML = "Aun no has agregado nada al carro de la compra."; // Uso el diálogo para mostrar los artículos agregados al carro de la compra, para indicar que aun no se ha agregado nada.
        btnopen.click(); // Hago click en el botón para mostrar el diálogo.
        setTimeout(function() // Función que espera 2 segundos.
        {
            btnclose.click(); // Hago click en el botón que cierra el diálogo.
        }, 3000);
    }
}

function emptyCar() // Limpia todo el cotenido del carro, ya que para cada caso, lo rellena nuevamente.
{
    const elements = document.getElementsByClassName("clear");
    while(elements.length > 0)
    {
        elements[0].parentNode.removeChild(elements[0]);
    }
}

function removeArticle(index) // Función para remover un artículo del carro de la compra, recibe index que es el índice concatenado con la ID del artículo a remover.
{
    const arrayId = index.split("-"); // Hago un split de la cadena de la ID del botón, en 0 tengo el índice, en 1 tengo la ID del artículo.
    let form = document.createElement("form"); // Creo un formulario.
    let input = document.createElement("input"); // Asigno a la variable input la creación de un input.
    let input1 = document.createElement("input"); // Asigno a la variable input1 la creación de un input.

    form.action = "";
    form.method = "post";

    input.type = "hidden";
    input.name = "delete";
    input.value = arrayId[0];
    form.appendChild(input);

    input1.type = "hidden";
    input1.name = "id";
    input1.value = arrayId[1];
    form.appendChild(input1);

    document.body.appendChild(form); // Agreo el formulario al body.

    form.submit(); // Lo envío.
}

function updateStock(id, qtty) // Función para actualizar las cantidades de los artículos desde dentro del carro, recibe la ID del artículo y la cantidad.
{
    let form = document.createElement("form"); // Creo un formulario.
    let input = document.createElement("input"); // Asigno a la variable input la creación de un input.
    let input1 = document.createElement("input"); // Asigno a la variable input1 la creación de un input.
    let input2 = document.createElement("input"); // Asigno a la variable input2 la creación de un input.

    form.action = "";
    form.method = "post";

    input.type = "hidden";
    input.name = "update";
    input.value = 1;
    form.appendChild(input);

    input1.type = "hidden";
    input1.name = "id";
    input1.value = id;
    form.appendChild(input1);

    input2.type = "hidden";
    input2.name = "qtty";
    input2.value = qtty;
    form.appendChild(input2);

    document.body.appendChild(form); // Agreo el formulario al body.

    form.submit(); // Lo envío.
}

function printIt(number) // Función para imprimir la pantalla con la factura.
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

function capture(number)
{
    const print = document.getElementById("printable" + number); // Asigna a printi el Div con ID printable + number
    const image = document.getElementById("image" + number); // Asigna a image el Div con ID image + number, contendrá el elemento img con la factura.

    html2canvas(print).then((canvas) => {
        const base64image = canvas.toDataURL('image/png'); // genera la imagen base64image a partir del contenido de print, el div que contiene la factura.
        image.setAttribute("href", base64image);
        const img = document.createElement("img");
        img.id = "img" + number;
        img.src = base64image;
        img.alt = "Factura: " + number;
        print.remove();
        image.appendChild(img);
    });
}

function pdfDown(number)
{
    const image = document.getElementById("img" + number); // Div con ID printable0, contiene la factura.

    var doc = new jsPDF();
    doc.addImage(image, 'png', 10, 10, 240, 120, '', 'FAST');
    doc.save();
}

function totNumPages() // Función para la paginación, calcula el número total de páginas según la cantidad de resultados dividido por la cantidad a mostrar.
{
    return Math.ceil(window.length / window.qtty); // Calcula la cantidad de páginas que habrá, divide la cantidad de eventos por 6 resultados a mostrar por página.
}

function prev(where) // Función para ir a la página anterior.
{
    if (window.page > 1) // Si la página actual es mayor que la página 1.
    {
        window.page--; // Decrementa la variable page, página anterior.
        change(window.page, window.qtty, where); // Llama a la función change pasandole el número de página a mostrar y la cantidad de eventos a mostrar que siempre es 6.
    }
}

function next(where) // La Función next muestra la página siguiente.
{   
    if (window.page < totNumPages()) // Si la página en la que estoy es menor que la última.
    {
        window.page++; // Incremento la página
        change(window.page, window.qtty, where); // Llamo a la función que muestra los resultados.
    }
}

function change(page, qtty, where) // Función que muestra los resultados de a 2 filas y 3 columnas de bootstrap, recibe la página page y la cantidad de resultados a mostrar qtty.
{
    window.page = page; // Asigno la variable page, a la variable global window.page.
    window.qtty = qtty; // Asigno la variable qtty, a la variable global window.qtty.
    var length = product.length; // La variable length será del tamaño del array id.
    window.length = length; // Hago global la variable length.
    var btn_next = document.getElementById("next"); // Asigno a la variable btn_next la id del botón con id next, que muestra los resultados siguientes.
    var btn_prev = document.getElementById("prev"); // Asigno a la variable btn_prev la id del botón con id prev, que muestra los resultados anteriores.
    var page_span = document.getElementById("page"); // Asigno a la variable page_span la id del span page, que muestra el número de página.
    var table = document.getElementById("table"); // ID del div que contendrá las imágenes de los artículos y los formularios.
    if (length < 3) // Si la cantidad de artículos es menor que 4.
    {
        if (where == "profile") // Si se llama desde el perfil del cliente.
        {
            var html = "<table><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Parcial</th><th>I.V.A.</th><th>Total</th><th>Fecha</th><th>Hora</th></tr>"; // Muestro una tabla con las facturas del cliente.
            var result = ""; // Declaro la variable result y le asigno el valor de texto vacio.
            for (i = 0; i < qtty; i++) // Hago un bucle hasta la cantidad de resultados a mostrar.
            {
                if (i < length) // Mientras i sea menor que el tamaño del array, muestro los resultados en pantalla.
                {
                    result += tableProfile(i); // Llamo a la función tableProfile(i) y concateno el resultado en result.
                }
                else // Cuando i es igual a la cantidad de datos a mostrar.
                {
                    break; // Rompo el bucle.
                }
            }
            html += result + "</table>"; // Concateno result a html, Cierro la tabla.
            table.innerHTML = html; // La muestro en pantalla.
        }
        else // Si se llama desde search.
        {
            let container = document.getElementById("container");
            var html = ""; // Declaro y asigno texto vacio a la variable html.
            var result = ""; // Declaro y asigno texto vacio a la variable result.
            html += "<div class='row'>"; // Pongo en pantalla un elemento div de la clase row de Bootstrap.
            for (i = 0; i < length; i++) // Hago un bucle al tamaño de los array de productos.
            {
                if (qtties[i] > 0) // Si hay stock.
                {
                    result += htmlSearch(i); // Concateno el resultado de la función htmlSearch(i) a la variable result.
                }
            }
            html += result + "</div>"; // Concateno a html el valor de result, Cierro el div de fila.
            container.innerHTML = html; // Lo muestro en pantalla.
        }
    }
    else // Si hay más de 3 resultados.
    {
        if (where == "profile") // Si se llama desde el perfil del cliente.
        {
            var html = "<table><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Parcial</th><th>I.V.A.</th><th>Total</th><th>Fecha</th><th>Hora</th></tr>";
            var result = "";
            for (i = (page - 1) * qtty; i < qtty + ((page - 1) * qtty); i++) // Aquí hago el bucle desde la página donde esté, a la cantidad de resultados a mostrar.
            {
                if (i < length) // Mientras el valor de i sea menor que el tamaño del array, muestra resultados en pantalla.
                {
                    result += tableProfile(i);
                }
                else // Si i es igual a length.
                {
                    break; // Rompo el bucle for.
                }
            }
            html += result + "</table>";  // Concateno los resultados de la función tableProfile(i) en html, Cierra la tabla en html.
            table.innerHTML = html; // La muestro en pantalla.
        }
        else // Si se llama desde search.
        {
            let container = document.getElementById("container"); // ID del div contenedor.
            var html = ""; // Contendrá todo el html.
            var result = ""; // Result se usa en la llamada a la funcion que concatena los resultados en la variable.
            html += "<div class='row'>"; // Pongo en pantalla el primer elemento div de la clase row de Bootstrap.
            var i = ((page - 1) * qtty);
            while (i < qtty / 2 + ((page - 1) * qtty)) // Mientras i sea menor que la cantidad divida en 2 más la cantidad dividida en dos por el número de página.
            {
                if (i < length) // Si i es menor que el tamaño de los array, pasa y verifica si el artículo tiene stock.
                {
                    if (qtties[i] > 0) // Si hay stock entra.
                    {
                        result += htmlSearch(i); // Concateno en la variable result el resultado de la función htmlSearch(i).
                        i++; // Incremneto en valor de i.
                    }
                    else // Si no hay stock.
                    {
                        i++; // Incremento i.
                    }
                }
                else // Si i es igual al tamaño del array.
                {
                    i++; // Incremento i y salgo del bucle while.
                }
            }
            html += result + "</div><div class='row' style='height: 20px;'></div><div class='row'>"; //  Concateno la variable result en html, Cierro el div de la primera fila (row) de Bootstrap.
            result = ""; // Vacio la variable result.
            while (i < qtty + ((page - 1) * qtty)) // Repito pero mientras i sea menor que la cantidad total + la cantidad por el número de página menos 1.
            {
                if (i < length) // Si i es menor que el tamaño de los array, pasa y verifica si el artículo tiene stock.
                {
                    if (qtties[i] > 0) // Si hay stock entra.
                    {
                        result += htmlSearch(i); // Concatena en la variable result el resultado de la función htmlSearch(i).
                        i++; // Incremento i.
                    }
                    else // Si no hay stock.
                    {
                        i++; // Incremento i.
                    }
                }
                else // Si i es igual a length.
                {
                    i++; // Incremento i y salgo del bucle while.
                }
            }
            html += result + "</div>"; // Concateno a html el contenido de result, Cierro el div de la segunda fila de Bootstrap.
            container.innerHTML = html;
        }
    }

    if (length > 6) // Si la cantidad de Artículos es mayor que 6.
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
}

function leftUnits(qtty) // Esta función chequea cuantas unidades quedan del artículo seleccionado, recibe la cantidad.
{
    if (qtty < 10) // Si quedan menos de 10
    {
        return "<div class='leftunits'>QUEDAN " + qtty + " UNIDADES</div><br><br><br>"; // Muestro un aviso rojo avisando que quedan pocas unidades, y hago 3 saltos de linea en html.
    }
    else // Si hay 10 o más.
    {
        return "<br>"; // Hago un salto de linea en html.
    }
}

function changeSize(id, bool) // Esta función cambia el tamaño de las imágenes cuando paso el mouse por encima, recibe la ID de la imagen y verdadero o falso.
{
    let img = document.getElementById(id); // Obtengo la ID de la imagen.
    if (bool) // Si pase true.
    {
        img.className = 'bigsize'; // Pongo la clase de la imagen como bigsize, tamaño grande: sin padding.
    }
    else // Si paso false.
    {
        img.className = 'mysize'; // Pongo la clase de la imagen como mysize tamaño normal: con 20 pixeles de padding.
    }
}

function tableProfile(i) // Esta función crea una tabla con los datos de las facturas del cliente y retorna el resultado, recibe el índice de los arrays.
{
    var my_date = date[i].split("-"); // Hago un split del array date[i] en el array my_date.
    var my_qtty = qtties[i].split(","); // Hago un split del array qtties[i] en el array my_qtty.
    var final_qtty = ""; // Declaro y asigno la variable final_qtty como vacia.
    for (j = 0; j < my_qtty.length; j++) // hago un bucle al tamaño del array my_qtty.
    {
        final_qtty += my_qtty[j] + "<br>"; // Concateno en la variable final_qtty el contenido del array my_qtty[j] y hago un salto de linea para cada resultado.
    }
    var result = "<tr><td>" + product[i] + "</td><td>" + price[i] + "</td><td><br>" + final_qtty + "</td><td>" + (total[i] * 100 / 121).toFixed(2) + " €</td><td>" + ((total[i] * 100 / 121) * .21).toFixed(2) + " €</td><td>" + total[i] + " €</td><td>" + my_date[2] + "/" + my_date[1] + "/" + my_date[0] + "</td><td>" + time[i] + "</td></tr>"; // Asigno a la variable result el contenido de la tabla con los datos de las facturas del cliente.
    return result; // Retorno result.
}

function htmlSearch(i) // Esta función crea una columna con un artículo que tenga stock y retorna el resultado, recibe el índice de los arrays y de las ID.
{
    var result = "<div class='col-md-4'>";
    result += "<form id='form" + i + "' action='product.php' method='post'>";
    result += "<img id='img" + i + "' src='" + path[i] + "' alt='" + product[i] + "' style='cursor: pointer;' class='mysize' onmouseover='changeSize(this.id, true)' onmouseout='changeSize(this.id, false)' onclick='document.getElementById(\"form" + i + "\").submit()'>";
    result += "<input type='hidden' name='id' value='" + id[i] + "'>";
    result += "<br>"; // Pongo en pantalla un div con la clase col de Bootstrap(4 columnas), y un formulario a la página product.php pasándole por POST la ID del producto, con la imagen del producto.
    result += "<small><input type='submit' value='Ver Características del producto' class='btn btn-info'></small>"; // Botón para enviar el formulario.
    result += leftUnits(qtties[i]); // Llamo a la función leftUnits() pasándole la cantidad de entradas que quedan y verifico si en algún producto quedan menos de 10 unidades.
    result += "</form>";
    result += "</div>"; // Si hay artículos se muestra el producto en pantalla, si $left[$i] fuera menor o igual a 0 no se muestra el producto.
    return result; // Retorno el resultado.
}

function calculate(id) // Función que se llama onchange, reclacula los totales al modificar los precios o las cantidades de los artículos preparados para facturar, recibe la ID (índice) de qtty o price.
{
    var number = id.charAt(id.length-1); // Asigno a la variable number el último dígito de la ID que llega, es donde está el número, el índice.
    let new_price = document.getElementById("price" + number); // Asigno a new_price el elemento (input) que tiene la ID price0, price1, price2, etc.
    let qtty_id = document.getElementById("qtty" + number); // Asigno a qtty_id el elemento (input) que tiene la ID qtty0, qtty1, qtty2, etc.
    let total = document.getElementById("total"); // Total es el input total.
    let iva = document.getElementById("iva"); // Iva es el input iva.
    let totaliva = document.getElementById("totaliva"); // totaliva es el input totaliva.
    var last_price = new_price.value; // El último precio es el valor en new_price.value, si se cambia el precio o no, si cambia el precio no cambia la cantidad y viseversa.
    var new_qtty = qtty_id.value; // La nueva cantidad new_qtty es el valor en qtty_id, si se cambia la cantidad o no.
    var org_price = price[number]; // El precio original org_price es el que estaba en el array price en el índice number.
    var org_qtty = qtty[number]; // La cantidad original org_qtty es la que estaba en el array qtty en el índice number.
    var pre_total = total.value; // El pre_total es el valor del input total.value.
    // var pre_iva = iva.value; // El pre_iva es el valor en iva.value.
    // var pre_totaliva = totaliva.value; // El pre_totaliva es el valor que está en totaliva.value.
    var final = (pre_total - org_price * org_qtty + last_price * new_qtty) * 1.21; // Final es la formula: pre_total - org_price * org_qtty + last_price * new_price * 1.21 que es el iva, que se agrega.
    iva.value = ((pre_total - org_price * org_qtty + last_price * new_qtty) * .21).toFixed(2); // Pongo en el input iva la formula: pre_total - org_price * org_qtty + last_price * new_qtty) * .21, que es el iva.
    total.value = (pre_total - org_price * org_qtty + last_price * new_qtty).toFixed(2); // Pongo en el input total la formula: pre_total - org_price * org_qtty + last_price * new_qtty, que es el nuevo total.
    totaliva.value = final.toFixed(2); // Pongo en el input totaliva el resultado final.
    qtty[number] = new_qtty; // En el array qtty en el índice number pongo la cantidad modificada, new_qtty.
    price[number] = last_price; // En el array price en el índice number pongo el precio modificado, last_price, puede cambiar el precio o la cantidad. 
}