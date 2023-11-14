namespace Cuantas_Vocales
{
    internal class CuantasVocales
    {
        static void Main(string[] args)
        {
            string cadena;
            int size;
            int contador = 0;
            char seguir = 's';

            while (seguir == 's')
            {
                Console.WriteLine("Este Programa Cuenta las Vocales que Aparecen en una Cadena Introducida por Teclado.\n");
                Console.Write("Ingresa una Palabra: ");
                cadena = Console.ReadLine();
                size = cadena.Length;
                for (int n = 0; n < size; n++)
                {
                    if (cadena[n] == 'a')
                    {
                        contador++;
                    }
                    if (cadena[n] == 'e')
                    {
                        contador++;
                    }
                    if (cadena[n] == 'i')
                    {
                        contador++;
                    }
                    if (cadena[n] == 'o')
                    {
                        contador++;
                    }
                    if (cadena[n] == 'u')
                    {
                        contador++;
                    }
                }
                Console.WriteLine("En la Palabra: {0}, Aparecen {1} Vocales.\n", cadena, contador);
                Console.WriteLine("Presiona la Tecla s Para Introducir Otra Palabra, Cuanlquier otra Tecla Para Salir.");
                seguir = Console.ReadKey().KeyChar;
                Console.Clear();
                contador = 0;
            }
            Console.WriteLine("Presiona Cualquier Tecla Para Salir.");
            Console.ReadKey();
        }
    }
}