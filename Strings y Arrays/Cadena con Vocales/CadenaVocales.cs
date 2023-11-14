namespace Cadena_con_Vocales
{
    internal class CadenaVocales
    {
        static void Main(string[] args)
        {
            string cadena;
            int size;
            bool a = false;
            bool e = false;
            bool i = false;
            bool o = false;
            bool u = false;
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Muestra las Vocales que Aparecen en una Cadena Introducida por Teclado.\n");
                Console.Write("Ingresa una Palabra: ");
                cadena = Console.ReadLine();
                size = cadena.Length;
                for (int n = 0; n < size; n++)
                {
                    if (cadena[n] == 'a')
                    {
                        if (!a)
                        {
                            a = true;
                            Console.WriteLine("En la Palabra: {0}, aparece la vocal a.\n", cadena);
                        }
                    }
                    if (cadena[n] == 'e')
                    {
                        if (!e)
                        {
                            e = true;
                            Console.WriteLine("En la Palabra: {0}, aparece la vocal e.\n", cadena);
                        }
                    }
                    if (cadena[n] == 'i')
                    {
                        if (!i)
                        {
                            i = true;
                            Console.WriteLine("En la Palabra: {0}, aparece la vocal i.\n", cadena);
                        }
                    }
                    if (cadena[n] == 'o')
                    {
                        if (!o)
                        {
                            o = true;
                            Console.WriteLine("En la Palabra: {0}, aparece la vocal o.\n", cadena);
                        }
                    }
                    if (cadena[n] == 'u')
                    {
                        if (!u)
                        {
                            u = true;
                            Console.WriteLine("En la Palabra: {0}, aparece la vocal u.\n", cadena);
                        }
                    }
                }
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                a = e = i = o = u = false;
                Console.Clear();
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}